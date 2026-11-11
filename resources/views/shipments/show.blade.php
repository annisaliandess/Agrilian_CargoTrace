@extends('layouts.app')

@section('title', 'Kargo ' . $shipment->tracking_number)

@section('content')
<div class="space-y-6">

    @php
        $isCoffee = str_contains(strtolower($shipment->cargo_type), 'arabica') || str_contains(strtolower($shipment->cargo_type), 'coffee');
        $isHorti = str_contains(strtolower($shipment->cargo_type), 'avocado') || str_contains(strtolower($shipment->cargo_type), 'chili');
        $imageSrc = $isCoffee ? '/images/coffee.jpg' : ($isHorti ? '/images/avocado.jpg' : '/images/ship.jpg');
    @endphp

    <!-- Top Action & Waybill Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
            <img src="{{ $imageSrc }}" alt="{{ $shipment->cargo_type }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shrink-0 hidden sm:block shadow-2xs">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-800 border border-slate-200">
                        {{ $shipment->cargo_type }}
                    </span>
                    <span class="text-xs font-semibold text-slate-500">&bull; {{ $shipment->carrier->name }}</span>
                </div>

                <div class="flex items-center gap-3">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-mono tracking-tight">{{ $shipment->tracking_number }}</h1>
                    <a href="{{ route('track.public', $shipment->tracking_number) }}" target="_blank" class="btn-brand-outline px-3 py-1 rounded-xl text-xs flex items-center gap-1.5">
                        <span>Lihat Cek Resi</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
                <p class="text-xs text-slate-600 mt-1 font-medium">
                    Pembeli / Consignee: <strong class="text-slate-900">{{ $shipment->customer->name ?? 'Confidential' }}</strong> &bull; Komoditas: <strong class="text-slate-900">{{ $shipment->cargo_type }}</strong>
                </p>
            </div>
        </div>

        <!-- Badges -->
        <div class="flex flex-wrap items-center gap-2">
            @php
                $badgeStyle = match($shipment->status) {
                    'CREATED' => 'bg-slate-100 text-slate-800 border-slate-300',
                    'BOOKED' => 'bg-blue-50 text-blue-900 border-blue-200',
                    'PICKED_UP' => 'bg-amber-50 text-amber-900 border-amber-200',
                    'IN_TRANSIT' => 'bg-emerald-50 text-emerald-800 border-emerald-300',
                    'DELIVERED' => 'bg-slate-900 text-white border-slate-900',
                    default => 'bg-slate-100 text-slate-800',
                };
            @endphp
            <span class="px-3.5 py-1.5 rounded-xl text-xs font-bold uppercase tracking-wider border {{ $badgeStyle }}">
                {{ $shipment->status }}
            </span>

            @if($shipment->is_delayed)
                <span class="px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-amber-50 text-amber-900 border border-amber-300 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    Tertunda +{{ $shipment->delay_duration_hours }} Jam ({{ $shipment->delay_severity }})
                </span>
            @endif
        </div>
    </div>

    <!-- Main Grid: 2 Cols Left, 1 Col Right -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Stepper, Map, Operator Panel, Timeline -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Stepper Progress Bar Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 text-xs">
                    <span class="text-slate-400 font-bold uppercase text-[10px] tracking-wider">Status Perjalanan Kargo</span>
                    <span class="text-slate-800 font-bold">{{ $shipment->origin->city }} &rarr; {{ $shipment->destination->city }}</span>
                </div>

                @php
                    $steps = ['CREATED', 'BOOKED', 'PICKED_UP', 'IN_TRANSIT', 'DELIVERED'];
                    $currentIdx = array_search($shipment->status, $steps);
                    if ($currentIdx === false) $currentIdx = 0;
                @endphp

                <div class="grid grid-cols-5 gap-2 mt-4">
                    @foreach($steps as $idx => $step)
                        <div>
                            <div class="h-1.5 rounded-full transition-colors {{ $idx <= $currentIdx ? 'bg-[#1B4332]' : 'bg-slate-200' }}"></div>
                            <div class="mt-2 text-center">
                                <span class="text-[10px] font-bold uppercase tracking-wide block {{ $idx <= $currentIdx ? 'text-slate-900' : 'text-slate-400' }}">
                                    {{ str_replace('_', ' ', $step) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Map Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Peta Rute Multimodal Pelayaran & Darat</h3>
                    </div>
                    <span class="text-xs text-slate-400 font-mono">Leaflet.js &bull; OpenStreetMap</span>
                </div>
                <div id="shipment-map" class="w-full h-80 rounded-xl border border-slate-200 z-10"></div>
            </div>

            <!-- Operator Control Panel (Admin & Operator only) -->
            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs space-y-5">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            Panel Kendali Operator & Dispatch
                        </h3>
                        <span class="text-xs font-semibold text-slate-500">Akses: {{ auth()->user()->role }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- 1. Status Transition Form -->
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-1">1. Majukan Status Kargo</h4>
                            <p class="text-[11px] text-slate-500 mb-3">Validasi siklus ketat: CREATED &rarr; BOOKED &rarr; PICKED UP &rarr; IN TRANSIT &rarr; DELIVERED.</p>

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
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Status Valid Selanjutnya</label>
                                        <select name="status" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-bold text-slate-900 focus:ring-1 focus:ring-slate-900 focus:outline-none">
                                            @foreach($allowed as $target)
                                                <option value="{{ $target }}">{{ $target }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Checkpoint Terkait</label>
                                        <select name="location_id" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-medium">
                                            @foreach($locations as $l)
                                                <option value="{{ $l->id }}" {{ $shipment->current_location_id == $l->id ? 'selected' : '' }}>{{ $l->name }} ({{ $l->city }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <input type="text" name="notes" placeholder="Catatan operator (misal: Kontainer dimuat di Belawan)..." class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-normal">
                                    </div>
                                    <button type="submit" class="btn-brand-primary w-full py-2.5 px-3 rounded-lg text-xs font-bold cursor-pointer">
                                        Perbarui Status Kargo &rarr;
                                    </button>
                                </form>
                            @else
                                <div class="p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold">
                                    Klirens Selesai: Kargo telah tiba di tujuan (DELIVERED).
                                </div>
                            @endif
                        </div>

                        <!-- 2. Log Checkpoint Milestone Event -->
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-1">2. Catat Titik Checkpoint</h4>
                            <p class="text-[11px] text-slate-500 mb-3">Tambahkan pemindaian transit tanpa mengubah status utama kargo.</p>

                            <form action="{{ route('shipments.events.store', $shipment->id) }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Checkpoint *</label>
                                    <select name="location_id" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-medium">
                                        @foreach($locations as $l)
                                            <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->city }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Keterangan Pemindaian *</label>
                                    <input type="text" name="description" placeholder="misal: Melewati pos Bireuen, suhu reefer stabil..." required
                                           class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-normal">
                                </div>
                                <button type="submit" class="btn-brand-outline w-full py-2.5 px-3 rounded-lg text-xs font-semibold cursor-pointer">
                                    + Simpan Checkpoint
                                </button>
                            </form>
                        </div>

                        <!-- 3. Report Exception Modal / Form -->
                        <div class="md:col-span-2 p-4 rounded-xl bg-amber-50/70 border border-amber-200">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-amber-950 mb-1">3. Laporkan Kendala Rute & Hitung Ulang Estimasi</h4>
                            <p class="text-[11px] text-amber-800 mb-3">Evaluasi kondisi cuaca otomatis jika terkait cuaca, kalkulasi durasi keterlambatan, dan perbarui ETA.</p>

                            <form action="{{ route('shipments.exceptions.store', $shipment->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-semibold text-amber-950 mb-1">Kategori Kendala *</label>
                                    <select name="exception_type" required class="w-full px-3 py-2 rounded-lg border border-amber-300 text-xs bg-white font-bold text-amber-950">
                                        <option value="WEATHER_DELAY">WEATHER_DELAY (Longsor / Cuaca Ekstrem)</option>
                                        <option value="CUSTOMS_HOLD">CUSTOMS_HOLD (Karantina / Pabean)</option>
                                        <option value="PORT_CONGESTION">PORT_CONGESTION (Antrean Pelabuhan)</option>
                                        <option value="DAMAGED">DAMAGED (Pemeriksaan Kemasan)</option>
                                        <option value="MISROUTED">MISROUTED</option>
                                        <option value="DOCUMENTATION_ISSUE">DOCUMENTATION_ISSUE</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-amber-950 mb-1">Tingkat Keparahan *</label>
                                    <select name="severity" required class="w-full px-3 py-2 rounded-lg border border-amber-300 text-xs bg-white font-bold text-amber-950">
                                        <option value="LOW">LOW (+3 Jam)</option>
                                        <option value="MEDIUM" selected>MEDIUM (+8 Jam)</option>
                                        <option value="HIGH">HIGH (+24 Jam)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-amber-950 mb-1">Lokasi Kejadian</label>
                                    <select name="location_id" class="w-full px-3 py-2 rounded-lg border border-amber-300 text-xs bg-white font-semibold text-amber-950">
                                        @foreach($locations as $l)
                                            <option value="{{ $l->id }}">{{ $l->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="sm:col-span-2">
                                    <input type="text" name="description" placeholder="Deskripsi kendala (misal: Longsor di jalur Bireuen-Takengon km 45)..." required
                                           class="w-full px-3 py-2 rounded-lg border border-amber-300 text-xs bg-white font-normal">
                                </div>

                                <div>
                                    <button type="submit" class="w-full py-2 px-3 rounded-lg bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-xs transition-colors cursor-pointer">
                                        Catat Kendala & Update ETA
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Event Checkpoints Timeline -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-4 pb-3 border-b border-slate-100 flex items-center justify-between">
                    <span>Linimasa Checkpoint (Audit Trail)</span>
                    <span class="text-xs text-slate-400 font-mono">{{ $shipment->trackingEvents->count() }} Milestone</span>
                </h3>

                <div class="relative pl-6 space-y-5 before:content-[''] before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    @forelse($shipment->trackingEvents as $idx => $event)
                        <div class="relative group">
                            <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full border-2 {{ $idx === 0 ? 'bg-emerald-600 border-white ring-2 ring-emerald-600/30' : 'bg-slate-300 border-white' }}"></div>

                            <div>
                                <div class="text-[10px] font-bold text-slate-400 font-mono">
                                    {{ $event->event_time->format('d M Y, H:i') }} WIB
                                </div>
                                <div class="text-xs font-bold text-slate-900 mt-0.5">
                                    {{ $event->status }}
                                </div>
                                <div class="text-xs font-semibold text-emerald-800 mt-0.5">
                                    {{ $event->location->name }} ({{ $event->location->city }})
                                </div>
                                @if($event->remarks)
                                    <div class="text-[11px] text-slate-600 mt-1 bg-slate-50 p-2 rounded border border-slate-100 leading-relaxed">
                                        {{ $event->remarks }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic">Belum ada peristiwa checkpoint tercatat.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right 1 Col: Live Weather Station & Cargo Packing -->
        <div class="space-y-6">

            <!-- Dynamic Weather Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs" id="weather-station-card">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Cuaca Live OpenWeather</h3>
                    </div>
                    <button onclick="refreshLiveWeather({{ $shipment->current_location_id ?? $shipment->origin_id }})" 
                            title="Perbarui data cuaca dari satelit"
                            class="text-[11px] font-semibold text-emerald-800 hover:text-emerald-950 flex items-center gap-1 cursor-pointer transition-colors">
                        <svg id="refresh-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Perbarui Live</span>
                    </button>
                </div>

                <div class="flex items-center justify-between mb-3 px-3 py-2 rounded-xl bg-slate-50 border border-slate-100">
                    <div>
                        <span class="text-[10px] uppercase font-semibold text-slate-400">Suhu Koridor</span>
                        <div class="text-2xl font-bold text-slate-900 font-mono" id="weather-temp">
                            {{ $weather['temp_c'] ?? 22 }}°C
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] uppercase font-semibold text-slate-400">Kondisi Udara</span>
                        <div class="text-xs font-bold text-slate-800 capitalize" id="weather-condition">
                            {{ $weather['condition'] ?? 'Berawan Sejuk' }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2 text-center text-xs">
                    <div class="p-2 rounded-lg bg-slate-50 border border-slate-100">
                        <span class="block text-[10px] text-slate-400 font-medium">Hujan</span>
                        <strong class="text-slate-800 font-mono" id="weather-rain">{{ $weather['rain_mm'] ?? 0 }} mm</strong>
                    </div>
                    <div class="p-2 rounded-lg bg-slate-50 border border-slate-100">
                        <span class="block text-[10px] text-slate-400 font-medium">Angin</span>
                        <strong class="text-slate-800 font-mono" id="weather-wind">{{ $weather['wind_speed_kmh'] ?? 12 }} km/h</strong>
                    </div>
                    <div class="p-2 rounded-lg bg-slate-50 border border-slate-100">
                        <span class="block text-[10px] text-slate-400 font-medium">Lembab</span>
                        <strong class="text-slate-800 font-mono" id="weather-humidity">{{ $weather['humidity'] ?? 78 }}%</strong>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-600">
                    <span class="font-bold text-slate-700">Analisis Resiko Jalur:</span>
                    <span id="weather-summary" class="text-slate-500 ml-1">{{ $weather['alert_summary'] ?? 'Jalur pegunungan terpantau lancar dan aman.' }}</span>
                </div>
            </div>

            <!-- Cargo Packing Manifest Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                        Rincian Barang Kargo
                    </h3>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800">
                        {{ number_format($shipment->weight_kg, 0) }} KG
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($shipment->items as $item)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70 text-xs">
                            <div class="font-bold text-slate-900">{{ $item->item_name }}</div>
                            <div class="flex justify-between text-slate-600 mt-1 font-medium">
                                <span>Jumlah: <strong>{{ $item->quantity }} unit</strong></span>
                                <span>Berat: <strong>{{ number_format($item->weight_kg, 0) }} kg</strong></span>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Kemasan: {{ $item->package_type }}</div>
                            @if($item->description)
                                <p class="text-[11px] text-slate-500 italic mt-1 bg-white p-2 rounded border border-slate-100">{{ $item->description }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic">Tidak ada rincian barang.</div>
                    @endforelse
                </div>

                <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-600 space-y-1.5 font-medium">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Total Volume:</span>
                        <strong class="text-slate-800">{{ $shipment->volume_cbm ? $shipment->volume_cbm . ' CBM' : 'N/A' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Pembeli / Consignee:</span>
                        <strong class="text-slate-800">{{ $shipment->customer->name ?? 'Confidential' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Armada Pengangkut:</span>
                        <strong class="text-slate-800">{{ $shipment->carrier->name }}</strong>
                    </div>
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
            .bindPopup("<b>Asal Komoditas:</b><br>{{ $shipment->origin->name }}<br>{{ $shipment->origin->city }} [{{ $shipment->origin->code }}]");

        L.marker([destLat, destLon]).addTo(map)
            .bindPopup("<b>Tujuan Ekspor:</b><br>{{ $shipment->destination->name }}<br>{{ $shipment->destination->city }} [{{ $shipment->destination->code }}]");

        const isDelayed = {{ $shipment->is_delayed ? 'true' : 'false' }};
        L.circleMarker([currentLat, currentLon], {
            radius: 8,
            color: isDelayed ? '#d97706' : '#1B4332',
            fillColor: isDelayed ? '#f59e0b' : '#10b981',
            fillOpacity: 0.95,
            weight: 2
        }).addTo(map).bindPopup("<b>Posisi Checkpoint Kargo Saat Ini:</b><br>{{ $shipment->currentLocation->name ?? 'Dalam Perjalanan' }}<br>Status: <b>{{ $shipment->status }}</b>").openPopup();

        const routePoints = [
            [originLat, originLon],
            [currentLat, currentLon],
            [destLat, destLon]
        ];

        L.polyline(routePoints, {
            color: isDelayed ? '#d97706' : '#1B4332',
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
                }
            })
            .catch(err => console.error('Weather refresh error:', err))
            .finally(() => {
                if (icon) icon.classList.remove('animate-spin');
            });
    }
</script>
@endpush
@endsection
