<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Notification;
use App\Models\Shipment;
use App\Models\ShipmentException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExceptionService
{
    public function __construct(
        protected WeatherService $weatherService,
        protected EtaService $etaService
    ) {}

    /**
     * Report a new shipment exception (e.g. WEATHER_DELAY, CUSTOMS_HOLD).
     */
    public function reportException(Shipment $shipment, array $data, ?User $user = null): ShipmentException
    {
        return DB::transaction(function () use ($shipment, $data, $user) {
            $reportedById = $user?->id ?? $data['reported_by'] ?? 1;
            $exceptionType = $data['exception_type'];
            $severity = $data['severity'] ?? 'MEDIUM';
            $description = $data['description'];

            // Enrich weather delays with real OpenWeather API data if available
            if ($exceptionType === 'WEATHER_DELAY' && $shipment->currentLocation) {
                $weather = $this->weatherService->getWeatherForLocation($shipment->currentLocation);
                $description .= " [Live Weather at {$shipment->currentLocation->name}: {$weather['condition']}, {$weather['temp_c']}°C, Rain: {$weather['rain_mm']}mm, Wind: {$weather['wind_speed_kmh']}km/h]";
            }

            $exception = ShipmentException::create([
                'shipment_id' => $shipment->id,
                'exception_type' => $exceptionType,
                'severity' => $severity,
                'status' => 'OPEN',
                'description' => $description,
                'detected_at' => Carbon::now(),
                'reported_by' => $reportedById,
            ]);

            // Flag shipment as delayed if appropriate
            $additionalDelayHours = $data['estimated_delay_hours'] ?? ($severity === 'HIGH' ? 24 : ($severity === 'MEDIUM' ? 8 : 4));
            $newEstimated = Carbon::parse($shipment->estimated_arrival)->addHours($additionalDelayHours);

            $this->etaService->updateEstimatedArrival(
                $shipment,
                $newEstimated,
                "Exception [{$exceptionType}]: {$data['description']}"
            );

            // Notify Customer & Admin
            Notification::create([
                'user_id' => $shipment->customer_id,
                'title' => "Shipment Alert: {$shipment->tracking_number}",
                'message' => "An exception was reported for your cargo: {$exceptionType}. Severity: {$severity}. {$description}",
                'type' => 'EXCEPTION_ALERT',
                'is_read' => false,
            ]);

            // Audit log
            AuditLog::create([
                'user_id' => $reportedById,
                'action' => 'TRIGGER_EXCEPTION',
                'entity_type' => 'ShipmentException',
                'entity_id' => $exception->id,
                'old_values' => null,
                'new_values' => $exception->toArray(),
                'ip_address' => request()?->ip() ?? '127.0.0.1',
            ]);

            return $exception;
        });
    }

    /**
     * Resolve an existing exception.
     */
    public function resolveException(ShipmentException $exception, string $resolutionNotes, ?User $user = null): ShipmentException
    {
        return DB::transaction(function () use ($exception, $resolutionNotes, $user) {
            $oldValues = $exception->toArray();

            $exception->update([
                'status' => 'RESOLVED',
                'resolved_at' => Carbon::now(),
                'resolution_notes' => $resolutionNotes,
            ]);

            // Audit log
            AuditLog::create([
                'user_id' => $user?->id ?? 1,
                'action' => 'RESOLVE_EXCEPTION',
                'entity_type' => 'ShipmentException',
                'entity_id' => $exception->id,
                'old_values' => $oldValues,
                'new_values' => $exception->fresh()->toArray(),
                'ip_address' => request()?->ip() ?? '127.0.0.1',
            ]);

            return $exception;
        });
    }
}
