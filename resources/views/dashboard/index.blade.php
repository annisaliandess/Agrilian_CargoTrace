@extends('layouts.app')

@php
    $isEn = app()->getLocale() === 'en';
@endphp

@section('title', $isEn ? 'Highland Export Operational Dashboard' : 'Dashboard Operasional Ekspor Highland')

@section('content')
<div class="space-y-6">

    <!-- ======================================================== -->
    <!-- 1. EXECUTIVE COMMAND BANNER (Highland Olive & Sage)      -->
    <!-- ======================================================== -->
    <div class="relative rounded-3xl overflow-hidden shadow-2xl border-2 border-[#728156]/40 bg-gradient-to-br from-[#11180D] via-[#1D2617] to-[#161F12] text-white">
        <!-- Background Image with Directional Shading (Crisp Photo on Right, Deep Contrast on Left) -->
        <img src="{{ asset('images/dashboard-hero.jpg') }}" alt="Takengon Highland Multimodal Logistics" class="absolute inset-0 w-full h-full object-cover object-right md:object-center pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-r from-[#11180D] via-[#11180D]/85 via-50% to-transparent pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#11180D]/80 via-transparent to-black/30 pointer-events-none"></div>
        
        <!-- Content Container -->
        <div class="relative p-6 sm:p-8 lg:p-10 z-10">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="max-w-2xl">
                    <!-- Status Badge -->
                    <div class="inline-flex flex-wrap items-center gap-1.5 sm:gap-2 px-3 py-1 rounded-full text-[10px] sm:text-xs font-semibold bg-[#11180D]/80 text-[#E7F5DC] border border-[#B6C99B]/40 backdrop-blur-md mb-3 shadow-xs font-mono max-w-full">
                        <span class="w-2 h-2 rounded-full bg-[#CFE1B9] animate-pulse"></span>
                        <span>{{ $isEn ? 'Takengon Hub (Gayo) • Belawan Ocean Port • Rotterdam Direct' : 'Takengon Hub (Gayo) • Belawan Ocean Port • Rotterdam Langsung' }}</span>
                    </div>

                    <!-- Headline -->
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-tight drop-shadow-sm">
                        {{ $isEn ? 'Highland Agro-Export Visibility Cockpit' : 'Cockpit Visibilitas Logistik Ekspor Highland' }}
                    </h1>
                    <p class="text-xs sm:text-sm text-[#CFE1B9] mt-2 font-normal leading-relaxed max-w-xl drop-shadow-xs">
                        {{ $isEn ? 'Telemetry tracking system for Gayo Arabica coffee & fresh horticulture containers, cross-Sumatra mountain corridor weather radar, and international customs compliance.' : 'Sistem pemantauan telemetri kontainer kopi Arabika Gayo & hortikultura segar, radar cuaca koridor pegunungan lintas Sumatra, dan kepatuhan pabean internasional.' }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <a href="{{ route('track.public') }}" class="btn-brand-outline px-4 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-sm cursor-pointer active:scale-95">
                        <svg class="w-4 h-4 text-[#728156]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>{{ $isEn ? 'Track Waybill' : 'Cek Resi' }}</span>
                    </a>

                    @if(auth()->user()->isOperator() || auth()->user()->isAdmin())
                        <a href="{{ route('shipments.create') }}" class="btn-brand-accent px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-md cursor-pointer active:scale-95">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            <span>{{ $isEn ? 'Create New Shipment' : 'Buat Pengiriman Baru' }}</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Live Global Export Valuation & Currency Bar (ECB Live) -->
            <div class="mt-6 pt-5 border-t border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs text-[#CFE1B9] font-medium">
                <div class="flex flex-wrap items-center gap-2.5 font-mono">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#11180D]/80 text-[#E7F5DC] border border-[#B6C99B]/40 backdrop-blur-xs shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-[#CFE1B9] animate-pulse"></span>
                        <span>{{ $isEn ? 'Live Export FX Rates (ECB Live):' : 'Kurs Valas Ekspor (ECB Live):' }}</span>
                    </span>
                    <span class="px-2.5 py-1 rounded-xl bg-white/10 border border-white/10 text-white"><strong class="text-white">1 USD</strong> = Rp {{ number_format($currencyRates['usd_to_idr'], 0, ',', '.') }}</span>
                    <span class="px-2.5 py-1 rounded-xl bg-white/10 border border-white/10 text-[#CFE1B9]"><strong class="text-[#E7F5DC]">1 EUR</strong> = Rp {{ number_format($currencyRates['eur_to_idr'], 0, ',', '.') }}</span>
                    <span class="text-[10px] text-[#B6C99B] bg-white/5 px-2.5 py-1 rounded-xl border border-white/10 font-mono">{{ $isEn ? 'European Central Bank' : 'Bank Sentral Eropa' }}</span>
                </div>

                <div class="flex flex-wrap items-center gap-2 bg-[#11180D]/80 backdrop-blur-xs px-3 sm:px-3.5 py-1.5 rounded-2xl border border-[#B6C99B]/30 max-w-full">
                    <span class="text-[#CFE1B9]">{{ $isEn ? 'Estimated Cargo Valuation:' : 'Estimasi Devisa Kargo:' }}</span>
                    <strong class="font-mono font-bold text-white text-sm tracking-tight">{{ $totalValuation['usd_formatted'] }} USD</strong>
                    <span class="text-xs font-mono font-bold text-[#E7F5DC] bg-[#728156]/50 px-2 py-0.5 rounded-lg border border-[#B6C99B]/40">({{ $totalValuation['eur_formatted'] }})</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 2. INTERACTIVE EXECUTIVE BENTO KPI METRICS               -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3.5 sm:gap-4">
        
        <!-- Metric 1: Total Pengiriman (Bento Sage & Olive) -->
        <a href="{{ route('shipments.index') }}" title="{{ $isEn ? 'Click to view all shipments' : 'Klik untuk melihat seluruh pengiriman' }}"
           class="bg-gradient-to-br from-white via-[#F7FAF2] to-[#EBF3E3] rounded-3xl p-5 border-2 border-[#CFE1B9] shadow-xs hover:shadow-lg hover:-translate-y-1 hover:border-[#728156] transition-all duration-300 group cursor-pointer active:scale-95 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-extrabold uppercase font-mono tracking-wider text-[#4C5836] bg-[#E7F5DC] px-2.5 py-1 rounded-full border border-[#B6C99B]/60 shadow-2xs">
                        {{ $isEn ? 'Total Shipments' : 'Total Pengiriman' }}
                    </span>
                    <div class="w-10 h-10 rounded-2xl bg-[#728156]/15 text-[#728156] flex items-center justify-center group-hover:scale-110 group-hover:bg-[#728156] group-hover:text-white transition-all shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
                <div class="text-3xl sm:text-4xl font-black text-[#1D2617] font-mono tracking-tight mt-2">{{ $totalShipments }}</div>
            </div>
            <div class="flex items-center justify-between text-[11px] text-[#4C5836] font-semibold pt-3 mt-3 border-t border-[#CFE1B9]/70">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-[#728156]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>100% Terverifikasi</span>
                </span>
                <span class="text-[#728156] font-mono font-bold group-hover:translate-x-1 transition-transform flex items-center gap-0.5">Lihat &rarr;</span>
            </div>
        </a>

        <!-- Metric 2: Dalam Perjalanan (Bento Ocean Sky) -->
        <a href="{{ route('shipments.index', ['status' => 'IN_TRANSIT']) }}" title="{{ $isEn ? 'Filter in transit cargo' : 'Filter kargo dalam perjalanan' }}"
           class="bg-gradient-to-br from-white via-[#F0F7FB] to-[#E3F0F8] rounded-3xl p-5 border-2 border-sky-200 shadow-xs hover:shadow-lg hover:-translate-y-1 hover:border-sky-500 transition-all duration-300 group cursor-pointer active:scale-95 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-extrabold uppercase font-mono tracking-wider text-sky-800 bg-sky-100 px-2.5 py-1 rounded-full border border-sky-300 shadow-2xs flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-pulse"></span>
                        <span>{{ $isEn ? 'In Transit' : 'Dalam Perjalanan' }}</span>
                    </span>
                    <div class="w-10 h-10 rounded-2xl bg-sky-500/15 text-sky-700 flex items-center justify-center group-hover:scale-110 group-hover:bg-sky-600 group-hover:text-white transition-all shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                </div>
                <div class="text-3xl sm:text-4xl font-black text-slate-900 font-mono tracking-tight mt-2 flex items-baseline gap-2">
                    <span>{{ $inTransitCount }}</span>
                    <span class="text-xs font-sans font-bold text-sky-700 bg-sky-100/90 px-2 py-0.5 rounded-full border border-sky-200">{{ $isEn ? 'Moving' : 'Bergerak' }}</span>
                </div>
            </div>
            <div class="flex items-center justify-between text-[11px] text-sky-900 font-semibold pt-3 mt-3 border-t border-sky-200/80">
                <span>Armada Truk & Kapal</span>
                <span class="text-sky-700 font-mono font-bold group-hover:translate-x-1 transition-transform flex items-center gap-0.5">Pantau &rarr;</span>
            </div>
        </a>

        <!-- Metric 3: Terkirim Sukses (Bento Fresh Emerald) -->
        <a href="{{ route('shipments.index', ['status' => 'DELIVERED']) }}" title="{{ $isEn ? 'Filter delivered cargo' : 'Filter kargo terkirim sukses' }}"
           class="bg-gradient-to-br from-white via-[#F0FDF4] to-[#DCFCE7] rounded-3xl p-5 border-2 border-emerald-200 shadow-xs hover:shadow-lg hover:-translate-y-1 hover:border-emerald-500 transition-all duration-300 group cursor-pointer active:scale-95 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-extrabold uppercase font-mono tracking-wider text-emerald-800 bg-emerald-100 px-2.5 py-1 rounded-full border border-emerald-300 shadow-2xs">
                        {{ $isEn ? 'Delivered Safely' : 'Terkirim Sukses' }}
                    </span>
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/15 text-emerald-700 flex items-center justify-center group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl sm:text-4xl font-black text-slate-900 font-mono tracking-tight mt-2">{{ $deliveredCount }}</div>
            </div>
            <div class="flex items-center justify-between text-[11px] text-emerald-900 font-semibold pt-3 mt-3 border-t border-emerald-200/80">
                <span>Tiba di Pelabuhan Tujuan</span>
                <span class="text-emerald-700 font-mono font-bold group-hover:translate-x-1 transition-transform flex items-center gap-0.5">Riwayat &rarr;</span>
            </div>
        </a>

        <!-- Metric 4: Peringatan Jalur (Bento Highland Amber Alert) -->
        <a href="{{ route('shipments.index', ['delayed' => 1]) }}" title="{{ $isEn ? 'Check route weather alerts' : 'Periksa mitigasi peringatan jalur' }}"
           class="bg-gradient-to-br from-white via-[#FFFBEB] to-[#FEF3C7] rounded-3xl p-5 border-2 border-amber-200 shadow-xs hover:shadow-lg hover:-translate-y-1 hover:border-amber-500 transition-all duration-300 group cursor-pointer active:scale-95 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-extrabold uppercase font-mono tracking-wider text-amber-900 bg-amber-100 px-2.5 py-1 rounded-full border border-amber-300 shadow-2xs flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                        <span>{{ $isEn ? 'Delayed' : 'Peringatan Jalur' }}</span>
                    </span>
                    <div class="w-10 h-10 rounded-2xl bg-amber-500/15 text-amber-700 flex items-center justify-center group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl sm:text-4xl font-black text-amber-700 font-mono tracking-tight mt-2">{{ $delayedCount }}</div>
            </div>
            <div class="flex items-center justify-between text-[11px] text-amber-900 font-semibold pt-3 mt-3 border-t border-amber-200/80">
                <span>Mitigasi Jalur Km 48</span>
                <span class="text-amber-700 font-mono font-bold group-hover:translate-x-1 transition-transform flex items-center gap-0.5">Detail &rarr;</span>
            </div>
        </a>

        <!-- Metric 5: Open Exceptions (Bento Rose Alert Matching Slide) -->
        <a href="{{ route('shipments.index') }}" title="{{ $isEn ? 'Review open cargo exceptions' : 'Periksa kendala kargo yang aktif' }}"
           class="bg-gradient-to-br from-white via-[#FFF5F5] to-[#FEE2E2] rounded-3xl p-5 border-2 border-rose-200 shadow-xs hover:shadow-lg hover:-translate-y-1 hover:border-rose-500 transition-all duration-300 group cursor-pointer active:scale-95 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-extrabold uppercase font-mono tracking-wider text-rose-900 bg-rose-100 px-2.5 py-1 rounded-full border border-rose-300 shadow-2xs flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                        <span>{{ $isEn ? 'Open Exceptions' : 'Kendala Terbuka' }}</span>
                    </span>
                    <div class="w-10 h-10 rounded-2xl bg-rose-500/15 text-rose-700 flex items-center justify-center group-hover:scale-110 group-hover:bg-rose-600 group-hover:text-white transition-all shadow-2xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                </div>
                <div class="text-3xl sm:text-4xl font-black text-rose-700 font-mono tracking-tight mt-2">{{ $openExceptionsCount }}</div>
            </div>
            <div class="flex items-center justify-between text-[11px] text-rose-900 font-semibold pt-3 mt-3 border-t border-rose-200/80">
                <span>Status Investigasi</span>
                <span class="text-rose-700 font-mono font-bold group-hover:translate-x-1 transition-transform flex items-center gap-0.5">Pantau &rarr;</span>
            </div>
        </a>

    </div>

    <!-- ======================================================== -->
    <!-- VISUAL DATA ANALYTICS & CHARTS (Chart.js Role-Adaptive)  -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <!-- Chart 1: Status Distribution Doughnut Chart -->
        <div class="bg-white/95 rounded-3xl border-2 border-[#CFE1B9] shadow-sm p-5.5 backdrop-blur-xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3.5 border-b border-[#E7F5DC]">
                <div>
                    <h3 class="text-sm font-bold text-[#1D2617] flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <span>{{ auth()->user()->isCustomer() ? ($isEn ? 'My Consignment Status' : 'Status Pengiriman Kargo') : ($isEn ? 'Shipments by Status' : 'Distribusi Status Kargo') }}</span>
                    </h3>
                    <p class="text-xs text-[#4C5836] mt-0.5">{{ $isEn ? 'Overview of active shipments by status' : 'Komposisi kargo berdasarkan tahapan operasional' }}</p>
                </div>
                <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-[#E7F5DC] text-[#384226] border border-[#B6C99B] font-bold">Chart.js</span>
            </div>
            <div class="mt-4 flex items-center justify-center relative" style="height: 220px;">
                <canvas id="statusDoughnutChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Delay Rate by Carrier (Matching PPT Slide Specs) -->
        <div class="bg-white/95 rounded-3xl border-2 border-[#CFE1B9] shadow-sm p-5.5 backdrop-blur-xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3.5 border-b border-[#E7F5DC]">
                <div>
                    <h3 class="text-sm font-bold text-[#1D2617] flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <span>{{ $isEn ? 'Delay Rate by Carrier' : 'Rasio Delay Armada Ekspedisi' }}</span>
                    </h3>
                    <p class="text-xs text-[#4C5836] mt-0.5">{{ $isEn ? 'Distribution of delay rates across carriers' : 'Distribusi persentase keterlambatan per armada' }}</p>
                </div>
                <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200 font-bold">
                    {{ $averageDelayRate }}% {{ $isEn ? 'Avg' : 'Rata-rata' }}
                </span>
            </div>
            <div class="mt-4 flex items-center justify-center relative" style="height: 220px;">
                <canvas id="delayCarrierDoughnutChart"></canvas>
                <!-- Center Text Overlay -->
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-2xl font-black font-mono text-[#1D2617]">{{ $averageDelayRate }}%</span>
                    <span class="text-[9px] font-bold text-stone-500 uppercase tracking-wider font-mono">{{ $isEn ? 'Avg Delay' : 'Rata Delay' }}</span>
                </div>
            </div>
        </div>

        <!-- Chart 3: Export Volume Bar Chart -->
        <div class="bg-white/95 rounded-3xl border-2 border-[#CFE1B9] shadow-sm p-5.5 backdrop-blur-xs flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3.5 border-b border-[#E7F5DC]">
                <div>
                    <h3 class="text-sm font-bold text-[#1D2617] flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#728156]"></span>
                        <span>{{ $barTitle }}</span>
                    </h3>
                    <p class="text-xs text-[#4C5836] mt-0.5">{{ auth()->user()->isCustomer() ? ($isEn ? 'Tonnage per active waybill' : 'Tonase kopi per nomor resi') : ($isEn ? 'Tonnage per transport mode' : 'Total tonase per moda transportasi') }}</p>
                </div>
                <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-[#E7F5DC] text-[#384226] border border-[#B6C99B] font-bold">Metric Ton</span>
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
                <h2 class="text-xs font-bold text-[#1D2617] uppercase tracking-wider flex items-center gap-2 font-mono">
                    <span class="w-2 h-2 rounded-full bg-[#728156]"></span>
                    <span>{{ $isEn ? 'Navigation Center & Primary Shortcuts' : 'Pusat Navigasi & Pintasan Modul Utama' }}</span>
                </h2>
                <p class="text-xs text-[#4C5836] mt-0.5">{{ $isEn ? 'Rapid access to each core capability of the AgriLian export visibility platform' : 'Akses cepat ke setiap kapabilitas utama platform visibilitas ekspor AgriLian' }}</p>
            </div>
            <span class="text-[11px] font-bold text-[#728156] hidden sm:inline font-mono">{{ $isEn ? '4 Integrated Modules' : '4 Modul Terintegrasi' }}</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Shortcut 1: Daftar Pengiriman Kargo -->
            <a href="{{ route('shipments.index') }}" class="group bg-gradient-to-br from-white via-[#F7FAF2] to-white rounded-3xl border-2 border-[#CFE1B9] p-5 shadow-xs hover:border-[#728156] hover:shadow-md hover:-translate-y-1 transition-all flex flex-col justify-between active:scale-95">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#E7F5DC] text-[#384226] flex items-center justify-center group-hover:bg-[#728156] group-hover:text-white transition-all shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-[#384226] bg-[#E7F5DC] px-2.5 py-0.5 rounded-full border border-[#B6C99B] font-mono">{{ $totalShipments }} {{ $isEn ? 'Containers' : 'Kontainer' }}</span>
                    </div>
                    <h3 class="text-xs font-bold text-[#1D2617] group-hover:text-[#728156] transition-colors">{{ $isEn ? 'Shipment List & Records' : 'Daftar Pengiriman Kargo' }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $isEn ? 'Manage consignments, cargo tonnage, transport fleet, and customs clearance.' : 'Kelola seluruh data pengiriman kargo, tonase muatan, armada pengangkut, dan kepabeanan.' }}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-[#CFE1B9]/60 flex items-center justify-between text-xs font-bold text-[#728156] group-hover:translate-x-0.5 transition-transform">
                    <span>{{ $isEn ? 'View Shipments' : 'Lihat Pengiriman' }}</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Shortcut 2: Pelacakan Waybill -->
            <a href="{{ route('track.public') }}" class="group bg-gradient-to-br from-white via-[#F7FAF2] to-white rounded-3xl border-2 border-[#CFE1B9] p-5 shadow-xs hover:border-[#728156] hover:shadow-md hover:-translate-y-1 transition-all flex flex-col justify-between active:scale-95">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center group-hover:bg-[#1D2617] group-hover:text-white transition-all shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-[#384226] bg-[#E7F5DC] px-2.5 py-0.5 rounded-full border border-[#B6C99B] font-mono">{{ $isEn ? 'Waybill Tracker' : 'Pelacak Resi' }}</span>
                    </div>
                    <h3 class="text-xs font-bold text-[#1D2617] group-hover:text-[#728156] transition-colors">{{ $isEn ? 'Cargo Waybill Tracker' : 'Pelacak Waybill Kargo' }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $isEn ? 'Track container location, live satellite corridor weather, and customs clearance.' : 'Cek posisi kontainer, telemetri cuaca rute satelit, dan status kepabeanan secara langsung.' }}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-[#CFE1B9]/60 flex items-center justify-between text-xs font-bold text-[#728156] group-hover:translate-x-0.5 transition-transform">
                    <span>{{ $isEn ? 'Track Waybill' : 'Lacak Resi' }}</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Shortcut 3: Telemetri Cuaca Rute -->
            <div class="bg-gradient-to-br from-white via-[#F7FAF2] to-white rounded-3xl border-2 border-[#CFE1B9] p-5 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#E7F5DC] text-[#384226] flex items-center justify-center shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-[#384226] bg-[#E7F5DC] px-2.5 py-0.5 rounded-full border border-[#B6C99B] font-mono">OpenWeather</span>
                    </div>
                    <h3 class="text-xs font-bold text-[#1D2617]">{{ $isEn ? 'Route Weather Telemetry' : 'Telemetri Cuaca Jalur' }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $isEn ? 'Live satellite monitoring fog & precipitation risks across Takengon, Bireuen, to Belawan.' : 'Satelit live memantau titik rawan kabut & hujan di Takengon, Bireuen, hingga Belawan.' }}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-[#CFE1B9]/60 flex items-center justify-between text-xs text-slate-600 font-mono">
                    <span>Takengon Hub:</span>
                    <strong class="text-[#1D2617] font-bold">{{ $corridorWeather[0]['temp_c'] ?? '19.2' }}°C</strong>
                </div>
            </div>

            <!-- Shortcut 4: Valuasi Devisa ECB -->
            <div class="bg-gradient-to-br from-white via-[#F7FAF2] to-white rounded-3xl border-2 border-[#CFE1B9] p-5 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#E7F5DC] text-[#384226] flex items-center justify-center shadow-2xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-[#384226] bg-[#E7F5DC] px-2.5 py-0.5 rounded-full border border-[#B6C99B] font-mono">ECB Live</span>
                    </div>
                    <h3 class="text-xs font-bold text-[#1D2617]">{{ $isEn ? 'Export Foreign Valuation' : 'Valuasi Devisa Ekspor' }}</h3>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">{{ $isEn ? 'Automated currency conversion to USD ($) and EUR (€) directly from ECB data.' : 'Konversi otomatis devisa ke USD ($) dan EUR (€) langsung dari data Bank Sentral Eropa.' }}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-[#CFE1B9]/60 flex items-center justify-between text-xs text-slate-600 font-mono">
                    <span>{{ $isEn ? 'Total Valuation:' : 'Total Devisa:' }}</span>
                    <strong class="text-[#1D2617] font-bold">{{ $totalValuation['usd_formatted'] }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 4. RADAR VISUAL GIS RUTE MULTIMODAL (Full Width)          -->
    <!-- ======================================================== -->
    <div class="bg-white/95 rounded-3xl border-2 border-[#CFE1B9] p-6 shadow-sm backdrop-blur-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-4 border-b border-[#E7F5DC]">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#728156] animate-pulse"></span>
                    <h2 class="text-sm font-bold text-[#1D2617] uppercase tracking-wider font-mono">
                        {{ $isEn ? 'Multimodal Agro-Export Corridor Visual GIS Radar' : 'Radar Visual Rute Multimodal Koridor Ekspor Agro' }}
                    </h2>
                </div>
                <p class="text-xs text-[#4C5836] mt-0.5">{{ $isEn ? 'Monitoring cargo waypoints from Highland Gayo Plantations (Takengon), Bireuen Transit, Belawan Ocean Port, Malacca Strait, Singapore, to Rotterdam.' : 'Pemantauan titik henti kargo dari Kebun Dataran Tinggi Gayo (Takengon), Transit Bireuen, Pelabuhan Belawan, Selat Malaka, Singapura, hingga Rotterdam.' }}</p>
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
    <!-- 6. RECENT SHIPMENT LIST TABLE (Unified Highland Sage)   -->
    <!-- ======================================================== -->
    <div class="bg-white/95 rounded-3xl border-2 border-[#CFE1B9] shadow-md overflow-hidden backdrop-blur-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 sm:p-6 pb-4 border-b border-[#E7F5DC]">
            <div>
                <h3 class="text-xs font-bold text-[#1D2617] uppercase tracking-wider font-mono flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#728156]"></span>
                    <span>{{ $isEn ? 'Recent Shipments' : 'Recent Shipments (Pengiriman Terkini)' }}</span>
                </h3>
                <p class="text-xs text-[#4C5836] mt-0.5">{{ $isEn ? 'Live overview of all shipments' : 'Live overview pemantauan seluruh kargo aktif' }}</p>
            </div>
            <div class="flex items-center gap-2">
                <!-- Filter Button (Matching Slide TV Specs) -->
                <a href="{{ route('shipments.index') }}" title="{{ $isEn ? 'Filter shipments' : 'Filter pengiriman' }}"
                   class="px-3 py-1.5 rounded-xl bg-white hover:bg-[#E7F5DC] text-slate-700 border border-[#CFE1B9] text-xs font-bold flex items-center gap-1.5 transition-all shadow-2xs active:scale-95">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Filter</span>
                </a>

                <!-- Export Button (Matching Slide TV Specs) -->
                <a href="{{ route('shipments.index') }}" title="{{ $isEn ? 'Export shipment data' : 'Export data pengiriman' }}"
                   class="px-3 py-1.5 rounded-xl bg-white hover:bg-[#E7F5DC] text-slate-700 border border-[#CFE1B9] text-xs font-bold flex items-center gap-1.5 transition-all shadow-2xs active:scale-95">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Export</span>
                </a>

                <a href="{{ route('shipments.index') }}" class="px-3.5 py-1.5 rounded-xl bg-[#E7F5DC] hover:bg-[#CFE1B9] text-[#1D2617] border border-[#B6C99B] text-xs font-bold flex items-center gap-1.5 transition-all shadow-2xs active:scale-95">
                    <span>{{ $isEn ? 'View All' : 'Lihat Semua' }}</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gradient-to-r from-[#E7F5DC] via-[#F1F6EA] to-[#E7F5DC] border-b-2 border-[#B6C99B] text-[#384226] uppercase tracking-wider text-[10px] font-extrabold font-mono">
                    <tr>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Waybill No.' : 'Nomor Resi / Surat Jalan' }}</th>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Buyer / Consignee' : 'Penerima / Pembeli' }}</th>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Commodity & Weight' : 'Komoditas & Bobot' }}</th>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Route & Location' : 'Rute & Posisi Terkini' }}</th>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Carrier Fleet' : 'Armada Pengangkut' }}</th>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Status & ETA' : 'Status & Estimasi Tiba' }}</th>
                        <th class="py-3.5 px-4 font-bold text-right">{{ $isEn ? 'Actions' : 'Aksi' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E7F5DC]/80 text-slate-700">
                    @forelse($recentShipments as $s)
                        <tr class="{{ $loop->even ? 'bg-[#F9FBF7]' : 'bg-white' }} hover:bg-[#E7F5DC]/45 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-[#1D2617]">
                                <a href="{{ route('shipments.show', $s->id) }}" class="text-[#728156] hover:text-[#384226] hover:underline flex items-center gap-1">
                                    <span>{{ $s->tracking_number }}</span>
                                </a>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $s->customer->name ?? 'Confidential' }}
                            </td>
                            <td class="py-3.5 px-4">
                                @php
                                    $thumb = str_contains(strtolower($s->cargo_type), 'arabica') || str_contains(strtolower($s->cargo_type), 'coffee') 
                                        ? '/images/coffee.jpg' 
                                        : (str_contains(strtolower($s->cargo_type), 'avocado') || str_contains(strtolower($s->cargo_type), 'chili') ? '/images/avocado.jpg' : '/images/ship.jpg');
                                @endphp
                                <div class="flex items-center gap-2.5">
                                    <img src="{{ $thumb }}" alt="" class="w-8 h-8 rounded-xl object-cover border border-[#CFE1B9] shrink-0 shadow-2xs">
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $s->cargo_type }}</div>
                                        <div class="text-[11px] text-slate-500 font-mono mt-0.5">{{ number_format($s->weight_kg, 0) }} kg &bull; {{ $s->volume_cbm ?? '-' }} CBM</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                <div class="font-bold text-slate-800">{{ $s->origin->name }} &rarr; {{ $s->destination->name }}</div>
                                <div class="text-[#728156] text-[11px] font-semibold mt-0.5">{{ $isEn ? 'Location:' : 'Posisi:' }} {{ $s->currentLocation->name ?? ($isEn ? 'In Transit' : 'Dalam Perjalanan') }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900">{{ $s->carrier->name }}</span>
                                <span class="block text-[10px] text-[#728156] font-mono font-bold mt-0.5">[{{ $s->carrier->transport_mode }}]</span>
                            </td>
                            <td class="py-3.5 px-4">
                                @php
                                    $badge = match($s->status) {
                                        'CREATED' => 'bg-[#E7F5DC] text-[#384226] border-[#B6C99B]',
                                        'BOOKED' => 'bg-sky-50 text-sky-900 border-sky-300',
                                        'PICKED_UP' => 'bg-indigo-50 text-indigo-900 border-indigo-300',
                                        'IN_TRANSIT' => 'bg-sky-100 text-sky-950 border-sky-300 font-bold',
                                        'DELIVERED' => 'bg-emerald-50 text-emerald-900 border-emerald-300 font-bold',
                                        default => 'bg-slate-100 text-slate-800 border-slate-200',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase border font-mono {{ $badge }}">
                                    {{ $s->status }}
                                </span>
                                @if($s->is_delayed)
                                    <span class="block text-[10px] text-amber-700 font-bold mt-1 font-mono">
                                        +{{ $s->delay_duration_hours }}{{ $isEn ? 'h Delayed' : 'j Tunda' }}
                                    </span>
                                @else
                                    <span class="block text-[10px] text-slate-500 font-medium mt-1 font-mono">
                                        ETA: {{ \Carbon\Carbon::parse($s->estimated_arrival)->format('d M, H:i') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('shipments.show', $s->id) }}" class="px-3 py-1.5 rounded-xl bg-[#E7F5DC] hover:bg-[#CFE1B9] text-[#1D2617] border border-[#B6C99B] text-xs font-bold inline-block shadow-2xs active:scale-95 transition-all">
                                    {{ auth()->user()->isCustomer() ? ($isEn ? 'Detail' : 'Detail') : ($isEn ? 'Manage' : 'Kelola') }}
                                </a>
                                <a href="{{ route('track.public', $s->tracking_number) }}" target="_blank" title="{{ $isEn ? 'Open Waybill Tracking' : 'Buka Halaman Cek Resi' }}" 
                                   class="px-2.5 py-1.5 rounded-xl bg-white text-slate-700 hover:text-[#1D2617] hover:bg-[#E7F5DC] border border-[#CFE1B9] text-xs font-semibold inline-block transition-all shadow-2xs active:scale-95">
                                    Radar
                                </a>
                                @if(auth()->user()->isCustomer())
                                    <button type="button" onclick="openClaimModal({{ $s->id }}, '{{ $s->tracking_number }}')" class="px-2.5 py-1.5 rounded-xl text-xs font-bold bg-[#FFF5F5] hover:bg-rose-50 text-rose-700 border border-rose-200 inline-flex items-center gap-1 cursor-pointer transition-all shadow-2xs active:scale-95" title="{{ $isEn ? 'Report Discrepancy / Return Claim' : 'Lapor Ketidaksesuaian Mutu / Klaim Kerusakan' }}">
                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <span>{{ $isEn ? 'Claim' : 'Klaim' }}</span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-400 italic">{{ $isEn ? 'No active cargo shipments found.' : 'Belum ada pengiriman kargo terdaftar.' }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom In-App Modal: Lapor Ketidaksesuaian / Klaim Kerusakan (Customer Self-Service) -->
    <div id="claimModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border-2 border-[#CFE1B9]">
            <div class="flex items-center justify-between pb-4 border-b border-[#E7F5DC]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-200 font-bold text-base shadow-2xs">
                        ⚠️
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-[#1D2617]">{{ $isEn ? 'Report Cargo Discrepancy' : 'Lapor Ketidaksesuaian Kargo' }}</h3>
                        <p class="text-xs text-[#4C5836]">{{ $isEn ? 'Waybill Number:' : 'Nomor Resi:' }} <span id="modalTrackingNumber" class="font-mono font-bold text-[#728156]"></span></p>
                    </div>
                </div>
                <button type="button" onclick="closeClaimModal()" class="p-1.5 rounded-xl text-stone-400 hover:text-stone-700 hover:bg-[#E7F5DC] cursor-pointer transition-colors active:scale-90">✕</button>
            </div>

            <form id="claimForm" method="POST" action="" class="mt-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[#1D2617] uppercase tracking-wider mb-1 font-mono">{{ $isEn ? 'Issue Type / Discrepancy' : 'Jenis Kendala / Ketidaksesuaian' }}</label>
                    <select name="exception_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs font-semibold focus:ring-2 focus:ring-[#728156] focus:border-[#728156] bg-white transition-all">
                        <option value="DAMAGED">{{ $isEn ? 'Physical Cargo Damage (Packaging / Wet / Torn Jute Bags)' : 'Kargo Rusak Fisik (Kemasan / Karung Basah / Rusak)' }}</option>
                        <option value="DOCUMENTATION_ISSUE">{{ $isEn ? 'Coffee Quality Discrepancy / Quarantine Document Issue' : 'Ketidaksesuaian Mutu Kopi / Dokumen Karantina' }}</option>
                        <option value="MISROUTED">{{ $isEn ? 'Misrouted / Container Return Request' : 'Salah Rute / Permohonan Retur Kontainer' }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#1D2617] uppercase tracking-wider mb-1 font-mono">{{ $isEn ? 'Urgency Level (Severity)' : 'Tingkat Urgensi (Severity)' }}</label>
                    <select name="severity" required class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs font-semibold focus:ring-2 focus:ring-[#728156] focus:border-[#728156] bg-white transition-all">
                        <option value="MEDIUM">{{ $isEn ? 'MEDIUM — Field Verification / Quality Inspection Required' : 'MEDIUM — Butuh Verifikasi / Uji Mutu Lapangan' }}</option>
                        <option value="HIGH">{{ $isEn ? 'HIGH — Critical / Halt Consignment Immediately' : 'HIGH — Kritis / Stop Pengiriman Segera' }}</option>
                        <option value="LOW">{{ $isEn ? 'LOW — Minor Evaluation Note' : 'LOW — Catatan Minor Evaluasi' }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#1D2617] uppercase tracking-wider mb-1 font-mono">{{ $isEn ? 'Issue Description / Reason for Claim' : 'Rincian Masalah / Alasan Klaim' }}</label>
                    <textarea name="description" rows="3" required placeholder="{{ $isEn ? 'Describe quality discrepancy, moisture variance, or cargo damage found...' : 'Jelaskan ketidaksesuaian mutu, kadar air, atau kerusakan kargo yang ditemukan...' }}"
                              class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#728156] focus:border-[#728156] bg-white transition-all"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#E7F5DC]">
                    <button type="button" onclick="closeClaimModal()" class="btn-brand-outline px-4 py-2 rounded-xl text-xs font-bold active:scale-95 cursor-pointer">{{ $isEn ? 'Cancel' : 'Batal' }}</button>
                    <button type="submit" class="btn-brand-accent px-5 py-2.5 rounded-xl text-xs font-bold shadow-md cursor-pointer active:scale-95">{{ $isEn ? 'Submit Claim Report' : 'Kirim Laporan Klaim' }}</button>
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

        // 2. Chart.js: Delay Rate by Carrier Doughnut Chart (Slide TV Requirement)
        const ctxDelay = document.getElementById('delayCarrierDoughnutChart');
        if (ctxDelay) {
            new Chart(ctxDelay, {
                type: 'doughnut',
                data: {
                    labels: @json($carrierDelayLabels),
                    datasets: [{
                        data: @json($carrierDelayData),
                        backgroundColor: ['#F97316', '#0284C7', '#10B981', '#6366F1', '#EC4899'],
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
                                font: { family: 'Plus Jakarta Sans', size: 10, weight: 'bold' },
                                padding: 8,
                                boxWidth: 10
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.parsed + '% delay';
                                }
                            }
                        }
                    },
                    cutout: '72%'
                }
            });
        }

        // 3. Chart.js: Role-Adaptive Volume Bar Chart
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
