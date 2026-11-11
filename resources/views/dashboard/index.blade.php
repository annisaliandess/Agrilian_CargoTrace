@extends('layouts.app')

@section('title', 'Dashboard Operasional')

@section('content')
<div class="space-y-7">

    <!-- ======================================================== -->
    <!-- TOP TITLE & ACTION BAR                                  -->
    <!-- ======================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-bold bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]">
                    <span class="w-2 h-2 rounded-full bg-[#57C84D] animate-pulse"></span>
                    Radar Operasional Aktif
                </span>
                <span class="text-xs text-slate-300">&bull;</span>
                <span class="text-xs text-slate-500 font-semibold">Hub Dataran Tinggi Takengon &bull; Belawan &bull; Rotterdam</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#1B4332] tracking-tight">
                Dashboard Logistik Ekspor Highland
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('track.public') }}" target="_blank" class="btn-brand-outline px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 shadow-2xs">
                <svg class="w-3.5 h-3.5 text-[#1B4332]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Halaman Cek Resi</span>
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                <a href="{{ route('shipments.create') }}" class="btn-brand-primary px-5 py-2.5 rounded-xl text-xs font-extrabold flex items-center gap-2 cursor-pointer shadow-md shadow-[#1B4332]/20">
                    <svg class="w-4 h-4 text-[#57C84D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Buat Manifest Baru</span>
                </a>
            @endif
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 4 NUMERICAL KPI CARDS (Soft Glow & High Contrast)        -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Total Managed -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-sm relative overflow-hidden group hover:border-[#95D5B2] transition-colors">
            <div class="flex items-center justify-between text-slate-400 text-xs font-extrabold uppercase tracking-wider">
                <span>Total Pengiriman</span>
                <div class="w-9 h-9 rounded-xl bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]/60 flex items-center justify-center font-bold text-sm">
                    📦
                </div>
            </div>
            <div class="text-3xl font-black text-[#1B4332] mt-3 tracking-tight font-mono">{{ $totalShipments }}</div>
            <div class="text-[11px] text-slate-500 mt-1 font-semibold flex items-center gap-1.5">
                <span class="text-[#57C84D] font-bold">100%</span>
                <span>Manifest terdaftar sistem</span>
            </div>
        </div>

        <!-- In-Transit -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-sm relative overflow-hidden group hover:border-[#57C84D] transition-colors">
            <div class="flex items-center justify-between text-slate-400 text-xs font-extrabold uppercase tracking-wider">
                <span>Dalam Perjalanan</span>
                <div class="w-9 h-9 rounded-xl bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]/60 flex items-center justify-center font-bold text-sm">
                    🚚
                </div>
            </div>
            <div class="text-3xl font-black text-[#1B4332] mt-3 tracking-tight font-mono flex items-baseline gap-2">
                <span>{{ $inTransitCount }}</span>
                <span class="text-xs font-bold text-[#57C84D] uppercase font-sans">Bergerak</span>
            </div>
            <div class="text-[11px] text-slate-500 mt-1 font-semibold">Truk darat & kapal kontainer</div>
        </div>

        <!-- Delivered Safely -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-sm relative overflow-hidden group hover:border-[#95D5B2] transition-colors">
            <div class="flex items-center justify-between text-slate-400 text-xs font-extrabold uppercase tracking-wider">
                <span>Terkirim Sukses</span>
                <div class="w-9 h-9 rounded-xl bg-[#F0FBF5] text-[#57C84D] border border-[#95D5B2]/60 flex items-center justify-center font-black text-sm">
                    ✓
                </div>
            </div>
            <div class="text-3xl font-black text-slate-900 mt-3 tracking-tight font-mono">{{ $deliveredCount }}</div>
            <div class="text-[11px] text-slate-500 mt-1 font-semibold">Tiba di pelabuhan tujuan akhir</div>
        </div>

        <!-- Exceptions / Delayed -->
        <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-sm relative overflow-hidden group hover:border-amber-300 transition-colors">
            <div class="flex items-center justify-between text-slate-400 text-xs font-extrabold uppercase tracking-wider">
                <span>Tertunda / Insiden</span>
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 border border-amber-200 flex items-center justify-center font-bold text-sm">
                    ⚠️
                </div>
            </div>
            <div class="text-3xl font-black text-amber-600 mt-3 tracking-tight font-mono">{{ $delayedCount }}</div>
            <div class="text-[11px] text-amber-800 mt-1 font-semibold">Peringatan cuaca & pabean</div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3-COLUMN AGRO INTELLIGENCE CARDS (Image 2 Reference Style)-->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Card 1: Kargo Prioritas Bergerak (Trending Style) -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-base">🔥</span>
                        <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">Kargo Prioritas</h3>
                    </div>
                    <a href="{{ route('shipments.index') }}" class="text-[11px] font-bold text-[#1B4332] hover:text-[#57C84D] flex items-center gap-1 transition-colors">
                        <span>Semua</span>
                        <span>&gt;</span>
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($recentShipments->take(4) as $s)
                        <div class="flex items-center justify-between py-1.5 border-b border-slate-50 last:border-0">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-7 h-7 rounded-lg bg-[#F0FBF5] text-[#1B4332] flex items-center justify-center text-xs shrink-0 font-bold border border-[#95D5B2]/40">
                                    ☕
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-extrabold text-slate-900 truncate">{{ $s->tracking_number }}</div>
                                    <div class="text-[10px] text-slate-400 truncate">{{ $s->origin->city }} &rarr; {{ $s->destination->city }}</div>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $s->is_delayed ? 'bg-amber-100 text-amber-900' : 'bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]/60' }}">
                                    {{ $s->is_delayed ? '⚠️ Tertunda' : '+ On Time' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic py-2">Belum ada pengiriman aktif.</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                <span>Rute aktif utama:</span>
                <strong class="text-[#1B4332]">Takengon - Belawan</strong>
            </div>
        </div>

        <!-- Card 2: Radar Cuaca Jalur Ekspor (Top Gainers Style) -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-base">🚀</span>
                        <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">Cuaca Titik Transit</h3>
                    </div>
                    <span class="text-[11px] font-bold text-[#1B4332]">Satelit &gt;</span>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <div class="flex items-center gap-2.5">
                            <span class="text-sm">⛰️</span>
                            <div>
                                <div class="text-xs font-extrabold text-slate-900">Takengon Hub (1.200m)</div>
                                <div class="text-[10px] text-slate-400">Gudang Asal Kopi & Cabai</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-[#1B4332]">21°C</div>
                            <div class="text-[10px] text-emerald-600 font-bold">Berawan Sejuk</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <div class="flex items-center gap-2.5">
                            <span class="text-sm">🛣️</span>
                            <div>
                                <div class="text-xs font-extrabold text-slate-900">Jalur Bireuen - Takengon</div>
                                <div class="text-[10px] text-slate-400">Koridor Darat Truk Ekspor</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-[#1B4332]">26°C</div>
                            <div class="text-[10px] text-amber-600 font-bold">Waspada Kabut</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <div class="flex items-center gap-2.5">
                            <span class="text-sm">⚓</span>
                            <div>
                                <div class="text-xs font-extrabold text-slate-900">Belawan Container Terminal</div>
                                <div class="text-[10px] text-slate-400">Pelabuhan Muat Kapal Laut</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-[#1B4332]">31°C</div>
                            <div class="text-[10px] text-emerald-600 font-bold">Cerah Berangin</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5">
                        <div class="flex items-center gap-2.5">
                            <span class="text-sm">🇸🇬</span>
                            <div>
                                <div class="text-xs font-extrabold text-slate-900">Port of Singapore</div>
                                <div class="text-[10px] text-slate-400">Hub Transhipment Asia</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-[#1B4332]">29°C</div>
                            <div class="text-[10px] text-emerald-600 font-bold">Operasional Lancar</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                <span>Sumber Data:</span>
                <strong class="text-[#1B4332]">OpenWeather API v2.5</strong>
            </div>
        </div>

        <!-- Card 3: Kepatuhan & Mutu Produk (Recently Added Style) -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-base">💎</span>
                        <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">Integritas Komoditas</h3>
                    </div>
                    <span class="text-[11px] font-bold text-[#1B4332]">Standar &gt;</span>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <div class="flex items-center gap-2.5">
                            <span class="text-sm">☕</span>
                            <div>
                                <div class="text-xs font-extrabold text-slate-900">Kadar Air Kopi Gayo</div>
                                <div class="text-[10px] text-slate-400">Toleransi Ekspor: &lt; 12.0%</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-[#1B4332]">11.4%</div>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]/60">+ Lolos Uji</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <div class="flex items-center gap-2.5">
                            <span class="text-sm">🥑</span>
                            <div>
                                <div class="text-xs font-extrabold text-slate-900">Reefer Container Cold-Chain</div>
                                <div class="text-[10px] text-slate-400">Target Hortikultura: 4° - 8°C</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-[#1B4332]">5.8°C</div>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]/60">+ Dingin Stabil</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50">
                        <div class="flex items-center gap-2.5">
                            <span class="text-sm">🔒</span>
                            <div>
                                <div class="text-xs font-extrabold text-slate-900">Segel Bea Cukai & Pabean</div>
                                <div class="text-[10px] text-slate-400">e-Seal Telemetri Aktif</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-[#1B4332]">100% Intact</div>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]/60">Verified</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5">
                        <div class="flex items-center gap-2.5">
                            <span class="text-sm">📜</span>
                            <div>
                                <div class="text-xs font-extrabold text-slate-900">Karantina Tumbuhan (KT)</div>
                                <div class="text-[10px] text-slate-400">Sertifikat Phytosanitary</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-black text-[#1B4332]">Diterbitkan</div>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]/60">Valid</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                <span>Kepatuhan Ekspor:</span>
                <strong class="text-[#1B4332]">Standar Uni Eropa & Singapura</strong>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- LEAFLET RADAR MAP & CONSORTIUM HUB                      -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
            <div>
                <h2 class="text-sm font-black text-[#1B4332] uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#57C84D] animate-ping"></span>
                    Radar Visual Rute Logistik Dataran Tinggi Gayo &bull; Global
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Pemantauan titik henti kargo dari Takengon, transit Bireuen, Pelabuhan Belawan, Singapura, hingga Rotterdam</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-bold text-slate-600">
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#1B4332]"></span> Hub Gudang</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#57C84D]"></span> Kargo Bergerak</span>
            </div>
        </div>

        <div id="overview-map" class="h-96 w-full rounded-2xl border border-slate-200 z-10"></div>
    </div>

    <!-- ======================================================== -->
    <!-- RECENT CONSIGNMENTS TABLE & ACTIVE HOLDS (2 Cols)       -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Shipments Table (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-sm font-black text-[#1B4332] uppercase tracking-wider">
                        Manifest Pengiriman Terkini
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar consignment yang sedang dalam proses pengiriman</p>
                </div>
                <a href="{{ route('shipments.index') }}" class="text-xs font-black text-[#1B4332] hover:text-[#57C84D] flex items-center gap-1 transition-colors">
                    <span>Lihat Semua</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-[10px] font-black uppercase tracking-wider text-slate-400">
                            <th class="pb-3">Resi & Komoditas</th>
                            <th class="pb-3">Rute & Lokasi</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentShipments as $s)
                            @php
                                $isCoffee = str_contains(strtolower($s->cargo_type), 'arabica') || str_contains(strtolower($s->cargo_type), 'coffee');
                                $isHorti = str_contains(strtolower($s->cargo_type), 'avocado') || str_contains(strtolower($s->cargo_type), 'chili');
                            @endphp
                            <tr class="hover:bg-[#F8FAF9] transition-colors group">
                                <td class="py-3.5 pr-3">
                                    <a href="{{ route('shipments.show', $s->id) }}" class="font-mono text-xs font-black text-[#1B4332] group-hover:underline">
                                        {{ $s->tracking_number }}
                                    </a>
                                    <div class="font-bold text-slate-900 text-xs flex items-center gap-1.5 mt-0.5">
                                        <span>{{ $isCoffee ? '☕' : ($isHorti ? '🥑' : '📦') }}</span>
                                        <span>{{ $s->cargo_type }}</span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-semibold">
                                        {{ number_format($s->weight_kg, 0) }} kg &bull; {{ $s->carrier->name }}
                                    </div>
                                </td>
                                <td class="py-3.5 pr-3 text-xs">
                                    <div class="font-bold text-slate-800">{{ $s->origin->city }} &rarr; {{ $s->destination->city }}</div>
                                    <div class="text-[#1B4332] text-[11px] font-extrabold mt-0.5">
                                        Posisi: {{ $s->currentLocation->name ?? 'Dalam Perjalanan' }}
                                    </div>
                                </td>
                                <td class="py-3.5 pr-3">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase {{ $s->status === 'DELIVERED' ? 'bg-slate-100 text-slate-900' : ($s->status === 'IN_TRANSIT' ? 'bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]/60' : 'bg-slate-100 text-slate-700') }}">
                                        {{ $s->status }}
                                    </span>
                                    @if($s->is_delayed)
                                        <span class="block text-[10px] text-amber-700 font-extrabold mt-1">⚠️ +{{ $s->delay_duration_hours }}j tertunda</span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right">
                                    <a href="{{ route('shipments.show', $s->id) }}" class="btn-brand-outline px-3 py-1.5 rounded-xl text-xs inline-block">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400 italic">Belum ada manifest kargo terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Exceptions & Notifications (1 col) -->
        <div class="space-y-6">

            <!-- Active Holds / Exceptions -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h3 class="text-xs font-black uppercase tracking-wider text-amber-950 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Kendala Cuaca / Jalur ({{ $openExceptions->count() }})
                    </h3>
                </div>

                <div class="space-y-3">
                    @forelse($openExceptions as $exc)
                        <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200 text-xs">
                            <div class="flex items-center justify-between font-black text-amber-950">
                                <span>{{ $exc->exception_type }}</span>
                                <span class="text-[10px] uppercase px-2 py-0.5 rounded-md bg-amber-200 text-amber-900 font-black">{{ $exc->severity }}</span>
                            </div>
                            <div class="text-[11px] text-amber-800 font-bold mt-1">
                                Kargo: <a href="{{ route('shipments.show', $exc->shipment_id) }}" class="underline font-mono">{{ $exc->shipment->tracking_number }}</a>
                            </div>
                            <p class="text-slate-600 mt-1 leading-relaxed text-[11px]">{{ Str::limit($exc->description, 100) }}</p>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic py-2">Semua rute koridor pengiriman terpantau aman dan lancar!</div>
                    @endforelse
                </div>
            </div>

            <!-- Notifications Feed -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-sm">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">
                        Pemberitahuan Sistem
                    </h3>
                </div>

                <div class="space-y-2.5">
                    @forelse($notifications as $notif)
                        <div class="p-3.5 rounded-2xl bg-[#F8FAF9] border border-slate-200/60 text-xs">
                            <div class="font-extrabold text-[#1B4332]">{{ $notif->title }}</div>
                            <div class="text-slate-600 text-[11px] mt-0.5 leading-relaxed font-medium">{{ $notif->message }}</div>
                            <div class="text-[10px] font-bold text-slate-400 mt-1.5 font-mono">{{ $notif->created_at->diffForHumans() }}</div>
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
                color: '#1B4332',
                fillColor: '#57C84D',
                fillOpacity: 0.95,
                weight: 2
            }).addTo(map).bindPopup(`<b>${loc.name}</b><br>${loc.city}, ${loc.country}<br><span class="font-mono text-xs font-bold text-[#1B4332]">[${loc.code}]</span>`);
            markers.push(marker);
        });

        const activeShipments = @json($recentShipments);
        activeShipments.forEach(s => {
            if (s.current_location) {
                const isDelayed = s.is_delayed;
                const cargoMarker = L.circleMarker([s.current_location.latitude, s.current_location.longitude], {
                    radius: 9,
                    color: isDelayed ? '#b45309' : '#1B4332',
                    fillColor: isDelayed ? '#f59e0b' : '#57C84D',
                    fillOpacity: 0.95,
                    weight: 3
                }).addTo(map).bindPopup(`
                    <b>Kargo: ${s.tracking_number}</b><br>
                    Komoditas: ${s.cargo_type}<br>
                    Status: <b>${s.status}</b> ${isDelayed ? '<br><span style="color:#b45309">⚠️ Tertunda: +' + s.delay_duration_hours + ' jam</span>' : ''}<br>
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
