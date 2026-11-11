<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\TrackingEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TrackingService
{
    /**
     * Record an immutable tracking milestone for a shipment.
     */
    public function recordEvent(Shipment $shipment, array $data, ?User $user = null): TrackingEvent
    {
        return DB::transaction(function () use ($shipment, $data, $user) {
            $createdById = $user?->id ?? $data['created_by'] ?? 1;
            $locationId = $data['location_id'];
            $location = Location::find($locationId);

            $lat = $data['latitude'] ?? $location?->latitude;
            $lon = $data['longitude'] ?? $location?->longitude;
            $eventTime = isset($data['event_time']) ? Carbon::parse($data['event_time']) : Carbon::now();

            $event = TrackingEvent::create([
                'shipment_id' => $shipment->id,
                'location_id' => $locationId,
                'status' => $data['status'] ?? $shipment->status,
                'event_time' => $eventTime,
                'latitude' => $lat,
                'longitude' => $lon,
                'description' => $data['description'],
                'created_by' => $createdById,
            ]);

            // Synchronize shipment current location and status
            $oldShipment = $shipment->toArray();
            $shipment->current_location_id = $locationId;

            if (!empty($data['status'])) {
                $shipment->status = $data['status'];
            }

            $shipment->save();

            // Audit log
            AuditLog::create([
                'user_id' => $createdById,
                'action' => 'ADD_TRACKING_EVENT',
                'entity_type' => 'TrackingEvent',
                'entity_id' => $event->id,
                'old_values' => ['current_location_id' => $oldShipment['current_location_id'], 'status' => $oldShipment['status']],
                'new_values' => ['current_location_id' => $locationId, 'status' => $shipment->status, 'event_id' => $event->id],
                'ip_address' => request()?->ip() ?? '127.0.0.1',
            ]);

            return $event;
        });
    }

    /**
     * Retrieve complete chronological timeline for a shipment.
     */
    public function getTimeline(Shipment $shipment)
    {
        return $shipment->trackingEvents()
            ->with(['location', 'creator'])
            ->orderBy('event_time', 'asc')
            ->get();
    }
}
