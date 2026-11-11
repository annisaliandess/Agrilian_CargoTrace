<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(
        protected WeatherService $weatherService
    ) {}

    /**
     * Get live weather by Location ID or latitude/longitude.
     */
    public function query(Request $request): JsonResponse
    {
        if ($request->filled('location_id')) {
            $location = Location::find($request->location_id);
            if (!$location) {
                return response()->json(['success' => false, 'message' => 'Location not found.'], 404);
            }
            $weather = $this->weatherService->getWeatherForLocation($location);
            return response()->json(['success' => true, 'data' => $weather]);
        }

        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $weather = $this->weatherService->getWeatherByCoordinates(
            (float) $request->lat,
            (float) $request->lon
        );

        return response()->json(['success' => true, 'data' => $weather]);
    }
}
