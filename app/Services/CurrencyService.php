<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    /**
     * Endpoint for Frankfurter API (Official European Central Bank Reference Data)
     * Free, Open Source, no key required.
     */
    protected string $apiUrl = 'https://api.frankfurter.dev/v1/latest?from=USD&to=IDR,EUR';

    /**
     * Get live exchange rates with 24-hour caching and resilient fallback.
     */
    public function getRates(): array
    {
        return Cache::remember('agro_currency_rates', 86400, function () {
            return $this->fetchLiveRates();
        });
    }

    /**
     * Fetch live rates from Frankfurter API.
     */
    public function fetchLiveRates(): array
    {
        try {
            $response = Http::timeout(5)->get($this->apiUrl);

            if ($response->successful()) {
                $data = $response->json();
                $usdToIdr = (float) ($data['rates']['IDR'] ?? 16200.0);
                $usdToEur = (float) ($data['rates']['EUR'] ?? 0.92);
                $eurToIdr = $usdToEur > 0 ? ($usdToIdr / $usdToEur) : 17600.0;

                return [
                    'success' => true,
                    'base' => 'USD',
                    'date' => $data['date'] ?? date('Y-m-d'),
                    'usd_to_idr' => round($usdToIdr, 2),
                    'usd_to_eur' => round($usdToEur, 4),
                    'eur_to_idr' => round($eurToIdr, 2),
                    'source' => 'European Central Bank (Frankfurter API Live)',
                    'cached_at' => now()->format('d M Y, H:i'),
                ];
            }

            Log::warning('Frankfurter API returned status: ' . $response->status());
            return $this->fallbackRates('HTTP ' . $response->status());
        } catch (\Throwable $e) {
            Log::warning('Frankfurter API error: ' . $e->getMessage());
            return $this->fallbackRates($e->getMessage());
        }
    }

    /**
     * Convert an IDR amount to USD and EUR.
     */
    public function convertIdr(float $amountIdr): array
    {
        $rates = $this->getRates();
        $usdRate = $rates['usd_to_idr'] > 0 ? $rates['usd_to_idr'] : 16200.0;
        $eurRate = $rates['eur_to_idr'] > 0 ? $rates['eur_to_idr'] : 17600.0;

        $usd = $amountIdr / $usdRate;
        $eur = $amountIdr / $eurRate;

        return [
            'idr' => $amountIdr,
            'idr_formatted' => 'Rp ' . number_format($amountIdr, 0, ',', '.'),
            'usd' => round($usd, 2),
            'usd_formatted' => '$' . number_format($usd, 2, '.', ','),
            'eur' => round($eur, 2),
            'eur_formatted' => '€' . number_format($eur, 2, '.', ','),
            'rates' => $rates,
        ];
    }

    /**
     * Estimate commodity shipment export valuation.
     * Based on commodity type and weight in kilograms.
     */
    public function estimateShipmentValuation(string $cargoType, float $weightKg): array
    {
        $cargoLower = strtolower($cargoType);
        
        // Price per KG standard in Takengon Highland auctions
        if (str_contains($cargoLower, 'arabica') || str_contains($cargoLower, 'kopi') || str_contains($cargoLower, 'coffee')) {
            $pricePerKg = 120000; // Rp 120.000 / kg (Specialty Green Bean Grade 1)
        } elseif (str_contains($cargoLower, 'alpukat') || str_contains($cargoLower, 'avocado')) {
            $pricePerKg = 25000;  // Rp 25.000 / kg (Alpukat Mentega Super)
        } elseif (str_contains($cargoLower, 'cabai') || str_contains($cargoLower, 'chili')) {
            $pricePerKg = 45000;  // Rp 45.000 / kg
        } else {
            $pricePerKg = 50000;
        }

        $totalIdr = $pricePerKg * $weightKg;
        $converted = $this->convertIdr($totalIdr);
        $converted['price_per_kg_idr'] = $pricePerKg;

        return $converted;
    }

    /**
     * Resilient offline fallback rates.
     */
    protected function fallbackRates(string $reason): array
    {
        return [
            'success' => false,
            'base' => 'USD',
            'date' => date('Y-m-d'),
            'usd_to_idr' => 16250.0,
            'usd_to_eur' => 0.92,
            'eur_to_idr' => 17660.0,
            'source' => 'Bank Indonesia Benchmark (Smart Fallback: ' . $reason . ')',
            'cached_at' => now()->format('d M Y, H:i'),
        ];
    }
}
