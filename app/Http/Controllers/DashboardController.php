<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Notification;
use App\Models\Shipment;
use App\Models\ShipmentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
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

        return view('dashboard.index', compact(
            'totalShipments',
            'inTransitCount',
            'deliveredCount',
            'delayedCount',
            'recentShipments',
            'openExceptions',
            'locations',
            'notifications'
        ));
    }
}
