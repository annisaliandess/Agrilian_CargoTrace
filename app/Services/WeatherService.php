<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected ?string $apiKey;
    protected string $baseUrl = 'https://api.openweathermap.org/data/2.5/weather';

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key', '2d42f08cfd74d9c7b2212012feefac6a');
    }

    /**
     * Get live weather for a specific latitude and longitude (Cached for 15 mins).
     */
    public function getWeatherByCoordinates(float $lat, float $lon): array
    {
        $cacheKey = 'weather_' . round($lat, 2) . '_' . round($lon, 2);

        return Cache::remember($cacheKey, 900, function () use ($lat, $lon) {
            return $this->fetchFromOpenWeather($lat, $lon);
        });
    }

    /**
     * Fetch fresh weather from OpenWeatherMap API.
     */
    protected function fetchFromOpenWeather(float $lat, float $lon): array
    {
        if (empty($this->apiKey)) {
            return $this->fallbackWeatherData('API key not configured');
        }

        try {
            $response = Http::timeout(5)->get($this->baseUrl, [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $temp = $data['main']['temp'] ?? 0;
                $humidity = $data['main']['humidity'] ?? 0;
                $windSpeed = ($data['wind']['speed'] ?? 0) * 3.6; // m/s to km/h
                $condition = $data['weather'][0]['description'] ?? 'Clear';
                $rainMm = $data['rain']['1h'] ?? ($data['rain']['3h'] ?? 0);

                // Severe weather indicator for mountainous agro-routes (Gayo highland corridors)
                $isHazardous = $rainMm > 20 || $windSpeed > 45 || str_contains(strtolower($condition), 'thunderstorm');

                return [
                    'success' => true,
                    'temp_c' => round($temp, 1),
                    'condition' => ucwords($condition),
                    'rain_mm' => round($rainMm, 1),
                    'wind_speed_kmh' => round($windSpeed, 1),
                    'humidity' => $humidity,
                    'is_hazardous' => $isHazardous,
                    'alert_summary' => $isHazardous
                        ? "Hazardous Weather Alert: {$condition}, Rain: {$rainMm}mm, Wind: {$windSpeed}km/h"
                        : "Weather normal: {$condition}, {$temp}°C",
                    'source' => 'OpenWeatherMap API Live',
                ];
            }

            Log::warning('OpenWeatherMap API response error: ' . $response->body());
            return $this->fallbackWeatherData('API returned status: ' . $response->status());
        } catch (\Throwable $e) {
            Log::warning('OpenWeatherMap API exception: ' . $e->getMessage());
            return $this->fallbackWeatherData($e->getMessage());
        }
    }

    /**
     * Get live corridor weather telemetry for the 3 key export transit hubs.
     */
    public function getCorridorTelemetry(): array
    {
        $takengon = $this->getWeatherByCoordinates(4.629, 96.845);
        $bireuen = $this->getWeatherByCoordinates(5.201, 96.702);
        $belawan = $this->getWeatherByCoordinates(3.784, 98.685);

        return [
            [
                'name' => 'Takengon Hub (1.200m)',
                'subtitle' => 'Gudang Asal Kopi & Cabai',
                'temp_c' => $takengon['temp_c'],
                'condition' => $takengon['condition'],
                'status_badge' => $takengon['is_hazardous'] ? 'Waspada Cuaca' : 'Optimal Kebun',
                'badge_color' => $takengon['is_hazardous'] ? 'amber' : 'emerald',
            ],
            [
                'name' => 'Jalur Bireuen - Takengon',
                'subtitle' => 'Koridor Darat Truk Ekspor',
                'temp_c' => $bireuen['temp_c'],
                'condition' => $bireuen['condition'],
                'status_badge' => $bireuen['is_hazardous'] ? 'Waspada Jalur' : 'Lancar Terkendali',
                'badge_color' => $bireuen['is_hazardous'] ? 'amber' : 'emerald',
            ],
            [
                'name' => 'Belawan Container Terminal',
                'subtitle' => 'Pelabuhan Muat Kapal Laut',
                'temp_c' => $belawan['temp_c'],
                'condition' => $belawan['condition'],
                'status_badge' => $belawan['is_hazardous'] ? 'Peringatan Ombak' : 'Dermaga Siap Muat',
                'badge_color' => $belawan['is_hazardous'] ? 'amber' : 'emerald',
            ],
        ];
    }

    /**
     * Get weather for a Location model.
     */
    public function getWeatherForLocation(Location $location): array
    {
        $weather = $this->getWeatherByCoordinates($location->latitude, $location->longitude);
        $weather['location_name'] = $location->name;
        $weather['city'] = $location->city;
        return $weather;
    }

    protected function fallbackWeatherData(string $reason): array
    {
        return [
            'success' => false,
            'temp_c' => 22.0,
            'condition' => 'Scattered Clouds (Simulated)',
            'rain_mm' => 0.0,
            'wind_speed_kmh' => 12.0,
            'humidity' => 65,
            'is_hazardous' => false,
            'alert_summary' => 'Simulated normal highland climate (Weather API fallback: ' . $reason . ')',
            'source' => 'Simulated Fallback',
        ];
    }
}

