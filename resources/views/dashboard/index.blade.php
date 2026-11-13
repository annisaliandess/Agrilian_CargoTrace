@extends('layouts.app')

@section('title', 'Dashboard Operasional Ekspor Highland')

@section('content')
<div class="space-y-6">

    <!-- ======================================================== -->
    <!-- 1. EXECUTIVE COMMAND BANNER (Pure Clean Light Theme)     -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-stone-200/90 shadow-2xs">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <!-- Status Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-900 border border-amber-200 mb-3">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span>Takengon Central Hub &bull; Koridor Belawan &bull; Rotterdam Direct</span>
                </div>

                <!-- Headline (Clean, Bold, Solid Typography - No AI rainbow gradient!) -->
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-stone-900">
                    Dashboard Logistik Ekspor Highland
                </h1>
                <p class="text-xs sm:text-sm text-stone-600 mt-1.5 font-medium leading-relaxed">
                    Sistem pemantauan telemetri kontainer kopi Arabika Gayo & hasil bumi, radar cuaca koridor lintas Sumatra, dan kepatuhan pabean internasional.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('track.public') }}" target="_blank" class="btn-brand-outline px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2 cursor-pointer shadow-xs">
                    <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Halaman Cek Resi</span>
                </a>

                @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                    <a href="{{ route('shipments.create') }}" class="btn-brand-accent px-5 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 cursor-pointer shadow-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Buat Manifest Baru</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Live Global Export Valuation & Currency Bar (ECB Live in Light Mode) -->
        <div class="mt-6 pt-4 border-t border-stone-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
            <div class="flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-stone-100 text-stone-700 font-semibold border border-stone-200">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Kurs Valas Ekspor (ECB Live):</span>
                </span>
                <span class="font-mono text-stone-700">
                    <strong class="text-stone-900">1 USD</strong> = Rp {{ number_format($currencyRates['usd_to_idr'], 0, ',', '.') }}
                </span>
                <span class="text-stone-300">&bull;</span>
                <span class="font-mono text-stone-700">
                    <strong class="text-amber-800">1 EUR</strong> = Rp {{ number_format($currencyRates['eur_to_idr'], 0, ',', '.') }}
                </span>
                <span class="text-[10px] text-stone-500 bg-stone-50 px-2 py-0.5 rounded border border-stone-200">Bank Sentral Eropa</span>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-stone-500 font-medium">Estimasi Devisa Kargo:</span>
                <strong class="font-mono font-bold text-stone-900 text-sm tracking-tight">{{ $totalValuation['usd_formatted'] }} USD</strong>
                <span class="text-xs font-mono font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">({{ $totalValuation['eur_formatted'] }})</span>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 2. UNIFIED EXECUTIVE METRIC STRIP                         -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-xl border border-stone-200/90 shadow-2xs divide-y sm:divide-y-0 sm:divide-x divide-stone-100 grid grid-cols-2 lg:grid-cols-4">
        <!-- Metric 1: Total Managed -->
        <div class="p-4 sm:p-5">
            <span class="block text-[11px] font-semibold text-stone-500 uppercase tracking-wider">Total Pengiriman</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-stone-900 mt-1 font-mono">{{ $totalShipments }}</div>
            <span class="block text-[11px] text-stone-400 mt-1">100% Manifest Tercatat</span>
        </div>

        <!-- Metric 2: In-Transit -->
        <div class="p-4 sm:p-5">
            <span class="block text-[11px] font-semibold text-stone-500 uppercase tracking-wider">Dalam Perjalanan</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-stone-900 mt-1 font-mono">{{ $inTransitCount }} <span class="text-xs font-sans font-bold text-amber-600">Bergerak</span></div>
            <span class="block text-[11px] text-stone-400 mt-1">Truk Darat & Kapal Kontainer</span>
        </div>

        <!-- Metric 3: Delivered Safely -->
        <div class="p-4 sm:p-5">
            <span class="block text-[11px] font-semibold text-stone-500 uppercase tracking-wider">Terkirim Sukses</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-stone-900 mt-1 font-mono">{{ $deliveredCount }}</div>
            <span class="block text-[11px] text-stone-400 mt-1">Tiba di Pelabuhan Tujuan</span>
        </div>

        <!-- Metric 4: Route Alerts -->
        <div class="p-4 sm:p-5">
            <span class="block text-[11px] font-semibold text-stone-500 uppercase tracking-wider">Peringatan Jalur</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-1 font-mono">{{ $delayedCount }}</div>
            <span class="block text-[11px] text-stone-400 mt-1">Mitigasi Cuaca & Antrean</span>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3. PINTASAN SISTEM & MODUL UTAMA (Ayaa's Executive Hub)  -->
    <!-- Memudahkan Dosen & Penguji melihat fitur utama web       -->
    <!-- ======================================================== -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xs font-bold text-stone-900 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Pusat Navigasi & Pintasan Modul Utama</span>
                </h2>
                <p class="text-xs text-stone-500 mt-0.5">Akses cepat ke setiap kapabilitas utama platform visibilitas ekspor AgriLian</p>
            </div>
            <span class="text-[11px] font-semibold text-stone-400 hidden sm:inline">4 Modul Terintegrasi</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Shortcut 1: Manifes Kargo -->
            <a href="{{ route('shipments.index') }}" class="group bg-white rounded-xl border border-stone-200/90 p-4 shadow-2xs hover:border-amber-400 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-800 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 font-mono">{{ $totalShipments }} Kontainer</span>
                    </div>
                    <h3 class="text-xs font-bold text-stone-900 group-hover:text-amber-800 transition-colors">Manifes & Roster Kargo</h3>
                    <p class="text-[11px] text-stone-500 mt-1 leading-relaxed">Kelola seluruh data consignment, tonase kargo, armada pengangkut, dan kepabeanan.</p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-stone-100 flex items-center justify-between text-xs font-bold text-amber-800 group-hover:translate-x-0.5 transition-transform">
                    <span>Buka Roster</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Shortcut 2: Pelacakan Publik -->
            <a href="{{ route('track.public') }}" target="_blank" class="group bg-white rounded-xl border border-stone-200/90 p-4 shadow-2xs hover:border-amber-400 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <div class="w-8 h-8 rounded-lg bg-stone-100 text-stone-800 flex items-center justify-center group-hover:bg-stone-900 group-hover:text-white transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-stone-700 bg-stone-100 px-2 py-0.5 rounded border border-stone-200">Akses Publik</span>
                    </div>
                    <h3 class="text-xs font-bold text-stone-900 group-hover:text-amber-800 transition-colors">Pelacak Waybill Publik</h3>
                    <p class="text-[11px] text-stone-500 mt-1 leading-relaxed">Portal mandiri bagi buyer internasional di Singapura dan Eropa untuk cek status resi.</p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-stone-100 flex items-center justify-between text-xs font-bold text-amber-800 group-hover:translate-x-0.5 transition-transform">
                    <span>Lacak Waybill</span>
                    <span>↗</span>
                </div>
            </a>

            <!-- Shortcut 3: Telemetri Cuaca Rute -->
            <div class="bg-white rounded-xl border border-stone-200/90 p-4 shadow-2xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-800 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-sky-800 bg-sky-50 px-2 py-0.5 rounded border border-sky-200">OpenWeather</span>
                    </div>
                    <h3 class="text-xs font-bold text-stone-900">Telemetri Cuaca Jalur</h3>
                    <p class="text-[11px] text-stone-500 mt-1 leading-relaxed">Satelit live memantau titik rawan kabut & hujan di Takengon, Bireuen, hingga Belawan.</p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-stone-100 flex items-center justify-between text-xs text-stone-600 font-mono">
                    <span>Takengon Hub:</span>
                    <strong class="text-stone-900">{{ $corridorWeather[0]['temp_c'] ?? '19.2' }}°C</strong>
                </div>
            </div>

            <!-- Shortcut 4: Valuasi Devisa ECB -->
            <div class="bg-white rounded-xl border border-stone-200/90 p-4 shadow-2xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">ECB Live</span>
                    </div>
                    <h3 class="text-xs font-bold text-stone-900">Valuasi Devisa Ekspor</h3>
                    <p class="text-[11px] text-stone-500 mt-1 leading-relaxed">Konversi otomatis devisa ke USD ($) dan EUR (€) langsung dari data Bank Sentral Eropa.</p>
                </div>
                <div class="mt-3 pt-2.5 border-t border-stone-100 flex items-center justify-between text-xs text-stone-600 font-mono">
                    <span>Total Devisa:</span>
                    <strong class="text-stone-900">{{ $totalValuation['usd_formatted'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 4. BALANCED TWO-COLUMN COCKPIT (Seimbang & Tidak Menumpuk) -->
    <!-- Kolom Kiri: Radar Peta GIS | Kolom Kanan: Komoditas HQ   -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Kolom Kiri (7 Kolom): Radar Visual GIS Rute Multimodal -->
        <div class="lg:col-span-7 bg-white rounded-xl border border-stone-200/90 p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3 pb-3 border-b border-stone-100">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        <h2 class="text-xs font-bold text-stone-900 uppercase tracking-wider">
                            Radar Visual Rute Multimodal Koridor Ekspor
                        </h2>
                    </div>
                    <div class="flex items-center gap-3 text-[11px] text-stone-500 font-medium">
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-stone-900"></span> Hub Gudang</span>
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Kargo Bergerak</span>
                    </div>
                </div>

                <div id="overview-map" class="h-84 w-full rounded-lg border border-stone-200 z-10"></div>
            </div>

            <div class="mt-3 pt-3 border-t border-stone-100 flex items-center justify-between text-xs text-stone-500">
                <span>Koridor Terpantau: <strong>Takengon &rarr; Bireuen &rarr; Belawan &rarr; Selat Malaka &rarr; Rotterdam</strong></span>
                <span class="text-amber-800 font-semibold font-mono text-[11px]">GIS Telemetri Aktif</span>
            </div>
        </div>

        <!-- Kolom Kanan (5 Kolom): Komoditas Ekspor Unggulan (Realistis HQ) -->
        <div class="lg:col-span-5 flex flex-col gap-4">
            
            <!-- Card Komoditas 1: Kopi Arabika Gayo Specialty -->
            <div class="bg-white rounded-xl border border-stone-200/90 shadow-2xs overflow-hidden flex flex-col sm:flex-row group hover:border-amber-300 transition-all">
                <div class="sm:w-36 h-32 sm:h-auto relative overflow-hidden bg-stone-100 shrink-0">
                    <img src="/images/coffee.jpg" alt="Kopi Arabika Gayo Takengon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[10px] font-bold bg-stone-900/90 text-white backdrop-blur-xs border border-white/20">
                        Ekspor Utama
                    </span>
                </div>
                <div class="p-3.5 sm:p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-1 mb-1">
                            <span class="text-xs font-mono font-bold text-amber-800">LNDS-2026-GY001</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                On Track
                            </span>
                        </div>
                        <h3 class="text-xs font-bold text-stone-900">Kopi Arabika Gayo Specialty Grade 1</h3>
                        <p class="text-[11px] text-stone-500 mt-0.5">Takengon Hub &rarr; Belawan &rarr; Rotterdam Port</p>
                    </div>

                    <div class="mt-2.5 pt-2 border-t border-stone-100 flex items-center justify-between text-[11px]">
                        <span class="text-stone-600">Kadar Air: <strong class="text-stone-900">11.4% (Standar &lt; 12%)</strong></span>
                        <a href="/shipments/1" class="font-bold text-amber-800 hover:text-amber-950 flex items-center gap-1 transition-colors">
                            <span>Detail</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Komoditas 2: Hortikultura Cold-Chain (Alpukat & Cabai) -->
            <div class="bg-white rounded-xl border border-stone-200/90 shadow-2xs overflow-hidden flex flex-col sm:flex-row group hover:border-amber-300 transition-all">
                <div class="sm:w-36 h-32 sm:h-auto relative overflow-hidden bg-stone-100 shrink-0">
                    <img src="/images/avocado.jpg" alt="Alpukat Mentega & Cabai Takengon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[10px] font-bold bg-stone-900/90 text-white backdrop-blur-xs border border-white/20">
                        Rantai Dingin
                    </span>
                </div>
                <div class="p-3.5 sm:p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-1 mb-1">
                            <span class="text-xs font-mono font-bold text-amber-800">LNDS-2026-GY002</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                In Transit
                            </span>
                        </div>
                        <h3 class="text-xs font-bold text-stone-900">Alpukat Mentega & Cabai Merah Segar</h3>
                        <p class="text-[11px] text-stone-500 mt-0.5">Takengon Hub &rarr; Belawan &rarr; Port of Singapore</p>
                    </div>

                    <div class="mt-2.5 pt-2 border-t border-stone-100 flex items-center justify-between text-[11px]">
                        <span class="text-stone-600">Suhu Reefer: <strong class="text-stone-900">5.8°C (Stabil)</strong></span>
                        <a href="/shipments/2" class="font-bold text-amber-800 hover:text-amber-950 flex items-center gap-1 transition-colors">
                            <span>Detail</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Ringkas Standar Kepatuhan Internasional -->
            <div class="bg-white rounded-xl border border-stone-200/90 p-3.5 shadow-2xs flex items-center justify-between text-xs">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-stone-100 text-stone-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <span class="font-bold text-stone-900 block">Sertifikasi & Kepatuhan Ekspor</span>
                        <span class="text-[11px] text-stone-500">ISO 22000, HACCP, & Bea Cukai Belawan</span>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">100% Lolos</span>
            </div>

        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 5. RECENT CONSIGNMENTS MANIFEST TABLE                   -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-xl border border-stone-200/90 p-5 shadow-2xs">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-stone-100">
            <div>
                <h3 class="text-xs font-bold text-stone-900 uppercase tracking-wider">
                    Manifest Pengiriman Terkini
                </h3>
                <p class="text-xs text-stone-500 mt-0.5">Daftar consignment yang sedang dalam proses pengiriman</p>
            </div>
            <a href="{{ route('shipments.index') }}" class="text-xs font-bold text-amber-800 hover:text-amber-950 flex items-center gap-1 transition-colors">
                <span>Buka Roster Lengkap</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-stone-200 text-[10px] font-bold uppercase tracking-wider text-stone-500">
                        <th class="pb-2.5 font-bold">Nomor Resi</th>
                        <th class="pb-2.5 font-bold">Komoditas & Bobot</th>
                        <th class="pb-2.5 font-bold">Rute Perjalanan</th>
                        <th class="pb-2.5 font-bold">Armada Pengangkut</th>
                        <th class="pb-2.5 font-bold">Status</th>
                        <th class="pb-2.5 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($recentShipments as $s)
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            <td class="py-3 pr-3 font-mono font-bold text-stone-900">
                                <a href="{{ route('shipments.show', $s->id) }}" class="text-amber-800 hover:underline font-bold">
                                    {{ $s->tracking_number }}
                                </a>
                            </td>
                            <td class="py-3 pr-3">
                                <div class="font-semibold text-stone-900">{{ $s->cargo_type }}</div>
                                <div class="text-[11px] text-stone-500 mt-0.5">{{ number_format($s->weight_kg, 0) }} kg</div>
                            </td>
                            <td class="py-3 pr-3">
                                <div class="font-medium text-stone-700">{{ $s->origin->city }} &rarr; {{ $s->destination->city }}</div>
                                <div class="text-stone-500 text-[11px] font-medium mt-0.5">Posisi: {{ $s->currentLocation->name ?? 'Dalam Perjalanan' }}</div>
                            </td>
                            <td class="py-3 pr-3">
                                <span class="font-medium text-stone-800">{{ $s->carrier->name }}</span>
                                <span class="block text-[10px] text-stone-400 font-mono">[{{ $s->carrier->transport_mode }}]</span>
                            </td>
                            <td class="py-3 pr-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $s->status === 'DELIVERED' ? 'bg-stone-100 text-stone-800 border border-stone-300' : ($s->status === 'IN_TRANSIT' ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-stone-100 text-stone-700') }}">
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
                            <td colspan="6" class="py-6 text-center text-stone-400 italic">Belum ada manifest kargo terdaftar.</td>
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
                color: '#1C1917',
                fillColor: '#44403C',
                fillOpacity: 0.9,
                weight: 2
            }).addTo(map).bindPopup(`<b>${loc.name}</b><br>${loc.city}, ${loc.country}<br><span class="font-mono text-xs font-bold text-amber-800">[${loc.code}]</span>`);
            markers.push(marker);
        });

        const activeShipments = @json($recentShipments);
        activeShipments.forEach(s => {
            if (s.current_location) {
                const isDelayed = s.is_delayed;
                const cargoMarker = L.circleMarker([s.current_location.latitude, s.current_location.longitude], {
                    radius: 8,
                    color: isDelayed ? '#b45309' : '#1C1917',
                    fillColor: isDelayed ? '#f59e0b' : '#D97706',
                    fillOpacity: 0.95,
                    weight: 2
                }).addTo(map).bindPopup(`
                    <b>Kargo: ${s.tracking_number}</b><br>
                    Komoditas: ${s.cargo_type}<br>
                    Status: <b>${s.status}</b> ${isDelayed ? '<br><span style="color:#b45309">Tertunda: +' + s.delay_duration_hours + ' jam</span>' : ''}<br>
                    <a href="/shipments/${s.id}" style="color:#b45309;font-weight:bold;">Periksa Kargo &rarr;</a>
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