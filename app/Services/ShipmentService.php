<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Notification;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ShipmentService
{
    private const ALLOWED_TRANSITIONS = [
        'CREATED' => ['BOOKED'],
        'BOOKED' => ['PICKED_UP'],
        'PICKED_UP' => ['IN_TRANSIT'],
        'IN_TRANSIT' => ['DELIVERED'],
        'DELIVERED' => [],
    ];

    public function __construct(
        protected TrackingService $trackingService,
        protected EtaService $etaService
    ) {}

    /**
     * Generate an agro-export tracking number (e.g., AGLN-2026-GY042).
     */
    public function generateTrackingNumber(): string
    {
        $year = date('Y');
        $count = Shipment::count() + 1;
        $unique = str_pad((string) $count, 3, '0', STR_PAD_LEFT);
        $number = "AGLN-{$year}-GY{$unique}";

        // Ensure uniqueness
        while (Shipment::where('tracking_number', $number)->exists()) {
            $count++;
            $unique = str_pad((string) $count, 3, '0', STR_PAD_LEFT);
            $number = "AGLN-{$year}-GY{$unique}";
        }

        return $number;
    }

    /**
     * Create a new shipment with cargo items and initial tracking record.
     */
    public function createShipment(array $data, ?User $creator = null): Shipment
    {
        return DB::transaction(function () use ($data, $creator) {
            $trackingNumber = $data['tracking_number'] ?? $this->generateTrackingNumber();

            $expectedDeparture = Carbon::parse($data['expected_departure']);
            $expectedArrival = Carbon::parse($data['expected_arrival']);
            $estimatedArrival = isset($data['estimated_arrival'])
                ? Carbon::parse($data['estimated_arrival'])
                : $expectedArrival->copy();

            $delayEval = $this->etaService->evaluateDelay(new Shipment([
                'expected_arrival' => $expectedArrival,
                'estimated_arrival' => $estimatedArrival,
            ]));

            $shipment = Shipment::create([
                'tracking_number' => $trackingNumber,
                'customer_id' => $data['customer_id'],
                'carrier_id' => $data['carrier_id'],
                'origin_id' => $data['origin_id'],
                'destination_id' => $data['destination_id'],
                'cargo_type' => $data['cargo_type'],
                'weight_kg' => $data['weight_kg'],
                'volume_cbm' => $data['volume_cbm'] ?? null,
                'expected_departure' => $expectedDeparture,
                'expected_arrival' => $expectedArrival,
                'estimated_arrival' => $estimatedArrival,
                'status' => 'CREATED',
                'is_delayed' => $delayEval['is_delayed'],
                'delay_duration_hours' => $delayEval['delay_duration_hours'],
                'delay_severity' => $delayEval['delay_severity'],
                'delay_reason' => null,
                'current_location_id' => $data['origin_id'],
            ]);

            // Create items if provided
            if (!empty($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    ShipmentItem::create([
                        'shipment_id' => $shipment->id,
                        'item_name' => $item['item_name'],
                        'quantity' => $item['quantity'],
                        'weight_kg' => $item['weight_kg'],
                        'package_type' => $item['package_type'] ?? 'Jute Bag 60kg',
                        'description' => $item['description'] ?? null,
                    ]);
                }
            }

            // Create initial tracking milestone
            $this->trackingService->recordEvent($shipment, [
                'location_id' => $shipment->origin_id,
                'status' => 'CREATED',
                'event_time' => Carbon::now(),
                'description' => "Shipment created & export booking registered for {$shipment->cargo_type}.",
                'created_by' => $creator?->id ?? 1,
            ], $creator);

            // Notify Customer
            Notification::create([
                'user_id' => $shipment->customer_id,
                'title' => "Shipment Booked: {$shipment->tracking_number}",
                'message' => "Your shipment for {$shipment->cargo_type} has been registered successfully. Tracking Number: {$shipment->tracking_number}",
                'type' => 'INFO',
                'is_read' => false,
            ]);

            // Audit log
            AuditLog::create([
                'user_id' => $creator?->id ?? 1,
                'action' => 'CREATE_SHIPMENT',
                'entity_type' => 'Shipment',
                'entity_id' => $shipment->id,
                'old_values' => null,
                'new_values' => $shipment->toArray(),
                'ip_address' => request()?->ip() ?? '127.0.0.1',
            ]);

            return $shipment->fresh(['items', 'origin', 'destination', 'carrier', 'customer']);
        });
    }

    /**
     * Transition shipment status enforcing strictly valid lifecycle flows.
     */
    public function transitionStatus(Shipment $shipment, string $newStatus, ?int $locationId = null, ?string $notes = null, ?User $user = null): Shipment
    {
        $currentStatus = $shipment->status;
        $allowed = self::ALLOWED_TRANSITIONS[$currentStatus] ?? [];

        if (!in_array($newStatus, $allowed, true)) {
            throw new InvalidArgumentException(
                "Invalid status transition from '{$currentStatus}' to '{$newStatus}'. Allowed transitions: " . implode(', ', $allowed)
            );
        }

        return DB::transaction(function () use ($shipment, $newStatus, $locationId, $notes, $user) {
            $oldValues = $shipment->toArray();

            $targetLocationId = $locationId ?? $shipment->current_location_id ?? $shipment->origin_id;
            if ($newStatus === 'DELIVERED') {
                $targetLocationId = $shipment->destination_id;
            }

            $shipment->status = $newStatus;
            $shipment->current_location_id = $targetLocationId;
            $shipment->save();

            // Record tracking event
            $description = $notes ?? match ($newStatus) {
                'BOOKED' => 'Consignment confirmed with carrier and space allocated.',
                'PICKED_UP' => 'Cargo picked up from origin facility and in custody of carrier.',
                'IN_TRANSIT' => 'Cargo actively in transit along designated export lane.',
                'DELIVERED' => 'Cargo safely delivered and received at final destination port.',
                default => "Status updated to {$newStatus}.",
            };

            $this->trackingService->recordEvent($shipment, [
                'location_id' => $targetLocationId,
                'status' => $newStatus,
                'event_time' => Carbon::now(),
                'description' => $description,
                'created_by' => $user?->id ?? 1,
            ], $user);

            // Notify Customer of Status Change
            Notification::create([
                'user_id' => $shipment->customer_id,
                'title' => "Status Update: {$shipment->tracking_number}",
                'message' => "Your shipment status is now {$newStatus}. {$description}",
                'type' => 'STATUS_CHANGE',
                'is_read' => false,
            ]);

            // Audit Log
            AuditLog::create([
                'user_id' => $user?->id ?? 1,
                'action' => 'UPDATE_STATUS',
                'entity_type' => 'Shipment',
                'entity_id' => $shipment->id,
                'old_values' => ['status' => $oldValues['status'], 'location' => $oldValues['current_location_id']],
                'new_values' => ['status' => $newStatus, 'location' => $targetLocationId],
                'ip_address' => request()?->ip() ?? '127.0.0.1',
            ]);

            return $shipment->fresh(['currentLocation', 'items', 'trackingEvents', 'exceptions']);
        });
    }

    /**
     * Get shipment by ID or tracking number.
     */
    public function findShipment(string|int $identifier): ?Shipment
    {
        return Shipment::where('id', $identifier)
            ->orWhere('tracking_number', $identifier)
            ->with(['customer', 'carrier', 'origin', 'destination', 'currentLocation', 'items', 'trackingEvents.location', 'exceptions.reporter'])
            ->first();
    }
}
