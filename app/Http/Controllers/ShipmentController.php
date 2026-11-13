<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\User;
use App\Services\CurrencyService;
use App\Services\ShipmentService;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class ShipmentController extends Controller
{
    public function __construct(
        protected ShipmentService $shipmentService,
        protected WeatherService $weatherService,
        protected CurrencyService $currencyService
    ) {}

    /**
     * Display a listing of shipments (Web view or JSON).
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Shipment::with(['origin', 'destination', 'currentLocation', 'carrier', 'customer'])
            ->latest();

        // RBAC: Customers can only see their own shipments
        if ($user && $user->isCustomer()) {
            $query->where('customer_id', $user->id);
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('carrier_id')) {
            $query->where('carrier_id', $request->carrier_id);
        }

        if ($request->filled('delayed')) {
            $query->where('is_delayed', $request->boolean('delayed'));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tracking_number', 'like', "%{$search}%")
                  ->orWhere('cargo_type', 'like', "%{$search}%");
            });
        }

        $shipments = $query->paginate(10)->withQueryString();
        $carriers = Carrier::where('is_active', true)->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $shipments,
            ]);
        }

        return view('shipments.index', compact('shipments', 'carriers'));
    }

    /**
     * Show form to create a new shipment.
     */
    public function create()
    {
        $this->authorizeOperatorOrAdmin();

        $customers = User::where('role', 'customer')->get();
        $carriers = Carrier::where('is_active', true)->get();
        $locations = Location::orderBy('name')->get();

        return view('shipments.create', compact('customers', 'carriers', 'locations'));
    }

    /**
     * Store a newly created shipment.
     */
    public function store(Request $request)
    {
        $this->authorizeOperatorOrAdmin();

        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'carrier_id' => 'required|exists:carriers,id',
            'origin_id' => 'required|exists:locations,id',
            'destination_id' => 'required|exists:locations,id|different:origin_id',
            'cargo_type' => 'required|string|max:255',
            'weight_kg' => 'required|numeric|min:0.1',
            'volume_cbm' => 'nullable|numeric|min:0.01',
            'expected_departure' => 'required|date',
            'expected_arrival' => 'required|date|after:expected_departure',
            'items' => 'nullable|array',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.weight_kg' => 'required|numeric|min:0.1',
            'items.*.package_type' => 'nullable|string',
            'items.*.description' => 'nullable|string',
        ]);

        $shipment = $this->shipmentService->createShipment($validated, Auth::user());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Shipment created successfully.',
                'data' => $shipment,
            ], 201);
        }

        return redirect()->route('shipments.show', $shipment->id)
            ->with('success', "Shipment {$shipment->tracking_number} created successfully.");
    }

    /**
     * Display a specific shipment with route map, tracking milestones, and exceptions.
     */
    public function show(Request $request, $id)
    {
        $shipment = $this->shipmentService->findShipment($id);

        if (!$shipment) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Shipment not found.'], 404);
            }
            abort(404, 'Shipment not found');
        }

        $user = Auth::user();
        if ($user && $user->isCustomer() && $shipment->customer_id !== $user->id) {
            abort(403, 'Unauthorized to view this shipment.');
        }

        // Live weather at current location or destination
        $targetLocation = $shipment->currentLocation ?? $shipment->destination;
        $weather = $targetLocation ? $this->weatherService->getWeatherForLocation($targetLocation) : null;

        // Export valuation via CurrencyService (IDR, USD, EUR)
        $valuation = $this->currencyService->estimateShipmentValuation(
            $shipment->cargo_type,
            (float) $shipment->weight_kg
        );

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $shipment,
                'live_weather' => $weather,
                'valuation' => $valuation,
            ]);
        }

        $locations = Location::orderBy('name')->get();

        return view('shipments.show', compact('shipment', 'weather', 'locations', 'valuation'));
    }

    /**
     * Generate printable official multimodal export waybill (Surat Jalan Ekspor).
     */
    public function printWaybill(Request $request, $id)
    {
        $shipment = $this->shipmentService->findShipment($id);

        if (!$shipment) {
            abort(404, 'Shipment not found');
        }

        $user = Auth::user();
        if ($user && $user->isCustomer() && $shipment->customer_id !== $user->id) {
            abort(403, 'Unauthorized to view this waybill.');
        }

        $valuation = $this->currencyService->estimateShipmentValuation(
            $shipment->cargo_type,
            (float) $shipment->weight_kg
        );

        return view('shipments.print', compact('shipment', 'valuation'));
    }

    /**
     * Transition shipment status.
     */
    public function updateStatus(Request $request, $id)
    {
        $this->authorizeOperatorOrAdmin();

        $validated = $request->validate([
            'status' => 'required|in:BOOKED,PICKED_UP,IN_TRANSIT,DELIVERED',
            'location_id' => 'nullable|exists:locations,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $shipment = Shipment::findOrFail($id);

        try {
            $updated = $this->shipmentService->transitionStatus(
                $shipment,
                $validated['status'],
                $validated['location_id'] ?? null,
                $validated['notes'] ?? null,
                Auth::user()
            );

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Status transitioned to {$validated['status']}.",
                    'data' => $updated,
                ]);
            }

            return redirect()->route('shipments.show', $shipment->id)
                ->with('success', "Status updated to {$validated['status']}.");
        } catch (InvalidArgumentException $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    protected function authorizeOperatorOrAdmin(): void
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isOperator())) {
            abort(403, 'Access denied. Only Admins and Operators can perform this action.');
        }
    }
}
