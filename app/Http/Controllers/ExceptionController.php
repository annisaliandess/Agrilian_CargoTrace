<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\ShipmentException;
use App\Services\ExceptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExceptionController extends Controller
{
    public function __construct(
        protected ExceptionService $exceptionService
    ) {}

    /**
     * Report an exception on a shipment.
     */
    public function store(Request $request, $shipmentId)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized.');
        }

        $shipment = Shipment::findOrFail($shipmentId);

        // RBAC: Admin & Operator can file any exception; Customer can file damage/quality dispute on own shipment
        if ($user->isCustomer() && $shipment->customer_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'exception_type' => 'required|in:WEATHER_DELAY,CUSTOMS_HOLD,PORT_CONGESTION,DAMAGED,MISROUTED,DOCUMENTATION_ISSUE',
            'severity' => 'required|in:LOW,MEDIUM,HIGH',
            'description' => 'required|string|max:1000',
            'estimated_delay_hours' => 'nullable|integer|min:1|max:720',
        ]);

        $exception = $this->exceptionService->reportException($shipment, $validated, $user);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Shipment exception reported and delay recalculated.',
                'data' => $exception,
            ], 201);
        }

        $typeLabel = match($validated['exception_type']) {
            'DAMAGED' => app()->getLocale() === 'en' ? 'Cargo Damage' : 'Kerusakan Barang',
            'WEATHER_DELAY' => app()->getLocale() === 'en' ? 'Weather Delay' : 'Kendala Cuaca Buruk',
            'CUSTOMS_HOLD' => app()->getLocale() === 'en' ? 'Customs Hold' : 'Pemeriksaan Bea Cukai',
            'PORT_CONGESTION' => app()->getLocale() === 'en' ? 'Port Congestion' : 'Kepadatan Pelabuhan',
            default => $validated['exception_type'],
        };

        $msg = app()->getLocale() === 'en'
            ? "Exception report [{$typeLabel}] recorded successfully. Consignment status under investigation."
            : "Laporan kendala [{$typeLabel}] berhasil dicatat. Status kargo dalam penanganan.";

        return redirect()->route('shipments.show', $shipment->id)
            ->with('warning', $msg);
    }

    /**
     * Resolve an exception.
     */
    public function resolve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isOperator())) {
            abort(403, 'Unauthorized.');
        }

        $exception = ShipmentException::findOrFail($id);

        $validated = $request->validate([
            'resolution_notes' => 'required|string|max:1000',
        ]);

        $resolved = $this->exceptionService->resolveException($exception, $validated['resolution_notes'], $user);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Exception resolved successfully.',
                'data' => $resolved,
            ]);
        }

        $msg = app()->getLocale() === 'en'
            ? 'Exception marked as RESOLVED successfully.'
            : 'Kendala operasional kargo berhasil diselesaikan (Tuntas).';

        return redirect()->route('shipments.show', $exception->shipment_id)
            ->with('success', $msg);
    }
}
