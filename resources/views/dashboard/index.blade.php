@extends('layouts.app')

@section('title', 'Operations Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Title Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="font-mono text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-stone-200/70 text-stone-700">
                    Operations Center
                </span>
                <span class="text-xs text-stone-400">&bull;</span>
                <span class="text-xs text-stone-500 font-mono">Takengon Central Hub Active</span>
            </div>
            <h1 class="text-2xl font-extrabold text-espresso-950 tracking-tight">Highland Agro-Export Radar</h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('track.public') }}" class="px-3.5 py-2 rounded-lg border border-stone-300 bg-white hover:bg-stone-50 text-stone-800 text-xs font-semibold shadow-2xs transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Public Tracker</span>
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                <a href="{{ route('shipments.create') }}" class="px-4 py-2 rounded-lg bg-canopy-800 hover:bg-canopy-900 text-white text-xs font-bold shadow-xs transition-colors flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ New Consignment</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Numerical KPI Cards (Clean, High-Density, Typography-Forward) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Managed -->
        <div class="bg-white rounded-xl p-5 border border-stone-200 shadow-2xs">
            <div class="flex items-center justify-between text-stone-500 font-mono text-[11px] uppercase tracking-wider">
                <span>Total Consignments</span>
                <span class="text-stone-400">SUM</span>
            </div>
            <div class="text-3xl font-extrabold text-stone-900 font-mono mt-2 tracking-tight">{{ $totalShipments }}</div>
            <div class="text-[11px] text-stone-500 mt-1">Multi-commodity manifests recorded</div>
        </div>

        <!-- In-Transit -->
        <div class="bg-white rounded-xl p-5 border border-stone-200 shadow-2xs">
            <div class="flex items-center justify-between text-stone-500 font-mono text-[11px] uppercase tracking-wider">
                <span>Active In-Transit</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <div class="text-3xl font-extrabold text-canopy-900 font-mono mt-2 tracking-tight">{{ $inTransitCount }}</div>
            <div class="text-[11px] text-stone-500 mt-1">Highland trucks, vessels & air freight</div>
        </div>

        <!-- Delivered Safely -->
        <div class="bg-white rounded-xl p-5 border border-stone-200 shadow-2xs">
            <div class="flex items-center justify-between text-stone-500 font-mono text-[11px] uppercase tracking-wider">
                <span>Delivered Safely</span>
                <span class="text-stone-400">100%</span>
            </div>
            <div class="text-3xl font-extrabold text-stone-900 font-mono mt-2 tracking-tight">{{ $deliveredCount }}</div>
            <div class="text-[11px] text-stone-500 mt-1">Confirmed at final destination ports</div>
        </div>

        <!-- Exceptions / Delayed -->
        <div class="bg-white rounded-xl p-5 border border-stone-200 shadow-2xs">
            <div class="flex items-center justify-between text-stone-500 font-mono text-[11px] uppercase tracking-wider">
                <span>Corridor Delays</span>
                @if($delayedCount > 0)
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                @else
                    <span class="text-stone-400">CLEAR</span>
                @endif
            </div>
            <div class="text-3xl font-extrabold text-amber-800 font-mono mt-2 tracking-tight">{{ $delayedCount }}</div>
            <div class="text-[11px] text-stone-500 mt-1">Mountain weather & checkpoint holds</div>
        </div>
    </div>

    <!-- Logistics Network Map Cockpit -->
    <div class="bg-white rounded-xl p-5 border border-stone-200 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3 px-1">
            <div>
                <h2 class="text-xs font-bold font-mono uppercase tracking-wider text-stone-900">
                    Highland-to-Global Multimodal Transit Lane Radar
                </h2>
                <p class="text-xs text-stone-500">Active monitoring from Takengon central warehouse, Sumatra checkpoints, Belawan Seaport, Singapore Transshipment, to Rotterdam Maasvlakte</p>
            </div>
            <div class="flex items-center gap-3 text-[10px] font-mono text-stone-500">
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-canopy-800"></span> Logistics Hubs</span>
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-espresso-900"></span> Active Cargoes</span>
            </div>
        </div>
        <div id="overview-map" class="w-full h-80 sm:h-96 rounded-lg border border-stone-200"></div>
    </div>

    <!-- Bottom Section: Recent Manifests & Active Exceptions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Shipments Table (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-stone-200 shadow-2xs">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-stone-100">
                <h3 class="text-xs font-bold font-mono uppercase tracking-wider text-stone-900">
                    Recent Consignments Manifest
                </h3>
                <a href="{{ route('shipments.index') }}" class="text-xs font-semibold text-canopy-800 hover:underline font-mono">
                    View Complete Roster &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-stone-200 text-stone-400 font-mono uppercase tracking-wider text-[10px]">
                            <th class="py-2.5 font-bold">Consignment #</th>
                            <th class="py-2.5 font-bold">Agro Commodity</th>
                            <th class="py-2.5 font-bold">Transit Route</th>
                            <th class="py-2.5 font-bold">Status</th>
                            <th class="py-2.5 font-bold text-right">Inspect</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-stone-700">
                        @forelse($recentShipments as $s)
                            @php
                                $isCoffee = str_contains(strtolower($s->cargo_type), 'arabica') || str_contains(strtolower($s->cargo_type), 'coffee');
                                $isHorti = str_contains(strtolower($s->cargo_type), 'avocado') || str_contains(strtolower($s->cargo_type), 'chili');
                            @endphp
                            <tr class="hover:bg-stone-50/70 transition-colors">
                                <td class="py-3 font-mono font-bold text-stone-900">
                                    <a href="{{ route('shipments.show', $s->id) }}" class="hover:text-canopy-800">
                                        {{ $s->tracking_number }}
                                    </a>
                                </td>
                                <td class="py-3">
                                    <div class="font-semibold text-stone-900 flex items-center gap-1.5">
                                        @if($isCoffee)
                                            <span class="text-[10px]">☕</span>
                                        @elseif($isHorti)
                                            <span class="text-[10px]">🥑</span>
                                        @endif
                                        <span>{{ $s->cargo_type }}</span>
                                    </div>
                                    <div class="text-[10px] font-mono text-stone-400 mt-0.5">
                                        {{ number_format($s->weight_kg, 0) }} kg &bull; {{ $s->carrier->name }}
                                    </div>
                                </td>
                                <td class="py-3 text-[11px]">
                                    <div class="font-medium text-stone-800">{{ $s->origin->city }} &rarr; {{ $s->destination->city }}</div>
                                    <div class="text-canopy-900 font-mono text-[10px] font-semibold">{{ $s->currentLocation->name ?? 'In Transit' }}</div>
                                </td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded font-mono text-[9px] font-bold uppercase {{ $s->status === 'DELIVERED' ? 'bg-stone-100 text-stone-900 border border-stone-300' : ($s->status === 'IN_TRANSIT' ? 'bg-emerald-50 text-emerald-900 border border-emerald-200' : 'bg-stone-100 text-stone-700') }}">
                                        {{ $s->status }}
                                    </span>
                                    @if($s->is_delayed)
                                        <span class="block text-[9px] font-mono text-amber-800 font-bold mt-0.5">+{{ $s->delay_duration_hours }}h hold</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('shipments.show', $s->id) }}" class="px-2.5 py-1 rounded bg-stone-100 hover:bg-stone-200 font-mono font-semibold text-[11px] text-stone-800 transition-colors">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-stone-400 italic">No consignments registered yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Exceptions & System Log (1 col) -->
        <div class="space-y-6">

            <!-- Active Route Holds / Exceptions -->
            <div class="bg-white rounded-xl p-5 border border-stone-200 shadow-2xs">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-stone-100">
                    <h3 class="text-xs font-bold font-mono uppercase tracking-wider text-amber-950 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                        Active Corridor Holds ({{ $openExceptions->count() }})
                    </h3>
                </div>

                <div class="space-y-3">
                    @forelse($openExceptions as $exc)
                        <div class="p-3 rounded-lg bg-amber-50/60 border border-amber-200 text-xs">
                            <div class="flex items-center justify-between font-mono font-bold text-amber-950">
                                <span>{{ $exc->exception_type }}</span>
                                <span class="text-[9px] uppercase px-1.5 py-0.2 rounded bg-amber-200 text-amber-900">{{ $exc->severity }}</span>
                            </div>
                            <div class="text-[11px] text-amber-800 font-mono font-semibold mt-1">
                                Consignment: <a href="{{ route('shipments.show', $exc->shipment_id) }}" class="underline">{{ $exc->shipment->tracking_number }}</a>
                            </div>
                            <p class="text-stone-700 mt-1 leading-relaxed text-[11px]">{{ Str::limit($exc->description, 100) }}</p>
                        </div>
                    @empty
                        <div class="text-xs text-stone-400 italic py-2">No active corridor holds. All trade lanes clear!</div>
                    @endforelse
                </div>
            </div>

            <!-- Notifications Feed -->
            <div class="bg-white rounded-xl p-5 border border-stone-200 shadow-2xs">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-stone-100">
                    <h3 class="text-xs font-bold font-mono uppercase tracking-wider text-stone-900">
                        System Event Alerts
                    </h3>
                </div>

                <div class="space-y-2.5">
                    @forelse($notifications as $notif)
                        <div class="p-2.5 rounded-lg bg-stone-50 border border-stone-200/70 text-xs">
                            <div class="font-bold text-stone-900">{{ $notif->title }}</div>
                            <div class="text-stone-600 text-[11px] mt-0.5 leading-relaxed">{{ $notif->message }}</div>
                            <div class="text-[9px] font-mono text-stone-400 mt-1">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="text-xs text-stone-400 italic py-2">No unread notifications.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapEl = document.getElementById('overview-map');
        if (!mapEl) return;

        const map = L.map('overview-map').setView([4.0, 99.0], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const locations = @json($locations);
        const markers = [];

        locations.forEach(loc => {
            const marker = L.circleMarker([loc.latitude, loc.longitude], {
                radius: 6,
                color: '#14532d',
                fillColor: '#166534',
                fillOpacity: 0.9,
                weight: 2
            }).addTo(map).bindPopup(`<b>${loc.name}</b><br>${loc.city}, ${loc.country}<br><span class="font-mono text-xs font-bold text-canopy-800">[${loc.code}]</span>`);
            markers.push(marker);
        });

        const activeShipments = @json($recentShipments);
        activeShipments.forEach(s => {
            if (s.current_location) {
                const isDelayed = s.is_delayed;
                const cargoMarker = L.circleMarker([s.current_location.latitude, s.current_location.longitude], {
                    radius: 8,
                    color: isDelayed ? '#b45309' : '#1c1917',
                    fillColor: isDelayed ? '#d97706' : '#292524',
                    fillOpacity: 0.95,
                    weight: 2.5
                }).addTo(map).bindPopup(`
                    <b>Cargo: ${s.tracking_number}</b><br>
                    Commodity: ${s.cargo_type}<br>
                    Status: <b>${s.status}</b> ${isDelayed ? '<br><span style="color:#b45309">⚠️ Delay: +' + s.delay_duration_hours + 'h</span>' : ''}<br>
                    <a href="/shipments/${s.id}" style="color:#14532d;font-weight:bold;">Inspect Consignment &rarr;</a>
                `);
                markers.push(cargoMarker);
            }
        });

        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds(), { padding: [40, 40] });
        }
    });
</script>
@endpush
@endsection
