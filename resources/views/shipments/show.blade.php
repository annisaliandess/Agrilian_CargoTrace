@extends('layouts.app')

@section('title', 'Shipment ' . $shipment->tracking_number)

@section('content')
<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-extrabold text-slate-900 font-mono tracking-tight">{{ $shipment->tracking_number }}</h1>
                <a href="{{ route('track.public', $shipment->tracking_number) }}" target="_blank" class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 hover:bg-emerald-200 transition-colors flex items-center gap-1">
                    <span>Public Radar</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Commodity: <strong class="text-slate-800">{{ $shipment->cargo_type }}</strong> &bull; Carrier: <strong class="text-slate-800">{{ $shipment->carrier->name }}</strong>
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @php
                $badgeClass = match($shipment->status) {
                    'CREATED' => 'bg-slate-100 text-slate-800 border-slate-300',
                    'BOOKED' => 'bg-blue-100 text-blue-800 border-blue-300',
                    'PICKED_UP' => 'bg-amber-100 text-amber-800 border-amber-300',
                    'IN_TRANSIT' => 'bg-indigo-100 text-indigo-800 border-indigo-300 animate-pulse',
                    'DELIVERED' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                    default => 'bg-slate-100 text-slate-800',
                };
            @endphp
            <span class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold border uppercase tracking-wider {{ $badgeClass }}">
                {{ $shipment->status }}
            </span>

            @if($shipment->is_delayed)
                <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-amber-100 text-amber-900 border border-amber-300 flex items-center gap-1">
                    ⚠️ Delayed (+{{ $shipment->delay_duration_hours }}h)
                </span>
            @endif
        </div>
    </div>

    <!-- Main Grid: 2 Cols Left, 1 Col Right -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Map, Overview, Operator Control Panel, Timeline -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Map Card -->
            <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between mb-3 px-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <h3 class="text-sm font-bold text-slate-800">Live Trade Route & Checkpoints</h3>
                    </div>
                    <span class="text-xs text-slate-400">Leaflet.js &bull; OpenStreetMap</span>
                </div>
                <div id="shipment-map" class="w-full h-80 rounded-xl border border-slate-200"></div>
            </div>

            <!-- Operator Action Controls (Restricted to Admin & Operator) -->
            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs space-y-6">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                        Operator Control & Lifecycle Dispatch
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- 1. Status Transition Form -->
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">1. Transition Status</h4>
                            <p class="text-[11px] text-slate-500 mb-3">Service layer enforces strict lifecycle order: CREATED &rarr; BOOKED &rarr; PICKED_UP &rarr; IN_TRANSIT &rarr; DELIVERED.</p>

                            @php
                                $allowedMap = [
                                    'CREATED' => ['BOOKED'],
                                    'BOOKED' => ['PICKED_UP'],
                                    'PICKED_UP' => ['IN_TRANSIT'],
                                    'IN_TRANSIT' => ['DELIVERED'],
                                    'DELIVERED' => [],
                                ];
                                $allowed = $allowedMap[$shipment->status] ?? [];
                            @endphp

                            @if(count($allowed) > 0)
                                <form action="{{ route('shipments.status', $shipment->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Next Valid Status</label>
                                        <select name="status" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs bg-white font-semibold">
                                            @foreach($allowed as $target)
                                                <option value="{{ $target }}">{{ $target }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Checkpoint Location</label>
                                        <select name="location_id" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs bg-white">
                                            @foreach($locations as $l)
                                                <option value="{{ $l->id }}" {{ $shipment->current_location_id == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <input type="text" name="notes" placeholder="Optional operator remarks..." class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs bg-white">
                                    </div>
                                    <button type="submit" class="w-full py-2 px-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition-colors cursor-pointer">
                                        Advance Status &rarr;
                                    </button>
                                </form>
                            @else
                                <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium">
                                    ✓ Cargo is DELIVERED. Final lifecycle state reached.
                                </div>
                            @endif
                        </div>

                        <!-- 2. Log Checkpoint Milestone Event -->
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">2. Log Checkpoint Milestone</h4>
                            <p class="text-[11px] text-slate-500 mb-3">Record intermediate checkpoint without altering final status.</p>

                            <form action="{{ route('shipments.events.store', $shipment->id) }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Checkpoint Location *</label>
                                    <select name="location_id" required class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs bg-white">
                                        @foreach($locations as $l)
                                            <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->city }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Checkpoint Description *</label>
                                    <input type="text" name="description" placeholder="e.g. Scanned at Bireuen weigh station..." required
                                           class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs bg-white">
                                </div>
                                <button type="submit" class="w-full py-2 px-3 rounded-lg bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs shadow-xs transition-colors cursor-pointer">
                                    + Log Checkpoint
                                </button>
                            </form>
                        </div>

                        <!-- 3. Report Exception Modal / Form (Spans full width) -->
                        <div class="md:col-span-2 p-4 rounded-xl bg-amber-50/70 border border-amber-200">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-amber-900 mb-1">3. Trigger Route Exception & Recalculate ETA</h4>
                            <p class="text-[11px] text-amber-800 mb-3">Triggers delay threshold, queries OpenWeather API if weather-related, and dispatches notification alerts.</p>

                            <form action="{{ route('shipments.exceptions.store', $shipment->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-semibold text-amber-900 mb-1">Exception Type *</label>
                                    <select name="exception_type" required class="w-full px-2.5 py-1.5 rounded-lg border border-amber-300 text-xs bg-white">
                                        <option value="WEATHER_DELAY">WEATHER_DELAY (Landslide/Heavy Rain)</option>
                                        <option value="CUSTOMS_HOLD">CUSTOMS_HOLD (Phytosanitary/Customs)</option>
                                        <option value="PORT_CONGESTION">PORT_CONGESTION (Vessel Berth Wait)</option>
                                        <option value="DAMAGED">DAMAGED (Packaging Inspection)</option>
                                        <option value="MISROUTED">MISROUTED</option>
                                        <option value="DOCUMENTATION_ISSUE">DOCUMENTATION_ISSUE</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-amber-900 mb-1">Severity *</label>
                                    <select name="severity" required class="w-full px-2.5 py-1.5 rounded-lg border border-amber-300 text-xs bg-white">
                                        <option value="LOW">LOW (+4h delay)</option>
                                        <option value="MEDIUM" selected>MEDIUM (+8h delay)</option>
                                        <option value="HIGH">HIGH (+24h delay)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-amber-900 mb-1">Estimated Delay (Hours)</label>
                                    <input type="number" name="estimated_delay_hours" value="12" min="1" max="720" class="w-full px-2.5 py-1.5 rounded-lg border border-amber-300 text-xs bg-white">
                                </div>

                                <div class="sm:col-span-3">
                                    <label class="block text-xs font-semibold text-amber-900 mb-1">Incident Report Notes *</label>
                                    <input type="text" name="description" placeholder="Describe delay incident (e.g. Torrential rain on Gayo mountain pass)..." required
                                           class="w-full px-2.5 py-1.5 rounded-lg border border-amber-300 text-xs bg-white">
                                </div>

                                <div class="sm:col-span-3 text-right">
                                    <button type="submit" class="px-5 py-2 rounded-lg bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-xs transition-colors cursor-pointer">
                                        ⚠️ Flag Route Exception
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Chronological Milestones Timeline -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Audited Tracking Milestones ({{ $shipment->trackingEvents->count() }})
                </h3>

                <div class="relative pl-6 space-y-6 before:content-[''] before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    @forelse($shipment->trackingEvents as $event)
                        <div class="relative">
                            <div class="absolute -left-6 top-1.5 w-3.5 h-3.5 rounded-full bg-emerald-600 ring-4 ring-emerald-50"></div>
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="font-bold text-sm text-slate-800 flex items-center gap-2">
                                        <span>{{ $event->location->name ?? 'Logistics Checkpoint' }}</span>
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">{{ $event->status }}</span>
                                    </div>
                                    <span class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($event->event_time)->format('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-xs text-slate-600 mt-2 leading-relaxed">{{ $event->description }}</p>
                                @if($event->creator)
                                    <div class="text-[11px] text-slate-400 mt-2">
                                        Recorded by: {{ $event->creator->name }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic">No tracking events recorded yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right 1 Col: Live Weather, Manifest, Exceptions -->
        <div class="space-y-6">
            <!-- Live Weather at Checkpoint -->
            @if($weather)
                <div class="bg-gradient-to-br from-sky-950 via-slate-900 to-indigo-950 rounded-2xl p-5 text-white shadow-md border border-sky-800/40">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-sky-300 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                            Live Climate at Checkpoint
                        </span>
                        <span class="text-[10px] px-2 py-0.5 rounded bg-sky-800/60 text-sky-200">OpenWeather API</span>
                    </div>

                    <div class="flex items-baseline justify-between">
                        <div>
                            <div class="text-3xl font-extrabold">{{ $weather['temp_c'] }}°C</div>
                            <div class="text-xs text-sky-200 mt-0.5">{{ $weather['condition'] }}</div>
                            <div class="text-[11px] text-sky-300 font-semibold mt-1">{{ $weather['location_name'] ?? ($shipment->currentLocation->name ?? '') }}</div>
                        </div>
                        <div class="text-right text-xs text-sky-200 space-y-1">
                            <div>Precipitation: <strong class="text-white">{{ $weather['rain_mm'] }} mm</strong></div>
                            <div>Wind: <strong class="text-white">{{ $weather['wind_speed_kmh'] }} km/h</strong></div>
                            <div>Humidity: <strong class="text-white">{{ $weather['humidity'] }}%</strong></div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-sky-800/60 text-xs {{ $weather['is_hazardous'] ? 'text-amber-300 font-bold' : 'text-sky-200' }}">
                        {{ $weather['alert_summary'] }}
                    </div>
                </div>
            @endif

            <!-- Exceptions & Delays Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center justify-between">
                    <span>Recorded Exceptions ({{ $shipment->exceptions->count() }})</span>
                    @if($shipment->is_delayed)
                        <span class="text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded">
                            +{{ $shipment->delay_duration_hours }}h Total Delay
                        </span>
                    @endif
                </h3>

                <div class="space-y-3">
                    @forelse($shipment->exceptions as $exc)
                        <div class="p-3.5 rounded-xl {{ $exc->status === 'RESOLVED' ? 'bg-slate-50 border-slate-200' : 'bg-amber-50 border-amber-200' }} border text-xs">
                            <div class="flex items-center justify-between">
                                <span class="font-bold {{ $exc->status === 'RESOLVED' ? 'text-slate-800' : 'text-amber-900' }}">{{ $exc->exception_type }}</span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ $exc->status === 'RESOLVED' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $exc->status }}
                                </span>
                            </div>
                            <p class="text-slate-600 mt-1 leading-relaxed">{{ $exc->description }}</p>

                            @if($exc->status !== 'RESOLVED' && (auth()->user()->isAdmin() || auth()->user()->isOperator()))
                                <form action="{{ route('exceptions.resolve', $exc->id) }}" method="POST" class="mt-3 pt-2 border-t border-amber-200 flex gap-2">
                                    @csrf
                                    <input type="text" name="resolution_notes" placeholder="Resolution action taken..." required
                                           class="flex-1 px-2 py-1 rounded border border-amber-300 bg-white text-xs">
                                    <button type="submit" class="px-2.5 py-1 rounded bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] cursor-pointer">
                                        Resolve
                                    </button>
                                </form>
                            @elseif($exc->resolution_notes)
                                <div class="mt-2 pt-2 border-t border-slate-200 text-emerald-700 text-[11px] font-medium">
                                    Resolved: {{ $exc->resolution_notes }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic py-2">No exceptions recorded. Shipment in good order.</div>
                    @endforelse
                </div>
            </div>

            <!-- Cargo Items Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center justify-between">
                    <span>Cargo Manifest</span>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded bg-slate-100 text-slate-700">
                        {{ number_format($shipment->weight_kg, 0) }} kg
                    </span>
                </h3>

                <div class="space-y-3">
                    @forelse($shipment->items as $item)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            <div class="font-bold text-slate-800">{{ $item->item_name }}</div>
                            <div class="flex justify-between text-slate-500 mt-1">
                                <span>Quantity: <strong>{{ $item->quantity }} units</strong></span>
                                <span>Weight: <strong>{{ number_format($item->weight_kg, 0) }} kg</strong></span>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-1">Packaging: {{ $item->package_type }}</div>
                            @if($item->description)
                                <p class="text-[11px] text-slate-500 italic mt-1">{{ $item->description }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic">No specific items listed.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapEl = document.getElementById('shipment-map');
        if (!mapEl) return;

        const originLat = {{ $shipment->origin->latitude }};
        const originLon = {{ $shipment->origin->longitude }};
        const destLat = {{ $shipment->destination->latitude }};
        const destLon = {{ $shipment->destination->longitude }};
        const currentLat = {{ $shipment->currentLocation->latitude ?? $shipment->origin->latitude }};
        const currentLon = {{ $shipment->currentLocation->longitude ?? $shipment->origin->longitude }};

        const map = L.map('shipment-map').setView([currentLat, currentLon], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([originLat, originLon]).addTo(map).bindPopup("<b>Origin:</b> {{ $shipment->origin->name }}<br>{{ $shipment->origin->city }}");
        L.marker([destLat, destLon]).addTo(map).bindPopup("<b>Destination:</b> {{ $shipment->destination->name }}<br>{{ $shipment->destination->city }}");

        L.circleMarker([currentLat, currentLon], {
            radius: 9,
            color: '{{ $shipment->is_delayed ? "#b45309" : "#059669" }}',
            fillColor: '{{ $shipment->is_delayed ? "#f59e0b" : "#10b981" }}',
            fillOpacity: 0.9,
            weight: 3
        }).addTo(map).bindPopup("<b>Current Cargo Position:</b><br>{{ $shipment->currentLocation->name ?? 'In Transit' }}<br>Status: {{ $shipment->status }}").openPopup();

        const routePoints = [
            [originLat, originLon],
            [currentLat, currentLon],
            [destLat, destLon]
        ];
        L.polyline(routePoints, {
            color: '{{ $shipment->is_delayed ? "#b45309" : "#059669" }}',
            weight: 3,
            opacity: 0.7,
            dashArray: '6, 8'
        }).addTo(map);

        const bounds = L.latLngBounds([
            [originLat, originLon],
            [currentLat, currentLon],
            [destLat, destLon]
        ]);
        map.fitBounds(bounds, { padding: [40, 40] });
    });
</script>
@endpush
@endsection
