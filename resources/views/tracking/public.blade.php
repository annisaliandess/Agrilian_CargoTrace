@extends('layouts.app')

@section('title', 'Lacak Kargo Ekspor Agro')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- ======================================================== -->
    <!-- HERO SECTION (Automark Style: Rich Gradient & Glow)     -->
    <!-- ======================================================== -->
    <div class="relative rounded-3xl bg-hero-gradient p-8 sm:p-14 text-center overflow-hidden shadow-2xl border border-white/10">
        <!-- Ambient Background Glows -->
        <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-[#57C84D]/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-80 h-80 rounded-full bg-[#95D5B2]/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl mx-auto">
            <!-- Pill Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold bg-[#95D5B2]/15 text-[#95D5B2] border border-[#95D5B2]/30 mb-5 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-[#57C84D] animate-pulse"></span>
                <span>Pelacakan Kargo Ekspor Agro Dataran Tinggi</span>
            </div>

            <!-- Big Headline with Gradient Highlight -->
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                Rantai Pasok Agro Highland <br class="hidden sm:inline" />
                <span class="text-gradient-mint">ke Pasar Internasional</span>
            </h1>

            <p class="text-xs sm:text-sm text-[#D8F3DC] mt-4 max-w-xl mx-auto font-medium leading-relaxed">
                Pantau pergerakan Kopi Arabika Gayo, Alpukat, & Cabai secara real-time dari Takengon, Pelabuhan Belawan, hingga Singapura dan Rotterdam.
            </p>

            <!-- Search Form (High Contrast & Clear Buttons) -->
            <form action="{{ route('track.public') }}" method="GET" class="mt-8 flex flex-col sm:flex-row gap-2 max-w-xl mx-auto p-1.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 shadow-xl">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="tracking_number" value="{{ $query ?? 'LNDS-2026-GY001' }}" placeholder="Ketik nomor resi (cth: LNDS-2026-GY001)"
                           class="w-full pl-11 pr-4 py-3.5 rounded-xl border-0 bg-white text-slate-900 placeholder-slate-400 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#57C84D] transition-all">
                </div>
                <button type="submit" class="btn-brand-accent px-7 py-3.5 rounded-xl text-xs sm:text-sm font-black flex items-center justify-center gap-2 cursor-pointer shadow-lg shadow-[#57C84D]/30 shrink-0">
                    <span>Lacak Kargo</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Quick Chips -->
            <div class="mt-5 flex flex-wrap items-center justify-center gap-2 text-xs">
                <span class="text-[#95D5B2]/80 font-semibold">Resi Contoh:</span>
                <a href="{{ route('track.public', 'LNDS-2026-GY001') }}" class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-[#D8F3DC] hover:text-white font-bold transition-all border border-white/10 backdrop-blur-sm">
                    ☕ LNDS-2026-GY001 (Kopi Gayo &rarr; Rotterdam)
                </a>
                <a href="{{ route('track.public', 'LNDS-2026-GY002') }}" class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-[#D8F3DC] hover:text-white font-bold transition-all border border-white/10 backdrop-blur-sm">
                    🥑 LNDS-2026-GY002 (Alpukat &rarr; Singapura)
                </a>
                <a href="{{ route('track.public', 'LNDS-2026-GY003') }}" class="px-3 py-1.5 rounded-lg bg-amber-400/20 hover:bg-amber-400/30 text-amber-200 hover:text-white font-bold transition-all border border-amber-300/30 backdrop-blur-sm">
                    ⚠️ LNDS-2026-GY003 (Status Peringatan Cuaca)
                </a>
            </div>
        </div>
    </div>

    @if($query && !$shipment)
        <!-- Not Found -->
        <div class="bg-white rounded-3xl p-10 border border-slate-200 text-center max-w-md mx-auto shadow-sm">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-4 border border-rose-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-lg font-black text-slate-900">Nomor Resi Tidak Ditemukan</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Tidak ditemukan riwayat kargo dengan nomor <span class="font-mono font-bold text-[#1B4332]">"{{ $query }}"</span>. Pastikan nomor resi sesuai dengan dokumen e-Waybill Anda.</p>
        </div>
    @elseif($shipment)

        @php
            $isCoffee = str_contains(strtolower($shipment->cargo_type), 'arabica') || str_contains(strtolower($shipment->cargo_type), 'coffee');
            $isHorti = str_contains(strtolower($shipment->cargo_type), 'avocado') || str_contains(strtolower($shipment->cargo_type), 'chili');
        @endphp

        <!-- ======================================================== -->
        <!-- WAYBILL STATUS BANNER & PROGRESS BAR                    -->
        <!-- ======================================================== -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        @if($isCoffee)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]">
                                ☕ Kopi Arabika Gayo Specialty
                            </span>
                        @elseif($isHorti)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]">
                                🥑 Hortikultura Rantai Dingin
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200">
                                📦 Komoditas Pertanian
                            </span>
                        @endif
                        <span class="text-xs font-bold text-slate-500">• {{ $shipment->carrier->name }}</span>
                    </div>

                    <div class="flex items-baseline gap-3">
                        <h2 class="text-2xl sm:text-3xl font-black text-[#1B4332] font-mono tracking-tight">
                            {{ $shipment->tracking_number }}
                        </h2>
                    </div>
                    <p class="text-xs text-slate-600 mt-1 font-medium">
                        Rute: <strong class="text-slate-900">{{ $shipment->origin->name }} ({{ $shipment->origin->city }})</strong> &rarr; <strong class="text-slate-900">{{ $shipment->destination->name }} ({{ $shipment->destination->city }})</strong>
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    @if($shipment->is_delayed)
                        <div class="px-4 py-2 rounded-2xl bg-amber-50 border border-amber-300 text-amber-900 text-right">
                            <span class="block text-[10px] font-extrabold uppercase tracking-wider text-amber-700">Status Kargo</span>
                            <span class="text-xs font-black flex items-center justify-end gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                PERHATIAN: TERTUNDA CUACA
                            </span>
                        </div>
                    @else
                        <div class="px-4 py-2 rounded-2xl bg-[#F0FBF5] border border-[#95D5B2] text-[#1B4332] text-right">
                            <span class="block text-[10px] font-extrabold uppercase tracking-wider text-[#40916C]">Status Kargo</span>
                            <span class="text-xs font-black flex items-center justify-end gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#57C84D] animate-pulse"></span>
                                ON TRACK (TEPAT WAKTU)
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Segmented Progress Bar -->
            <div class="mt-6">
                @php
                    $steps = [
                        ['key' => 'CREATED', 'label' => 'Dipesan'],
                        ['key' => 'PICKED_UP', 'label' => 'Muat di Kebun'],
                        ['key' => 'IN_TRANSIT', 'label' => 'Jalur Bireuen-Belawan'],
                        ['key' => 'AT_PORT', 'label' => 'Pelabuhan Belawan'],
                        ['key' => 'CUSTOMS_HOLD', 'label' => 'Pabean / Karantina'],
                        ['key' => 'DELIVERED', 'label' => 'Tiba di Tujuan']
                    ];
                    $statusOrder = ['CREATED' => 0, 'PICKED_UP' => 1, 'IN_TRANSIT' => 2, 'AT_PORT' => 3, 'CUSTOMS_HOLD' => 4, 'OUT_FOR_DELIVERY' => 4, 'DELIVERED' => 5];
                    $currentIdx = $statusOrder[$shipment->status] ?? 2;
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-6 gap-2">
                    @foreach($steps as $idx => $step)
                        @php
                            $isDone = $idx < $currentIdx;
                            $isCurrent = $idx === $currentIdx;
                        @endphp
                        <div class="flex flex-col items-center text-center">
                            <div class="w-full h-2 rounded-full mb-2 {{ $isDone ? 'bg-[#1B4332]' : ($isCurrent ? 'bg-[#57C84D] shadow-sm shadow-[#57C84D]/50' : 'bg-slate-200') }}"></div>
                            <span class="text-[11px] font-bold {{ $isCurrent ? 'text-[#1B4332]' : ($isDone ? 'text-slate-700' : 'text-slate-400') }}">
                                {{ $step['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- 3-CARD ROW METRICS (Image 2 Reference Style)             -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Card 1: Rute & Transportasi Multimodal -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-[#F0FBF5] text-[#1B4332] flex items-center justify-center font-bold text-xs border border-[#95D5B2]/50">
                                🚚
                            </div>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">Koridor Rute Ekspor</h3>
                        </div>
                        <span class="text-[11px] font-bold text-[#1B4332] hover:text-[#57C84D] cursor-pointer">Multimodal &rarr;</span>
                    </div>

                    <div class="space-y-2.5 text-xs">
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">Asal Komoditas</span>
                            <strong class="text-slate-900 font-mono">{{ $shipment->origin->name }}</strong>
                        </div>
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">Moda Angkutan</span>
                            <span class="px-2 py-0.5 rounded-md bg-[#F0FBF5] text-[#1B4332] font-extrabold border border-[#95D5B2]/60">
                                {{ $shipment->carrier->transport_mode }} ({{ $shipment->carrier->code }})
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">Lokasi Terkini</span>
                            <strong class="text-[#1B4332] font-bold">{{ $shipment->currentLocation->name ?? 'Dalam Perjalanan' }}</strong>
                        </div>
                        <div class="flex items-center justify-between py-1">
                            <span class="text-slate-500 font-medium">Pelabuhan Tujuan</span>
                            <strong class="text-slate-900 font-mono">{{ $shipment->destination->name }}</strong>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                    <span>Estimasi Sampai:</span>
                    <strong class="text-[#1B4332]">{{ $shipment->estimated_arrival->format('d M Y, H:i') }} WIB</strong>
                </div>
            </div>

            <!-- Card 2: Stasiun Cuaca Real-Time (OpenWeather API) -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm flex flex-col justify-between" id="weather-station-card">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-[#F0FBF5] text-[#1B4332] flex items-center justify-center font-bold text-xs border border-[#95D5B2]/50" id="weather-icon-box">
                                ⛅
                            </div>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">Cuaca Live OpenWeather</h3>
                        </div>
                        <button onclick="refreshLiveWeather({{ $shipment->current_location_id ?? $shipment->origin_id }})" 
                                title="Perbarui data cuaca dari satelit"
                                class="text-[11px] font-extrabold text-[#1B4332] hover:text-[#57C84D] flex items-center gap-1 cursor-pointer transition-colors">
                            <svg id="refresh-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span>Perbarui Live</span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between mb-3 px-2 py-1.5 rounded-2xl bg-[#F8FAF9] border border-slate-100">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-400">Suhu Koridor</span>
                            <div class="text-2xl font-black text-[#1B4332]" id="weather-temp">
                                {{ $weather['temp_c'] ?? 22 }}°C
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] uppercase font-bold text-slate-400">Kondisi Udara</span>
                            <div class="text-xs font-extrabold text-slate-800 capitalize" id="weather-condition">
                                {{ $weather['condition'] ?? 'Berawan Sejuk' }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-center text-xs">
                        <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="block text-[10px] text-slate-400 font-bold">Curah Hujan</span>
                            <strong class="text-slate-800" id="weather-rain">{{ $weather['rain_mm'] ?? 0 }} mm</strong>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="block text-[10px] text-slate-400 font-bold">Kecepatan Angin</span>
                            <strong class="text-slate-800" id="weather-wind">{{ $weather['wind_speed_kmh'] ?? 12 }} km/h</strong>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="block text-[10px] text-slate-400 font-bold">Kelembaban</span>
                            <strong class="text-slate-800" id="weather-humidity">{{ $weather['humidity'] ?? 78 }}%</strong>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-600">
                    <span class="font-bold text-slate-700">Analisis Resiko Jalan:</span>
                    <span id="weather-summary" class="text-slate-500 ml-1">{{ $weather['alert_summary'] ?? 'Jalur pegunungan terpantau aman dan lancar.' }}</span>
                </div>
            </div>

            <!-- Card 3: Kontrol Mutu & Keamanan Komoditas -->
            <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-[#F0FBF5] text-[#1B4332] flex items-center justify-center font-bold text-xs border border-[#95D5B2]/50">
                                🛡️
                            </div>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">Integritas Komoditas</h3>
                        </div>
                        <span class="text-[11px] font-bold text-[#1B4332]">Standar Mutu &rarr;</span>
                    </div>

                    <div class="space-y-2.5 text-xs">
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">Total Bobot Muatan</span>
                            <strong class="text-slate-900 font-mono">{{ number_format($shipment->weight_kg, 0) }} KG</strong>
                        </div>
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">Kadar Air Kopi</span>
                            <span class="px-2 py-0.5 rounded-md bg-[#F0FBF5] text-[#1B4332] font-black border border-[#95D5B2]/60">
                                11.4% (Standar &lt; 12%)
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">Suhu Kontainer Reefer</span>
                            <strong class="text-[#1B4332] font-mono">18.2°C (Optimal)</strong>
                        </div>
                        <div class="flex items-center justify-between py-1">
                            <span class="text-slate-500 font-medium">Segel Pengaman Digital</span>
                            <span class="text-[#1B4332] font-bold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#57C84D]"></span>
                                RFID Terverifikasi
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                    <span>Sertifikasi:</span>
                    <strong class="text-slate-800">Organik Fairtrade & Phytosanitary</strong>
                </div>
            </div>

        </div>

        <!-- ======================================================== -->
        <!-- MAP RADAR & EVENT TIMELINE (2 Columns)                  -->
        <!-- ======================================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left 2 Cols: Leaflet Radar Map & Rincian Muatan -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Interactive Leaflet Map Card -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-3 h-3 rounded-full bg-[#57C84D] animate-ping"></div>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">
                                Radar Perjalanan Kargo Multimodal (Leaflet GIS)
                            </h3>
                        </div>
                        <span class="text-[11px] text-slate-500 font-mono">Takengon &bull; Belawan &bull; Selat Malaka</span>
                    </div>

                    <div id="shipment-map" class="h-80 w-full rounded-2xl border border-slate-200 z-10"></div>
                </div>

                <!-- Cargo Packing Manifest Items -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <h4 class="text-xs font-black uppercase tracking-wider text-slate-800">
                            Daftar Barang & Kemasan Ekspor
                        </h4>
                        <span class="text-xs font-black px-3 py-1 rounded-full bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]/60">
                            Total: {{ number_format($shipment->weight_kg, 0) }} KG
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse($shipment->items as $item)
                            <div class="p-4 rounded-2xl bg-[#F8FAF9] border border-slate-200/60 text-xs">
                                <div class="font-extrabold text-[#1B4332] text-sm">{{ $item->item_name }}</div>
                                <div class="flex justify-between text-slate-600 mt-1.5 font-semibold">
                                    <span>Jumlah Muatan: <strong class="text-slate-900">{{ $item->quantity }} unit</strong></span>
                                    <span>Berat Satuan: <strong class="text-slate-900">{{ number_format($item->weight_kg, 0) }} kg</strong></span>
                                </div>
                                <div class="text-[11px] text-slate-500 mt-1">Jenis Kemasan: <strong class="text-slate-700">{{ $item->package_type }}</strong></div>
                                @if($item->description)
                                    <p class="text-[11px] text-slate-500 italic mt-1.5 bg-white p-2 rounded-lg border border-slate-100">{{ $item->description }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="text-xs text-slate-400 italic">Tidak ada rincian kemasan khusus.</div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Right 1 Col: Checkpoint Timeline & Exceptions -->
            <div class="space-y-6">

                <!-- Checkpoint Timeline -->
                <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 mb-4 pb-3 border-b border-slate-100 flex items-center justify-between">
                        <span>Riwayat Checkpoint</span>
                        <span class="text-[10px] text-slate-400 font-mono">{{ $shipment->trackingEvents->count() }} Peristiwa</span>
                    </h3>

                    <div class="relative pl-6 space-y-6 before:content-[''] before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                        @forelse($shipment->trackingEvents as $idx => $event)
                            <div class="relative group">
                                <div class="absolute -left-6 top-1 w-4 h-4 rounded-full border-2 {{ $idx === 0 ? 'bg-[#57C84D] border-white shadow-sm ring-2 ring-[#57C84D]/40' : 'bg-slate-300 border-white' }}"></div>

                                <div>
                                    <div class="text-[10px] font-bold text-slate-400 font-mono">
                                        {{ $event->event_time->format('d M Y, H:i') }} WIB
                                    </div>
                                    <div class="text-xs font-black text-slate-900 mt-0.5">
                                        {{ $event->status }}
                                    </div>
                                    <div class="text-xs font-bold text-[#1B4332] mt-0.5">
                                        {{ $event->location->name }} ({{ $event->location->city }})
                                    </div>
                                    @if($event->remarks)
                                        <div class="text-[11px] text-slate-600 mt-1.5 bg-[#F8FAF9] p-2.5 rounded-xl border border-slate-100 leading-relaxed">
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

                <!-- Weather Exceptions Alert (If Any) -->
                @if($shipment->exceptions->count() > 0)
                    <div class="bg-white rounded-3xl border border-amber-200 p-6 shadow-sm">
                        <div class="flex items-center gap-2 mb-3 pb-2 border-b border-amber-100">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                            <h4 class="text-xs font-black uppercase tracking-wider text-amber-900">
                                Catatan Cuaca & Insiden Jalur
                            </h4>
                        </div>

                        <div class="space-y-3">
                            @foreach($shipment->exceptions as $exc)
                                <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-xs">
                                    <div class="flex items-center justify-between text-amber-950 font-black">
                                        <span>{{ $exc->exception_type }}</span>
                                        <span class="px-2 py-0.5 rounded text-[10px] {{ $exc->severity === 'HIGH' ? 'bg-rose-100 text-rose-800' : 'bg-amber-200 text-amber-900' }}">
                                            {{ $exc->severity }}
                                        </span>
                                    </div>
                                    <p class="text-amber-900 mt-1 text-[11px] leading-relaxed">{{ $exc->description }}</p>
                                    @if($exc->resolution_notes)
                                        <div class="mt-2 pt-2 border-t border-amber-200 text-[#1B4332] font-bold text-[11px]">
                                            Tindakan Mitigasi: {{ $exc->resolution_notes }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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
                    radius: 9,
                    color: isDelayed ? '#d97706' : '#1B4332',
                    fillColor: isDelayed ? '#f59e0b' : '#57C84D',
                    fillOpacity: 0.95,
                    weight: 3
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
