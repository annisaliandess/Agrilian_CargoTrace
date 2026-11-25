@extends('layouts.app')

@php
    $isEn = app()->getLocale() === 'en';
@endphp

@section('title', $isEn ? 'Track Highland Agro-Export Cargo' : 'Lacak Kargo Ekspor Agro')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <!-- ======================================================== -->
    <!-- HERO SECTION (Full-Bleed HD Immersive Cockpit Hero)       -->
    <!-- ======================================================== -->
    <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-[#728156]/40 p-6 sm:p-10 lg:p-12">
        <!-- Full-bleed background photo (100% full & crisp) -->
        <img src="{{ asset('images/dashboard-hero.jpg') }}" alt="Takengon Highland Multimodal Logistics" class="absolute inset-0 w-full h-full object-cover object-right md:object-center">
        
        <!-- Subtle directional shading for text readability WITHOUT green tint over the whole photo -->
        <!-- On left: deep dark shadow so text is crisp and readable. On right: transparent so photo is completely visible! -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/75 via-50% to-transparent pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-transparent to-black/30 pointer-events-none"></div>

        <div class="w-full relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Left 7 Cols: Text, Search, Badges -->
                <div class="lg:col-span-7 space-y-5">
                    <!-- Pill Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-semibold bg-black/60 text-emerald-300 border border-emerald-500/30 backdrop-blur-md shadow-xs font-mono">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>{{ $isEn ? 'Highland Gayo Logistics & Multimodal Corridors' : 'Logistik Dataran Tinggi Gayo & Koridor Multimoda' }}</span>
                    </div>

                    <!-- Headline -->
                    <h1 class="text-2xl sm:text-4xl lg:text-[38px] font-extrabold text-white tracking-tight leading-tight drop-shadow-sm">
                        {{ $isEn ? 'Highland Agro Cargo Visibility from Takengon to the World' : 'Visibilitas Pengiriman Kargo Dataran Tinggi Takengon ke Seluruh Dunia' }}
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-200 leading-relaxed max-w-xl font-normal drop-shadow-xs">
                        {{ $isEn ? 'Real-time telemetry tracking for Gayo coffee & fresh commodities, route climate intelligence, and seamless multimodal checkpoints from Aceh highlands to global seaports.' : 'Pelacakan telemetri langsung untuk kopi Gayo & komoditas segar, pemantauan cuaca jalur pegunungan, dan kepatuhan pabean dari Aceh Tengah ke pelabuhan tujuan dunia.' }}
                    </p>

                    <!-- Search Form -->
                    <form action="{{ route('track.public') }}" method="GET" class="flex flex-col sm:flex-row gap-2 max-w-lg p-1.5 rounded-2xl bg-black/60 backdrop-blur-md border border-white/20 shadow-2xl">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="tracking_number" value="{{ $query ?? 'AGLN-2026-GY001' }}" 
                                   placeholder="{{ $isEn ? 'Enter waybill number...' : 'Masukkan nomor resi kargo...' }}"
                                   class="w-full pl-10 pr-3 py-2.5 rounded-xl border-0 bg-white text-slate-900 placeholder-slate-400 text-xs sm:text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm">
                        </div>
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white flex items-center justify-center gap-2 cursor-pointer shadow-lg bg-gradient-to-r from-[#2D6A4F] to-[#1B4332] hover:from-[#1B4332] hover:to-[#081C15] border border-emerald-400/30 transition-all shrink-0">
                            <span>{{ $isEn ? 'Track Cargo' : 'Lacak Kargo' }}</span>
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>

                    <!-- Quick Samples & Live Pills -->
                    <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                        <span class="text-slate-300 font-mono text-[11px] font-medium">{{ $isEn ? 'Sample Waybill:' : 'Contoh Resi Cepat:' }}</span>
                        <a href="{{ route('track.public', 'AGLN-2026-GY001') }}" class="px-2.5 py-1 rounded-lg bg-black/55 hover:bg-black/75 text-white transition-colors border border-white/20 hover:border-emerald-400/50 font-mono text-xs flex items-center gap-1.5 shadow-2xs backdrop-blur-xs">
                            <span class="font-bold">AGLN-2026-GY001</span>
                            <span class="text-slate-500">&bull;</span>
                            <span class="text-[11px] text-emerald-300 font-medium">{{ $isEn ? 'Gayo Coffee (Rotterdam)' : 'Kopi Gayo (Rotterdam)' }}</span>
                        </a>
                        <a href="{{ route('track.public', 'AGLN-2026-GY002') }}" class="px-2.5 py-1 rounded-lg bg-black/55 hover:bg-black/75 text-white transition-colors border border-white/20 hover:border-emerald-400/50 font-mono text-xs hidden sm:flex items-center gap-1.5 shadow-2xs backdrop-blur-xs">
                            <span class="font-bold">AGLN-2026-GY002</span>
                            <span class="text-slate-500">&bull;</span>
                            <span class="text-[11px] text-emerald-300 font-medium">{{ $isEn ? 'Avocado (Singapore)' : 'Alpukat (Singapura)' }}</span>
                        </a>
                    </div>
                </div>

                <!-- Right 5 Cols: Floating Telemetry Cards Over Full Photo -->
                <div class="lg:col-span-5 flex flex-col items-start lg:items-end gap-3.5 pt-4 lg:pt-0">
                    
                    <!-- Floating Badge 1: Central Hub Pulse -->
                    <div class="bg-black/60 backdrop-blur-xl px-4 py-2.5 rounded-2xl border border-white/15 text-white shadow-xl flex items-center gap-3">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <div>
                            <div class="text-[10px] font-mono text-emerald-400 font-bold uppercase tracking-wider">Pusat Operasional</div>
                            <div class="text-xs font-bold text-white">Takengon Central Hub Online</div>
                        </div>
                    </div>

                    <!-- Floating Badge 2: Telemetry Card -->
                    <div class="bg-black/60 backdrop-blur-xl p-4 rounded-2xl border border-white/15 text-white shadow-2xl w-full max-w-xs space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-white/10 text-xs">
                            <span class="text-[11px] font-mono text-slate-300 font-bold uppercase">Koridor Multimoda</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-emerald-950/80 text-emerald-300 border border-emerald-500/30">Aktif 24/7</span>
                        </div>
                        <div class="space-y-1.5 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Rute Ekspor:</span>
                                <span class="font-bold text-slate-100">Gayo &rarr; Belawan &rarr; Eropa</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Rantai Dingin:</span>
                                <span class="font-mono font-bold text-emerald-400">4°C - 8°C Verified</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Satelit Jalur Km 48:</span>
                                <span class="font-bold text-amber-200">Cerah Berawan (24°C)</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @if($query && !$shipment)
        <!-- Not Found -->
        <div class="bg-white rounded-2xl p-8 border border-slate-200 text-center max-w-md mx-auto shadow-sm">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-base font-bold text-slate-900">{{ $isEn ? 'Waybill Number Not Found' : 'Nomor Resi Tidak Ditemukan' }}</h3>
            <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $isEn ? 'No cargo record found for number "' . $query . '". Please verify your tracking number.' : 'Tidak ditemukan riwayat kargo dengan nomor "' . $query . '". Silakan periksa kembali nomor resi pengiriman Anda.' }}</p>
        </div>
    @elseif($shipment)

        @php
            $imageSrc = '/images/ship.jpg';
            if (str_contains(strtolower($shipment->cargo_type), 'arabica') || str_contains(strtolower($shipment->cargo_type), 'coffee')) {
                $imageSrc = '/images/coffee.jpg';
            } elseif (str_contains(strtolower($shipment->cargo_type), 'avocado') || str_contains(strtolower($shipment->cargo_type), 'chili')) {
                $imageSrc = '/images/avocado.jpg';
            }
        @endphp

        <!-- Waybill Status Banner -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                <div class="flex items-start gap-4">
                    <img src="{{ $imageSrc }}" alt="{{ $shipment->cargo_type }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shrink-0 hidden sm:block shadow-2xs">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-800 border border-slate-200">
                                {{ $shipment->cargo_type }}
                            </span>
                            <span class="text-xs font-semibold text-slate-500">&bull; {{ $shipment->carrier->name }}</span>
                        </div>

                        <h2 class="text-2xl font-black text-slate-900 font-mono tracking-tight">
                            {{ $shipment->tracking_number }}
                        </h2>
                        <p class="text-xs text-slate-600 mt-1 font-medium">
                            {{ $isEn ? 'Route:' : 'Rute:' }} <strong class="text-slate-900">{{ $shipment->origin->name }} ({{ $shipment->origin->city }})</strong> &rarr; <strong class="text-slate-900">{{ $shipment->destination->name }} ({{ $shipment->destination->city }})</strong>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-end sm:items-center gap-3">
                    <!-- Dynamic Scannable QR Code via API -->
                    <div class="hidden sm:flex items-center gap-2.5 bg-stone-50 p-2 rounded-xl border border-stone-200 shadow-2xs">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&color=051F20&bgcolor=FFFFFF&data={{ urlencode(url('/track/' . $shipment->tracking_number)) }}" 
                             alt="QR Tracking Code" class="w-10 h-10 object-contain rounded">
                        <div class="text-[9px] font-mono leading-tight">
                            <span class="font-extrabold text-stone-800 block">QR TRACK</span>
                            <span class="text-stone-500 text-[8px] block">{{ $isEn ? 'Scan via Mobile' : 'Scan via Kamera HP' }}</span>
                            <span class="text-[7px] text-emerald-700 font-bold uppercase">Key: {{ substr(md5($shipment->tracking_number), 0, 8) }}</span>
                        </div>
                    </div>

                    <!-- Barcode / Digital Waybill Badge -->
                    <div class="hidden md:flex flex-col items-end">
                        <div class="bg-stone-50 px-3 py-1.5 rounded-lg border border-stone-200 shadow-2xs flex flex-col items-center">
                            <svg class="h-6 w-36 text-stone-800" viewBox="0 0 176 26" fill="currentColor">
                                <rect x="0" y="0" width="2" height="26"/><rect x="4" y="0" width="1" height="26"/><rect x="7" y="0" width="3" height="26"/><rect x="12" y="0" width="1" height="26"/><rect x="15" y="0" width="2" height="26"/><rect x="19" y="0" width="4" height="26"/><rect x="25" y="0" width="1" height="26"/><rect x="28" y="0" width="2" height="26"/><rect x="32" y="0" width="3" height="26"/><rect x="37" y="0" width="1" height="26"/><rect x="40" y="0" width="2" height="26"/><rect x="44" y="0" width="4" height="26"/><rect x="50" y="0" width="2" height="26"/><rect x="54" y="0" width="1" height="26"/><rect x="57" y="0" width="3" height="26"/><rect x="62" y="0" width="1" height="26"/><rect x="65" y="0" width="2" height="26"/><rect x="69" y="0" width="4" height="26"/><rect x="75" y="0" width="2" height="26"/><rect x="79" y="0" width="1" height="26"/><rect x="82" y="0" width="3" height="26"/><rect x="87" y="0" width="2" height="26"/><rect x="91" y="0" width="1" height="26"/><rect x="94" y="0" width="4" height="26"/><rect x="100" y="0" width="2" height="26"/><rect x="104" y="0" width="1" height="26"/><rect x="107" y="0" width="3" height="26"/><rect x="112" y="0" width="1" height="26"/><rect x="115" y="0" width="3" height="26"/><rect x="120" y="0" width="2" height="26"/><rect x="124" y="0" width="1" height="26"/><rect x="127" y="0" width="4" height="26"/><rect x="133" y="0" width="2" height="26"/><rect x="137" y="0" width="1" height="26"/><rect x="140" y="0" width="3" height="26"/><rect x="145" y="0" width="2" height="26"/><rect x="149" y="0" width="1" height="26"/><rect x="152" y="0" width="3" height="26"/><rect x="157" y="0" width="2" height="26"/><rect x="161" y="0" width="1" height="26"/><rect x="164" y="0" width="4" height="26"/><rect x="170" y="0" width="2" height="26"/><rect x="174" y="0" width="2" height="26"/>
                            </svg>
                            <span class="text-[9px] font-mono tracking-widest text-stone-600 mt-1 uppercase">*{{ $shipment->tracking_number }}*</span>
                        </div>
                        <div class="flex items-center gap-1.5 mt-1 text-[10px] text-stone-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span class="font-medium text-stone-600">Digital Waybill</span>
                            <span>&bull;</span>
                            <a href="/api/track/{{ $shipment->tracking_number }}" target="_blank" class="hover:text-amber-800 text-stone-500 underline font-mono">API JSON ↗</a>
                        </div>
                    </div>

                    @if($shipment->is_delayed)
                        <div class="px-3.5 py-1.5 rounded-xl bg-amber-50 border border-amber-300 text-amber-900 text-right">
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-amber-700">{{ $isEn ? 'Cargo Status' : 'Status Kargo' }}</span>
                            <span class="text-xs font-bold flex items-center justify-end gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                {{ $isEn ? 'Weather Delayed' : 'Tertunda Akibat Cuaca' }}
                            </span>
                        </div>
                    @else
                        <div class="px-3.5 py-1.5 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-900 text-right">
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-emerald-700">{{ $isEn ? 'Cargo Status' : 'Status Kargo' }}</span>
                            <span class="text-xs font-bold flex items-center justify-end gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                {{ $isEn ? 'On Track (Scheduled)' : 'Sesuai Jadwal (On Track)' }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Segmented Progress Bar -->
            <div class="mt-6">
                @php
                    $steps = [
                        ['key' => 'CREATED', 'label' => $isEn ? 'Booked' : 'Dipesan'],
                        ['key' => 'PICKED_UP', 'label' => $isEn ? 'Loaded at Farm' : 'Muat di Kebun'],
                        ['key' => 'IN_TRANSIT', 'label' => $isEn ? 'Bireuen Corridor' : 'Jalur Bireuen-Belawan'],
                        ['key' => 'AT_PORT', 'label' => $isEn ? 'Belawan Port' : 'Pelabuhan Belawan'],
                        ['key' => 'CUSTOMS_HOLD', 'label' => $isEn ? 'Customs Clearance' : 'Klirens Pabean'],
                        ['key' => 'DELIVERED', 'label' => $isEn ? 'Delivered' : 'Tiba di Tujuan']
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
                            <div class="w-full h-1.5 rounded-full mb-2 {{ $isDone ? 'bg-forest-600' : ($isCurrent ? 'bg-forest-500 ring-2 ring-forest-200' : 'bg-slate-200') }}"></div>
                            <span class="text-[11px] font-semibold {{ $isCurrent ? 'text-forest-700 font-bold' : ($isDone ? 'text-slate-800' : 'text-slate-400') }}">
                                {{ $step['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            @if(isset($valuation))
                <!-- Valuasi Ekspor Valas Bar (ECB Live) -->
                <div class="mt-5 pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-forest-50 text-forest-800 border border-forest-200 font-mono">
                            <span class="w-1.5 h-1.5 rounded-full bg-forest-600"></span>
                            {{ $isEn ? 'Export Foreign Valuation:' : 'Valuasi Devisa Ekspor:' }}
                        </span>
                        <strong class="font-mono text-slate-900 text-xs">{{ $valuation['idr_formatted'] }}</strong>
                    </div>

                    <div class="flex items-center gap-3 font-mono text-[11px]">
                        <span class="text-slate-600">{{ $isEn ? 'Global Market:' : 'Pasar Global:' }} <strong class="text-slate-900 font-bold">{{ $valuation['usd_formatted'] }} USD</strong></span>
                        <span class="text-slate-300">&bull;</span>
                        <span class="text-slate-600">{{ $isEn ? 'Europe (Rotterdam):' : 'Eropa (Rotterdam):' }} <strong class="text-forest-700 font-bold">{{ $valuation['eur_formatted'] }} EUR</strong></span>
                    </div>
                </div>
            @endif
        </div>

        <!-- 3-Card Metrics (Enterprise B2B Format) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <!-- Card 1: Rute & Transportasi Multimodal -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">{{ $isEn ? 'Export Route Corridor' : 'Koridor Rute Ekspor' }}</h3>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-400">Multimodal</span>
                    </div>

                    <div class="space-y-2.5 text-xs">
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">{{ $isEn ? 'Commodity Origin' : 'Asal Komoditas' }}</span>
                            <strong class="text-slate-900 font-mono">{{ $shipment->origin->name }}</strong>
                        </div>
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">{{ $isEn ? 'Transport Mode' : 'Moda Angkutan' }}</span>
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-800 font-semibold text-[11px]">
                                {{ $shipment->carrier->transport_mode }} ({{ $shipment->carrier->code }})
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">{{ $isEn ? 'Current Location' : 'Lokasi Terkini' }}</span>
                            <strong class="text-emerald-800 font-semibold">{{ $shipment->currentLocation->name ?? ($isEn ? 'In Transit' : 'Dalam Perjalanan') }}</strong>
                        </div>
                        <div class="flex items-center justify-between py-1">
                            <span class="text-slate-500 font-medium">{{ $isEn ? 'Destination Port' : 'Pelabuhan Tujuan' }}</span>
                            <strong class="text-slate-900 font-mono">{{ $shipment->destination->name }}</strong>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                    <span>{{ $isEn ? 'Estimated Arrival (ETA):' : 'Estimasi Sampai (ETA):' }}</span>
                    <strong class="text-slate-800 font-mono">{{ $shipment->estimated_arrival->format('d M Y, H:i') }} WIB</strong>
                </div>
            </div>

            <!-- Card 2: Stasiun Cuaca Real-Time (OpenWeather API) -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs flex flex-col justify-between" id="weather-station-card">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">{{ $isEn ? 'Live OpenWeather Radar' : 'Cuaca Live OpenWeather' }}</h3>
                        </div>
                        <button onclick="refreshLiveWeather({{ $shipment->current_location_id ?? $shipment->origin_id }})" 
                                title="{{ $isEn ? 'Refresh satellite weather telemetry' : 'Perbarui data cuaca dari satelit' }}"
                                class="text-[11px] font-semibold text-emerald-800 hover:text-emerald-950 flex items-center gap-1 cursor-pointer transition-colors">
                            <svg id="refresh-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span>{{ $isEn ? 'Live Refresh' : 'Perbarui Live' }}</span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between mb-3 px-3 py-2 rounded-xl bg-slate-50 border border-slate-100">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-400">{{ $isEn ? 'Corridor Temp' : 'Suhu Koridor' }}</span>
                            <div class="text-2xl font-black text-slate-900 font-mono" id="weather-temp">
                                {{ $weather['temp_c'] ?? 22 }}°C
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] uppercase font-bold text-slate-400">{{ $isEn ? 'Condition' : 'Kondisi Udara' }}</span>
                            <div class="text-xs font-bold text-slate-800 capitalize" id="weather-condition">
                                {{ $weather['condition'] ?? ($isEn ? 'Partly Cloudy' : 'Berawan Sejuk') }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-center text-xs">
                        <div class="p-2 rounded-lg bg-slate-50 border border-slate-100">
                            <span class="block text-[10px] text-slate-400 font-medium">{{ $isEn ? 'Rainfall' : 'Curah Hujan' }}</span>
                            <strong class="text-slate-800 font-mono" id="weather-rain">{{ $weather['rain_mm'] ?? 0 }} mm</strong>
                        </div>
                        <div class="p-2 rounded-lg bg-slate-50 border border-slate-100">
                            <span class="block text-[10px] text-slate-400 font-medium">{{ $isEn ? 'Wind Speed' : 'Kecepatan Angin' }}</span>
                            <strong class="text-slate-800 font-mono" id="weather-wind">{{ $weather['wind_speed_kmh'] ?? 12 }} km/h</strong>
                        </div>
                        <div class="p-2 rounded-lg bg-slate-50 border border-slate-100">
                            <span class="block text-[10px] text-slate-400 font-medium">{{ $isEn ? 'Humidity' : 'Kelembaban' }}</span>
                            <strong class="text-slate-800 font-mono" id="weather-humidity">{{ $weather['humidity'] ?? 78 }}%</strong>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-600">
                    <span class="font-bold text-slate-700">{{ $isEn ? 'Route Risk Analysis:' : 'Analisis Resiko Jalur:' }}</span>
                    <span id="weather-summary" class="text-slate-500 ml-1">{{ $weather['alert_summary'] ?? ($isEn ? 'Mountain route clear and operating normally.' : 'Jalur pegunungan terpantau aman dan lancar.') }}</span>
                </div>
            </div>

            <!-- Card 3: Kontrol Mutu & Keamanan Komoditas -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">{{ $isEn ? 'Commodity Integrity' : 'Integritas Komoditas' }}</h3>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-400">{{ $isEn ? 'Quality Standard' : 'Standar Mutu' }}</span>
                    </div>

                    <div class="space-y-2.5 text-xs">
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">{{ $isEn ? 'Total Cargo Weight' : 'Total Bobot Muatan' }}</span>
                            <strong class="text-slate-900 font-mono">{{ number_format($shipment->weight_kg, 0) }} KG</strong>
                        </div>
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">{{ $isEn ? 'Coffee Moisture' : 'Kadar Air Kopi' }}</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 font-bold border border-emerald-200">
                                11.4% ({{ $isEn ? 'Standard < 12%' : 'Standar < 12%' }})
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500 font-medium">{{ $isEn ? 'Reefer Container Temp' : 'Suhu Kontainer Reefer' }}</span>
                            <strong class="text-slate-900 font-mono">18.2°C (Optimal)</strong>
                        </div>
                        <div class="flex items-center justify-between py-1">
                            <span class="text-slate-500 font-medium">{{ $isEn ? 'Digital Security Seal' : 'Segel Pengaman Digital' }}</span>
                            <span class="text-emerald-800 font-semibold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                {{ $isEn ? 'RFID Verified' : 'RFID Terverifikasi' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                    <span>{{ $isEn ? 'Certification:' : 'Sertifikasi:' }}</span>
                    <strong class="text-slate-800">Organik Fairtrade & Phytosanitary</strong>
                </div>
            </div>

        </div>

        <!-- Map & Event Timeline (2 Columns) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left 2 Cols: Leaflet Radar Map & Shipment Items -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Interactive Leaflet Map Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                                {{ $isEn ? 'Multimodal Cargo Journey Radar (Leaflet GIS)' : 'Radar Perjalanan Kargo Multimodal (Leaflet GIS)' }}
                            </h3>
                        </div>
                        <span class="text-[11px] text-slate-500 font-mono">Takengon &bull; Belawan &bull; Selat Malaka</span>
                    </div>

                    <div id="shipment-map" class="h-80 w-full rounded-xl border border-slate-200 z-10"></div>
                </div>

                <!-- Cargo Shipment Items -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                            {{ $isEn ? 'Export Cargo Items & Packaging' : 'Daftar Barang & Kemasan Ekspor' }}
                        </h4>
                        <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800">
                            Total: {{ number_format($shipment->weight_kg, 0) }} KG
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse($shipment->items as $item)
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/70 text-xs">
                                <div class="font-bold text-slate-900">{{ $item->item_name }}</div>
                                <div class="flex justify-between text-slate-600 mt-1 font-medium">
                                    <span>{{ $isEn ? 'Quantity:' : 'Jumlah Muatan:' }} <strong class="text-slate-800">{{ $item->quantity }} unit</strong></span>
                                    <span>{{ $isEn ? 'Unit Weight:' : 'Berat Satuan:' }} <strong class="text-slate-800">{{ number_format($item->weight_kg, 0) }} kg</strong></span>
                                </div>
                                <div class="text-[11px] text-slate-500 mt-0.5">{{ $isEn ? 'Package Type:' : 'Jenis Kemasan:' }} <strong class="text-slate-700">{{ $item->package_type }}</strong></div>
                                @if($item->description)
                                    <p class="text-[11px] text-slate-500 italic mt-1 bg-white p-2 rounded border border-slate-100">{{ $item->description }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="text-xs text-slate-400 italic">{{ $isEn ? 'No custom packaging details.' : 'Tidak ada rincian kemasan khusus.' }}</div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Right 1 Col: Checkpoint Timeline & Exceptions -->
            <div class="space-y-6">

                <!-- Checkpoint Timeline -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-2xs">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 mb-4 pb-3 border-b border-slate-100 flex items-center justify-between">
                        <span>{{ $isEn ? 'Checkpoint History' : 'Riwayat Checkpoint' }}</span>
                        <span class="text-[10px] text-slate-400 font-mono">{{ $shipment->trackingEvents->count() }} {{ $isEn ? 'Events' : 'Peristiwa' }}</span>
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
                                        <div class="text-[11px] text-slate-600 mt-1 bg-slate-50 p-2 rounded border border-slate-100 leading-relaxed font-normal">
                                            {{ $event->remarks }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-xs text-slate-400 italic">{{ $isEn ? 'No checkpoint events recorded yet.' : 'Belum ada peristiwa checkpoint tercatat.' }}</div>
                        @endforelse
                    </div>
                </div>

                <!-- Weather Exceptions Alert (If Any) -->
                @if($shipment->exceptions->count() > 0)
                    <div class="bg-white rounded-2xl border border-amber-200 p-5 shadow-2xs">
                        <div class="flex items-center gap-2 mb-3 pb-2 border-b border-amber-100">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-amber-900">
                                {{ $isEn ? 'Weather Notes & Route Incidents' : 'Catatan Cuaca & Insiden Jalur' }}
                            </h4>
                        </div>

                        <div class="space-y-3">
                            @foreach($shipment->exceptions as $exc)
                                <div class="p-3 rounded-xl bg-amber-50/80 border border-amber-200/80 text-xs">
                                    <div class="flex items-center justify-between text-amber-950 font-bold">
                                        <span>{{ $exc->exception_type }}</span>
                                        <span class="px-1.5 py-0.5 rounded text-[10px] {{ $exc->severity === 'HIGH' ? 'bg-rose-100 text-rose-800 font-bold' : 'bg-amber-200 text-amber-900 font-semibold' }}">
                                            {{ $exc->severity }}
                                        </span>
                                    </div>
                                    <p class="text-amber-900 mt-1 text-[11px] leading-relaxed">{{ $exc->description }}</p>
                                    @if($exc->resolution_notes)
                                        <div class="mt-2 pt-2 border-t border-amber-200 text-emerald-900 font-semibold text-[11px]">
                                            {{ $isEn ? 'Mitigation Action:' : 'Tindakan Mitigasi:' }} {{ $exc->resolution_notes }}
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
                    maxZoom: 19,
                    subdomains: ['a', 'b', 'c'],
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                L.marker([originLat, originLon]).addTo(map)
                    .bindPopup("<b>{{ $isEn ? 'Commodity Origin:' : 'Asal Komoditas:' }}</b><br>{{ $shipment->origin->name }}<br>{{ $shipment->origin->city }} [{{ $shipment->origin->code }}]");

                L.marker([destLat, destLon]).addTo(map)
                    .bindPopup("<b>{{ $isEn ? 'Export Destination:' : 'Tujuan Ekspor:' }}</b><br>{{ $shipment->destination->name }}<br>{{ $shipment->destination->city }} [{{ $shipment->destination->code }}]");

                const isDelayed = {{ $shipment->is_delayed ? 'true' : 'false' }};
                L.circleMarker([currentLat, currentLon], {
                    radius: 8,
                    color: isDelayed ? '#D97706' : '#0B2B26',
                    fillColor: isDelayed ? '#F59E0B' : '#235347',
                    fillOpacity: 0.95,
                    weight: 2
                }).addTo(map).bindPopup("<b>{{ $isEn ? 'Current Cargo Checkpoint:' : 'Posisi Checkpoint Kargo Saat Ini:' }}</b><br>{{ $shipment->currentLocation->name ?? ($isEn ? 'In Transit' : 'Dalam Perjalanan') }}<br>Status: <b>{{ $shipment->status }}</b>").openPopup();

                const routePoints = [
                    [originLat, originLon],
                    [currentLat, currentLon],
                    [destLat, destLon]
                ];

                L.polyline(routePoints, {
                    color: isDelayed ? '#D97706' : '#163832',
                    weight: 3.5,
                    opacity: 0.85,
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
    @else
        <!-- ======================================================== -->
        <!-- LANDING PAGE DYNAMIC BENTO SHOWCASE (Non-Monotonous UI) -->
        <!-- ======================================================== -->
        <div class="space-y-8 mt-8">

            <!-- 1. Pipeline Rute Multimoda Terpadu (Editorial Interactive Strip) -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#B6C99B]/50 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#728156] font-mono block">
                            {{ $isEn ? 'Multimodal Pipeline' : 'Alur Rantai Pasok Terpadu' }}
                        </span>
                        <h3 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight">
                            {{ $isEn ? 'Takengon Highland to Global Destination Ocean Ports' : 'Dari Perkebunan Dataran Tinggi Gayo ke Pelabuhan Samudra Dunia' }}
                        </h3>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#E7F5DC] text-[#4C5836] border border-[#CFE1B9] font-mono self-start sm:self-auto">
                        <span class="w-2 h-2 rounded-full bg-[#728156]"></span>
                        {{ $isEn ? 'Continuous Cold-Chain' : 'Rantai Dingin Terjamin' }}
                    </span>
                </div>

                <!-- 4 Step Flow Badges -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4">
                    <div class="p-3.5 rounded-2xl bg-[#E7F5DC]/50 border border-[#CFE1B9] flex flex-col justify-between">
                        <span class="text-[10px] font-bold text-[#728156] font-mono">01 &bull; KEBUN GAYO</span>
                        <div class="text-xs font-bold text-slate-900 mt-1">Takengon Central Depot</div>
                        <span class="text-[10px] text-slate-500 mt-0.5">Muat Truk Reefer (4°C)</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-[#E7F5DC]/50 border border-[#CFE1B9] flex flex-col justify-between">
                        <span class="text-[10px] font-bold text-[#728156] font-mono">02 &bull; JALUR PEGUNUNGAN</span>
                        <div class="text-xs font-bold text-slate-900 mt-1">Koridor Bireuen (Km 48)</div>
                        <span class="text-[10px] text-slate-500 mt-0.5">Monitoring Cuaca Satelit</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-[#E7F5DC]/50 border border-[#CFE1B9] flex flex-col justify-between">
                        <span class="text-[10px] font-bold text-[#728156] font-mono">03 &bull; HUB PELABUHAN</span>
                        <div class="text-xs font-bold text-slate-900 mt-1">Terminal Belawan (Medan)</div>
                        <span class="text-[10px] text-slate-500 mt-0.5">Klirens Bea Cukai & Pabean</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-[#728156] text-white border border-[#5F6D46] flex flex-col justify-between shadow-xs">
                        <span class="text-[10px] font-bold text-[#CFE1B9] font-mono">04 &bull; SAMUDERA DUNIA</span>
                        <div class="text-xs font-bold text-white mt-1">Singapura &bull; Rotterdam</div>
                        <span class="text-[10px] text-[#E7F5DC] mt-0.5">Kapal Kontainer Samudera</span>
                    </div>
                </div>
            </div>

            <!-- 2. Asymmetrical Bento-Grid (Bukan 3 Kartu Kembar Monoton) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                
                <!-- Main Feature Bento (7 Cols): Kopi Arabika Gayo Spesial -->
                <div class="lg:col-span-7 bg-white rounded-3xl overflow-hidden border border-[#B6C99B]/60 shadow-sm hover:shadow-md transition-all flex flex-col group">
                    <div class="relative h-64 sm:h-72 overflow-hidden bg-slate-900">
                        <!-- Photo is fully visible & crisp -->
                        <img src="{{ asset('images/coffee.jpg') }}" alt="Kopi Arabika Gayo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#E7F5DC] text-[#384226] border border-[#CFE1B9] shadow-sm font-mono">
                                {{ $isEn ? 'Premier Export Commodity' : 'Komoditas Unggulan Utama' }}
                            </span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <span class="text-xs font-mono font-bold text-[#CFE1B9] uppercase tracking-wider block">Koridor 01 &bull; Dataran Tinggi Gayo ➔ Eropa</span>
                            <h3 class="text-lg sm:text-xl font-extrabold text-white leading-tight mt-0.5">
                                Kopi Arabika Specialty Gayo (Wine & Full Washed)
                            </h3>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ $isEn ? 'Grade 1 certified organic green coffee beans hermetically packed in grainpro bags. Transported via climate-controlled multimodal routes directly to European roasters.' : 'Biji kopi hijau Grade 1 tersertifikasi organik dikemas hermetis khusus. Dikirim melintasi koridor pegunungan menuju Pelabuhan Belawan untuk dimuat ke kapal kargo samudera Maersk Line menuju Pelabuhan Rotterdam, Belanda.' }}
                        </p>
                        <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-lg bg-[#E7F5DC] text-[#4C5836] font-bold font-mono text-[11px]">Kadar Air: 11.5%</span>
                                <span class="px-2.5 py-0.5 rounded-lg bg-[#E7F5DC] text-[#4C5836] font-bold font-mono text-[11px]">Suhu: 18°C</span>
                            </div>
                            <span class="text-[#728156] font-bold font-mono">Armada: Maersk Container</span>
                        </div>
                    </div>
                </div>

                <!-- Secondary Stacked Bento (5 Cols): Alpukat & Hub Multimoda -->
                <div class="lg:col-span-5 flex flex-col gap-6">
                    
                    <!-- Card 2A: Alpukat Mentega Gayo -->
                    <div class="bg-white rounded-3xl overflow-hidden border border-[#B6C99B]/60 shadow-sm hover:shadow-md transition-all flex flex-col group flex-1">
                        <div class="relative h-36 overflow-hidden bg-slate-900">
                            <!-- Photo clear and bright -->
                            <img src="{{ asset('images/avocado.jpg') }}" alt="Alpukat Mentega Gayo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 left-3 text-white">
                                <span class="text-[10px] font-mono text-emerald-300 font-bold uppercase">Koridor 02 &bull; Hortikultura Segar</span>
                                <h4 class="text-sm font-extrabold text-white">Alpukat Mentega Dataran Tinggi</h4>
                            </div>
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#E7F5DC] text-[#384226] font-mono">Takengon ➔ Singapura</span>
                            </div>
                        </div>
                        <div class="p-4 flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-mono text-[11px]">Rantai Dingin: <strong>7.5°C</strong></span>
                            <span class="text-[#728156] font-bold font-mono">Evergreen Reefer</span>
                        </div>
                    </div>

                    <!-- Card 2B: Pelabuhan & Hub Multimoda -->
                    <div class="bg-white rounded-3xl overflow-hidden border border-[#B6C99B]/60 shadow-sm hover:shadow-md transition-all flex flex-col group flex-1">
                        <div class="relative h-36 overflow-hidden bg-slate-900">
                            <!-- Photo clear and bright -->
                            <img src="{{ asset('images/multimodal-port.jpg') }}" alt="Terminal Pelabuhan Belawan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                            <div class="absolute bottom-3 left-3 text-white">
                                <span class="text-[10px] font-mono text-emerald-300 font-bold uppercase">Infrastruktur Ekspor</span>
                                <h4 class="text-sm font-extrabold text-white">Terminal Petikemas Samudera</h4>
                            </div>
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#E7F5DC] text-[#384226] font-mono">Darat &bull; Laut &bull; Udara</span>
                            </div>
                        </div>
                        <div class="p-4 flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-mono text-[11px]">Status Hub: <strong>6 Lokasi Strategis</strong></span>
                            <a href="{{ route('commodities.index') }}" class="text-[#728156] font-bold hover:underline flex items-center gap-1 font-mono text-[11px]">
                                <span>Lihat Rute Lengkap &rarr;</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 3. Kotak Gelap Banner (Highland Dark Olive Box #1D2617) -->
            <div class="rounded-3xl p-7 sm:p-9 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl border border-emerald-500/20 bg-gradient-to-br from-[#0B1209] via-[#142010] to-[#0D180A]">
                <div class="max-w-xl space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-950/80 text-emerald-300 border border-emerald-500/30 font-mono">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>{{ $isEn ? 'Enterprise Multimodal Visibility' : 'Sistem Pengiriman Logistik Terpadu' }}</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-white leading-tight">
                        {{ $isEn ? 'Highland Agro Cargo Traceability Platform' : 'Platform Pelacakan Pengiriman Kargo Dataran Tinggi Gayo' }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-normal">
                        {{ $isEn ? 'Delivering end-to-end transparency for Gayo coffee and highland agro commodities with temperature sensors, live satellite weather radar, and international customs audit trail.' : 'Menjamin transparansi pengiriman kopi dan komoditas pertanian Gayo dengan pemantauan suhu, satelit cuaca jalur pegunungan, serta dokumen surat jalan digital.' }}
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <a href="{{ route('commodities.index') }}" class="btn-brand-accent px-5 py-2.5 rounded-xl text-xs font-bold text-white shadow-md">
                        {{ $isEn ? 'Commodities & Fleet' : 'Komoditas & Armada' }}
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-white text-[#142010] hover:bg-slate-100 shadow-md transition-colors">
                            {{ $isEn ? 'Sign In to Portal' : 'Masuk ke Portal' }}
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-white text-[#142010] hover:bg-slate-100 shadow-md transition-colors">
                            Dashboard
                        </a>
                    @endguest
                </div>
            </div>

        </div>
    @endif

</div>
@endsection
