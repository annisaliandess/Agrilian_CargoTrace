<?php

namespace App\Services;

use App\Models\Shipment;
use Carbon\Carbon;

class EtaService
{
    /**
     * Calculate delay status, duration, and severity for a shipment.
     */
    public function evaluateDelay(Shipment $shipment, ?Carbon $estimatedArrival = null): array
    {
        $estimated = $estimatedArrival ?? ($shipment->estimated_arrival ? Carbon::parse($shipment->estimated_arrival) : null);
        $expected = $shipment->expected_arrival ? Carbon::parse($shipment->expected_arrival) : null;

        if (!$estimated || !$expected) {
            return [
                'is_delayed' => false,
                'delay_duration_hours' => 0,
                'delay_severity' => 'NONE',
            ];
        }

        // Delay occurs when estimated arrival is strictly after expected arrival
        if ($estimated->greaterThan($expected)) {
            $delayHours = (int) ceil($expected->diffInMinutes($estimated) / 60);

            $severity = 'LOW';
            if ($delayHours > 24) {
                $severity = 'HIGH';
            } elseif ($delayHours > 6) {
                $severity = 'MEDIUM';
            }

            return [
                'is_delayed' => true,
                'delay_duration_hours' => $delayHours,
                'delay_severity' => $severity,
            ];
        }

        return [
            'is_delayed' => false,
            'delay_duration_hours' => 0,
            'delay_severity' => 'NONE',
        ];
    }

    /**
     * Recalculate and update shipment ETA.
     */
    public function updateEstimatedArrival(Shipment $shipment, Carbon $newEstimatedArrival, ?string $reason = null): Shipment
    {
        $delayEval = $this->evaluateDelay($shipment, $newEstimatedArrival);

        $shipment->estimated_arrival = $newEstimatedArrival;
        $shipment->is_delayed = $delayEval['is_delayed'];
        $shipment->delay_duration_hours = $delayEval['delay_duration_hours'];
        $shipment->delay_severity = $delayEval['delay_severity'];

        if ($reason) {
            $shipment->delay_reason = $reason;
        } elseif (!$delayEval['is_delayed']) {
            $shipment->delay_reason = null;
        }

        $shipment->save();

        return $shipment;
    }
}
