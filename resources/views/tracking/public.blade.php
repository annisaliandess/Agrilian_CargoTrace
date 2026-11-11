@extends('layouts.app')

@section('title', 'Lacak Kargo Ekspor Agro')

@section('content')
<div class="space-y-8 max-w-5xl mx-auto">

    <!-- Search Hero Box (Clean, Bright & Professional) -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-10 shadow-sm text-center relative overflow-hidden">
        <div class="max-w-2xl mx-auto">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Pelacakan Kargo Ekspor Agro Dataran Tinggi
            </span>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Cek Posisi & Cuaca Kargo Real-Time
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 mt-2">
                Pantau perjalanan komoditas Kopi Gayo, Alpukat, & Cabai dari gudang Takengon, pelabuhan Belawan, hingga Singapura dan Rotterdam.
            </p>

            <!-- Search Form -->
            <form action="{{ route('track.public') }}" method="GET" class="mt-6 flex flex-col sm:flex-row gap-2 max-w-xl mx-auto">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="tracking_number" value="{{ $query ?? 'LNDS-2026-GY001' }}" placeholder="Masukkan Nomor Resi (misal: LNDS-2026-GY001)"
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 bg-slate-50 text-slate-900 placeholder-slate-400 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                </div>
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm shadow-sm transition-colors cursor-pointer flex items-center justify-center gap-2">
                    <span>Lacak Kargo</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Quick Chips -->
            <div class="mt-4 flex flex-wrap items-center justify-center gap-2 text-xs">
                <span class="text-slate-400 font-medium">Contoh Resi:</span>
                <a href="{{ route('track.public', 'LNDS-2026-GY001') }}" class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-emerald-800 text-slate-700 font-bold transition-colors">
                    ☕ LNDS-2026-GY001 (Kopi Gayo &rarr; Rotterdam)
                </a>
                <a href="{{ route('track.public', 'LNDS-2026-GY002') }}" class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-emerald-50 hover:text-emerald-800 text-slate-700 font-bold transition-colors">
                    🥑 LNDS-2026-GY002 (Alpukat & Cabai &rarr; Singapura)
                </a>
                <a href="{{ route('track.public', 'LNDS-2026-GY003') }}" class="px-3 py-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-900 font-bold transition-colors border border-amber-200">
                    ⚠️ LNDS-2026-GY003 (Status Tertunda Cuaca)
                </a>
            </div>
        </div>
    </div>

    @if($query && !$shipment)
        <!-- Not Found -->
        <div class="bg-white rounded-2xl p-8 border border-slate-200 text-center max-w-md mx-auto shadow-sm">
            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-base font-extrabold text-slate-800">Nomor Resi Tidak Ditemukan</h3>
            <p class="text-xs text-slate-500 mt-1">Tidak ada data kargo dengan nomor <span class="font-mono font-bold text-slate-900">"{{ $query }}"</span>. Silakan periksa kembali nomor manifest Anda.</p>
        </div>
    @elseif($shipment)

        <!-- Consignment Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left 2 Cols: Main Info, Stepper, Map, Timeline -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Header Waybill Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    @php
                        $isCoffee = str_contains(strtolower($shipment->cargo_type), 'arabica') || str_contains(strtolower($shipment->cargo_type), 'coffee');
                        $isHorti = str_contains(strtolower($shipment->cargo_type), 'avocado') || str_contains(strtolower($shipment->cargo_type), 'chili');
                    @endphp

                    <div class="flex flex-wrap items-start justify-between gap-4 pb-4 border-b border-slate-100">
                        <div>
                            <div class="flex items-center gap-2 mb-1.5">
                                @if($isCoffee)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200">
                                        ☕ Kopi Arabika Gayo Specialty
                                    </span>
                                @elseif($isHorti)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-900 border border-emerald-200">
                                        🥑 Hortikultura Rantai Dingin
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200">
                                        📦 Komoditas Pertanian
                                    </span>
                                @endif
                                <span class="text-xs font-bold text-slate-500">&bull; {{ $shipment->carrier->name }}</span>
                            </div>

                            <h2 class="text-2xl font-black text-slate-900 font-mono tracking-tight">
                                {{ $shipment->tracking_number }}
                            </h2>
                            <p class="text-xs font-semibold text-slate-600 mt-0.5">
                                {{ $shipment->cargo_type }}
                            </p>
                        </div>

                        <!-- Status Badge -->
                        <div class="text-right">
                            @php
                                $badgeStyle = match($shipment->status) {
                                    'CREATED' => 'bg-slate-100 text-slate-800 border-slate-300',
                                    'BOOKED' => 'bg-blue-50 text-blue-900 border-blue-200',
                                    'PICKED_UP' => 'bg-amber-50 text-amber-900 border-amber-200',
                                    'IN_TRANSIT' => 'bg-emerald-50 text-emerald-800 border-emerald-300 animate-pulse',
                                    'DELIVERED' => 'bg-emerald-600 text-white border-emerald-600',
                                    default => 'bg-slate-100 text-slate-800',
                                };
                            @endphp

                            <span class="inline-block px-3.5 py-1.5 rounded-xl text-xs font-extrabold uppercase tracking-wider border {{ $badgeStyle }}">
                                {{ $shipment->status }}
                            </span>

                            @if($shipment->is_delayed)
                                <div class="mt-1.5 text-xs font-bold text-amber-800 bg-amber-50 px-2.5 py-0.5 rounded-lg border border-amber-300 flex items-center justify-end gap-1">
                                    <span>⚠️ Tertunda +{{ $shipment->delay_duration_hours }} Jam</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Origin, Checkpoint, Destination Cards -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 text-xs">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-[10px] font-bold uppercase text-slate-400 block">Asal Pengiriman</span>
                            <strong class="text-slate-900 block font-bold text-xs mt-0.5">{{ $shipment->origin->name }}</strong>
                            <span class="text-slate-500 text-[11px]">{{ $shipment->origin->city }}</span>
                        </div>
                        <div class="bg-emerald-50/70 p-3 rounded-xl border border-emerald-100">
                            <span class="text-[10px] font-bold uppercase text-emerald-700 block">Posisi Checkpoint</span>
                            <strong class="text-emerald-950 block font-bold text-xs mt-0.5">{{ $shipment->currentLocation->name ?? 'Dalam Perjalanan' }}</strong>
                            <span class="text-emerald-800 text-[11px]">{{ $shipment->currentLocation->city ?? '-' }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-[10px] font-bold uppercase text-slate-400 block">Pelabuhan Tujuan</span>
                            <strong class="text-slate-900 block font-bold text-xs mt-0.5">{{ $shipment->destination->name }}</strong>
                            <span class="text-slate-500 text-[11px]">{{ $shipment->destination->city }}, {{ $shipment->destination->country }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-[10px] font-bold uppercase text-slate-400 block">Estimasi Sampai (ETA)</span>
                            <strong class="text-slate-900 block font-bold text-xs mt-0.5 font-mono">{{ \Carbon\Carbon::parse($shipment->estimated_arrival)->format('d M Y, H:i') }}</strong>
                            <span class="text-[11px] {{ $shipment->is_delayed ? 'text-amber-700 font-bold' : 'text-slate-500' }}">
                                {{ $shipment->is_delayed ? 'Jadwal diperbarui' : 'Tepat waktu' }}
                            </span>
                        </div>
                    </div>

                    <!-- Clean Horizontal Stepper -->
                    <div class="mt-6 pt-5 border-t border-slate-100">
                        @php
                            $steps = ['CREATED', 'BOOKED', 'PICKED_UP', 'IN_TRANSIT', 'DELIVERED'];
                            $currentIdx = array_search($shipment->status, $steps);
                            if ($currentIdx === false) $currentIdx = 0;
                        @endphp

                        <div class="grid grid-cols-5 gap-2">
                            @foreach($steps as $idx => $step)
                                <div>
                                    <div class="h-2 rounded-full transition-colors {{ $idx <= $currentIdx ? 'bg-emerald-600' : 'bg-slate-200' }}"></div>
                                    <div class="mt-2 text-center">
                                        <span class="text-[10px] font-extrabold uppercase tracking-wide block {{ $idx <= $currentIdx ? 'text-slate-900' : 'text-slate-400' }}">
                                            {{ str_replace('_', ' ', $step) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Interactive Map Cockpit -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3 px-1">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                            <h3 class="text-sm font-extrabold text-slate-900">Peta Rute Multimodal Pelayaran & Darat</h3>
                        </div>
                        <span class="text-xs text-slate-400 font-medium">Leaflet.js &bull; OpenStreetMap</span>
                    </div>
                    <div id="shipment-map" class="w-full h-80 sm:h-96 rounded-xl border border-slate-200"></div>
                </div>

                <!-- Timeline Milestones -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h3 class="text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Riwayat Pemeriksaan Checkpoint</span>
                        <span class="text-xs font-normal text-slate-400">({{ $shipment->trackingEvents->count() }} catatan resmi)</span>
                    </h3>

                    <div class="relative pl-6 space-y-5 before:content-[''] before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                        @forelse($shipment->trackingEvents as $event)
                            <div class="relative">
                                <div class="absolute -left-6 top-1.5 w-3 h-3 rounded-full bg-emerald-600 ring-4 ring-emerald-50"></div>
                                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <div class="font-extrabold text-xs text-slate-900 flex items-center gap-2">
                                            <span>{{ $event->location->name ?? 'Titik Checkpoint' }}</span>
                                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800">{{ $event->status }}</span>
                                        </div>
                                        <span class="text-xs font-bold text-slate-500">{{ \Carbon\Carbon::parse($event->event_time)->format('d M Y &bull; H:i') }}</span>
                                    </div>
                                    <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">{{ $event->description }}</p>
                                    @if($event->creator)
                                        <div class="text-[11px] text-slate-400 mt-2 font-medium">
                                            Petugas Verifikator: {{ $event->creator->name }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-xs text-slate-400 italic">Belum ada catatan checkpoint.</div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Right 1 Col: Dynamic OpenWeather Station Card, Packing Manifest, Holds -->
            <div class="space-y-6">

                <!-- Dynamic OpenWeather Visual Station Card -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-2xl p-6 shadow-md border border-slate-700 relative overflow-hidden" id="weather-card">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-700/80 text-xs">
                        <span class="text-emerald-400 font-extrabold tracking-wide flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                            Stasiun Cuaca Real-Time
                        </span>
                        <button type="button" onclick="refreshLiveWeather({{ $shipment->current_location_id ?? $shipment->origin_id }})" class="p-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors cursor-pointer" title="Perbarui Data Cuaca">
                            <svg class="w-4 h-4" id="refresh-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </button>
                    </div>

                    <!-- Weather Metric Display -->
                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <div class="text-4xl font-black tracking-tight" id="weather-temp">{{ $weather['temp_c'] ?? 20 }}°C</div>
                            <div class="text-sm font-bold text-emerald-300 mt-0.5" id="weather-condition">{{ $weather['condition'] ?? 'Cuaca Normal' }}</div>
                            <div class="text-xs text-slate-300 font-medium mt-1 flex items-center gap-1" id="weather-location">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <span>{{ $weather['location_name'] ?? ($shipment->currentLocation->name ?? 'Takengon') }}</span>
                            </div>
                        </div>

                        <!-- Graphical Weather Icon Badge -->
                        <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center text-3xl shadow-inner" id="weather-icon-box">
                            @php
                                $cond = strtolower($weather['condition'] ?? '');
                                $icon = '⛅';
                                if (str_contains($cond, 'rain') || str_contains($cond, 'hujan')) $icon = '🌧️';
                                elseif (str_contains($cond, 'clear') || str_contains($cond, 'cerah')) $icon = '☀️';
                                elseif (str_contains($cond, 'thunder') || str_contains($cond, 'petir')) $icon = '⛈️';
                            @endphp
                            <span>{{ $icon }}</span>
                        </div>
                    </div>

                    <!-- Live Agronomic Gauges -->
                    <div class="grid grid-cols-3 gap-2 mt-5 pt-4 border-t border-slate-700/80 text-center text-xs">
                        <div class="bg-white/5 rounded-xl p-2">
                            <span class="text-[10px] text-slate-400 block font-semibold uppercase">Curah Hujan</span>
                            <strong class="text-sm font-extrabold text-white mt-0.5 block" id="weather-rain">{{ $weather['rain_mm'] ?? 0 }} mm</strong>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <span class="text-[10px] text-slate-400 block font-semibold uppercase">Angin</span>
                            <strong class="text-sm font-extrabold text-white mt-0.5 block" id="weather-wind">{{ $weather['wind_speed_kmh'] ?? 12 }} km/h</strong>
                        </div>
                        <div class="bg-white/5 rounded-xl p-2">
                            <span class="text-[10px] text-slate-400 block font-semibold uppercase">Kelembaban</span>
                            <strong class="text-sm font-extrabold text-white mt-0.5 block" id="weather-humidity">{{ $weather['humidity'] ?? 65 }}%</strong>
                        </div>
                    </div>

                    <div class="mt-4 text-xs font-semibold p-2.5 rounded-xl {{ ($weather['is_hazardous'] ?? false) ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/20' }}" id="weather-summary">
                        {{ $weather['alert_summary'] ?? 'Cuaca terpantau aman untuk jalur lintas pegunungan Takengon-Bireuen.' }}
                    </div>
                </div>

                <!-- Active Holds / Exceptions -->
                @if($shipment->exceptions->count() > 0)
                    <div class="bg-amber-50 rounded-2xl p-5 border border-amber-200 shadow-sm">
                        <h4 class="text-xs font-black uppercase tracking-wider text-amber-950 flex items-center gap-1.5 mb-3">
                            <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            Peringatan Kendala Jalur ({{ $shipment->exceptions->count() }})
                        </h4>
                        <div class="space-y-3">
                            @foreach($shipment->exceptions as $exc)
                                <div class="p-3.5 rounded-xl bg-white border border-amber-200 text-xs">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-extrabold text-amber-950">{{ $exc->exception_type }}</span>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $exc->status === 'RESOLVED' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                            {{ $exc->status }}
                                        </span>
                                    </div>
                                    <p class="text-slate-600 mt-1 leading-relaxed">{{ $exc->description }}</p>
                                    @if($exc->resolution_notes)
                                        <div class="mt-2 pt-2 border-t border-slate-100 text-emerald-800 font-bold text-[11px]">
                                            Tindakan: {{ $exc->resolution_notes }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Cargo Packing Manifest Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-3 pb-3 border-b border-slate-100">
                        <h4 class="text-xs font-black uppercase tracking-wider text-slate-800">
                            Rincian Barang Kargo
                        </h4>
                        <span class="text-xs font-black px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800">
                            {{ number_format($shipment->weight_kg, 0) }} KG
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse($shipment->items as $item)
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                <div class="font-extrabold text-slate-900">{{ $item->item_name }}</div>
                                <div class="flex justify-between text-slate-600 mt-1 font-semibold">
                                    <span>Jumlah: <strong>{{ $item->quantity }} unit</strong></span>
                                    <span>Berat: <strong>{{ number_format($item->weight_kg, 0) }} kg</strong></span>
                                </div>
                                <div class="text-[11px] text-slate-400 mt-1">Kemasan: {{ $item->package_type }}</div>
                                @if($item->description)
                                    <p class="text-[11px] text-slate-500 italic mt-1">{{ $item->description }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="text-xs text-slate-400 italic">Tidak ada rincian barang spesifik.</div>
                        @endforelse
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-600 space-y-1.5 font-medium">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Total Volume:</span>
                            <strong class="text-slate-900">{{ $shipment->volume_cbm ? $shipment->volume_cbm . ' CBM' : 'N/A' }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Pembeli / Consignee:</span>
                            <strong class="text-slate-900">{{ $shipment->customer->name ?? 'Confidential' }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Armada Pengangkut:</span>
                            <strong class="text-slate-900">{{ $shipment->carrier->name }}</strong>
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
                    .bindPopup("<b>Asal:</b> {{ $shipment->origin->name }}<br>{{ $shipment->origin->city }} [{{ $shipment->origin->code }}]");

                L.marker([destLat, destLon]).addTo(map)
                    .bindPopup("<b>Tujuan:</b> {{ $shipment->destination->name }}<br>{{ $shipment->destination->city }} [{{ $shipment->destination->code }}]");

                const isDelayed = {{ $shipment->is_delayed ? 'true' : 'false' }};
                L.circleMarker([currentLat, currentLon], {
                    radius: 9,
                    color: isDelayed ? '#d97706' : '#059669',
                    fillColor: isDelayed ? '#f59e0b' : '#10b981',
                    fillOpacity: 0.95,
                    weight: 3
                }).addTo(map).bindPopup("<b>Posisi Checkpoint Kargo Saat Ini:</b><br>{{ $shipment->currentLocation->name ?? 'Dalam Perjalanan' }}<br>Status: <b>{{ $shipment->status }}</b>").openPopup();

                const routePoints = [
                    [originLat, originLon],
                    [currentLat, currentLon],
                    [destLat, destLon]
                ];

                L.polyline(routePoints, {
                    color: isDelayed ? '#d97706' : '#059669',
                    weight: 3,
                    opacity: 0.8,
                    dashArray: '6, 8'
                }).addTo(map);

                const bounds = L.latLngBounds([
                    [originLat, originLon],
                    [currentLat, currentLon],
                    [destLat, destLon]
                ]);
                map.fitBounds(bounds, { padding: [40, 40] });
            });

            // Dynamic Live Weather Refresh via AJAX
            function refreshLiveWeather(locationId) {
                const icon = document.getElementById('refresh-icon');
                if (icon) icon.classList.add('animate-spin');

                fetch(`/api/weather?location_id=${locationId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.data) {
                            const w = data.data;
                            document.getElementById('weather-temp').innerText = `${w.temp_c}°C`;
                            document.getElementById('weather-condition').innerText = w.condition;
                            document.getElementById('weather-rain').innerText = `${w.rain_mm} mm`;
                            document.getElementById('weather-wind').innerText = `${w.wind_speed_kmh} km/h`;
                            document.getElementById('weather-humidity').innerText = `${w.humidity}%`;
                            document.getElementById('weather-summary').innerText = w.alert_summary;

                            let emoji = '⛅';
                            const c = w.condition.toLowerCase();
                            if (c.includes('rain') || c.includes('hujan')) emoji = '🌧️';
                            else if (c.includes('clear') || c.includes('cerah')) emoji = '☀️';
                            else if (c.includes('thunder') || c.includes('petir')) emoji = '⛈️';
                            document.getElementById('weather-icon-box').innerHTML = `<span>${emoji}</span>`;
                        }
                    })
                    .catch(err => console.error('Weather refresh error:', err))
                    .finally(() => {
                        if (icon) icon.classList.remove('animate-spin');
                    });
            }
        </script>
        @endpush
    @endif

</div>
@endsection
