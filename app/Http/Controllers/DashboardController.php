<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Notification;
use App\Models\Shipment;
use App\Models\ShipmentException;
use App\Services\CurrencyService;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request, CurrencyService $currencyService, WeatherService $weatherService)
    {
        $user = Auth::user();

        $query = Shipment::with(['origin', 'destination', 'currentLocation', 'carrier', 'customer']);

        if ($user->isCustomer()) {
            $query->where('customer_id', $user->id);
        }

        $totalShipments = (clone $query)->count();
        $inTransitCount = (clone $query)->where('status', 'IN_TRANSIT')->count();
        $deliveredCount = (clone $query)->where('status', 'DELIVERED')->count();
        $delayedCount = (clone $query)->where('is_delayed', true)->count();

        $recentShipments = (clone $query)->latest()->take(6)->get();

        // Active open exceptions
        $openExceptionsQuery = ShipmentException::with('shipment')
            ->where('status', '!=', 'RESOLVED')
            ->latest();

        if ($user->isCustomer()) {
            $openExceptionsQuery->whereHas('shipment', function ($q) use ($user) {
                $q->where('customer_id', $user->id);
            });
        }
        $openExceptions = $openExceptionsQuery->take(5)->get();

        // Locations for Leaflet map
        $locations = Location::all();

        // Notifications
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Live APIs: Currency Rates & Weather Corridor Telemetry
        $currencyRates = $currencyService->getRates();
        $corridorWeather = $weatherService->getCorridorTelemetry();

        // Total managed commodity weight & valuation
        $totalWeightKg = (clone $query)->sum('weight_kg');
        $totalValuation = $currencyService->convertIdr($totalWeightKg > 0 ? ($totalWeightKg * 115000) : 2185000000);

        // Chart.js Datasets Differentiated by Role
        if ($user->isCustomer()) {
            // Customer Charts: Personal Cargo Focus
            $doughnutLabels = ['Dalam Perjalanan (In Transit)', 'Sudah Tiba (Delivered)', 'Menunggu Jadwal (Booked)'];
            $doughnutData = [
                (clone $query)->where('status', 'IN_TRANSIT')->count(),
                (clone $query)->where('status', 'DELIVERED')->count(),
                (clone $query)->whereIn('status', ['CREATED', 'BOOKED', 'PICKED_UP'])->count(),
            ];

            $customerShipments = (clone $query)->latest()->take(6)->get();
            $barLabels = $customerShipments->pluck('tracking_number')->toArray();
            $barData = $customerShipments->pluck('weight_kg')->map(fn($w) => (float) $w)->toArray();
            $barTitle = 'Volume Kargo per Nomor Resi (kg)';
        } else {
            // Admin & Operator Charts: Global Logistics & Fleet Monitoring
            $doughnutLabels = ['Booked / Scheduled', 'Picked Up', 'In Transit', 'Delivered'];
            $doughnutData = [
                Shipment::where('status', 'BOOKED')->count(),
                Shipment::where('status', 'PICKED_UP')->count(),
                Shipment::where('status', 'IN_TRANSIT')->count(),
                Shipment::where('status', 'DELIVERED')->count(),
            ];

            $barLabels = ['Truk Dataran Tinggi (Road)', 'Kapal Samudera (Sea)', 'Kargo Udara (Air)'];
            $barData = [
                (float) Shipment::whereHas('carrier', fn($q) => $q->where('transport_mode', 'TRUCK'))->sum('weight_kg'),
                (float) Shipment::whereHas('carrier', fn($q) => $q->where('transport_mode', 'SEA'))->sum('weight_kg'),
                (float) Shipment::whereHas('carrier', fn($q) => $q->where('transport_mode', 'AIR'))->sum('weight_kg'),
            ];
            $barTitle = 'Total Volume Ekspor per Moda Transportasi (kg)';
        }

        return view('dashboard.index', compact(
            'totalShipments',
            'inTransitCount',
            'deliveredCount',
            'delayedCount',
            'recentShipments',
            'openExceptions',
            'locations',
            'notifications',
            'currencyRates',
            'corridorWeather',
            'totalValuation',
            'totalWeightKg',
            'doughnutLabels',
            'doughnutData',
            'barLabels',
            'barData',
            'barTitle'
        ));
    }

    public function markAllNotificationsRead(Request $request)
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return back()->with('success', 'Semua notifikasi berhasil ditandai sudah dibaca.');
    }

    public function commodities(CurrencyService $currencyService, WeatherService $weatherService)
    {
        $currencyRates = $currencyService->getRates();
        $corridorWeather = $weatherService->getCorridorTelemetry();

        $activeShipments = Shipment::with(['origin', 'destination', 'currentLocation', 'carrier'])
            ->latest()
            ->get();

        return view('commodities.index', compact('currencyRates', 'corridorWeather', 'activeShipments'));
    }
}
