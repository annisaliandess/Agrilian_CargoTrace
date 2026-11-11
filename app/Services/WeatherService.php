<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected ?string $apiKey;
    protected string $baseUrl = 'https://api.openweathermap.org/data/2.5/weather';

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key');
    }

    /**
     * Get live weather for a specific latitude and longitude.
     */
    public function getWeatherByCoordinates(float $lat, float $lon): array
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
        ];
    }
}
