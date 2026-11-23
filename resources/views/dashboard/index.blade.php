@extends('layouts.app')

@php
    $isEn = app()->getLocale() === 'en';
@endphp

@section('title', $isEn ? 'Highland Export Operational Dashboard' : 'Dashboard Operasional Ekspor Highland')

@section('content')
<div class="space-y-6">

    <!-- ======================================================== -->
    <!-- 1. EXECUTIVE COMMAND BANNER (High-Precision Enterprise)   -->
    <!-- ======================================================== -->
    <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-forest-800/60 bg-[#051F20] text-white">
        <!-- Background Image with Ambient Multimodal Port & Twilight Overlay -->
        <div class="absolute inset-0 bg-cover bg-center opacity-45 scale-105 transition-transform duration-1000" style="background-image: url('{{ asset('images/dashboard-hero.jpg') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#051F20] via-[#051F20]/90 to-[#0B2B26]/75"></div>
        
        <!-- Content Container -->
        <div class="relative p-6 sm:p-8 z-10">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="max-w-2xl">
                    <!-- Status Badge -->
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-forest-500/30 text-forest-200 border border-forest-400/30 backdrop-blur-md mb-3 shadow-sm font-mono">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>{{ $isEn ? 'Takengon Hub (Gayo) • Belawan Ocean Port • Rotterdam Direct' : 'Takengon Hub (Gayo) • Belawan Ocean Port • Rotterdam Langsung' }}</span>
                    </div>

                    <!-- Headline -->
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white leading-tight">
                        {{ $isEn ? 'Highland Agro-Export Visibility Cockpit' : 'Cockpit Visibilitas Logistik Ekspor Highland' }}
                    </h1>
                    <p class="text-xs sm:text-sm text-forest-100/80 mt-2 font-medium leading-relaxed max-w-xl">
                        {{ $isEn ? 'Telemetry tracking system for Gayo Arabica coffee & fresh horticulture containers, cross-Sumatra mountain corridor weather radar, and international customs compliance.' : 'Sistem pemantauan telemetri kontainer kopi Arabika Gayo & hortikultura segar, radar cuaca koridor pegunungan lintas Sumatra, dan kepatuhan pabean internasional.' }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <a href="{{ route('track.public') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md transition-all flex items-center justify-center gap-2 shadow-sm cursor-pointer">
                        <svg class="w-4 h-4 text-forest-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>{{ $isEn ? 'Track Waybill' : 'Cek Resi' }}</span>
                    </a>

                    @if(auth()->user()->isOperator())
                        <a href="{{ route('shipments.create') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-emerald-400 hover:bg-emerald-300 text-forest-950 transition-all flex items-center justify-center gap-2 shadow-lg shadow-emerald-950/40 cursor-pointer">
                            <svg class="w-4 h-4 text-forest-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            <span>{{ $isEn ? 'Create New Shipment' : 'Buat Pengiriman Baru' }}</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Live Global Export Valuation & Currency Bar (ECB Live) -->
            <div class="mt-6 pt-5 border-t border-white/15 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-forest-200/90 font-medium">
                <div class="flex flex-wrap items-center gap-3 font-mono">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 text-white border border-white/15 backdrop-blur-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>{{ $isEn ? 'Live Export FX Rates (ECB Live):' : 'Kurs Valas Ekspor (ECB Live):' }}</span>
                    </span>
                    <span><strong class="text-white">1 USD</strong> = Rp {{ number_format($currencyRates['usd_to_idr'], 0, ',', '.') }}</span>
                    <span class="text-forest-400">&bull;</span>
                    <span><strong class="text-forest-200">1 EUR</strong> = Rp {{ number_format($currencyRates['eur_to_idr'], 0, ',', '.') }}</span>
                    <span class="text-[10px] text-forest-200/70 bg-white/5 px-2 py-0.5 rounded border border-white/10 font-mono">{{ $isEn ? 'European Central Bank' : 'Bank Sentral Eropa' }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-forest-200/80">{{ $isEn ? 'Estimated Cargo Valuation:' : 'Estimasi Devisa Kargo:' }}</span>
                    <strong class="font-mono font-bold text-white text-sm tracking-tight">{{ $totalValuation['usd_formatted'] }} USD</strong>
                    <span class="text-xs font-mono font-bold text-emerald-300 bg-emerald-950/80 px-2 py-0.5 rounded-md border border-emerald-500/40">({{ $totalValuation['eur_formatted'] }})</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 2. UNIFIED EXECUTIVE METRIC STRIP                         -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-[0_1px_3px_rgba(0,0,0,0.03)] divide-y sm:divide-y-0 sm:divide-x divide-slate-100 grid grid-cols-2 lg:grid-cols-4 overflow-hidden">
        <!-- Metric 1: Total Managed -->
        <div class="p-5 relative">
            <div class="w-1.5 h-full bg-forest-600 absolute left-0 top-0"></div>
            <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider font-mono">{{ $isEn ? 'Total Shipments' : 'Total Pengiriman' }}</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 font-mono">{{ $totalShipments }}</div>
            <span class="block text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-forest-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ $isEn ? '100% Verified Shipments' : '100% Pengiriman Terverifikasi' }}
            </span>
        </div>

        <!-- Metric 2: In-Transit -->
        <div class="p-5 relative">
            <div class="w-1.5 h-full bg-indigo-600 absolute left-0 top-0"></div>
            <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider font-mono">{{ $isEn ? 'In Transit' : 'Dalam Perjalanan' }}</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 font-mono">{{ $inTransitCount }} <span class="text-xs font-sans font-bold text-indigo-600">{{ $isEn ? 'Moving' : 'Bergerak' }}</span></div>
            <span class="block text-[11px] text-slate-500 mt-1">{{ $isEn ? 'Truck Fleet & Ocean Vessels' : 'Armada Truk & Kapal Kontainer' }}</span>
        </div>

        <!-- Metric 3: Delivered Safely -->
        <div class="p-5 relative">
            <div class="w-1.5 h-full bg-emerald-600 absolute left-0 top-0"></div>
            <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider font-mono">{{ $isEn ? 'Delivered Safely' : 'Terkirim Sukses' }}</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1 font-mono">{{ $deliveredCount }}</div>
            <span class="block text-[11px] text-slate-500 mt-1">{{ $isEn ? 'Arrived at Destination Port' : 'Tiba di Pelabuhan Tujuan' }}</span>
        </div>

        <!-- Metric 4: Route Alerts -->
        <div class="p-5 relative">
            <div class="w-1.5 h-full bg-amber-500 absolute left-0 top-0"></div>
            <span class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider font-mono">{{ $isEn ? 'Route Alerts' : 'Peringatan Jalur' }}</span>
            <div class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-1 font-mono">{{ $delayedCount }}</div>
            <span class="block text-[11px] text-slate-500 mt-1">{{ $isEn ? 'Weather Mitigation & Port Queue' : 'Mitigasi Cuaca & Antrean Pelabuhan' }}</span>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- VISUAL DATA ANALYTICS & CHARTS (Chart.js Role-Adaptive)  -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart 1: Status Distribution Doughnut Chart -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-[0_1px_3px_rgba(0,0,0,0.03)] p-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span>{{ auth()->user()->isCustomer() ? ($isEn ? 'My Cargo Consignment Status' : 'Status Pengiriman Kargo Saya') : ($isEn ? 'Global Cargo Status Distribution' : 'Distribusi Status Kargo Global') }}</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $isEn ? 'Cargo composition across operational logistic stages' : 'Komposisi kargo berdasarkan tahapan operasional logistik' }}</p>
                </div>
                <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-forest-50 text-forest-800 border border-forest-200 font-bold">Chart.js Live</span>
            </div>
            <div class="mt-4 flex items-center justify-center relative" style="height: 220px;">
                <canvas id="statusDoughnutChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Export Volume Bar Chart -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-[0_1px_3px_rgba(0,0,0,0.03)] p-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-forest-600"></span>
                        <span>{{ $barTitle }}</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ auth()->user()->isCustomer() ? ($isEn ? 'Coffee tonnage comparison per active waybill' : 'Perbandingan tonase kopi per resi aktif') : ($isEn ? 'Total commodity tonnage moving per transport mode' : 'Total tonase komoditas yang bergerak per moda pengangkutan') }}</p>
                </div>
                <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-forest-50 text-forest-800 border border-forest-200 font-bold">Metric Tonnage</span>
            </div>
            <div class="mt-4 flex items-center justify-center relative" style="height: 220px;">
                <canvas id="volumeBarChart"></canvas>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3. PINTASAN SISTEM & MODUL UTAMA (Executive Nav)          -->
    <!-- ======================================================== -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 font-mono">
                    <span class="w-2 h-2 rounded-full bg-forest-600"></span>
                    <span>{{ $isEn ? 'Navigation Center & Primary Shortcuts' : 'Pusat Navigasi & Pintasan Modul Utama' }}</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">{{ $isEn ? 'Rapid access to each core capability of the AgriLian export visibility platform' : 'Akses cepat ke setiap kapabilitas utama platform visibilitas ekspor AgriLian' }}</p>
            </div>
            <span class="text-[11px] font-semibold text-slate-400 hidden sm:inline font-mono">{{ $isEn ? '4 Integrated Modules' : '4 Modul Terintegrasi' }}</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Shortcut 1: Manifes Kargo -->
            <a href="{{ route('shipments.index') }}" class="group bg-white rounded-2xl border border-slate-200/90 p-5 shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:border-forest-500 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl bg-forest-50 text-forest-700 flex items-center justify-center group-hover:bg-forest-600 group-hover:text-white transition-colors">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-forest-800 bg-forest-50 px-2.5 py-0.5 rounded-full border border-forest-200 font-mono">{{ $totalShipments }} {{ $isEn ? 'Containers' : 'Kontainer' }}</span>
                    </div>
                    <h3 class="text-xs font-bold text-slate-900 group-hover:text-forest-700 transition-colors">{{ $isEn ? 'Shipment List & Records' : 'Daftar Pengiriman Kargo' }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $isEn ? 'Manage consignments, cargo tonnage, transport fleet, and customs clearance.' : 'Kelola seluruh data pengiriman kargo, tonase muatan, armada pengangkut, dan kepabeanan.' }}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-forest-700 group-hover:translate-x-0.5 transition-transform">
                    <span>{{ $isEn ? 'View Shipments' : 'Lihat Pengiriman' }}</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Shortcut 2: Pelacakan Waybill -->
            <a href="{{ route('track.public') }}" class="group bg-white rounded-2xl border border-slate-200/90 p-5 shadow-[0_1px_3px_rgba(0,0,0,0.03)] hover:border-forest-500 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center group-hover:bg-slate-900 group-hover:text-white transition-colors">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-forest-800 bg-forest-50 px-2.5 py-0.5 rounded-full border border-forest-200 font-mono">{{ $isEn ? 'Waybill Tracker' : 'Pelacak Resi' }}</span>
                    </div>
                    <h3 class="text-xs font-bold text-slate-900 group-hover:text-forest-700 transition-colors">{{ $isEn ? 'Cargo Waybill Tracker' : 'Pelacak Waybill Kargo' }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $isEn ? 'Track container location, live satellite corridor weather, and customs clearance.' : 'Cek posisi kontainer, telemetri cuaca rute satelit, dan status kepabeanan secara langsung.' }}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-forest-700 group-hover:translate-x-0.5 transition-transform">
                    <span>{{ $isEn ? 'Track Waybill' : 'Lacak Resi' }}</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Shortcut 3: Telemetri Cuaca Rute -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-[0_1px_3px_rgba(0,0,0,0.03)] flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl bg-forest-50 text-forest-700 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-forest-800 bg-forest-50 px-2.5 py-0.5 rounded-full border border-forest-200 font-mono">OpenWeather</span>
                    </div>
                    <h3 class="text-xs font-bold text-slate-900">{{ $isEn ? 'Route Weather Telemetry' : 'Telemetri Cuaca Jalur' }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $isEn ? 'Live satellite monitoring fog & precipitation risks across Takengon, Bireuen, to Belawan.' : 'Satelit live memantau titik rawan kabut & hujan di Takengon, Bireuen, hingga Belawan.' }}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-mono">
                    <span>Takengon Hub:</span>
                    <strong class="text-slate-900">{{ $corridorWeather[0]['temp_c'] ?? '19.2' }}°C</strong>
                </div>
            </div>

            <!-- Shortcut 4: Valuasi Devisa ECB -->
            <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-[0_1px_3px_rgba(0,0,0,0.03)] flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl bg-forest-50 text-forest-700 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-forest-800 bg-forest-50 px-2.5 py-0.5 rounded-full border border-forest-200 font-mono">ECB Live</span>
                    </div>
                    <h3 class="text-xs font-bold text-slate-900">{{ $isEn ? 'Export Foreign Valuation' : 'Valuasi Devisa Ekspor' }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $isEn ? 'Automated currency conversion to USD ($) and EUR (€) directly from ECB data.' : 'Konversi otomatis devisa ke USD ($) dan EUR (€) langsung dari data Bank Sentral Eropa.' }}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-mono">
                    <span>{{ $isEn ? 'Total Valuation:' : 'Total Devisa:' }}</span>
                    <strong class="text-slate-900">{{ $totalValuation['usd_formatted'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 4. RADAR VISUAL GIS RUTE MULTIMODAL (Full Width)          -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-4 border-b border-slate-100">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-forest-600 animate-pulse"></span>
                    <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider font-mono">
                        {{ $isEn ? 'Multimodal Agro-Export Corridor Visual GIS Radar' : 'Radar Visual Rute Multimodal Koridor Ekspor Agro' }}
                    </h2>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">{{ $isEn ? 'Monitoring cargo waypoints from Highland Gayo Plantations (Takengon), Bireuen Transit, Belawan Ocean Port, Malacca Strait, Singapore, to Rotterdam.' : 'Pemantauan titik henti kargo dari Kebun Dataran Tinggi Gayo (Takengon), Transit Bireuen, Pelabuhan Belawan, Selat Malaka, Singapura, hingga Rotterdam.' }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-600 font-medium">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-slate-900"></span> {{ $isEn ? 'Hub / Seaport' : 'Hub / Pelabuhan' }}</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-forest-600"></span> {{ $isEn ? 'Moving Cargo' : 'Kargo Bergerak' }}</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> {{ $isEn ? 'Weather Alert' : 'Peringatan Cuaca' }}</span>
            </div>
        </div>

        <!-- Container Peta Beresolusi Tinggi dengan CartoDB Voyager Tiles -->
        <div id="overview-map" class="w-full rounded-xl border border-slate-200 shadow-inner z-10" style="height: 480px; min-height: 480px; width: 100%;"></div>

        <div class="mt-4 pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-slate-500">
            <span>{{ $isEn ? 'Monitored Corridor:' : 'Koridor Terpantau:' }} <strong class="text-slate-800 font-mono">Takengon Hub (4.6°N) &rarr; Bireuen (5.2°N) &rarr; Belawan Port (3.7°N) &rarr; Malacca Strait &rarr; Singapore &rarr; Rotterdam</strong></span>
            <span class="text-forest-700 font-semibold font-mono text-[11px] inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                {{ $isEn ? 'GIS GPS Telemetry Active & Calibrated' : 'GIS Telemetri GPS Aktif & Terkalibrasi' }}
            </span>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 5. KOMODITAS EKSPOR UNGGULAN GAYO (Spacious HD Showcase)  -->
    <!-- ======================================================== -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 font-mono">
                    <span class="w-2 h-2 rounded-full bg-forest-600"></span>
                    <span>{{ $isEn ? 'Highland Gayo Primary Export Commodities Showcase' : 'Showcase Komoditas Ekspor Unggulan Dataran Tinggi Gayo' }}</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">{{ $isEn ? 'Quality specifications for export agro commodities under live cold-chain and humidity telemetry monitoring' : 'Spesifikasi mutu komoditas ekspor agro yang sedang dalam pemantauan telemetri rantai dingin & kelembaban' }}</p>
            </div>
            <a href="{{ route('commodities.index') }}" class="btn-brand-accent px-3.5 py-1.5 rounded-xl text-xs flex items-center gap-1.5 shadow-sm hover:shadow transition-all font-mono">
                <span>{{ $isEn ? 'Open Detailed Catalog' : 'Buka Katalog Detail' }}</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Card 1: Kopi Arabika Gayo Specialty -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-[0_1px_3px_rgba(0,0,0,0.03)] overflow-hidden flex flex-col group hover:border-forest-300 transition-all">
                <div class="h-44 relative overflow-hidden bg-slate-100 shrink-0">
                    <img src="/images/coffee.jpg" alt="Kopi Arabika Gayo Takengon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-[#051F20]/90 text-white backdrop-blur-xs border border-white/20 uppercase tracking-wider font-mono">
                        {{ $isEn ? 'Primary Gayo Commodity' : 'Komoditas Utama Gayo' }}
                    </span>
                    <span class="absolute bottom-3 left-3 px-2 py-0.5 rounded text-[10px] font-bold bg-black/60 text-forest-200 backdrop-blur-xs font-mono">
                        {{ $isEn ? '1,400 m ASL Takengon' : '1.400 mdpl Takengon' }}
                    </span>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <span class="text-xs font-mono font-bold text-forest-700">AGLN-2026-GY001</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 font-mono">
                                On Track (Maersk)
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 group-hover:text-forest-700 transition-colors">
                            {{ $isEn ? 'Gayo Arabica Green Coffee Beans' : 'Biji Kopi Mentah Arabika Gayo' }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Takengon Central &rarr; Belawan &rarr; Rotterdam</p>
                        <p class="text-[11px] text-slate-700 mt-2 italic leading-relaxed bg-forest-50/70 p-2 rounded-xl border border-forest-200/60">
                            {{ $isEn ? '"Premium export-grade Gayo Arabica green coffee beans with distinctive highland spice aroma."' : '"Biji kopi mentah Arabika Gayo kualitas ekspor premium dengan aroma rempah khas Takengon."' }}
                        </p>

                        <div class="grid grid-cols-2 gap-2 mt-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 text-xs">
                            <div>
                                <span class="text-[9px] text-slate-400 block uppercase font-medium font-mono">{{ $isEn ? 'Moisture' : 'Kadar Air' }}</span>
                                <strong class="text-slate-800 font-mono text-xs">11.4% (&lt; 12%)</strong>
                            </div>
                            <div>
                                <span class="text-[9px] text-slate-400 block uppercase font-medium font-mono">{{ $isEn ? 'Defect' : 'Nilai Cacat' }}</span>
                                <strong class="text-slate-800 font-mono text-xs">&lt; 3 (Zero Defect)</strong>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-mono">{{ $isEn ? 'Weight:' : 'Bobot:' }} <strong class="text-slate-900">18.500 kg</strong></span>
                        <a href="/shipments/1" class="btn-brand-outline px-3 py-1.5 rounded-lg text-xs font-bold text-forest-700 hover:text-forest-900 flex items-center gap-1 transition-colors">
                            <span>{{ $isEn ? 'Inspect' : 'Periksa' }}</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 2: Hortikultura Cold-Chain (Alpukat & Cabai) -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-[0_1px_3px_rgba(0,0,0,0.03)] overflow-hidden flex flex-col group hover:border-forest-300 transition-all">
                <div class="h-44 relative overflow-hidden bg-slate-100 shrink-0">
                    <img src="/images/avocado.jpg" alt="Alpukat Mentega & Cabai Takengon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-forest-900/90 text-white backdrop-blur-xs border border-white/20 uppercase tracking-wider font-mono">
                        {{ $isEn ? 'Reefer Cold Chain' : 'Rantai Dingin Reefer' }}
                    </span>
                    <span class="absolute bottom-3 left-3 px-2 py-0.5 rounded text-[10px] font-bold bg-black/60 text-emerald-300 backdrop-blur-xs font-mono">
                        Takengon &rarr; Singapore
                    </span>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <span class="text-xs font-mono font-bold text-forest-700">AGLN-2026-GY002</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-forest-50 text-forest-800 border border-forest-200 font-mono">
                                {{ $isEn ? 'In Transit' : 'Dalam Perjalanan' }}
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 group-hover:text-forest-700 transition-colors">
                            {{ $isEn ? 'Fresh Green Butter Avocado Takengon' : 'Alpukat Mentega Hijau Segar Takengon' }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Takengon Central &rarr; Belawan &rarr; {{ $isEn ? 'Singapore' : 'Singapura' }}</p>
                        <p class="text-[11px] text-slate-700 mt-2 italic leading-relaxed bg-forest-50/70 p-2 rounded-xl border border-forest-200/60">
                            {{ $isEn ? '"Highland Gayo grade A butter avocado with rich, creamy, and fiber-free flesh texture."' : '"Alpukat mentega dataran tinggi Gayo kualitas grade A dengan tekstur lembut, tebal, dan bebas serat."' }}
                        </p>

                        <div class="grid grid-cols-2 gap-2 mt-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 text-xs">
                            <div>
                                <span class="text-[9px] text-slate-400 block uppercase font-medium font-mono">{{ $isEn ? 'Reefer Temp' : 'Suhu Reefer' }}</span>
                                <strong class="text-slate-800 font-mono text-xs">5.8°C ({{ $isEn ? 'Stable' : 'Stabil' }})</strong>
                            </div>
                            <div>
                                <span class="text-[9px] text-slate-400 block uppercase font-medium font-mono">{{ $isEn ? 'Humidity' : 'Kelembaban' }}</span>
                                <strong class="text-slate-800 font-mono text-xs">88% ({{ $isEn ? 'Ideal' : 'Ideal' }})</strong>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-mono">{{ $isEn ? 'Weight:' : 'Bobot:' }} <strong class="text-slate-900">4.200 kg</strong></span>
                        <a href="/shipments/2" class="btn-brand-outline px-3 py-1.5 rounded-lg text-xs font-bold text-forest-700 hover:text-forest-900 flex items-center gap-1 transition-colors">
                            <span>{{ $isEn ? 'Inspect' : 'Periksa' }}</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 3: Armada Angkutan Samudera & Logistik Multimodal -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-[0_1px_3px_rgba(0,0,0,0.03)] overflow-hidden flex flex-col group hover:border-forest-300 transition-all">
                <div class="h-44 relative overflow-hidden bg-slate-100 shrink-0">
                    <img src="/images/ship.jpg" alt="Kapal Pengangkut Kontainer Samudera" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-extrabold bg-[#051F20]/90 text-white backdrop-blur-xs border border-white/20 uppercase tracking-wider font-mono">
                        {{ $isEn ? 'Ocean Vessel Fleet' : 'Armada Kapal Samudera' }}
                    </span>
                    <span class="absolute bottom-3 left-3 px-2 py-0.5 rounded text-[10px] font-bold bg-black/60 text-sky-300 backdrop-blur-xs font-mono">
                        Maersk Line &bull; Belawan
                    </span>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-1.5">
                            <span class="text-xs font-mono font-bold text-forest-700">VESSEL-MSK-09</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 font-mono">
                                {{ $isEn ? 'Active Sailing' : 'Pelayaran Aktif' }}
                            </span>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 group-hover:text-forest-700 transition-colors">
                            {{ $isEn ? 'Ocean Container Liner Fleet' : 'Kapal Kontainer Ekspor Samudera' }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $isEn ? 'Port of Belawan → Malacca Strait → Europe' : 'Pelabuhan Belawan → Selat Malaka → Eropa' }}</p>

                        <div class="grid grid-cols-2 gap-2 mt-3 p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 text-xs">
                            <div>
                                <span class="text-[9px] text-slate-400 block uppercase font-medium font-mono">{{ $isEn ? 'TEU Capacity' : 'Kapasitas TEU' }}</span>
                                <strong class="text-slate-800 font-mono text-xs">1.250 TEU</strong>
                            </div>
                            <div>
                                <span class="text-[9px] text-slate-400 block uppercase font-medium font-mono">{{ $isEn ? 'Average Speed' : 'Kecepatan Rata-rata' }}</span>
                                <strong class="text-slate-800 font-mono text-xs">18.4 Knots</strong>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-500 font-mono">AIS GPS: <strong class="text-emerald-700">{{ $isEn ? 'Connected' : 'Terkoneksi' }}</strong></span>
                        <a href="/shipments/1" class="btn-brand-outline px-3 py-1.5 rounded-lg text-xs font-bold text-forest-700 hover:text-forest-900 flex items-center gap-1 transition-colors">
                            <span>{{ $isEn ? 'Radar' : 'Radar' }}</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Strip Sertifikasi & Kepatuhan Ekspor -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-4.5 shadow-[0_1px_3px_rgba(0,0,0,0.03)] flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <span class="font-bold text-slate-900 block">{{ $isEn ? 'Export Quality Standards & International Customs Compliance' : 'Kepatuhan Standar Mutu Ekspor & Kepabeanan Internasional' }}</span>
                    <span class="text-slate-500 text-[11px]">{{ $isEn ? 'Accredited with ISO 22000:2018 (Food Safety), HACCP, Belawan Agricultural Quarantine Phytosanitary, and Customs Clearance.' : 'Terakreditasi ISO 22000:2018 (Food Safety), HACCP, Sertifikat Fitosanitari Karantina Pertanian Belawan, dan Bea Cukai Ekspor.' }}</span>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <span class="text-[10px] font-bold text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 font-mono">100% COMPLIANT</span>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 6. RECENT CONSIGNMENTS MANIFEST TABLE                   -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono">
                    {{ $isEn ? 'Recent Cargo Shipments' : 'Daftar Pengiriman Kargo Terkini' }}
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ $isEn ? 'List of consignments currently in transit' : 'Daftar kargo yang sedang dalam proses perjalanan' }}</p>
            </div>
            <a href="{{ route('shipments.index') }}" class="text-xs font-bold text-forest-700 hover:text-forest-900 flex items-center gap-1 transition-colors">
                <span>{{ $isEn ? 'View All Shipments' : 'Lihat Semua Pengiriman' }}</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-200 text-[10px] font-bold uppercase tracking-wider text-slate-500 font-mono">
                        <th class="pb-3 font-bold">{{ $isEn ? 'Waybill No.' : 'Nomor Resi / Surat Jalan' }}</th>
                        <th class="pb-3 font-bold">{{ $isEn ? 'Commodity & Weight' : 'Komoditas & Bobot' }}</th>
                        <th class="pb-3 font-bold">{{ $isEn ? 'Routing Journey' : 'Rute Perjalanan' }}</th>
                        <th class="pb-3 font-bold">{{ $isEn ? 'Carrier Fleet' : 'Armada Pengangkut' }}</th>
                        <th class="pb-3 font-bold">{{ $isEn ? 'Status' : 'Status' }}</th>
                        <th class="pb-3 font-bold text-right">{{ $isEn ? 'Actions' : 'Aksi' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentShipments as $s)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 pr-3 font-mono font-bold text-slate-900">
                                <a href="{{ route('shipments.show', $s->id) }}" class="text-forest-700 hover:underline font-bold">
                                    {{ $s->tracking_number }}
                                </a>
                            </td>
                            <td class="py-3.5 pr-3">
                                <div class="font-semibold text-slate-900">{{ $s->cargo_type }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5 font-mono">{{ number_format($s->weight_kg, 0) }} kg</div>
                            </td>
                            <td class="py-3.5 pr-3">
                                <div class="font-medium text-slate-700">{{ $s->origin->city }} &rarr; {{ $s->destination->city }}</div>
                                <div class="text-slate-500 text-[11px] font-medium mt-0.5">{{ $isEn ? 'Location:' : 'Posisi:' }} {{ $s->currentLocation->name ?? ($isEn ? 'In Transit' : 'Dalam Perjalanan') }}</div>
                            </td>
                            <td class="py-3.5 pr-3">
                                <span class="font-medium text-slate-800">{{ $s->carrier->name }}</span>
                                <span class="block text-[10px] text-slate-400 font-mono">[{{ $s->carrier->transport_mode }}]</span>
                            </td>
                            <td class="py-3.5 pr-3">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase font-mono {{ $s->status === 'DELIVERED' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : ($s->status === 'IN_TRANSIT' ? 'bg-forest-50 text-forest-800 border border-forest-200' : 'bg-slate-100 text-slate-700 border border-slate-200') }}">
                                    {{ $s->status }}
                                </span>
                                @if($s->is_delayed)
                                    <span class="block text-[10px] text-amber-700 font-medium mt-0.5 font-mono">+{{ $s->delay_duration_hours }}{{ $isEn ? 'h delayed' : 'j tertunda' }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('shipments.show', $s->id) }}" class="btn-brand-outline px-2.5 py-1 rounded-lg text-xs font-semibold inline-block">
                                        {{ $isEn ? 'Details' : 'Detail' }}
                                    </a>
                                    <a href="{{ route('shipments.print', $s->id) }}" target="_blank" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-200 inline-flex items-center gap-1 cursor-pointer" title="{{ $isEn ? 'Print Waybill A4' : 'Cetak Waybill A4' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                        <span>{{ $isEn ? 'Print' : 'Cetak' }}</span>
                                    </a>
                                    @if(auth()->user()->isCustomer())
                                        <button type="button" onclick="openClaimModal({{ $s->id }}, '{{ $s->tracking_number }}')" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 inline-flex items-center gap-1 cursor-pointer" title="{{ $isEn ? 'Report Discrepancy / Return Claim' : 'Lapor Ketidaksesuaian Mutu / Klaim Kerusakan' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            <span>{{ $isEn ? 'Claim' : 'Klaim' }}</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 italic">{{ $isEn ? 'No registered cargo manifests found.' : 'Belum ada manifest kargo terdaftar.' }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom In-App Modal: Lapor Ketidaksesuaian / Klaim Kerusakan (Customer Self-Service) -->
    <div id="claimModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100 font-bold text-base">
                        ⚠️
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900">{{ $isEn ? 'Report Cargo Discrepancy' : 'Lapor Ketidaksesuaian Kargo' }}</h3>
                        <p class="text-xs text-slate-500">{{ $isEn ? 'Waybill Number:' : 'Nomor Resi:' }} <span id="modalTrackingNumber" class="font-mono font-bold text-forest-700"></span></p>
                    </div>
                </div>
                <button type="button" onclick="closeClaimModal()" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer">✕</button>
            </div>

            <form id="claimForm" method="POST" action="" class="mt-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">{{ $isEn ? 'Issue Type / Discrepancy' : 'Jenis Kendala / Ketidaksesuaian' }}</label>
                    <select name="exception_type" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold focus:ring-2 focus:ring-forest-600 bg-slate-50 focus:bg-white">
                        <option value="DAMAGED">{{ $isEn ? 'Physical Cargo Damage (Packaging / Wet / Torn Jute Bags)' : 'Kargo Rusak Fisik (Kemasan / Karung Basah / Rusak)' }}</option>
                        <option value="DOCUMENTATION_ISSUE">{{ $isEn ? 'Coffee Quality Discrepancy / Quarantine Document Issue' : 'Ketidaksesuaian Mutu Kopi / Dokumen Karantina' }}</option>
                        <option value="MISROUTED">{{ $isEn ? 'Misrouted / Container Return Request' : 'Salah Rute / Permohonan Retur Kontainer' }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">{{ $isEn ? 'Urgency Level (Severity)' : 'Tingkat Urgensi (Severity)' }}</label>
                    <select name="severity" required class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold focus:ring-2 focus:ring-forest-600 bg-slate-50 focus:bg-white">
                        <option value="MEDIUM">{{ $isEn ? 'MEDIUM — Field Verification / Quality Inspection Required' : 'MEDIUM — Butuh Verifikasi / Uji Mutu Lapangan' }}</option>
                        <option value="HIGH">{{ $isEn ? 'HIGH — Critical / Halt Consignment Immediately' : 'HIGH — Kritis / Stop Pengiriman Segera' }}</option>
                        <option value="LOW">{{ $isEn ? 'LOW — Minor Evaluation Note' : 'LOW — Catatan Minor Evaluasi' }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">{{ $isEn ? 'Issue Description / Reason for Claim' : 'Rincian Masalah / Alasan Klaim' }}</label>
                    <textarea name="description" rows="3" required placeholder="{{ $isEn ? 'Describe quality discrepancy, moisture variance, or cargo damage found...' : 'Jelaskan ketidaksesuaian mutu, kadar air, atau kerusakan kargo yang ditemukan...' }}"
                              class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-forest-600 bg-slate-50 focus:bg-white"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeClaimModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 cursor-pointer">{{ $isEn ? 'Cancel' : 'Batal' }}</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white shadow-md shadow-rose-900/20 cursor-pointer">{{ $isEn ? 'Submit Claim Report' : 'Kirim Laporan Klaim' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // In-App Claim Modal Script
    function openClaimModal(shipmentId, trackingNumber) {
        const modal = document.getElementById('claimModal');
        const form = document.getElementById('claimForm');
        const num = document.getElementById('modalTrackingNumber');
        if (modal && form && num) {
            num.innerText = trackingNumber;
            form.action = `/shipments/${shipmentId}/exceptions`;
            modal.classList.remove('hidden');
        }
    }
    function closeClaimModal() {
        const modal = document.getElementById('claimModal');
        if (modal) modal.classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // 1. Chart.js: Role-Adaptive Status Doughnut Chart
        const ctxDoughnut = document.getElementById('statusDoughnutChart');
        if (ctxDoughnut) {
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: @json($doughnutLabels),
                    datasets: [{
                        data: @json($doughnutData),
                        backgroundColor: ['#163832', '#235347', '#8EB69B', '#051F20'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { family: 'Plus Jakarta Sans', size: 11, weight: 'bold' },
                                padding: 12,
                                boxWidth: 12
                            }
                        }
                    },
                    cutout: '68%'
                }
            });
        }

        // 2. Chart.js: Role-Adaptive Volume Bar Chart
        const ctxBar = document.getElementById('volumeBarChart');
        if (ctxBar) {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: @json($barLabels),
                    datasets: [{
                        label: 'Volume (kg)',
                        data: @json($barData),
                        backgroundColor: '#163832',
                        borderRadius: 8,
                        maxBarThickness: 42
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#F1F5F9' },
                            ticks: { font: { family: 'JetBrains Mono', size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Plus Jakarta Sans', size: 10, weight: '600' } }
                        }
                    }
                }
            });
        }

        // 3. Leaflet Interactive Multimodal Corridor Radar Map
        const mapEl = document.getElementById('overview-map');
        if (!mapEl) return;

        // Inisialisasi peta Leaflet
        const map = L.map('overview-map').setView([4.0, 99.0], 5);

        // Menggunakan OpenStreetMap Tiles Resmi (100% Bersih, Tanpa Watermark, Tanpa API Key)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            subdomains: ['a', 'b', 'c'],
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const locations = @json($locations);
        const markers = [];

        // Pin Hub Pelabuhan & Gudang
        locations.forEach(loc => {
            const marker = L.circleMarker([loc.latitude, loc.longitude], {
                radius: 7,
                color: '#051F20',
                fillColor: '#0B2B26',
                fillOpacity: 0.95,
                weight: 2
            }).addTo(map).bindPopup(`
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; padding: 2px;">
                    <div style="font-size: 11px; font-weight: bold; color: #051F20;">${loc.name}</div>
                    <div style="font-size: 10px; color: #64748B;">${loc.city}, ${loc.country}</div>
                    <div style="font-size: 10px; font-family: monospace; font-weight: bold; color: #163832; margin-top: 2px;">[${loc.code}] &bull; ${loc.type}</div>
                </div>
            `);
            markers.push(marker);
        });

        // Pin Kargo yang Sedang Bergerak
        const activeShipments = @json($recentShipments);
        activeShipments.forEach(s => {
            if (s.current_location) {
                const isDelayed = s.is_delayed;
                const cargoMarker = L.circleMarker([s.current_location.latitude, s.current_location.longitude], {
                    radius: 9,
                    color: isDelayed ? '#D97706' : '#0B2B26',
                    fillColor: isDelayed ? '#F59E0B' : '#235347',
                    fillOpacity: 1,
                    weight: 3
                }).addTo(map).bindPopup(`
                    <div style="font-family: 'Plus Jakarta Sans', sans-serif; padding: 2px; min-width: 160px;">
                        <div style="font-size: 12px; font-weight: 800; font-family: monospace; color: #051F20;">${s.tracking_number}</div>
                        <div style="font-size: 10px; color: #475569; margin-top: 1px;">${s.cargo_type}</div>
                        <div style="font-size: 10px; margin-top: 4px;">Status: <b style="color: ${isDelayed ? '#D97706' : '#163832'}">${s.status}</b></div>
                        ${isDelayed ? '<div style="font-size: 10px; color: #B45309; font-weight: bold;">Weather Alert (+' + s.delay_duration_hours + ' h)</div>' : ''}
                        <div style="margin-top: 6px;"><a href="/shipments/${s.id}" style="color: #163832; font-weight: bold; font-size: 10px; text-decoration: underline;">Detail &rarr;</a></div>
                    </div>
                `);
                markers.push(cargoMarker);
            }
        });

        // Garis Rute Multimodal Koridor Ekspor (Takengon -> Bireuen -> Belawan -> Selat Malaka -> Singapura)
        const corridorRoute = [
            [4.6293, 96.8458], // Takengon Warehouse
            [5.2045, 96.7009], // Bireuen Transit
            [3.7844, 98.6833], // Pelabuhan Belawan
            [1.2644, 103.8220]  // Port of Singapore
        ];
        L.polyline(corridorRoute, {
            color: '#163832',
            weight: 3.5,
            opacity: 0.9,
            dashArray: '6, 8',
            lineJoin: 'round'
        }).addTo(map);

        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds(), { padding: [40, 40] });
        }

        // Pastikan ukuran peta Leaflet terkalkulasi sempurna setelah layout dirender
        setTimeout(function() {
            map.invalidateSize();
        }, 300);
    });
</script>
@endpush
@endsection
