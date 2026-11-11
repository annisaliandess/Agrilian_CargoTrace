@extends('layouts.app')

@section('title', 'Dashboard Operasional')

@section('content')
<div class="space-y-6">

    <!-- ======================================================== -->
    <!-- TOP TITLE & ACTION BAR                                  -->
    <!-- ======================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                    Radar Operasional Aktif
                </span>
                <span class="text-xs text-slate-300">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Takengon Hub &bull; Pelabuhan Belawan &bull; Port of Rotterdam</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                Dashboard Logistik Ekspor Highland
            </h1>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('track.public') }}" target="_blank" class="btn-brand-outline px-3.5 py-2 rounded-xl text-xs flex items-center gap-2 shadow-2xs">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Halaman Cek Resi</span>
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                <a href="{{ route('shipments.create') }}" class="btn-brand-primary px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-1.5 cursor-pointer shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Buat Manifest Baru</span>
                </a>
            @endif
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 4 ENTERPRISE METRIC CARDS (Professional SVG Icons)       -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Managed -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 text-[11px] font-semibold uppercase tracking-wider">
                <span>Total Pengiriman</span>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 font-mono">{{ $totalShipments }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium flex items-center gap-1.5">
                <span class="text-emerald-700 font-semibold">100%</span>
                <span>Manifest tercatat sistem</span>
            </div>
        </div>

        <!-- In-Transit -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 text-[11px] font-semibold uppercase tracking-wider">
                <span>Dalam Perjalanan</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 font-mono flex items-baseline gap-2">
                <span>{{ $inTransitCount }}</span>
                <span class="text-xs font-semibold text-emerald-700 font-sans">Aktif Bergerak</span>
            </div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Truk darat & kapal kontainer</div>
        </div>

        <!-- Delivered Safely -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 text-[11px] font-semibold uppercase tracking-wider">
                <span>Terkirim Sukses</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 font-mono">{{ $deliveredCount }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Klirens pelabuhan selesai</div>
        </div>

        <!-- Exceptions / Delayed -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-2xs">
            <div class="flex items-center justify-between text-slate-500 text-[11px] font-semibold uppercase tracking-wider">
                <span>Peringatan Jalur</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-amber-600 mt-2 font-mono">{{ $delayedCount }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Mitigasi risiko cuaca & pabean</div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3-COLUMN LOGISTICS INTELLIGENCE (Enterprise B2B Format) -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <!-- Card 1: Manifest Kargo Prioritas -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Manifest Prioritas</h3>
                    </div>
                    <a href="{{ route('shipments.index') }}" class="text-[11px] font-semibold text-emerald-800 hover:text-emerald-950 flex items-center gap-1 transition-colors">
                        <span>Semua</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($recentShipments->take(4) as $s)
                        <div class="flex items-center justify-between py-1.5 border-b border-slate-100/70 last:border-0">
                            <div class="min-w-0 pr-2">
                                <a href="{{ route('shipments.show', $s->id) }}" class="text-xs font-bold text-slate-900 font-mono hover:text-emerald-800 hover:underline truncate block">
                                    {{ $s->tracking_number }}
                                </a>
                                <div class="text-[11px] text-slate-500 truncate mt-0.5 font-medium">
                                    {{ $s->origin->city }} &rarr; {{ $s->destination->city }}
                                </div>
                            </div>
                            <div class="shrink-0">
                                @if($s->is_delayed)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Tertunda
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                        On Track
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic py-2">Belum ada pengiriman aktif.</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                <span>Rute aktif utama:</span>
                <strong class="text-slate-800">Takengon &bull; Belawan &bull; Rotterdam</strong>
            </div>
        </div>

        <!-- Card 2: Telemetri Cuaca Jalur Ekspor -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 00-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Cuaca Jalur Ekspor</h3>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400">OpenWeather API</span>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100/70">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Takengon Highland Hub</div>
                            <div class="text-[10px] text-slate-500">Elevasi 1.200m dpl &bull; Gudang Asal</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold text-slate-900">21°C</div>
                            <div class="text-[10px] text-emerald-700 font-semibold">Berawan Sejuk</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100/70">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Koridor Bireuen - Takengon</div>
                            <div class="text-[10px] text-slate-500">Jalur Pegunungan Truk Kontainer</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold text-slate-900">26°C</div>
                            <div class="text-[10px] text-amber-700 font-semibold">Waspada Kabut</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100/70">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Belawan Container Terminal</div>
                            <div class="text-[10px] text-slate-500">Dermaga Peti Kemas Laut</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold text-slate-900">31°C</div>
                            <div class="text-[10px] text-emerald-700 font-semibold">Dermaga Normal</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Port of Singapore</div>
                            <div class="text-[10px] text-slate-500">Hub Transhipment Selat Malaka</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold text-slate-900">29°C</div>
                            <div class="text-[10px] text-emerald-700 font-semibold">Jadwal Sesuai ETA</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                <span>Status Koridor:</span>
                <strong class="text-slate-800">Jalur Utama Beroperasi Normal</strong>
            </div>
        </div>

        <!-- Card 3: Kontrol Kualitas & Regulasi Ekspor -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Integritas Komoditas</h3>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400">Standar ISO/SNI</span>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100/70">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Kadar Air Kopi Gayo (Moisture)</div>
                            <div class="text-[10px] text-slate-500">Toleransi Ekspor: &lt; 12.0%</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold text-slate-900 font-mono">11.4%</div>
                            <span class="px-1.5 py-0.2 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-800">Memenuhi Syarat</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100/70">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Cold-Chain Reefer (Alpukat & Cabai)</div>
                            <div class="text-[10px] text-slate-500">Rentang Target: 4.0°C &ndash; 8.0°C</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold text-slate-900 font-mono">5.8°C</div>
                            <span class="px-1.5 py-0.2 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-800">Dingin Stabil</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100/70">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Segel Pabean Digital (e-Seal)</div>
                            <div class="text-[10px] text-slate-500">Telemetri RFID Bea Cukai</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold text-slate-900 font-mono">RFID #8821</div>
                            <span class="px-1.5 py-0.2 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-800">Utuh Terverifikasi</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-1.5">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Karantina Tumbuhan (KT)</div>
                            <div class="text-[10px] text-slate-500">Sertifikat Phytosanitary</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold text-slate-900">Form KT-9</div>
                            <span class="px-1.5 py-0.2 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-800">Tervalidasi</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 flex justify-between">
                <span>Kepatuhan Ekspor:</span>
                <strong class="text-slate-800">Uni Eropa &bull; Singapura</strong>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- LEAFLET RADAR MAP COCKPIT                               -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
            <div>
                <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    Radar Rute Multimodal Koridor Dataran Tinggi Gayo ke Pasar Internasional
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Pemantauan titik henti kargo dari Takengon, transit Bireuen, Pelabuhan Belawan, Singapura, hingga Rotterdam</p>
            </div>
            <div class="flex items-center gap-3 text-xs font-semibold text-slate-600">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#1B4332]"></span> Titik Hub Gudang</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span> Kargo Bergerak</span>
            </div>
        </div>

        <div id="overview-map" class="h-80 w-full rounded-xl border border-slate-200 z-10"></div>
    </div>

    <!-- ======================================================== -->
    <!-- RECENT CONSIGNMENTS TABLE & ACTIVE HOLDS (2 Cols)       -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Shipments Table (2 cols) -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                        Manifest Pengiriman Terkini
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar consignment yang sedang dalam proses pengiriman</p>
                </div>
                <a href="{{ route('shipments.index') }}" class="text-xs font-semibold text-emerald-800 hover:text-emerald-950 flex items-center gap-1 transition-colors">
                    <span>Lihat Roster Lengkap</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-[10px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="pb-2.5">Nomor Resi</th>
                            <th class="pb-2.5">Komoditas & Bobot</th>
                            <th class="pb-2.5">Rute & Lokasi Terkini</th>
                            <th class="pb-2.5">Status</th>
                            <th class="pb-2.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($recentShipments as $s)
                            @php
                                $isCoffee = str_contains(strtolower($s->cargo_type), 'arabica') || str_contains(strtolower($s->cargo_type), 'coffee');
                                $isHorti = str_contains(strtolower($s->cargo_type), 'avocado') || str_contains(strtolower($s->cargo_type), 'chili');
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 pr-3 font-mono font-bold text-slate-900">
                                    <a href="{{ route('shipments.show', $s->id) }}" class="text-emerald-800 hover:underline">
                                        {{ $s->tracking_number }}
                                    </a>
                                </td>
                                <td class="py-3 pr-3">
                                    <div class="font-semibold text-slate-800 flex items-center gap-1.5">
                                        <span>{{ $s->cargo_type }}</span>
                                    </div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">
                                        {{ number_format($s->weight_kg, 0) }} kg &bull; {{ $s->carrier->name }}
                                    </div>
                                </td>
                                <td class="py-3 pr-3">
                                    <div class="font-medium text-slate-700">{{ $s->origin->city }} &rarr; {{ $s->destination->city }}</div>
                                    <div class="text-emerald-800 text-[11px] font-semibold mt-0.5">Posisi: {{ $s->currentLocation->name ?? 'Dalam Perjalanan' }}</div>
                                </td>
                                <td class="py-3 pr-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $s->status === 'DELIVERED' ? 'bg-slate-100 text-slate-800 border border-slate-300' : ($s->status === 'IN_TRANSIT' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-slate-100 text-slate-700') }}">
                                        {{ $s->status }}
                                    </span>
                                    @if($s->is_delayed)
                                        <span class="block text-[10px] text-amber-700 font-semibold mt-0.5">+{{ $s->delay_duration_hours }}j tertunda</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('shipments.show', $s->id) }}" class="btn-brand-outline px-2.5 py-1 rounded-lg text-xs inline-block">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400 italic">Belum ada manifest kargo terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Exceptions & Notifications (1 col) -->
        <div class="space-y-5">

            <!-- Active Holds / Exceptions -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-amber-900 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        Kendala Jalur Aktif ({{ $openExceptions->count() }})
                    </h3>
                </div>

                <div class="space-y-3">
                    @forelse($openExceptions as $exc)
                        <div class="p-3 rounded-xl bg-amber-50/60 border border-amber-200/80 text-xs">
                            <div class="flex items-center justify-between font-bold text-amber-950">
                                <span>{{ $exc->exception_type }}</span>
                                <span class="text-[10px] uppercase px-1.5 py-0.5 rounded bg-amber-200 text-amber-900 font-semibold">{{ $exc->severity }}</span>
                            </div>
                            <div class="text-[11px] text-amber-800 font-semibold mt-1">
                                Kargo: <a href="{{ route('shipments.show', $exc->shipment_id) }}" class="underline font-mono">{{ $exc->shipment->tracking_number }}</a>
                            </div>
                            <p class="text-slate-600 mt-1 leading-relaxed text-[11px]">{{ Str::limit($exc->description, 100) }}</p>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic py-1">Semua rute koridor pengiriman terpantau lancar!</div>
                    @endforelse
                </div>
            </div>

            <!-- Notifications Feed -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-2xs">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                        Log Sistem & Notifikasi
                    </h3>
                </div>

                <div class="space-y-2.5">
                    @forelse($notifications as $notif)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70 text-xs">
                            <div class="font-bold text-slate-900">{{ $notif->title }}</div>
                            <div class="text-slate-600 text-[11px] mt-0.5 leading-relaxed">{{ $notif->message }}</div>
                            <div class="text-[10px] font-medium text-slate-400 mt-1 font-mono">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic py-1">Tidak ada notifikasi baru.</div>
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
                radius: 6,
                color: '#1B4332',
                fillColor: '#2D6A4F',
                fillOpacity: 0.9,
                weight: 2
            }).addTo(map).bindPopup(`<b>${loc.name}</b><br>${loc.city}, ${loc.country}<br><span class="font-mono text-xs font-bold text-emerald-800">[${loc.code}]</span>`);
            markers.push(marker);
        });

        const activeShipments = @json($recentShipments);
        activeShipments.forEach(s => {
            if (s.current_location) {
                const isDelayed = s.is_delayed;
                const cargoMarker = L.circleMarker([s.current_location.latitude, s.current_location.longitude], {
                    radius: 8,
                    color: isDelayed ? '#b45309' : '#047857',
                    fillColor: isDelayed ? '#f59e0b' : '#10b981',
                    fillOpacity: 0.95,
                    weight: 2
                }).addTo(map).bindPopup(`
                    <b>Kargo: ${s.tracking_number}</b><br>
                    Komoditas: ${s.cargo_type}<br>
                    Status: <b>${s.status}</b> ${isDelayed ? '<br><span style="color:#b45309">Tertunda: +' + s.delay_duration_hours + ' jam</span>' : ''}<br>
                    <a href="/shipments/${s.id}" style="color:#047857;font-weight:bold;">Periksa Kargo &rarr;</a>
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
