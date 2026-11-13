@extends('layouts.app')

@section('title', 'Dashboard Operasional Ekspor Highland')

@section('content')
<div class="space-y-6">

    <!-- ======================================================== -->
    <!-- 1. AUTOMARK-STYLE HIGHLAND HERO COMMAND BANNER           -->
    <!-- ======================================================== -->
    <div class="relative rounded-2xl bg-hero-gradient p-6 sm:p-10 text-white overflow-hidden shadow-2xl border border-slate-700/80">
        <!-- Ambient Glowing Aura Orbs (Subtle Emerald & Cyan Tech Glow) -->
        <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-80 h-80 rounded-full bg-cyan-500/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <!-- Pill Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-slate-200 border border-white/15 mb-3 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Takengon Highland Central Hub &bull; Koridor Belawan &bull; Rotterdam Direct</span>
                </div>

                <!-- Headline with Gradient Accent -->
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight leading-tight text-white">
                    Dashboard Logistik Ekspor Highland <br class="hidden sm:inline" />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-400">
                        Visibilitas Multimodal Rantai Pasok Gayo
                    </span>
                </h1>

                <p class="text-xs sm:text-sm text-slate-300 mt-2.5 max-w-xl font-normal leading-relaxed">
                    Pusat kendali operasional telemetri kontainer kopi Arabika Gayo & hasil bumi, kalkulasi peringatan cuaca otomatis, serta kepatuhan pabean internasional.
                </p>
            </div>

            <!-- Action Buttons (Automark Glowing Pill Style - NO DUPLICATE +) -->
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('track.public') }}" target="_blank" class="btn-glass-secondary px-4 py-2.5 rounded-full text-xs font-semibold flex items-center gap-2 cursor-pointer shadow-sm">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Halaman Cek Resi</span>
                </a>

                @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                    <a href="{{ route('shipments.create') }}" class="btn-brand-accent px-5 py-2.5 rounded-full text-xs font-bold flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4 text-[#052014]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Buat Manifest Baru</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Live Global Export Valuation & Currency Bar (ECB Frankfurter API Live) -->
        <div class="mt-6 pt-5 border-t border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
            <div class="flex flex-wrap items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 text-[#D8F3DC] font-semibold border border-white/15 backdrop-blur-xs">
                    <span class="w-2 h-2 rounded-full bg-[#57C84D] animate-pulse"></span>
                    <span>Kurs Valas Ekspor (ECB Live):</span>
                </span>
                <span class="font-mono text-slate-200">
                    <strong class="text-white">1 USD</strong> = Rp {{ number_format($currencyRates['usd_to_idr'], 0, ',', '.') }}
                </span>
                <span class="text-white/40">&bull;</span>
                <span class="font-mono text-slate-200">
                    <strong class="text-[#FBBF24]">1 EUR</strong> = Rp {{ number_format($currencyRates['eur_to_idr'], 0, ',', '.') }}
                </span>
                <span class="text-[10px] text-[#95D5B2] bg-emerald-950/60 px-2 py-0.5 rounded border border-[#95D5B2]/30">Live Bank Sentral</span>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-slate-200 font-medium">Estimasi Devisa Kargo:</span>
                <span class="font-mono font-black text-white text-sm tracking-tight drop-shadow-sm">{{ $totalValuation['usd_formatted'] }} USD</span>
                <span class="text-xs font-mono font-bold text-[#FBBF24] bg-amber-950/40 px-2.5 py-0.5 rounded-lg border border-amber-400/30 shadow-2xs">({{ $totalValuation['eur_formatted'] }})</span>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 2. UNIFIED EXECUTIVE METRIC STRIP                         -->
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
            <div class="text-2xl sm:text-3xl font-extrabold text-[#1B4332] mt-1 font-mono">{{ $inTransitCount }} <span class="text-xs font-sans font-bold text-emerald-600">Bergerak</span></div>
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
    <!-- 3. CRYPTO-STYLE 3-COLUMN INTELLIGENCE STRIP               -->
    <!-- Reference: Ayaa's Attachment 3 (Trending/Gainers/Recent)  -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <!-- Column 1: Kargo Prioritas (Active Consignments) -->
        <div class="bg-white rounded-xl border border-slate-200/90 p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Kargo Prioritas</h3>
                    </div>
                    <a href="{{ route('shipments.index') }}" class="text-xs font-bold text-emerald-800 hover:text-emerald-950 flex items-center gap-0.5">
                        <span>Semua</span>
                        <span>&gt;</span>
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($recentShipments->take(3) as $s)
                        <div class="py-2.5 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <a href="{{ route('shipments.show', $s->id) }}" class="text-xs font-mono font-bold text-slate-900 hover:text-emerald-800 block truncate">
                                    {{ $s->tracking_number }}
                                </a>
                                <span class="text-[11px] text-slate-500 block truncate">
                                    {{ $s->origin->city }} &rarr; {{ $s->destination->city }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                @if($s->is_delayed)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        Tertunda
                                    </span>
                                    <!-- Sparkline Dip -->
                                    <svg class="w-10 h-4 text-amber-500" viewBox="0 0 40 16" fill="none" stroke="currentColor">
                                        <path d="M0 6 L12 6 L20 12 L30 14 L40 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        + On Time
                                    </span>
                                    <!-- Sparkline Rise -->
                                    <svg class="w-10 h-4 text-[#57C84D]" viewBox="0 0 40 16" fill="none" stroke="currentColor">
                                        <path d="M0 12 L12 10 L22 4 L32 6 L40 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center text-xs text-slate-400 italic">Belum ada pengiriman aktif.</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                <span>Rantai Ekspor:</span>
                <span class="font-semibold text-slate-800">Dataran Tinggi Gayo</span>
            </div>
        </div>

        <!-- Column 2: Cuaca Titik Transit (Route Telemetry) -->
        <div class="bg-white rounded-xl border border-slate-200/90 p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                        </div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Cuaca Titik Transit</h3>
                    </div>
                    <span class="text-xs font-bold text-slate-400">Satelit &gt;</span>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($corridorWeather as $cw)
                        <div class="py-2.5 flex items-center justify-between gap-3">
                            <div>
                                <div class="text-xs font-bold text-slate-900">{{ $cw['name'] }}</div>
                                <div class="text-[11px] text-slate-500">{{ $cw['subtitle'] }}</div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-xs font-mono font-bold text-slate-900">{{ $cw['temp_c'] }}°C</div>
                                <span class="text-[10px] font-semibold {{ $cw['badge_color'] === 'amber' ? 'text-amber-700 bg-amber-50 border border-amber-200' : 'text-emerald-700 bg-emerald-50 border border-emerald-200' }} px-1.5 py-0.5 rounded">
                                    {{ $cw['condition'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                <span class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>OpenWeather Live Satelit</span>
                </span>
                <span class="font-mono text-[10px] text-slate-400">Key: 2d42...ac6a</span>
            </div>
        </div>

        <!-- Column 3: Integritas Komoditas (Quality & Cold-Chain) -->
        <div class="bg-white rounded-xl border border-slate-200/90 p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Integritas Komoditas</h3>
                    </div>
                    <span class="text-xs font-bold text-slate-400">Standar &gt;</span>
                </div>

                <div class="divide-y divide-slate-100">
                    <div class="py-2.5 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Kadar Air Kopi Gayo</div>
                            <div class="text-[11px] text-slate-500">Toleransi Ekspor: &lt; 12.0%</div>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-xs font-mono font-bold text-slate-900">11.4%</div>
                            <span class="text-[10px] font-bold text-[#1B4332] bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">+ Lolos Uji</span>
                        </div>
                    </div>

                    <div class="py-2.5 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Reefer Cold-Chain</div>
                            <div class="text-[11px] text-slate-500">Target Hortikultura: 4° - 8°C</div>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-xs font-mono font-bold text-slate-900">5.8°C</div>
                            <span class="text-[10px] font-bold text-[#1B4332] bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">+ Dingin Stabil</span>
                        </div>
                    </div>

                    <div class="py-2.5 flex items-center justify-between gap-3">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Segel Bea Cukai & Pabean</div>
                            <div class="text-[11px] text-slate-500">Klirens Pelabuhan Belawan</div>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-xs font-mono font-bold text-slate-900">100%</div>
                            <span class="text-[10px] font-bold text-[#1B4332] bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">Intact / Aman</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                <span>Standar Mutu:</span>
                <span class="font-semibold text-slate-800">ISO 22000 & HACCP</span>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 4. REAL PHOTOGRAPHIC COMMODITY SHOWCASE                 -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        
        <!-- Showcase 1: Gayo Arabica Specialty -->
        <div class="bg-white rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden flex flex-col sm:flex-row group hover:border-slate-300 transition-colors">
            <div class="sm:w-44 h-36 sm:h-auto relative overflow-hidden bg-slate-100 shrink-0">
                <img src="/images/coffee.jpg" alt="Kopi Arabika Gayo Takengon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[10px] font-bold bg-[#1B4332]/90 text-white backdrop-blur-xs border border-white/20">
                    Ekspor Utama
                </span>
            </div>
            <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-mono font-bold text-[#1B4332]">LNDS-2026-GY001</span>
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
                    <a href="/shipments/1" class="text-xs font-bold text-[#1B4332] hover:text-emerald-950 flex items-center gap-1">
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
                <span class="absolute top-2 left-2 px-2 py-0.5 rounded text-[10px] font-bold bg-[#1B4332]/90 text-white backdrop-blur-xs border border-white/20">
                    Rantai Dingin
                </span>
            </div>
            <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs font-mono font-bold text-[#1B4332]">LNDS-2026-GY002</span>
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
                    <a href="/shipments/2" class="text-xs font-bold text-[#1B4332] hover:text-emerald-950 flex items-center gap-1">
                        <span>Detail</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 5. OPERATIONAL COCKPIT: RADAR MAP                         -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-xl border border-slate-200/90 p-5 shadow-2xs flex flex-col">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#57C84D] animate-pulse"></span>
                <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">
                    Radar Visual Rute Multimodal Koridor Ekspor Highland
                </h2>
            </div>
            <div class="flex items-center gap-3 text-[11px] text-slate-500 font-medium">
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#1B4332]"></span> Hub Gudang</span>
                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#57C84D]"></span> Kargo Bergerak</span>
            </div>
        </div>

        <div id="overview-map" class="h-80 w-full rounded-lg border border-slate-200 z-10"></div>
    </div>

    <!-- ======================================================== -->
    <!-- 6. RECENT CONSIGNMENTS MANIFEST TABLE                   -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-xl border border-slate-200/90 p-5 shadow-2xs">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                    Manifest Pengiriman Terkini
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar consignment yang sedang dalam proses pengiriman</p>
            </div>
            <a href="{{ route('shipments.index') }}" class="text-xs font-bold text-[#1B4332] hover:text-emerald-950 flex items-center gap-1 transition-colors">
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
                                <a href="{{ route('shipments.show', $s->id) }}" class="text-[#1B4332] hover:underline font-bold">
                                    {{ $s->tracking_number }}
                                </a>
                            </td>
                            <td class="py-3 pr-3">
                                <div class="font-semibold text-slate-900">{{ $s->cargo_type }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">{{ number_format($s->weight_kg, 0) }} kg</div>
                            </td>
                            <td class="py-3 pr-3">
                                <div class="font-medium text-slate-700">{{ $s->origin->city }} &rarr; {{ $s->destination->city }}</div>
                                <div class="text-[#1B4332] text-[11px] font-medium mt-0.5">Posisi: {{ $s->currentLocation->name ?? 'Dalam Perjalanan' }}</div>
                            </td>
                            <td class="py-3 pr-3">
                                <span class="font-medium text-slate-800">{{ $s->carrier->name }}</span>
                                <span class="block text-[10px] text-slate-400 font-mono">[{{ $s->carrier->transport_mode }}]</span>
                            </td>
                            <td class="py-3 pr-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $s->status === 'DELIVERED' ? 'bg-slate-100 text-slate-800 border border-slate-300' : ($s->status === 'IN_TRANSIT' ? 'bg-emerald-50 text-[#1B4332] border border-emerald-200' : 'bg-slate-100 text-slate-700') }}">
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
            }).addTo(map).bindPopup(`<b>${loc.name}</b><br>${loc.city}, ${loc.country}<br><span class="font-mono text-xs font-bold text-[#1B4332]">[${loc.code}]</span>`);
            markers.push(marker);
        });

        const activeShipments = @json($recentShipments);
        activeShipments.forEach(s => {
            if (s.current_location) {
                const isDelayed = s.is_delayed;
                const cargoMarker = L.circleMarker([s.current_location.latitude, s.current_location.longitude], {
                    radius: 8,
                    color: isDelayed ? '#b45309' : '#1B4332',
                    fillColor: isDelayed ? '#f59e0b' : '#57C84D',
                    fillOpacity: 0.95,
                    weight: 2
                }).addTo(map).bindPopup(`
                    <b>Kargo: ${s.tracking_number}</b><br>
                    Komoditas: ${s.cargo_type}<br>
                    Status: <b>${s.status}</b> ${isDelayed ? '<br><span style="color:#b45309">Tertunda: +' + s.delay_duration_hours + ' jam</span>' : ''}<br>
                    <a href="/shipments/${s.id}" style="color:#1B4332;font-weight:bold;">Periksa Kargo &rarr;</a>
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
