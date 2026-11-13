<?php

namespace Tests\Unit;

use App\Services\CurrencyService;
use Tests\TestCase;

class CurrencyServiceTest extends TestCase
{
    protected CurrencyService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CurrencyService();
    }

    public function test_it_returns_currency_rates_with_usd_and_eur()
    {
        $rates = $this->service->getRates();

        $this->assertIsArray($rates);
        $this->assertArrayHasKey('usd_to_idr', $rates);
        $this->assertArrayHasKey('usd_to_eur', $rates);
        $this->assertArrayHasKey('eur_to_idr', $rates);
        $this->assertGreaterThan(10000, $rates['usd_to_idr']);
        $this->assertGreaterThan(10000, $rates['eur_to_idr']);
    }

    public function test_it_converts_idr_amount_to_usd_and_eur()
    {
        // 12 tons Gayo Arabica Specialty coffee valuation (Rp 1.440.000.000)
        $result = $this->service->convertIdr(1440000000);

        $this->assertIsArray($result);
        $this->assertEquals(1440000000, $result['idr']);
        $this->assertStringContainsString('Rp', $result['idr_formatted']);
        $this->assertGreaterThan(50000, $result['usd']);
        $this->assertGreaterThan(50000, $result['eur']);
        $this->assertStringContainsString('$', $result['usd_formatted']);
        $this->assertStringContainsString('€', $result['eur_formatted']);
    }

    public function test_it_estimates_commodity_shipment_valuation()
    {
        // 12.000 kg Arabica Gayo
        $valuation = $this->service->estimateShipmentValuation('Kopi Arabika Gayo Specialty', 12000);

        $this->assertEquals(1440000000, $valuation['idr']);
        $this->assertEquals(120000, $valuation['price_per_kg_idr']);
        $this->assertGreaterThan(0, $valuation['usd']);
    }
}
