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
        if (!$user || (!$user->isAdmin() && !$user->isOperator())) {
            abort(403, 'Unauthorized.');
        }

        $shipment = Shipment::findOrFail($shipmentId);

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

        return redirect()->route('shipments.show', $shipment->id)
            ->with('warning', "Exception [{$validated['exception_type']}] flagged. ETA updated.");
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

        return redirect()->route('shipments.show', $exception->shipment_id)
            ->with('success', 'Exception marked as RESOLVED.');
    }
}
