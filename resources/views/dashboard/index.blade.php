@extends('layouts.app')

@section('title', 'Dashboard Operasional')

@section('content')
<div class="space-y-6">

    <!-- ======================================================== -->
    <!-- 1. TOP TITLE & ACTION BAR                               -->
    <!-- ======================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200/70">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                    Sistem Rantai Pasok Aktif
                </span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Takengon Hub &bull; Pelabuhan Belawan &bull; Rotterdam</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                Dashboard Operasional Ekspor Highland
            </h1>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('track.public') }}" target="_blank" class="btn-brand-outline px-3.5 py-2 rounded-lg text-xs flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Halaman Cek Resi</span>
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                <a href="{{ route('shipments.create') }}" class="btn-brand-primary px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Buat Manifest Baru</span>
                </a>
            @endif
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 2. UNIFIED EXECUTIVE METRIC STRIP (Calm, Clean, Spacious) -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-xl border border-slate-200/90 shadow-2xs divide-y sm:divide-y-0 sm:divide-x divide-slate-100 grid grid-cols-2 lg:grid-cols-4">
        <!-- Metric 1: Total Managed -->
        <div class="p-4 sm:p-5">
            <span class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Pengiriman</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 font-mono">{{ $totalShipments }}</div>
            <span class="block text-[11px] text-slate-400 mt-1">100% Manifest Tercatat</span>
        </div>

        <!-- Metric 2: In-Transit -->
        <div class="p-4 sm:p-5">
            <span class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Dalam Perjalanan</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-emerald-700 mt-1 font-mono">{{ $inTransitCount }}</div>
            <span class="block text-[11px] text-slate-400 mt-1">Truk Darat & Kapal Kontainer</span>
        </div>

        <!-- Metric 3: Delivered Safely -->
        <div class="p-4 sm:p-5">
            <span class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Terkirim Sukses</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 font-mono">{{ $deliveredCount }}</div>
            <span class="block text-[11px] text-slate-400 mt-1">Tiba di Pelabuhan Tujuan</span>
        </div>

        <!-- Metric 4: Route Alerts -->
        <div class="p-4 sm:p-5">
            <span class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Peringatan Jalur</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-1 font-mono">{{ $delayedCount }}</div>
            <span class="block text-[11px] text-slate-400 mt-1">Mitigasi Cuaca & Antrean</span>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3. REAL PHOTOGRAPHIC COMMODITY SHOWCASE                 -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        
        <!-- Showcase 1: Gayo Arabica Specialty -->
        <div class="bg-white rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden flex flex-col sm:flex-row group hover:border-slate-300 transition-colors">
            <div class="sm:w-44 h-36 sm:h-auto relative overflow-hidden bg-slate-100 shrink-0">
                <img src="/images/coffee.jpg" alt="Kopi Arabika Gayo Takengon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[10px] font-bold bg-slate-900/80 text-white backdrop-blur-xs">
                    Ekspor Utama
                </span>
            </div>
            <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-mono font-bold text-emerald-800">LNDS-2026-GY001</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            On Track
                        </span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mt-1">Kopi Arabika Gayo Specialty Grade 1</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Takengon Hub &rarr; Pelabuhan Belawan &rarr; Rotterdam Port</p>
                </div>

                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <div class="text-[11px] text-slate-600">
                        <span>Kadar Air: <strong>11.4%</strong></span>
                        <span class="text-slate-300 mx-1">&bull;</span>
                        <span>Bobot: <strong>12.000 KG</strong></span>
                    </div>
                    <a href="/shipments/1" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 flex items-center gap-1">
                        <span>Detail</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Showcase 2: Cold-Chain Horticulture -->
        <div class="bg-white rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden flex flex-col sm:flex-row group hover:border-slate-300 transition-colors">
            <div class="sm:w-44 h-36 sm:h-auto relative overflow-hidden bg-slate-100 shrink-0">
                <img src="/images/avocado.jpg" alt="Alpukat Mentega & Cabai Takengon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[10px] font-bold bg-slate-900/80 text-white backdrop-blur-xs">
                    Rantai Dingin
                </span>
            </div>
            <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-mono font-bold text-emerald-800">LNDS-2026-GY002</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            In Transit
                        </span>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900 mt-1">Alpukat Mentega & Cabai Merah Segar</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Takengon Hub &rarr; Belawan &rarr; Port of Singapore</p>
                </div>

                <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <div class="text-[11px] text-slate-600">
                        <span>Suhu Reefer: <strong>5.8°C</strong></span>
                        <span class="text-slate-300 mx-1">&bull;</span>
                        <span>Bobot: <strong>4.500 KG</strong></span>
                    </div>
                    <a href="/shipments/2" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 flex items-center gap-1">
                        <span>Detail</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 4. OPERATIONAL COCKPIT: RADAR MAP (2/3) + WEATHER (1/3) -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <!-- Left: Interactive Leaflet Map (2 Cols) -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200/90 p-5 shadow-2xs flex flex-col">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                    <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">
                        Radar Visual Rute Multimodal Koridor Ekspor
                    </h2>
                </div>
                <div class="flex items-center gap-3 text-[11px] text-slate-500 font-medium">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#1B4332]"></span> Hub Gudang</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-600"></span> Kargo Bergerak</span>
                </div>
            </div>

            <div id="overview-map" class="h-80 w-full rounded-lg border border-slate-200 z-10 flex-1"></div>
        </div>

        <!-- Right: Live Weather Telemetry (1 Col) -->
        <div class="bg-white rounded-xl border border-slate-200/90 p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Telemetri Cuaca Rute</h3>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400">OpenWeather</span>
                </div>

                <div class="space-y-3">
                    <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                        <div class="flex justify-between items-baseline">
                            <span class="text-xs font-bold text-slate-900">Takengon Hub (1.200m)</span>
                            <span class="text-xs font-mono font-bold text-slate-900">21°C</span>
                        </div>
                        <div class="text-[11px] text-slate-500 mt-0.5 flex justify-between">
                            <span>Ketinggian Asal &bull; Sejuk</span>
                            <span class="text-emerald-700 font-medium">Optimal</span>
                        </div>
                    </div>

                    <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                        <div class="flex justify-between items-baseline">
                            <span class="text-xs font-bold text-slate-900">Koridor Bireuen - Takengon</span>
                            <span class="text-xs font-mono font-bold text-slate-900">26°C</span>
                        </div>
                        <div class="text-[11px] text-slate-500 mt-0.5 flex justify-between">
                            <span>Jalur Pegunungan Km 45</span>
                            <span class="text-amber-700 font-medium">Waspada Kabut</span>
                        </div>
                    </div>

                    <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-100">
                        <div class="flex justify-between items-baseline">
                            <span class="text-xs font-bold text-slate-900">Belawan Container Terminal</span>
                            <span class="text-xs font-mono font-bold text-slate-900">31°C</span>
                        </div>
                        <div class="text-[11px] text-slate-500 mt-0.5 flex justify-between">
                            <span>Pelabuhan Laut &bull; Angin 14 km/h</span>
                            <span class="text-emerald-700 font-medium">Dermaga Lancar</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                <span>Status Koridor:</span>
                <strong class="text-slate-800 font-medium">Normal Tanpa Hambatan</strong>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 5. RECENT CONSIGNMENTS MANIFEST TABLE                   -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-xl border border-slate-200/90 p-5 shadow-2xs">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                    Manifest Pengiriman Terkini
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar consignment yang sedang dalam proses pengiriman</p>
            </div>
            <a href="{{ route('shipments.index') }}" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 flex items-center gap-1 transition-colors">
                <span>Lihat Roster Lengkap</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="pb-2.5 font-bold">Nomor Resi</th>
                        <th class="pb-2.5 font-bold">Komoditas & Bobot</th>
                        <th class="pb-2.5 font-bold">Rute Perjalanan</th>
                        <th class="pb-2.5 font-bold">Armada Pengangkut</th>
                        <th class="pb-2.5 font-bold">Status</th>
                        <th class="pb-2.5 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentShipments as $s)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 pr-3 font-mono font-bold text-slate-900">
                                <a href="{{ route('shipments.show', $s->id) }}" class="text-emerald-800 hover:underline">
                                    {{ $s->tracking_number }}
                                </a>
                            </td>
                            <td class="py-3 pr-3">
                                <div class="font-semibold text-slate-900">{{ $s->cargo_type }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">{{ number_format($s->weight_kg, 0) }} kg</div>
                            </td>
                            <td class="py-3 pr-3">
                                <div class="font-medium text-slate-700">{{ $s->origin->city }} &rarr; {{ $s->destination->city }}</div>
                                <div class="text-emerald-800 text-[11px] font-medium mt-0.5">Posisi: {{ $s->currentLocation->name ?? 'Dalam Perjalanan' }}</div>
                            </td>
                            <td class="py-3 pr-3">
                                <span class="font-medium text-slate-800">{{ $s->carrier->name }}</span>
                                <span class="block text-[10px] text-slate-400 font-mono">[{{ $s->carrier->transport_mode }}]</span>
                            </td>
                            <td class="py-3 pr-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $s->status === 'DELIVERED' ? 'bg-slate-100 text-slate-800 border border-slate-300' : ($s->status === 'IN_TRANSIT' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-slate-100 text-slate-700') }}">
                                    {{ $s->status }}
                                </span>
                                @if($s->is_delayed)
                                    <span class="block text-[10px] text-amber-700 font-medium mt-0.5">+{{ $s->delay_duration_hours }}j tertunda</span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                <a href="{{ route('shipments.show', $s->id) }}" class="btn-brand-outline px-2.5 py-1 rounded text-xs inline-block">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400 italic">Belum ada manifest kargo terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
                color: '#1B4332',
                fillColor: '#2D6A4F',
                fillOpacity: 0.9,
                weight: 2
            }).addTo(map).bindPopup(`<b>${loc.name}</b><br>${loc.city}, ${loc.country}<br><span class="font-mono text-xs font-bold text-emerald-800">[${loc.code}]</span>`);
            markers.push(marker);
        });

        const activeShipments = @json($recentShipments);
        activeShipments.forEach(s => {
            if (s.current_location) {
                const isDelayed = s.is_delayed;
                const cargoMarker = L.circleMarker([s.current_location.latitude, s.current_location.longitude], {
                    radius: 8,
                    color: isDelayed ? '#b45309' : '#047857',
                    fillColor: isDelayed ? '#f59e0b' : '#10b981',
                    fillOpacity: 0.95,
                    weight: 2
                }).addTo(map).bindPopup(`
                    <b>Kargo: ${s.tracking_number}</b><br>
                    Komoditas: ${s.cargo_type}<br>
                    Status: <b>${s.status}</b> ${isDelayed ? '<br><span style="color:#b45309">Tertunda: +' + s.delay_duration_hours + ' jam</span>' : ''}<br>
                    <a href="/shipments/${s.id}" style="color:#047857;font-weight:bold;">Periksa Kargo &rarr;</a>
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
