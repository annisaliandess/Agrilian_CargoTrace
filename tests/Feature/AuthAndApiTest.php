<?php

namespace Tests\Feature;

use App\Models\Carrier;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Ayaa Liandes (Admin)',
            'email' => 'admin@cargotrace.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
    }

    public function test_user_can_login_via_web_form(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@cargotrace.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_user_can_register_new_account_via_web_form(): void
    {
        $response = $this->post('/register', [
            'name' => 'Mitra Gayo Coffee',
            'email' => 'mitra@gayo.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345',
            'role' => 'customer',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'mitra@gayo.com',
            'role' => 'customer',
        ]);
        $this->assertAuthenticated();
    }

    public function test_api_login_returns_sanctum_bearer_token(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'admin@cargotrace.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'access_token',
                'token_type',
                'user' => ['id', 'name', 'email', 'role'],
            ]);

        $token = $response->json('access_token');

        // Test accessing protected endpoint with Bearer token
        $meResponse = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/me');

        $meResponse->assertStatus(200)
            ->assertJsonPath('user.email', 'admin@cargotrace.com');
    }

    public function test_api_login_fails_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'admin@cargotrace.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJsonPath('success', false);
    }

    public function test_public_tracking_api_returns_shipment_details(): void
    {
        $carrier = Carrier::create(['name' => 'AgriLian Fleet', 'code' => 'AGLN', 'transport_mode' => 'TRUCK']);
        $origin = Location::create(['name' => 'Takengon Hub', 'code' => 'IDTKN', 'type' => 'ORIGIN_WAREHOUSE', 'city' => 'Takengon', 'country' => 'Indonesia', 'latitude' => 4.6, 'longitude' => 96.8]);
        $dest = Location::create(['name' => 'Singapore Port', 'code' => 'SGSIN', 'type' => 'DESTINATION_PORT', 'city' => 'Singapore', 'country' => 'Singapore', 'latitude' => 1.2, 'longitude' => 103.8]);

        $shipment = Shipment::create([
            'tracking_number' => 'AGLN-2026-TEST01',
            'customer_id' => $this->admin->id,
            'carrier_id' => $carrier->id,
            'origin_id' => $origin->id,
            'destination_id' => $dest->id,
            'cargo_type' => 'Arabica Gayo Sample',
            'weight_kg' => 100,
            'expected_departure' => Carbon::now(),
            'expected_arrival' => Carbon::now()->addDays(5),
            'estimated_arrival' => Carbon::now()->addDays(5),
            'status' => 'IN_TRANSIT',
        ]);

        $response = $this->getJson("/api/track/{$shipment->tracking_number}");

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.tracking_number', 'AGLN-2026-TEST01');
    }

    public function test_web_routes_render_html_successfully(): void
    {
        $carrier = Carrier::create(['name' => 'AgriLian Fleet', 'code' => 'AGLN', 'transport_mode' => 'TRUCK']);
        $origin = Location::create(['name' => 'Takengon Hub', 'code' => 'IDTKN', 'type' => 'ORIGIN_WAREHOUSE', 'city' => 'Takengon', 'country' => 'Indonesia', 'latitude' => 4.6, 'longitude' => 96.8]);
        $dest = Location::create(['name' => 'Singapore Port', 'code' => 'SGSIN', 'type' => 'DESTINATION_PORT', 'city' => 'Singapore', 'country' => 'Singapore', 'latitude' => 1.2, 'longitude' => 103.8]);

        $shipment = Shipment::create([
            'tracking_number' => 'AGLN-2026-TEST02',
            'customer_id' => $this->admin->id,
            'carrier_id' => $carrier->id,
            'origin_id' => $origin->id,
            'destination_id' => $dest->id,
            'cargo_type' => 'Arabica Gayo Sample',
            'weight_kg' => 100,
            'expected_departure' => Carbon::now(),
            'expected_arrival' => Carbon::now()->addDays(5),
            'estimated_arrival' => Carbon::now()->addDays(5),
            'status' => 'IN_TRANSIT',
        ]);

        // 1. Public tracker page
        $this->get('/track')->assertStatus(200);
        $this->get("/track/{$shipment->tracking_number}")->assertStatus(200);

        // 2. Login page
        $this->get('/login')->assertStatus(200);

        // 3. Authenticated dashboard & shipments
        $this->actingAs($this->admin)->get('/dashboard')->assertStatus(200);
        $this->actingAs($this->admin)->get('/commodities')->assertStatus(200);
        $this->actingAs($this->admin)->get('/shipments')->assertStatus(200);
        $this->actingAs($this->admin)->get("/shipments/{$shipment->id}")->assertStatus(200);
        $this->actingAs($this->admin)->get('/shipments/create')->assertStatus(200);
    }
}
