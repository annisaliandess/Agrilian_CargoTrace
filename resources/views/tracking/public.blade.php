@extends('layouts.app')

@section('title', 'Public Consignment Radar')

@section('content')
<div class="space-y-6">

    <!-- Search & Radar Ingress Card (Industrial Waybill Style) -->
    <div class="bg-white rounded-xl border border-stone-200 p-6 sm:p-8 shadow-xs">
        <div class="max-w-3xl">
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-mono uppercase font-bold tracking-wider bg-stone-100 text-stone-700 border border-stone-300">
                    <span class="w-1.5 h-1.5 rounded-full bg-canopy-700"></span>
                    E-Consignment Waybill Lookup
                </span>
                <span class="text-xs text-stone-400">&bull;</span>
                <span class="text-xs font-mono text-stone-500">Port of Singapore / Rotterdam Export Lane</span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-espresso-950">
                Track Highland Agro-Commodity Cargo
            </h1>
            <p class="text-xs sm:text-sm text-stone-600 mt-1 leading-relaxed">
                Direct export tracing from Gayo highland processing mills (Takengon) across the Sumatra corridor, Belawan container port, to international destination hubs.
            </p>

            <!-- Search Bar -->
            <form action="{{ route('track.public') }}" method="GET" class="mt-5 flex flex-col sm:flex-row gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="tracking_number" value="{{ $query ?? 'LNDS-2026-GY001' }}" placeholder="Enter Tracking Number (e.g. LNDS-2026-GY001)"
                           class="w-full pl-9 pr-4 py-2.5 rounded-lg border border-stone-300 bg-stone-50/50 text-stone-900 placeholder-stone-400 text-xs sm:text-sm font-mono focus:outline-none focus:ring-2 focus:ring-stone-900 focus:bg-white transition-all">
                </div>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-espresso-900 hover:bg-black text-white font-bold text-xs shadow-xs transition-colors cursor-pointer flex items-center justify-center gap-2">
                    <span>Inspect Cargo</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Live Sample Manifests -->
            <div class="mt-4 flex flex-wrap items-center gap-2 text-xs">
                <span class="text-stone-400 font-medium text-[11px]">Quick Manifests:</span>
                <a href="{{ route('track.public', 'LNDS-2026-GY001') }}" class="px-2 py-1 rounded bg-stone-100 hover:bg-stone-200 border border-stone-200 text-stone-700 font-mono text-[11px] transition-colors">
                    ☕ LNDS-2026-GY001 (Arabica Gayo &rarr; Rotterdam)
                </a>
                <a href="{{ route('track.public', 'LNDS-2026-GY002') }}" class="px-2 py-1 rounded bg-stone-100 hover:bg-stone-200 border border-stone-200 text-stone-700 font-mono text-[11px] transition-colors">
                    🥑 LNDS-2026-GY002 (Avocado & Chili &rarr; Singapore)
                </a>
                <a href="{{ route('track.public', 'LNDS-2026-GY003') }}" class="px-2 py-1 rounded bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-900 font-mono text-[11px] transition-colors">
                    ⚠️ LNDS-2026-GY003 (Weather Hold at Bireuen)
                </a>
            </div>
        </div>
    </div>

    @if($query && !$shipment)
        <!-- Empty State -->
        <div class="bg-white rounded-xl p-10 border border-stone-200 text-center max-w-lg mx-auto shadow-2xs">
            <div class="w-10 h-10 rounded-full bg-stone-100 text-stone-500 flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-sm font-bold text-stone-900">Consignment Not Found</h3>
            <p class="text-xs text-stone-500 mt-1">No export record matched identifier <span class="font-mono font-semibold text-stone-800">"{{ $query }}"</span>. Please verify your Bill of Lading reference.</p>
        </div>
    @elseif($shipment)

        <!-- Consignment Detail Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left 2 Cols: Waybill Banner, Stepper, Interactive Map, Timeline -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Waybill Header Card -->
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-xs">
                    <div class="flex flex-wrap items-start justify-between gap-4 pb-4 border-b border-stone-100">
                        <div>
                            <!-- Commodity Tag -->
                            @php
                                $isCoffee = str_contains(strtolower($shipment->cargo_type), 'arabica') || str_contains(strtolower($shipment->cargo_type), 'coffee');
                                $isPerishable = str_contains(strtolower($shipment->cargo_type), 'avocado') || str_contains(strtolower($shipment->cargo_type), 'chili');
                            @endphp

                            <div class="flex items-center gap-2 mb-1.5">
                                @if($isCoffee)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono uppercase font-bold bg-amber-50 text-amber-900 border border-amber-200">
                                        ☕ Specialty Coffee Export
                                    </span>
                                @elseif($isPerishable)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono uppercase font-bold bg-emerald-50 text-emerald-900 border border-emerald-200">
                                        🥑 Cold-Chain Horticulture
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono uppercase font-bold bg-stone-100 text-stone-800 border border-stone-200">
                                        📦 Agro-Commodity
                                    </span>
                                @endif

                                <span class="text-xs font-mono text-stone-400">Carrier: {{ $shipment->carrier->name }} ({{ $shipment->carrier->transport_mode }})</span>
                            </div>

                            <h2 class="text-xl sm:text-2xl font-extrabold text-espresso-950 font-mono tracking-tight">
                                {{ $shipment->tracking_number }}
                            </h2>
                            <p class="text-xs font-medium text-stone-600 mt-1">
                                {{ $shipment->cargo_type }}
                            </p>
                        </div>

                        <!-- Status Badge & Severity -->
                        <div class="text-right">
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

                            <span class="inline-block px-3 py-1 rounded text-xs font-mono font-bold uppercase tracking-wider border {{ $badgeStyle }}">
                                {{ $shipment->status }}
                            </span>

                            @if($shipment->is_delayed)
                                <div class="mt-1 text-[11px] font-mono font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                    ⚠️ DELAY: +{{ $shipment->delay_duration_hours }}H ({{ $shipment->delay_severity }})
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Transit Lane Segment Nodes -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 text-xs">
                        <div>
                            <span class="font-mono text-[10px] uppercase text-stone-400 block">Origin Depot</span>
                            <strong class="text-stone-900 block font-semibold text-xs mt-0.5">{{ $shipment->origin->name }}</strong>
                            <span class="text-stone-500 text-[11px]">{{ $shipment->origin->city }} [{{ $shipment->origin->code }}]</span>
                        </div>
                        <div>
                            <span class="font-mono text-[10px] uppercase text-stone-400 block">Current Checkpoint</span>
                            <strong class="text-canopy-900 block font-semibold text-xs mt-0.5">{{ $shipment->currentLocation->name ?? 'In Transit' }}</strong>
                            <span class="text-stone-500 text-[11px]">{{ $shipment->currentLocation->city ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="font-mono text-[10px] uppercase text-stone-400 block">Destination Port</span>
                            <strong class="text-stone-900 block font-semibold text-xs mt-0.5">{{ $shipment->destination->name }}</strong>
                            <span class="text-stone-500 text-[11px]">{{ $shipment->destination->city }}, {{ $shipment->destination->country }}</span>
                        </div>
                        <div>
                            <span class="font-mono text-[10px] uppercase text-stone-400 block">Estimated Delivery</span>
                            <strong class="text-stone-900 block font-semibold text-xs mt-0.5 font-mono">{{ \Carbon\Carbon::parse($shipment->estimated_arrival)->format('d M Y, H:i') }}</strong>
                            <span class="text-[11px] {{ $shipment->is_delayed ? 'text-amber-700 font-semibold' : 'text-stone-500' }}">
                                {{ $shipment->is_delayed ? 'Recalculated via weather/hold' : 'Standard transit schedule' }}
                            </span>
                        </div>
                    </div>

                    <!-- Segmented Industrial Status Bar -->
                    <div class="mt-6 pt-5 border-t border-stone-100">
                        @php
                            $steps = ['CREATED', 'BOOKED', 'PICKED_UP', 'IN_TRANSIT', 'DELIVERED'];
                            $currentIdx = array_search($shipment->status, $steps);
                            if ($currentIdx === false) $currentIdx = 0;
                        @endphp

                        <div class="grid grid-cols-5 gap-1.5">
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
                </div>

                <!-- Interactive Maritime & Inland Map -->
                <div class="bg-white rounded-xl border border-stone-200 p-4 shadow-xs">
                    <div class="flex items-center justify-between mb-3 px-1">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-canopy-800"></span>
                            <h3 class="text-xs font-bold font-mono uppercase tracking-wider text-stone-900">Multimodal Transit Lane Cockpit</h3>
                        </div>
                        <div class="text-[10px] font-mono text-stone-400">
                            Geospatial Layer: OpenStreetMap &bull; Leaflet.js
                        </div>
                    </div>
                    <div id="shipment-map" class="w-full h-80 sm:h-96 rounded-lg border border-stone-200"></div>
                    <div class="mt-2.5 flex items-center justify-between text-[10px] font-mono text-stone-500 px-1">
                        <span>Locus: Takengon Warehouse (4.6293°N) &bull; Belawan Port &bull; Singapore PSA &bull; Rotterdam (51.9547°N)</span>
                        <span class="text-canopy-900 font-semibold">Active Coordinates Monitored</span>
                    </div>
                </div>

                <!-- Chronological Milestones Timeline -->
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-xs">
                    <h3 class="text-sm font-bold text-stone-900 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-canopy-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Audit Log of Verified Checkpoints</span>
                        <span class="text-xs font-normal font-mono text-stone-400">({{ $shipment->trackingEvents->count() }} milestones)</span>
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
                                        <span class="font-mono text-[11px] text-stone-500">{{ \Carbon\Carbon::parse($event->event_time)->format('d M Y &bull; H:i') }}</span>
                                    </div>
                                    <p class="text-xs text-stone-600 mt-1.5 leading-relaxed">{{ $event->description }}</p>
                                    @if($event->creator)
                                        <div class="text-[10px] font-mono text-stone-400 mt-2">
                                            Operator Officer: {{ $event->creator->name }}
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

            <!-- Right 1 Col: Meteorological Card, Manifest, Exceptions -->
            <div class="space-y-6">

                <!-- Live OpenWeather Agronomic Radar Card -->
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

                <!-- Exceptions & Holds Card (If any recorded) -->
                @if($shipment->exceptions->count() > 0)
                    <div class="bg-amber-50/70 rounded-xl p-5 border border-amber-200 shadow-2xs">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold uppercase font-mono tracking-wider text-amber-950 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-amber-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                Active Corridor Exceptions ({{ $shipment->exceptions->count() }})
                            </h4>
                        </div>
                        <div class="space-y-2.5">
                            @foreach($shipment->exceptions as $exc)
                                <div class="p-3 rounded-lg bg-white border border-amber-200 text-xs">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-mono font-bold text-amber-900 text-[11px]">{{ $exc->exception_type }}</span>
                                        <span class="font-mono text-[9px] uppercase px-1.5 py-0.2 rounded font-bold {{ $exc->status === 'RESOLVED' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                            {{ $exc->status }}
                                        </span>
                                    </div>
                                    <p class="text-stone-700 text-[11px] leading-relaxed">{{ $exc->description }}</p>
                                    @if($exc->resolution_notes)
                                        <div class="mt-2 pt-1.5 border-t border-stone-100 text-[10px] text-emerald-800 font-medium">
                                            Resolution: {{ $exc->resolution_notes }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Cargo Item Manifest Card -->
                <div class="bg-white rounded-xl border border-stone-200 p-6 shadow-xs">
                    <div class="flex items-center justify-between mb-3 pb-2 border-b border-stone-100">
                        <h4 class="text-xs font-bold font-mono uppercase tracking-wider text-stone-900">
                            Cargo Packing Manifest
                        </h4>
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
                            <div class="text-xs text-stone-400 italic">No cargo manifest items listed.</div>
                        @endforelse
                    </div>

                    <div class="mt-4 pt-4 border-t border-stone-100 text-xs text-stone-600 space-y-1.5 font-mono text-[11px]">
                        <div class="flex justify-between">
                            <span class="text-stone-400">Total Volume:</span>
                            <strong class="text-stone-800">{{ $shipment->volume_cbm ? $shipment->volume_cbm . ' CBM' : 'N/A' }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-400">Consignee Buyer:</span>
                            <strong class="text-stone-800">{{ $shipment->customer->name ?? 'Confidential' }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-stone-400">Assigned Fleet:</span>
                            <strong class="text-stone-800">{{ $shipment->carrier->name }}</strong>
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

                // Origin & Destination Markers
                L.marker([originLat, originLon]).addTo(map)
                    .bindPopup("<b>Origin:</b> {{ $shipment->origin->name }}<br>{{ $shipment->origin->city }} [{{ $shipment->origin->code }}]");

                L.marker([destLat, destLon]).addTo(map)
                    .bindPopup("<b>Destination:</b> {{ $shipment->destination->name }}<br>{{ $shipment->destination->city }} [{{ $shipment->destination->code }}]");

                // Active Cargo Position Marker
                const isDelayed = {{ $shipment->is_delayed ? 'true' : 'false' }};
                L.circleMarker([currentLat, currentLon], {
                    radius: 8,
                    color: isDelayed ? '#b45309' : '#14532d',
                    fillColor: isDelayed ? '#d97706' : '#166534',
                    fillOpacity: 0.95,
                    weight: 2
                }).addTo(map).bindPopup("<b>Current Cargo Checkpoint:</b><br>{{ $shipment->currentLocation->name ?? 'In Transit' }}<br>Status: <b>{{ $shipment->status }}</b>").openPopup();

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
    @endif

</div>
@endsection
