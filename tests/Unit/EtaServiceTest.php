<?php

namespace Tests\Unit;

use App\Models\Shipment;
use App\Services\EtaService;
use Carbon\Carbon;
use Tests\TestCase;

class EtaServiceTest extends TestCase
{
    protected EtaService $etaService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->etaService = new EtaService();
    }

    public function test_it_detects_on_time_shipment(): void
    {
        $expected = Carbon::now()->addDays(5);
        $estimated = Carbon::now()->addDays(4); // Early or on-time

        $shipment = new Shipment([
            'expected_arrival' => $expected,
            'estimated_arrival' => $estimated,
        ]);

        $eval = $this->etaService->evaluateDelay($shipment);

        $this->assertFalse($eval['is_delayed']);
        $this->assertEquals(0, $eval['delay_duration_hours']);
        $this->assertEquals('NONE', $eval['delay_severity']);
    }

    public function test_it_calculates_low_severity_delay(): void
    {
        $expected = Carbon::now();
        $estimated = Carbon::now()->addHours(4); // 4 hours delay (< 6h)

        $shipment = new Shipment([
            'expected_arrival' => $expected,
            'estimated_arrival' => $estimated,
        ]);

        $eval = $this->etaService->evaluateDelay($shipment);

        $this->assertTrue($eval['is_delayed']);
        $this->assertEquals(4, $eval['delay_duration_hours']);
        $this->assertEquals('LOW', $eval['delay_severity']);
    }

    public function test_it_calculates_medium_severity_delay(): void
    {
        $expected = Carbon::now();
        $estimated = Carbon::now()->addHours(14); // 14 hours delay (6 - 24h)

        $shipment = new Shipment([
            'expected_arrival' => $expected,
            'estimated_arrival' => $estimated,
        ]);

        $eval = $this->etaService->evaluateDelay($shipment);

        $this->assertTrue($eval['is_delayed']);
        $this->assertEquals(14, $eval['delay_duration_hours']);
        $this->assertEquals('MEDIUM', $eval['delay_severity']);
    }

    public function test_it_calculates_high_severity_delay(): void
    {
        $expected = Carbon::now();
        $estimated = Carbon::now()->addHours(36); // 36 hours delay (> 24h)

        $shipment = new Shipment([
            'expected_arrival' => $expected,
            'estimated_arrival' => $estimated,
        ]);

        $eval = $this->etaService->evaluateDelay($shipment);

        $this->assertTrue($eval['is_delayed']);
        $this->assertEquals(36, $eval['delay_duration_hours']);
        $this->assertEquals('HIGH', $eval['delay_severity']);
    }
}
