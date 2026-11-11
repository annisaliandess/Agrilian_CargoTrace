@extends('layouts.app')

@section('title', 'Consignment ' . $shipment->tracking_number)

@section('content')
<div class="space-y-6">

    <!-- Top Action & Waybill Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            @php
                $isCoffee = str_contains(strtolower($shipment->cargo_type), 'arabica') || str_contains(strtolower($shipment->cargo_type), 'coffee');
                $isHorti = str_contains(strtolower($shipment->cargo_type), 'avocado') || str_contains(strtolower($shipment->cargo_type), 'chili');
            @endphp

            <div class="flex items-center gap-2 mb-1.5">
                @if($isCoffee)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono uppercase font-bold bg-amber-50 text-amber-900 border border-amber-200">
                        ☕ Specialty Arabica Coffee
                    </span>
                @elseif($isHorti)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono uppercase font-bold bg-emerald-50 text-emerald-900 border border-emerald-200">
                        🥑 Perishable Horticulture
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono uppercase font-bold bg-stone-100 text-stone-800 border border-stone-200">
                        📦 Agro-Export Cargo
                    </span>
                @endif
                <span class="text-xs font-mono text-stone-400">Carrier: {{ $shipment->carrier->name }}</span>
            </div>

            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-extrabold text-espresso-950 font-mono tracking-tight">{{ $shipment->tracking_number }}</h1>
                <a href="{{ route('track.public', $shipment->tracking_number) }}" target="_blank" class="px-2.5 py-0.5 rounded text-[11px] font-mono font-semibold bg-stone-100 text-stone-700 hover:bg-stone-200 border border-stone-200 transition-colors flex items-center gap-1">
                    <span>Public Radar View</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
            <p class="text-xs text-stone-600 mt-0.5">
                Consignee: <strong class="text-stone-900">{{ $shipment->customer->name ?? 'Confidential' }}</strong> &bull; Commodity: <strong class="text-stone-900">{{ $shipment->cargo_type }}</strong>
            </p>
        </div>

        <!-- Badges -->
        <div class="flex flex-wrap items-center gap-2">
            @php
                $badgeStyle = match($shipment->status) {
                    'CREATED' => 'bg-stone-100 text-stone-800 border-stone-300',
                    'BOOKED' => 'bg-blue-50 text-blue-900 border-blue-200',
                    'PICKED_UP' => 'bg-amber-50 text-amber-900 border-amber-200',
                    'IN_TRANSIT' => 'bg-emerald-50 text-emerald-900 border-emerald-300',
                    'DELIVERED' => 'bg-stone-900 text-white border-stone-900',
                    default => 'bg-stone-100 text-stone-800',
                };
            @endphp
            <span class="px-3.5 py-1 rounded text-xs font-mono font-bold uppercase tracking-wider border {{ $badgeStyle }}">
                {{ $shipment->status }}
            </span>

            @if($shipment->is_delayed)
                <span class="px-3 py-1 rounded text-xs font-mono font-bold bg-amber-50 text-amber-900 border border-amber-300 flex items-center gap-1">
                    ⚠️ Delayed (+{{ $shipment->delay_duration_hours }}h)
                </span>
            @endif
        </div>
    </div>

    <!-- Main Grid: 2 Cols Left, 1 Col Right -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Waybill Stepper, Map, Operator Panel, Timeline -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Stepper Progress Bar Card -->
            <div class="bg-white rounded-xl border border-stone-200 p-5 shadow-xs">
                <div class="flex items-center justify-between pb-3 border-b border-stone-100 text-xs font-mono">
                    <span class="text-stone-500 uppercase tracking-wider text-[10px]">Transit Corridor Lifecycle</span>
                    <span class="text-stone-900 font-bold">Route: {{ $shipment->origin->city }} &rarr; {{ $shipment->destination->city }}</span>
                </div>

                @php
                    $steps = ['CREATED', 'BOOKED', 'PICKED_UP', 'IN_TRANSIT', 'DELIVERED'];
                    $currentIdx = array_search($shipment->status, $steps);
                    if ($currentIdx === false) $currentIdx = 0;
                @endphp

                <div class="grid grid-cols-5 gap-1.5 mt-4">
                    @foreach($steps as $idx => $step)
                        <div>
                            <div class="h-1.5 rounded-xs transition-colors {{ $idx <= $currentIdx ? 'bg-canopy-800' : 'bg-stone-200' }}"></div>
                            <div class="mt-1.5 flex items-center justify-between">
                                <span class="font-mono text-[9px] uppercase tracking-wider font-semibold {{ $idx <= $currentIdx ? 'text-stone-900' : 'text-stone-400' }}">
                                    {{ str_replace('_', ' ', $step) }}
                                </span>
                                @if($idx <= $currentIdx)
                                    <span class="text-[9px] text-canopy-800 font-bold">✓</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Map Card -->
            <div class="bg-white rounded-xl border border-stone-200 p-4 shadow-xs">
                <div class="flex items-center justify-between mb-3 px-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-canopy-800"></span>
                        <h3 class="text-xs font-bold font-mono uppercase tracking-wider text-stone-900">Live Trade Route Cockpit</h3>
                    </div>
                    <span class="text-[10px] font-mono text-stone-400">Leaflet.js &bull; OpenStreetMap</span>
                </div>
                <div id="shipment-map" class="w-full h-80 rounded-lg border border-stone-200"></div>
            </div>

            <!-- Operator Control Panel (Admin & Operator only) -->
            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-xs space-y-6">
                    <div class="border-b border-stone-100 pb-3 flex items-center justify-between">
                        <h3 class="text-xs font-bold font-mono uppercase tracking-wider text-stone-900 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-stone-900"></span>
                            Operator Control & Dispatch Desk
                        </h3>
                        <span class="text-[10px] font-mono text-stone-400">Authorized: {{ auth()->user()->role }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- 1. Status Transition Form -->
                        <div class="p-4 rounded-lg bg-stone-50 border border-stone-200">
                            <h4 class="text-xs font-mono font-bold uppercase tracking-wider text-stone-800 mb-1">1. Advance Lifecycle State</h4>
                            <p class="text-[11px] text-stone-500 mb-3">Service layer enforces strict sequential validation (CREATED &rarr; BOOKED &rarr; PICKED UP &rarr; IN TRANSIT &rarr; DELIVERED).</p>

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
                                        <label class="block text-[11px] font-mono font-semibold text-stone-700 mb-1">Next Valid Lifecycle Status</label>
                                        <select name="status" required class="w-full px-2.5 py-1.5 rounded border border-stone-300 text-xs bg-white font-mono font-bold">
                                            @foreach($allowed as $target)
                                                <option value="{{ $target }}">{{ $target }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-mono font-semibold text-stone-700 mb-1">Checkpoint Hub</label>
                                        <select name="location_id" class="w-full px-2.5 py-1.5 rounded border border-stone-300 text-xs bg-white">
                                            @foreach($locations as $l)
                                                <option value="{{ $l->id }}" {{ $shipment->current_location_id == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <input type="text" name="notes" placeholder="Operator remarks (e.g. Scanned at Belawan)..." class="w-full px-2.5 py-1.5 rounded border border-stone-300 text-xs bg-white">
                                    </div>
                                    <button type="submit" class="w-full py-2 px-3 rounded bg-canopy-800 hover:bg-canopy-900 text-white font-bold text-xs shadow-2xs transition-colors cursor-pointer font-mono">
                                        Advance State &rarr;
                                    </button>
                                </form>
                            @else
                                <div class="p-3 rounded bg-stone-100 border border-stone-200 text-stone-700 text-xs font-mono">
                                    ✓ Cargo is DELIVERED. Terminal state reached.
                                </div>
                            @endif
                        </div>

                        <!-- 2. Log Checkpoint Milestone Event -->
                        <div class="p-4 rounded-lg bg-stone-50 border border-stone-200">
                            <h4 class="text-xs font-mono font-bold uppercase tracking-wider text-stone-800 mb-1">2. Log Checkpoint Milestone</h4>
                            <p class="text-[11px] text-stone-500 mb-3">Record intermediate checkpoint scan without changing the primary status.</p>

                            <form action="{{ route('shipments.events.store', $shipment->id) }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-[11px] font-mono font-semibold text-stone-700 mb-1">Checkpoint Hub *</label>
                                    <select name="location_id" required class="w-full px-2.5 py-1.5 rounded border border-stone-300 text-xs bg-white">
                                        @foreach($locations as $l)
                                            <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->city }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-mono font-semibold text-stone-700 mb-1">Scan Description *</label>
                                    <input type="text" name="description" placeholder="e.g. Cleared Bireuen weigh station, moisture checked..." required
                                           class="w-full px-2.5 py-1.5 rounded border border-stone-300 text-xs bg-white">
                                </div>
                                <button type="submit" class="w-full py-2 px-3 rounded bg-espresso-900 hover:bg-black text-white font-bold text-xs shadow-2xs transition-colors cursor-pointer font-mono">
                                    + Log Milestone
                                </button>
                            </form>
                        </div>

                        <!-- 3. Report Exception Modal / Form (Spans full width) -->
                        <div class="md:col-span-2 p-4 rounded-lg bg-amber-50/70 border border-amber-200">
                            <h4 class="text-xs font-mono font-bold uppercase tracking-wider text-amber-950 mb-1">3. Trigger Route Exception & Recalculate ETA</h4>
                            <p class="text-[11px] text-amber-800 mb-3">Automatically triggers OpenWeather API evaluation if weather-related, recalculates delay severity, and dispatches notifications.</p>

                            <form action="{{ route('shipments.exceptions.store', $shipment->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @csrf
                                <div>
                                    <label class="block text-[11px] font-mono font-semibold text-amber-950 mb-1">Exception Category *</label>
                                    <select name="exception_type" required class="w-full px-2 py-1.5 rounded border border-amber-300 text-xs bg-white font-mono">
                                        <option value="WEATHER_DELAY">WEATHER_DELAY (Landslide/Torrential Rain)</option>
                                        <option value="CUSTOMS_HOLD">CUSTOMS_HOLD (Phytosanitary/Customs)</option>
                                        <option value="PORT_CONGESTION">PORT_CONGESTION (Vessel Berth Queue)</option>
                                        <option value="DAMAGED">DAMAGED (Seal/Packaging Inspection)</option>
                                        <option value="MISROUTED">MISROUTED</option>
                                        <option value="DOCUMENTATION_ISSUE">DOCUMENTATION_ISSUE</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-mono font-semibold text-amber-950 mb-1">Severity *</label>
                                    <select name="severity" required class="w-full px-2 py-1.5 rounded border border-amber-300 text-xs bg-white font-mono">
                                        <option value="LOW">LOW (+4h delay)</option>
                                        <option value="MEDIUM" selected>MEDIUM (+8h delay)</option>
                                        <option value="HIGH">HIGH (+24h delay)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-mono font-semibold text-amber-950 mb-1">Estimated Hold (Hours)</label>
                                    <input type="number" name="estimated_delay_hours" value="12" min="1" max="720" class="w-full px-2 py-1.5 rounded border border-amber-300 text-xs bg-white font-mono">
                                </div>

                                <div class="sm:col-span-3">
                                    <label class="block text-[11px] font-mono font-semibold text-amber-950 mb-1">Incident Report Notes *</label>
                                    <input type="text" name="description" placeholder="Specify corridor condition (e.g. Torrential rain on Gayo mountain pass, road closed by BPBD)..." required
                                           class="w-full px-2.5 py-1.5 rounded border border-amber-300 text-xs bg-white">
                                </div>

                                <div class="sm:col-span-3 text-right">
                                    <button type="submit" class="px-4 py-2 rounded bg-amber-700 hover:bg-amber-800 text-white font-bold text-xs shadow-2xs transition-colors cursor-pointer font-mono">
                                        ⚠️ Flag Route Exception
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Chronological Milestones Timeline -->
            <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-xs">
                <h3 class="text-xs font-bold font-mono uppercase tracking-wider text-stone-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-canopy-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Audited Tracking Milestones ({{ $shipment->trackingEvents->count() }})
                </h3>

                <div class="relative pl-5 space-y-5 before:content-[''] before:absolute before:left-2 before:top-2 before:bottom-2 before:w-px before:bg-stone-200">
                    @forelse($shipment->trackingEvents as $event)
                        <div class="relative">
                            <div class="absolute -left-5 top-1.5 w-2.5 h-2.5 rounded-full bg-canopy-800 ring-4 ring-white"></div>
                            <div class="bg-stone-50/80 rounded-lg p-3.5 border border-stone-200/80">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="font-bold text-xs text-stone-900 flex items-center gap-2">
                                        <span>{{ $event->location->name ?? 'Corridor Checkpoint' }}</span>
                                        <span class="font-mono text-[10px] px-1.5 py-0.2 rounded bg-stone-200 text-stone-800 font-semibold">{{ $event->status }}</span>
                                    </div>
                                    <span class="font-mono text-[11px] text-stone-500">{{ \Carbon\Carbon::parse($event->event_time)->format('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-xs text-stone-600 mt-1.5 leading-relaxed">{{ $event->description }}</p>
                                @if($event->creator)
                                    <div class="text-[10px] font-mono text-stone-400 mt-2">
                                        Verified by: {{ $event->creator->name }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-stone-400 italic">No tracking milestones registered yet.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right 1 Col: Weather, Cargo Manifest, Exceptions -->
        <div class="space-y-6">

            <!-- Live Climate Radar Card -->
            @if($weather)
                <div class="bg-espresso-950 text-stone-100 rounded-xl p-5 border border-stone-800 shadow-xs">
                    <div class="flex items-center justify-between pb-3 border-b border-stone-800 text-[10px] font-mono">
                        <span class="text-stone-300 uppercase tracking-wider font-semibold flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Live Meteorological Radar
                        </span>
                        <span class="text-stone-400">OpenWeather API v2.5</span>
                    </div>

                    <div class="mt-3 flex items-baseline justify-between">
                        <div>
                            <div class="text-3xl font-extrabold tracking-tight font-mono">{{ $weather['temp_c'] }}°C</div>
                            <div class="text-xs text-stone-300 mt-0.5 font-medium">{{ $weather['condition'] }}</div>
                            <div class="text-[11px] text-emerald-400 font-mono mt-1">{{ $weather['location_name'] ?? ($shipment->currentLocation->name ?? '') }}</div>
                        </div>
                        <div class="text-right text-[11px] font-mono space-y-1 text-stone-300">
                            <div>Rainfall: <strong class="text-white">{{ $weather['rain_mm'] }} mm</strong></div>
                            <div>Wind Gust: <strong class="text-white">{{ $weather['wind_speed_kmh'] }} km/h</strong></div>
                            <div>Humidity: <strong class="text-white">{{ $weather['humidity'] }}%</strong></div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-stone-800 text-[11px] leading-relaxed {{ $weather['is_hazardous'] ? 'text-amber-300 font-semibold' : 'text-stone-400' }}">
                        {{ $weather['alert_summary'] }}
                    </div>
                </div>
            @endif

            <!-- Exceptions & Resolution Action Card -->
            <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-xs">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-stone-100">
                    <h3 class="text-xs font-bold font-mono uppercase tracking-wider text-stone-900">
                        Corridor Exceptions ({{ $shipment->exceptions->count() }})
                    </h3>
                    @if($shipment->is_delayed)
                        <span class="font-mono text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                            +{{ $shipment->delay_duration_hours }}h Delay
                        </span>
                    @endif
                </div>

                <div class="space-y-3">
                    @forelse($shipment->exceptions as $exc)
                        <div class="p-3.5 rounded-lg {{ $exc->status === 'RESOLVED' ? 'bg-stone-50 border-stone-200' : 'bg-amber-50/70 border-amber-200' }} border text-xs">
                            <div class="flex items-center justify-between font-mono">
                                <span class="font-bold {{ $exc->status === 'RESOLVED' ? 'text-stone-900' : 'text-amber-950' }} text-[11px]">{{ $exc->exception_type }}</span>
                                <span class="text-[9px] uppercase font-bold px-1.5 py-0.2 rounded {{ $exc->status === 'RESOLVED' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $exc->status }}
                                </span>
                            </div>
                            <p class="text-stone-700 mt-1 leading-relaxed text-[11px]">{{ $exc->description }}</p>

                            @if($exc->status !== 'RESOLVED' && (auth()->user()->isAdmin() || auth()->user()->isOperator()))
                                <form action="{{ route('exceptions.resolve', $exc->id) }}" method="POST" class="mt-3 pt-2 border-t border-amber-200 flex gap-2">
                                    @csrf
                                    <input type="text" name="resolution_notes" placeholder="Resolution action taken (e.g. Road reopened, inspection cleared)..." required
                                           class="flex-1 px-2 py-1 rounded border border-amber-300 bg-white text-xs">
                                    <button type="submit" class="px-3 py-1 rounded bg-canopy-800 hover:bg-canopy-900 text-white font-bold text-[11px] font-mono cursor-pointer">
                                        Resolve
                                    </button>
                                </form>
                            @elseif($exc->resolution_notes)
                                <div class="mt-2 pt-1.5 border-t border-stone-200 text-emerald-800 text-[10px] font-medium">
                                    Resolved: {{ $exc->resolution_notes }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-xs text-stone-400 italic py-2">No exceptions recorded. Consignment in prime condition.</div>
                    @endforelse
                </div>
            </div>

            <!-- Cargo Packing Manifest Card -->
            <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-xs">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-stone-100">
                    <h3 class="text-xs font-bold font-mono uppercase tracking-wider text-stone-900">
                        Packing Manifest
                    </h3>
                    <span class="font-mono text-xs font-bold px-2 py-0.5 rounded bg-stone-100 text-stone-800">
                        {{ number_format($shipment->weight_kg, 0) }} KG
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($shipment->items as $item)
                        <div class="p-3 rounded-lg bg-stone-50 border border-stone-200/80 text-xs">
                            <div class="font-bold text-stone-900">{{ $item->item_name }}</div>
                            <div class="flex justify-between text-stone-600 mt-1 text-[11px] font-mono">
                                <span>Quantity: <strong>{{ $item->quantity }} units</strong></span>
                                <span>Weight: <strong>{{ number_format($item->weight_kg, 0) }} kg</strong></span>
                            </div>
                            <div class="text-[10px] text-stone-500 font-mono mt-1">Pack: {{ $item->package_type }}</div>
                            @if($item->description)
                                <p class="text-[11px] text-stone-600 italic mt-1.5 leading-relaxed">{{ $item->description }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-xs text-stone-400 italic">No items listed.</div>
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

        L.marker([originLat, originLon]).addTo(map)
            .bindPopup("<b>Origin:</b> {{ $shipment->origin->name }}<br>{{ $shipment->origin->city }} [{{ $shipment->origin->code }}]");

        L.marker([destLat, destLon]).addTo(map)
            .bindPopup("<b>Destination:</b> {{ $shipment->destination->name }}<br>{{ $shipment->destination->city }} [{{ $shipment->destination->code }}]");

        const isDelayed = {{ $shipment->is_delayed ? 'true' : 'false' }};
        L.circleMarker([currentLat, currentLon], {
            radius: 8,
            color: isDelayed ? '#b45309' : '#14532d',
            fillColor: isDelayed ? '#d97706' : '#166534',
            fillOpacity: 0.95,
            weight: 2.5
        }).addTo(map).bindPopup("<b>Current Cargo Position:</b><br>{{ $shipment->currentLocation->name ?? 'In Transit' }}<br>Status: <b>{{ $shipment->status }}</b>").openPopup();

        const routePoints = [
            [originLat, originLon],
            [currentLat, currentLon],
            [destLat, destLon]
        ];

        L.polyline(routePoints, {
            color: isDelayed ? '#b45309' : '#166534',
            weight: 2.5,
            opacity: 0.8,
            dashArray: '5, 8'
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
