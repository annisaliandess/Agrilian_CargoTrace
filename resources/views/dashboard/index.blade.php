@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Operations Dashboard</h1>
            <p class="text-xs text-slate-500 mt-1">Highland Agro-Export Visibility & Supply Chain Radar</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('track.public') }}" class="px-3.5 py-2 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-xs transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Public Tracker</span>
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                <a href="{{ route('shipments.create') }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm shadow-emerald-600/30 transition-colors flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Create Shipment</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Metric KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Managed</span>
                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-slate-900 mt-2">{{ $totalShipments }}</div>
            <div class="text-[11px] text-slate-400 mt-1">Multi-commodity consignments</div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Active In-Transit</span>
                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-indigo-600 mt-2">{{ $inTransitCount }}</div>
            <div class="text-[11px] text-slate-400 mt-1">Ocean, air, & highland trucks</div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Delivered Safely</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $deliveredCount }}</div>
            <div class="text-[11px] text-slate-400 mt-1">Completed export deliveries</div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between text-slate-400">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Exceptions / Delayed</span>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-extrabold text-amber-600 mt-2">{{ $delayedCount }}</div>
            <div class="text-[11px] text-slate-400 mt-1">Weather & checkpoint alerts</div>
        </div>
    </div>

    <!-- Global Logistics Network Map Card -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
            <div>
                <h2 class="text-base font-bold text-slate-900">Highland-to-Global Logistics Lane Radar</h2>
                <p class="text-xs text-slate-500">Live positions of Takengon hubs, Sumatra checkpoints, Belawan Seaport, Singapore Transshipment, and Rotterdam Maasvlakte</p>
            </div>
            <div class="flex items-center gap-3 text-xs text-slate-500">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Logistics Hubs</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span> Active Cargoes</span>
            </div>
        </div>
        <div id="overview-map" class="w-full h-80 sm:h-96 rounded-xl border border-slate-200"></div>
    </div>

    <!-- Bottom Section: Recent Shipments & Exceptions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Shipments Table (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-slate-900">Recent Agro-Shipments</h3>
                <a href="{{ route('shipments.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">View All &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 uppercase tracking-wider text-[10px]">
                            <th class="py-2.5 font-bold">Tracking #</th>
                            <th class="py-2.5 font-bold">Commodity</th>
                            <th class="py-2.5 font-bold">Route</th>
                            <th class="py-2.5 font-bold">Status</th>
                            <th class="py-2.5 font-bold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($recentShipments as $s)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 font-mono font-bold text-slate-900">
                                    <a href="{{ route('shipments.show', $s->id) }}" class="hover:text-emerald-600">
                                        {{ $s->tracking_number }}
                                    </a>
                                </td>
                                <td class="py-3">
                                    <div class="font-semibold text-slate-800">{{ $s->cargo_type }}</div>
                                    <div class="text-[11px] text-slate-400">{{ number_format($s->weight_kg, 0) }} kg &bull; {{ $s->carrier->name }}</div>
                                </td>
                                <td class="py-3 text-[11px]">
                                    <div class="font-medium text-slate-800">{{ $s->origin->city }} &rarr; {{ $s->destination->city }}</div>
                                    <div class="text-emerald-700 font-semibold">{{ $s->currentLocation->name ?? 'In Transit' }}</div>
                                </td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $s->status === 'DELIVERED' ? 'bg-emerald-100 text-emerald-800' : ($s->status === 'IN_TRANSIT' ? 'bg-indigo-100 text-indigo-800' : 'bg-slate-100 text-slate-700') }}">
                                        {{ $s->status }}
                                    </span>
                                    @if($s->is_delayed)
                                        <span class="block text-[10px] text-amber-700 font-bold mt-0.5">+{{ $s->delay_duration_hours }}h delay</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('shipments.show', $s->id) }}" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 font-semibold text-slate-700 transition-colors">
                                        Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400 italic">No shipments registered yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Exceptions & Notifications Feed (1 col) -->
        <div class="space-y-6">
            <!-- Active Exceptions -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    Active Route Exceptions ({{ $openExceptions->count() }})
                </h3>

                <div class="space-y-3">
                    @forelse($openExceptions as $exc)
                        <div class="p-3 rounded-xl bg-amber-50/70 border border-amber-200 text-xs">
                            <div class="flex items-center justify-between font-bold text-amber-900">
                                <span>{{ $exc->exception_type }}</span>
                                <span class="text-[10px] uppercase px-1.5 py-0.2 rounded bg-amber-200 text-amber-900">{{ $exc->severity }}</span>
                            </div>
                            <div class="text-[11px] text-amber-800 font-semibold mt-1">
                                Cargo: <a href="{{ route('shipments.show', $exc->shipment_id) }}" class="underline font-mono">{{ $exc->shipment->tracking_number }}</a>
                            </div>
                            <p class="text-slate-600 mt-1 leading-relaxed text-[11px]">{{ Str::limit($exc->description, 110) }}</p>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic py-2">No open exceptions. All supply lanes clear!</div>
                    @endforelse
                </div>
            </div>

            <!-- Notifications -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Recent System Alerts
                </h3>

                <div class="space-y-2">
                    @forelse($notifications as $notif)
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                            <div class="font-bold text-slate-800">{{ $notif->title }}</div>
                            <div class="text-slate-500 text-[11px] mt-0.5">{{ $notif->message }}</div>
                            <div class="text-[10px] text-slate-400 mt-1">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic py-2">No alerts.</div>
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

        // Initialize map centered around Southeast Asia / Malacca trade lane
        const map = L.map('overview-map').setView([4.0, 99.0], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Logistics Hubs from DB
        const locations = @json($locations);
        const markers = [];

        locations.forEach(loc => {
            const marker = L.circleMarker([loc.latitude, loc.longitude], {
                radius: 7,
                color: '#047857',
                fillColor: '#10b981',
                fillOpacity: 0.9,
                weight: 2
            }).addTo(map).bindPopup(`<b>${loc.name}</b><br>${loc.city}, ${loc.country}<br><span class="text-xs font-mono font-bold text-emerald-700">[${loc.code}]</span>`);
            markers.push(marker);
        });

        // Active Shipment markers
        const activeShipments = @json($recentShipments);
        activeShipments.forEach(s => {
            if (s.current_location) {
                const isDelayed = s.is_delayed;
                const cargoMarker = L.circleMarker([s.current_location.latitude, s.current_location.longitude], {
                    radius: 9,
                    color: isDelayed ? '#b45309' : '#4338ca',
                    fillColor: isDelayed ? '#f59e0b' : '#6366f1',
                    fillOpacity: 0.95,
                    weight: 3
                }).addTo(map).bindPopup(`
                    <b>Cargo: ${s.tracking_number}</b><br>
                    Commodity: ${s.cargo_type}<br>
                    Status: <b>${s.status}</b> ${isDelayed ? '<br><span style="color:#b45309">⚠️ Delay: +' + s.delay_duration_hours + 'h</span>' : ''}<br>
                    <a href="/shipments/${s.id}" style="color:#059669;font-weight:bold;">View Details &rarr;</a>
                `);
                markers.push(cargoMarker);
            }
        });

        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds(), { padding: [50, 50] });
        }
    });
</script>
@endpush
@endsection
