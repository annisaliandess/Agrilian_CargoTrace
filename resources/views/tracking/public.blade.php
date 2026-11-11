@extends('layouts.app')

@section('title', 'Public Cargo Tracker')

@section('content')
<div class="space-y-6">
    <!-- Hero Search Card -->
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-12 -top-12 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="max-w-2xl relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Live Agro-Logistics Radar
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                Trace Highland Agro-Commodity Shipments
            </h1>
            <p class="text-sm text-slate-300 mt-2">
                Real-time visibility from Gayo Highlands through Strait of Malacca to European & Global Ports.
            </p>

            <!-- Search Form -->
            <form action="{{ route('track.public') }}" method="GET" class="mt-6 flex flex-col sm:flex-row gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="tracking_number" value="{{ $query ?? 'LNDS-2026-GY001' }}" placeholder="Enter Tracking Number (e.g. LNDS-2026-GY001)"
                           class="w-full pl-10 pr-4 py-3 rounded-xl bg-white/10 backdrop-blur border border-white/20 text-white placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:bg-white/15 transition-all">
                </div>
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm shadow-lg shadow-emerald-500/25 transition-all cursor-pointer flex items-center justify-center gap-2">
                    <span>Track Cargo</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Quick Samples -->
            <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-slate-300">
                <span class="text-slate-400">Try sample cargos:</span>
                <a href="{{ route('track.public', 'LNDS-2026-GY001') }}" class="px-2.5 py-1 rounded-lg bg-white/10 hover:bg-white/20 font-mono transition-colors">LNDS-2026-GY001 (Rotterdam Ocean)</a>
                <a href="{{ route('track.public', 'LNDS-2026-GY002') }}" class="px-2.5 py-1 rounded-lg bg-white/10 hover:bg-white/20 font-mono transition-colors">LNDS-2026-GY002 (Delivered SG)</a>
                <a href="{{ route('track.public', 'LNDS-2026-GY003') }}" class="px-2.5 py-1 rounded-lg bg-amber-500/20 text-amber-300 hover:bg-amber-500/30 font-mono transition-colors">LNDS-2026-GY003 (Weather Delay)</a>
            </div>
        </div>
    </div>

    @if($query && !$shipment)
        <!-- Not Found -->
        <div class="bg-white rounded-2xl p-8 border border-slate-200 text-center max-w-lg mx-auto shadow-sm">
            <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Tracking Number Not Found</h3>
            <p class="text-sm text-slate-500 mt-1">No cargo records found matching <span class="font-mono font-bold text-slate-700">"{{ $query }}"</span>. Please check your manifest code.</p>
        </div>
    @elseif($shipment)
        <!-- Shipment Found -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Status Bar, Map, Timeline -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header Card -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-slate-100">
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-xl font-extrabold text-slate-900 font-mono tracking-tight">{{ $shipment->tracking_number }}</h2>
                                @if($shipment->is_delayed)
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        Delayed (+{{ $shipment->delay_duration_hours }}h)
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        On Schedule
                                    </span>
                                @endif
                            </div>
                            <div class="text-sm font-semibold text-emerald-800 mt-1 flex items-center gap-2">
                                <span>{{ $shipment->cargo_type }}</span>
                                <span class="text-slate-300">&bull;</span>
                                <span class="text-slate-600 text-xs font-normal">{{ $shipment->carrier->name }} ({{ $shipment->carrier->transport_mode }})</span>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div>
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
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold border uppercase tracking-wider {{ $badgeClass }}">
                                {{ $shipment->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Origin to Destination Route Banner -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 text-xs">
                        <div>
                            <span class="text-slate-400 block font-medium">Origin</span>
                            <strong class="text-slate-800 block font-semibold text-sm">{{ $shipment->origin->name }}</strong>
                            <span class="text-slate-500">{{ $shipment->origin->city }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Current Checkpoint</span>
                            <strong class="text-emerald-700 block font-semibold text-sm">{{ $shipment->currentLocation->name ?? 'In Transit' }}</strong>
                            <span class="text-slate-500">{{ $shipment->currentLocation->city ?? '' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Destination</span>
                            <strong class="text-slate-800 block font-semibold text-sm">{{ $shipment->destination->name }}</strong>
                            <span class="text-slate-500">{{ $shipment->destination->city }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Estimated Arrival</span>
                            <strong class="text-slate-800 block font-semibold text-sm">{{ \Carbon\Carbon::parse($shipment->estimated_arrival)->format('d M Y, H:i') }}</strong>
                            <span class="{{ $shipment->is_delayed ? 'text-amber-600 font-bold' : 'text-slate-500' }}">
                                {{ $shipment->is_delayed ? 'Updated due to delay' : 'Expected on time' }}
                            </span>
                        </div>
                    </div>

                    <!-- Progress Lifecycle Steps -->
                    <div class="mt-6 pt-6 border-t border-slate-100">
                        @php
                            $steps = ['CREATED', 'BOOKED', 'PICKED_UP', 'IN_TRANSIT', 'DELIVERED'];
                            $currentIdx = array_search($shipment->status, $steps);
                            if ($currentIdx === false) $currentIdx = 0;
                        @endphp
                        <div class="relative flex items-center justify-between">
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-200 -z-0"></div>
                            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-emerald-500 transition-all -z-0"
                                 style="width: {{ ($currentIdx / (count($steps) - 1)) * 100 }}%"></div>

                            @foreach($steps as $idx => $step)
                                <div class="flex flex-col items-center relative z-10">
                                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all {{ $idx <= $currentIdx ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30 ring-4 ring-white' : 'bg-white border-2 border-slate-300 text-slate-400' }}">
                                        @if($idx < $currentIdx)
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        @else
                                            {{ $idx + 1 }}
                                        @endif
                                    </div>
                                    <span class="text-[10px] uppercase font-bold tracking-wider mt-1.5 {{ $idx <= $currentIdx ? 'text-emerald-800' : 'text-slate-400' }}">
                                        {{ str_replace('_', ' ', $step) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Interactive Leaflet Map Card -->
                <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-3 px-2">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <h3 class="text-sm font-bold text-slate-800">Interactive Multimodal Trade Route Map</h3>
                        </div>
                        <span class="text-xs text-slate-400">OpenStreetMap &bull; Leaflet.js</span>
                    </div>
                    <div id="shipment-map" class="w-full h-80 sm:h-96 rounded-xl border border-slate-200"></div>
                </div>

                <!-- Tracking Events Timeline -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <h3 class="text-base font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Tracking Milestones & Checkpoint Log
                    </h3>

                    <div class="relative pl-6 space-y-6 before:content-[''] before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                        @forelse($shipment->trackingEvents as $event)
                            <div class="relative">
                                <div class="absolute -left-6 top-1.5 w-3.5 h-3.5 rounded-full bg-emerald-600 ring-4 ring-emerald-50"></div>
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <div class="font-bold text-sm text-slate-800 flex items-center gap-2">
                                            <span>{{ $event->location->name ?? 'Checkpoint' }}</span>
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">{{ $event->status }}</span>
                                        </div>
                                        <span class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($event->event_time)->format('d M Y &bull; H:i') }}</span>
                                    </div>
                                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">{{ $event->description }}</p>
                                    @if($event->creator)
                                        <div class="text-[11px] text-slate-400 mt-2">
                                            Verified by: {{ $event->creator->name }}
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

            <!-- Right 1 Col: Live Weather, Cargo Items, Exceptions -->
            <div class="space-y-6">
                <!-- Live Weather Card (OpenWeatherMap API Integration) -->
                @if($weather)
                    <div class="bg-gradient-to-br from-sky-900 to-slate-900 rounded-2xl p-5 text-white shadow-md border border-sky-800/40 relative overflow-hidden">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-sky-300 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                                Live Climate Radar
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
                                <div>Rain: <strong class="text-white">{{ $weather['rain_mm'] }} mm</strong></div>
                                <div>Wind: <strong class="text-white">{{ $weather['wind_speed_kmh'] }} km/h</strong></div>
                                <div>Humidity: <strong class="text-white">{{ $weather['humidity'] }}%</strong></div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-sky-800/60 text-xs {{ $weather['is_hazardous'] ? 'text-amber-300 font-bold' : 'text-sky-200' }}">
                            {{ $weather['alert_summary'] }}
                        </div>
                    </div>
                @endif

                <!-- Active Exceptions Alert Card if Any -->
                @if($shipment->exceptions->count() > 0)
                    <div class="bg-amber-50 rounded-2xl p-5 border border-amber-200 shadow-sm">
                        <h4 class="text-sm font-bold text-amber-900 flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            Recorded Exceptions & Delays ({{ $shipment->exceptions->count() }})
                        </h4>
                        <div class="space-y-3">
                            @foreach($shipment->exceptions as $exc)
                                <div class="p-3 rounded-xl bg-white border border-amber-200 text-xs">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-bold text-amber-900">{{ $exc->exception_type }}</span>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ $exc->status === 'RESOLVED' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                            {{ $exc->status }}
                                        </span>
                                    </div>
                                    <p class="text-slate-600 mt-1 leading-relaxed">{{ $exc->description }}</p>
                                    @if($exc->resolution_notes)
                                        <div class="mt-2 pt-2 border-t border-slate-100 text-emerald-700 font-medium">
                                            Resolution: {{ $exc->resolution_notes }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Cargo Manifest / Items Card -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <h4 class="text-sm font-bold text-slate-800 flex items-center justify-between mb-3">
                        <span>Cargo Manifest Summary</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-slate-100 text-slate-700">
                            {{ number_format($shipment->weight_kg, 0) }} kg
                        </span>
                    </h4>

                    <div class="space-y-3">
                        @forelse($shipment->items as $item)
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs">
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
                            <div class="text-xs text-slate-400 italic">No cargo item details specified.</div>
                        @endforelse
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-500 space-y-1">
                        <div class="flex justify-between">
                            <span>Total Volume:</span>
                            <strong class="text-slate-700">{{ $shipment->volume_cbm ? $shipment->volume_cbm . ' CBM' : 'N/A' }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Consignee / Customer:</span>
                            <strong class="text-slate-700">{{ $shipment->customer->name ?? 'Confidential' }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Carrier Transport:</span>
                            <strong class="text-slate-700">{{ $shipment->carrier->name }}</strong>
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

                // Points along route
                const originLat = {{ $shipment->origin->latitude }};
                const originLon = {{ $shipment->origin->longitude }};
                const destLat = {{ $shipment->destination->latitude }};
                const destLon = {{ $shipment->destination->longitude }};
                const currentLat = {{ $shipment->currentLocation->latitude ?? $shipment->origin->latitude }};
                const currentLon = {{ $shipment->currentLocation->longitude ?? $shipment->origin->longitude }};

                // Initialize map centered between origin and current location
                const map = L.map('shipment-map').setView([currentLat, currentLon], 5);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                // Markers
                const originMarker = L.marker([originLat, originLon]).addTo(map)
                    .bindPopup("<b>Origin:</b> {{ $shipment->origin->name }}<br>{{ $shipment->origin->city }}");

                const destMarker = L.marker([destLat, destLon]).addTo(map)
                    .bindPopup("<b>Destination:</b> {{ $shipment->destination->name }}<br>{{ $shipment->destination->city }}");

                const currentMarker = L.circleMarker([currentLat, currentLon], {
                    radius: 9,
                    color: '#059669',
                    fillColor: '#10b981',
                    fillOpacity: 0.9,
                    weight: 3
                }).addTo(map).bindPopup("<b>Current Cargo Checkpoint:</b><br>{{ $shipment->currentLocation->name ?? 'In Transit' }}<br>Status: {{ $shipment->status }}").openPopup();

                // Draw path line
                const routePoints = [
                    [originLat, originLon],
                    [currentLat, currentLon],
                    [destLat, destLon]
                ];
                const polyline = L.polyline(routePoints, {
                    color: '#059669',
                    weight: 3,
                    opacity: 0.7,
                    dashArray: '6, 8'
                }).addTo(map);

                // Fit bounds to show all markers
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
