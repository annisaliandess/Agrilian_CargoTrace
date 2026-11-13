<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Shipment;
use App\Services\CurrencyService;
use App\Services\ShipmentService;
use App\Services\TrackingService;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function __construct(
        protected ShipmentService $shipmentService,
        protected TrackingService $trackingService,
        protected WeatherService $weatherService,
        protected CurrencyService $currencyService
    ) {}

    /**
     * Public Cargo Tracking Page / Search.
     */
    public function publicTrack(Request $request, ?string $tracking_number = null)
    {
        $query = $tracking_number ?? $request->query('tracking_number');
        $shipment = null;
        $weather = null;
        $valuation = null;

        if ($query) {
            $shipment = $this->shipmentService->findShipment(trim($query));
            if ($shipment) {
                if ($shipment->currentLocation) {
                    $weather = $this->weatherService->getWeatherForLocation($shipment->currentLocation);
                }
                $valuation = $this->currencyService->estimateShipmentValuation(
                    $shipment->cargo_type,
                    (float) $shipment->weight_kg
                );
            }
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            if (!$shipment) {
                return response()->json(['success' => false, 'message' => 'Tracking number not found.'], 404);
            }
            return response()->json([
                'success' => true,
                'data' => $shipment,
                'weather' => $weather,
                'valuation' => $valuation,
            ]);
        }

        return view('tracking.public', compact('shipment', 'query', 'weather', 'valuation'));
    }

    /**
     * Record a new tracking checkpoint event.
     */
    public function storeEvent(Request $request, $shipmentId)
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isOperator())) {
            abort(403, 'Unauthorized.');
        }

        $shipment = Shipment::findOrFail($shipmentId);

        $validated = $request->validate([
            'location_id' => 'required|exists:locations,id',
            'status' => 'nullable|in:CREATED,BOOKED,PICKED_UP,IN_TRANSIT,DELIVERED',
            'description' => 'required|string|max:500',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'event_time' => 'nullable|date',
        ]);

        $event = $this->trackingService->recordEvent($shipment, $validated, $user);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Tracking event logged.',
                'data' => $event,
            ], 201);
        }

        return redirect()->route('shipments.show', $shipment->id)
            ->with('success', 'New tracking checkpoint milestone recorded.');
    }
}
