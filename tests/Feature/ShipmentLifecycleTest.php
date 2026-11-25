<?php

namespace Tests\Feature;

use App\Models\Carrier;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\User;
use App\Services\EtaService;
use App\Services\ShipmentService;
use App\Services\TrackingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class ShipmentLifecycleTest extends TestCase
{
    use RefreshDatabase;

    protected ShipmentService $shipmentService;
    protected User $admin;
    protected User $customer;
    protected Carrier $carrier;
    protected Location $origin;
    protected Location $destination;

    protected function setUp(): void
    {
        parent::setUp();

        $this->shipmentService = app(ShipmentService::class);

        $this->admin = User::create([
            'name' => 'Annisa Liandes (Admin)',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->customer = User::create([
            'name' => 'Euro Coffee Amsterdam',
            'email' => 'customer@test.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);

        $this->carrier = Carrier::create([
            'name' => 'AgriLian Highland Fleet',
            'code' => 'AGLN',
            'transport_mode' => 'TRUCK',
        ]);

        $this->origin = Location::create([
            'name' => 'Takengon Warehouse',
            'code' => 'IDTKN',
            'type' => 'ORIGIN_WAREHOUSE',
            'city' => 'Takengon',
            'country' => 'Indonesia',
            'latitude' => 4.6293,
            'longitude' => 96.8458,
        ]);

        $this->destination = Location::create([
            'name' => 'Port of Rotterdam',
            'code' => 'NLRTM',
            'type' => 'DESTINATION_PORT',
            'city' => 'Rotterdam',
            'country' => 'Netherlands',
            'latitude' => 51.9547,
            'longitude' => 4.0322,
        ]);
    }

    public function test_it_creates_shipment_with_tracking_number_and_items(): void
    {
        $shipment = $this->shipmentService->createShipment([
            'customer_id' => $this->customer->id,
            'carrier_id' => $this->carrier->id,
            'origin_id' => $this->origin->id,
            'destination_id' => $this->destination->id,
            'cargo_type' => 'Arabica Gayo Grade 1',
            'weight_kg' => 12000,
            'expected_departure' => Carbon::now(),
            'expected_arrival' => Carbon::now()->addDays(20),
            'items' => [
                [
                    'item_name' => 'Gayo Wet Hulled Beans',
                    'quantity' => 200,
                    'weight_kg' => 12000,
                    'package_type' => 'Jute Bag 60kg',
                ],
            ],
        ], $this->admin);

        $this->assertNotNull($shipment->id);
        $this->assertStringStartsWith('AGLN-', $shipment->tracking_number);
        $this->assertEquals('CREATED', $shipment->status);
        $this->assertCount(1, $shipment->items);
        $this->assertCount(1, $shipment->trackingEvents);
    }

    public function test_it_enforces_strict_lifecycle_transitions(): void
    {
        $shipment = $this->shipmentService->createShipment([
            'customer_id' => $this->customer->id,
            'carrier_id' => $this->carrier->id,
            'origin_id' => $this->origin->id,
            'destination_id' => $this->destination->id,
            'cargo_type' => 'Arabica Gayo Grade 1',
            'weight_kg' => 6000,
            'expected_departure' => Carbon::now(),
            'expected_arrival' => Carbon::now()->addDays(15),
        ], $this->admin);

        // 1. Advance to BOOKED
        $shipment = $this->shipmentService->transitionStatus($shipment, 'BOOKED', $this->origin->id, 'Space confirmed', $this->admin);
        $this->assertEquals('BOOKED', $shipment->status);

        // 2. Advance to PICKED_UP
        $shipment = $this->shipmentService->transitionStatus($shipment, 'PICKED_UP', $this->origin->id, 'Truck loaded', $this->admin);
        $this->assertEquals('PICKED_UP', $shipment->status);

        // 3. Advance to IN_TRANSIT
        $shipment = $this->shipmentService->transitionStatus($shipment, 'IN_TRANSIT', $this->origin->id, 'En route to seaport', $this->admin);
        $this->assertEquals('IN_TRANSIT', $shipment->status);

        // 4. Advance to DELIVERED
        $shipment = $this->shipmentService->transitionStatus($shipment, 'DELIVERED', $this->destination->id, 'Received at Rotterdam', $this->admin);
        $this->assertEquals('DELIVERED', $shipment->status);
    }

    public function test_it_rejects_illegal_transition(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $shipment = $this->shipmentService->createShipment([
            'customer_id' => $this->customer->id,
            'carrier_id' => $this->carrier->id,
            'origin_id' => $this->origin->id,
            'destination_id' => $this->destination->id,
            'cargo_type' => 'Arabica Gayo Grade 1',
            'weight_kg' => 6000,
            'expected_departure' => Carbon::now(),
            'expected_arrival' => Carbon::now()->addDays(15),
        ], $this->admin);

        // Cannot jump directly from CREATED to DELIVERED
        $this->shipmentService->transitionStatus($shipment, 'DELIVERED');
    }
}
