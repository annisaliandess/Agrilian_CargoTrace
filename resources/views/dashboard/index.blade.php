@extends('layouts.app')

@section('title', 'Dashboard Operasional')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Title Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800">
                    Radar Logistik Aktif
                </span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-semibold">Gudang Utama Takengon (Aceh Tengah)</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Dashboard Operasional Ekspor</h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('track.public') }}" target="_blank" class="px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold shadow-2xs transition-colors flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Halaman Cek Resi</span>
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                <a href="{{ route('shipments.create') }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black shadow-xs transition-colors flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Buat Kargo Baru</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Numerical KPI Cards (Clean, Readable, Fresh Emerald Accents) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Managed -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between text-slate-400 text-xs font-bold uppercase tracking-wider">
                <span>Total Pengiriman</span>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center font-bold">
                    📦
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900 mt-2 tracking-tight">{{ $totalShipments }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Manifest kargo terdaftar</div>
        </div>

        <!-- In-Transit -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between text-slate-400 text-xs font-bold uppercase tracking-wider">
                <span>Dalam Perjalanan</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                    🚢
                </div>
            </div>
            <div class="text-3xl font-black text-emerald-600 mt-2 tracking-tight">{{ $inTransitCount }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Truk, kapal laut, & kargo udara</div>
        </div>

        <!-- Delivered Safely -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between text-slate-400 text-xs font-bold uppercase tracking-wider">
                <span>Terkirim Sukses</span>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-emerald-700 flex items-center justify-center font-bold">
                    ✓
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900 mt-2 tracking-tight">{{ $deliveredCount }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Tiba di pelabuhan tujuan</div>
        </div>

        <!-- Exceptions / Delayed -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between text-slate-400 text-xs font-bold uppercase tracking-wider">
                <span>Tertunda / Kendala</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center font-bold">
                    ⚠️
                </div>
            </div>
            <div class="text-3xl font-black text-amber-600 mt-2 tracking-tight">{{ $delayedCount }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Akibat cuaca & antrean pelabuhan</div>
        </div>
    </div>

    <!-- Logistics Network Map Cockpit -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3 px-1">
            <div>
                <h2 class="text-sm font-extrabold text-slate-900">
                    Radar Visual Rute Logistik Dataran Tinggi Gayo &bull; Global
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Pemantauan titik henti kargo dari Takengon, pos transit Bireuen, Pelabuhan Belawan, Singapura, hingga Rotterdam</p>
            </div>
            <div class="flex items-center gap-3 text-xs font-bold text-slate-500">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span> Titik Hub</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-slate-900"></span> Kargo Bergerak</span>
            </div>
        </div>
        <div id="overview-map" class="w-full h-80 sm:h-96 rounded-xl border border-slate-200"></div>
    </div>

    <!-- Bottom Section: Recent Manifests & Active Exceptions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Shipments Table (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200 shadow-2xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-sm font-extrabold text-slate-900">
                    Daftar Pengiriman Kargo Terbaru
                </h3>
                <a href="{{ route('shipments.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 uppercase tracking-wider text-[10px] font-extrabold">
                            <th class="py-3 font-bold">Nomor Resi</th>
                            <th class="py-3 font-bold">Komoditas Agro</th>
                            <th class="py-3 font-bold">Jalur Perjalanan</th>
                            <th class="py-3 font-bold">Status Kargo</th>
                            <th class="py-3 font-bold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($recentShipments as $s)
                            @php
                                $isCoffee = str_contains(strtolower($s->cargo_type), 'arabica') || str_contains(strtolower($s->cargo_type), 'coffee');
                                $isHorti = str_contains(strtolower($s->cargo_type), 'avocado') || str_contains(strtolower($s->cargo_type), 'chili');
                            @endphp
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3.5 font-mono font-bold text-slate-900">
                                    <a href="{{ route('shipments.show', $s->id) }}" class="text-emerald-700 hover:underline">
                                        {{ $s->tracking_number }}
                                    </a>
                                </td>
                                <td class="py-3.5">
                                    <div class="font-bold text-slate-900 flex items-center gap-1.5">
                                        @if($isCoffee)
                                            <span class="text-xs">☕</span>
                                        @elseif($isHorti)
                                            <span class="text-xs">🥑</span>
                                        @endif
                                        <span>{{ $s->cargo_type }}</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5 font-medium">
                                        {{ number_format($s->weight_kg, 0) }} kg &bull; {{ $s->carrier->name }}
                                    </div>
                                </td>
                                <td class="py-3.5 text-xs">
                                    <div class="font-semibold text-slate-800">{{ $s->origin->city }} &rarr; {{ $s->destination->city }}</div>
                                    <div class="text-emerald-700 text-[11px] font-bold">Saat ini: {{ $s->currentLocation->name ?? 'Dalam Perjalanan' }}</div>
                                </td>
                                <td class="py-3.5">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $s->status === 'DELIVERED' ? 'bg-slate-100 text-slate-900 border border-slate-300' : ($s->status === 'IN_TRANSIT' ? 'bg-emerald-50 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-700') }}">
                                        {{ $s->status }}
                                    </span>
                                    @if($s->is_delayed)
                                        <span class="block text-[10px] text-amber-700 font-bold mt-1">⚠️ +{{ $s->delay_duration_hours }}j tertunda</span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right">
                                    <a href="{{ route('shipments.show', $s->id) }}" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 font-bold text-xs text-slate-700 transition-colors">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400 italic">Belum ada pengiriman kargo terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Exceptions & Notifications (1 col) -->
        <div class="space-y-6">

            <!-- Active Holds / Exceptions -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-amber-950 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        Kendala Jalur Aktif ({{ $openExceptions->count() }})
                    </h3>
                </div>

                <div class="space-y-3">
                    @forelse($openExceptions as $exc)
                        <div class="p-3.5 rounded-xl bg-amber-50/70 border border-amber-200 text-xs">
                            <div class="flex items-center justify-between font-extrabold text-amber-950">
                                <span>{{ $exc->exception_type }}</span>
                                <span class="text-[10px] uppercase px-2 py-0.5 rounded-md bg-amber-200 text-amber-900">{{ $exc->severity }}</span>
                            </div>
                            <div class="text-[11px] text-amber-800 font-bold mt-1">
                                Kargo: <a href="{{ route('shipments.show', $exc->shipment_id) }}" class="underline font-mono">{{ $exc->shipment->tracking_number }}</a>
                            </div>
                            <p class="text-slate-600 mt-1 leading-relaxed text-[11px]">{{ Str::limit($exc->description, 100) }}</p>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic py-2">Semua jalur pengiriman terpantau lancar!</div>
                    @endforelse
                </div>
            </div>

            <!-- Notifications Feed -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-2xs">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-900">
                        Pemberitahuan Sistem
                    </h3>
                </div>

                <div class="space-y-2.5">
                    @forelse($notifications as $notif)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                            <div class="font-extrabold text-slate-900">{{ $notif->title }}</div>
                            <div class="text-slate-600 text-[11px] mt-0.5 leading-relaxed font-medium">{{ $notif->message }}</div>
                            <div class="text-[10px] font-bold text-slate-400 mt-1">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic py-2">Tidak ada notifikasi baru.</div>
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
                radius: 7,
                color: '#047857',
                fillColor: '#10b981',
                fillOpacity: 0.9,
                weight: 2
            }).addTo(map).bindPopup(`<b>${loc.name}</b><br>${loc.city}, ${loc.country}<br><span class="font-mono text-xs font-bold text-emerald-700">[${loc.code}]</span>`);
            markers.push(marker);
        });

        const activeShipments = @json($recentShipments);
        activeShipments.forEach(s => {
            if (s.current_location) {
                const isDelayed = s.is_delayed;
                const cargoMarker = L.circleMarker([s.current_location.latitude, s.current_location.longitude], {
                    radius: 9,
                    color: isDelayed ? '#b45309' : '#0f172a',
                    fillColor: isDelayed ? '#f59e0b' : '#334155',
                    fillOpacity: 0.95,
                    weight: 3
                }).addTo(map).bindPopup(`
                    <b>Kargo: ${s.tracking_number}</b><br>
                    Komoditas: ${s.cargo_type}<br>
                    Status: <b>${s.status}</b> ${isDelayed ? '<br><span style="color:#b45309">⚠️ Tertunda: +' + s.delay_duration_hours + ' jam</span>' : ''}<br>
                    <a href="/shipments/${s.id}" style="color:#059669;font-weight:bold;">Periksa Kargo &rarr;</a>
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
