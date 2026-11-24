@extends('layouts.app')

@php
    $isEn = app()->getLocale() === 'en';
@endphp

@section('title', $isEn ? 'Multimodal Commodities & Fleet Catalog' : 'Katalog Komoditas & Armada Multimodal Ekspor')

@section('content')
<div class="space-y-6">

    <!-- ======================================================== -->
    <!-- 1. HEADER SECTION                                        -->
    <!-- ======================================================== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-forest-50 text-forest-800 border border-forest-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-forest-600 animate-pulse"></span>
                    {{ $isEn ? 'Export Commodity Showcase' : 'Showcase Komoditas Ekspor' }}
                </span>
                <span class="text-xs text-slate-300">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">{{ $isEn ? 'Gayo Highlands • 1,200 - 1,600 m ASL' : 'Dataran Tinggi Gayo • 1.200 - 1.600 mdpl' }}</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $isEn ? 'Multimodal Commodities & Fleet Catalog' : 'Katalog Komoditas & Armada Multimodal' }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ $isEn ? 'International quality specifications, cold-chain telemetry, and multimodal transport fleet from Takengon to global ocean ports.' : 'Spesifikasi mutu standar internasional, telemetri rantai dingin, dan armada pengangkut dari Takengon ke pelabuhan dunia.' }}</p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('dashboard') }}" class="btn-brand-outline px-3.5 py-2 rounded-xl text-xs font-bold text-forest-800 hover:text-forest-900 flex items-center gap-1.5 shadow-2xs">
                <span>&larr;</span>
                <span>{{ $isEn ? 'Back to Radar' : 'Kembali ke Radar' }}</span>
            </a>
            <a href="{{ route('shipments.index') }}" class="btn-brand-accent px-4 py-2 rounded-xl text-xs font-bold text-white flex items-center gap-1.5 shadow-sm">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>{{ $isEn ? 'View Active Shipments' : 'Lihat Daftar Pengiriman' }}</span>
            </a>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 2. HIGHLAND TERROIR & EXPORT EXCELLENCE BANNER           -->
    <!-- ======================================================== -->
    <div class="relative rounded-3xl overflow-hidden border border-forest-800/40 shadow-xl bg-sidebar-gradient text-white">
        <div class="absolute inset-0 z-0 opacity-20 mix-blend-overlay">
            <img src="/images/dashboard-hero.jpg" alt="Highland Multimodal Logistics" class="w-full h-full object-cover">
        </div>
        <div class="relative z-10 p-6 sm:p-8 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-forest-500/30 border border-forest-400/40 text-[11px] font-bold text-forest-200 uppercase tracking-widest font-mono mb-3">
                    {{ $isEn ? 'Highland Terroir Profile • Takengon, Central Aceh' : 'Highland Terroir Profile • Takengon, Aceh Tengah' }}
                </div>
                <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight leading-snug">
                    {{ $isEn ? 'Excellence of Gayo Volcanic Soil Organic Agro Commodities' : 'Keunggulan Komoditas Agro Organik Tanah Vulkanik Gayo' }}
                </h2>
                <p class="text-xs sm:text-sm text-forest-100/90 mt-2 leading-relaxed">
                    {{ $isEn ? 'Situated at 1,200 to 1,600 meters above sea level with cool temperatures of 16°C – 22°C and mineral-rich volcanic soil surrounding Lake Laut Tawar, Takengon produces world-class commodities with distinctive flavor profiles and export resilience.' : 'Terletak di ketinggian 1.200 hingga 1.600 meter di atas permukaan laut dengan suhu sejuk 16°C – 22°C dan tanah vulkanik kaya mineral di sekeliling Danau Laut Tawar, Takengon menghasilkan komoditas dengan profil rasa dan ketahanan ekspor kelas dunia.' }}
                </p>
                <div class="flex flex-wrap gap-2.5 mt-4">
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 border border-white/15 text-[11px] font-semibold text-white">{{ $isEn ? '✓ USDA & EU Organic Certified' : '✓ Sertifikasi Organik USDA & EU' }}</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 border border-white/15 text-[11px] font-semibold text-white">✓ Fairtrade Certified</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 border border-white/15 text-[11px] font-semibold text-white">{{ $isEn ? '✓ Phytosanitary Quarantine Compliant' : '✓ Standar Fitosanitari Karantina RI' }}</span>
                    <span class="px-2.5 py-1 rounded-lg bg-white/10 border border-white/15 text-[11px] font-semibold text-white">{{ $isEn ? '✓ Calibrated Reefer Cold Chain' : '✓ Rantai Dingin Reefer Terkalibrasi' }}</span>
                </div>
            </div>

            <div class="bg-black/30 backdrop-blur-md rounded-2xl p-5 border border-forest-700/60 lg:min-w-[280px] shrink-0 space-y-3 font-mono">
                <div class="text-[10px] font-bold text-forest-300 uppercase tracking-wider">
                    {{ $isEn ? 'Live Export FX Rates (ECB Live)' : 'Nilai Tukar Ekspor (ECB Live)' }}
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs pb-2 border-b border-white/10">
                        <span class="text-slate-300">1 EUR (€):</span>
                        <strong class="text-white">Rp {{ number_format($currencyRates['idr_per_eur'] ?? 17200, 0, ',', '.') }}</strong>
                    </div>
                    <div class="flex items-center justify-between text-xs pb-2 border-b border-white/10">
                        <span class="text-slate-300">1 USD ($):</span>
                        <strong class="text-white">Rp {{ number_format($currencyRates['idr_per_usd'] ?? 16300, 0, ',', '.') }}</strong>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-300">EUR / USD:</span>
                        <strong class="text-forest-200">{{ number_format($currencyRates['eur_to_usd'] ?? 1.055, 3) }}</strong>
                    </div>
                </div>
                <div class="pt-2 text-[10px] text-forest-200/80 leading-tight">
                    {{ $isEn ? '* Used for real-time export container foreign exchange valuation.' : '* Digunakan untuk perhitungan devisa kontainer ekspor secara realtime.' }}
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3. KOMODITAS SHOWCASE CARDS (Deep Details)                -->
    <!-- ======================================================== -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 font-mono">
                <span class="w-2 h-2 rounded-full bg-forest-600"></span>
                <span>{{ $isEn ? 'Export Commodity Quality Specifications' : 'Spesifikasi Mutu Komoditas Ekspor' }}</span>
            </h2>
            <span class="text-[11px] font-semibold text-slate-400 font-mono">{{ $isEn ? '3 Commodity Variants' : '3 Varian Komoditas' }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Card 1: Kopi Arabika Gayo Specialty -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col group hover:border-forest-400 transition-all">
                <div class="h-52 relative overflow-hidden bg-slate-100 shrink-0">
                    <img src="/images/coffee.jpg" alt="Biji Kopi Arabika Gayo Takengon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg text-[10px] font-black bg-[#051F20]/90 text-white backdrop-blur-xs border border-white/20 uppercase tracking-wider font-mono">
                        {{ $isEn ? 'Primary Gayo Commodity' : 'Komoditas Utama Gayo' }}
                    </span>
                    <span class="absolute top-3 right-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500 text-white font-mono shadow-xs">
                        {{ $isEn ? 'Grade 1 Export' : 'Grade 1 Ekspor' }}
                    </span>
                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <div class="text-[11px] font-mono text-forest-200">{{ $isEn ? '1,400 m ASL • Takengon Central' : '1.400 mdpl • Takengon Central' }}</div>
                        <div class="text-base font-bold leading-tight">{{ $isEn ? 'Gayo Arabica Green Coffee Beans' : 'Biji Kopi Mentah Arabika Gayo' }}</div>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="p-3 rounded-2xl bg-forest-50/70 border border-forest-200/70 text-xs text-forest-900 italic leading-relaxed">
                            {{ $isEn ? '"Premium export-grade Gayo Arabica green coffee beans with distinctive highland spice aroma."' : '"Biji kopi mentah Arabika Gayo kualitas ekspor premium dengan aroma rempah khas Takengon."' }}
                        </div>

                        <div class="mt-4 space-y-2 text-xs">
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Tree Variety:' : 'Varietas Pohon:' }}</span>
                                <strong class="text-slate-800">Ateng Super, Tim-Tim, Bourbon</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Processing Method:' : 'Metode Pengolahan:' }}</span>
                                <strong class="text-slate-800">{{ $isEn ? 'Wet-Hulled (Semi-Washed)' : 'Semi-Washed (Giling Basah)' }}</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Moisture Content:' : 'Kadar Air (Moisture):' }}</span>
                                <strong class="text-forest-700 font-mono font-bold">{{ $isEn ? '11.4% (≤ 12.0% ICO Standard)' : '11.4% (≤ 12.0% Standar ICO)' }}</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Defect Value:' : 'Nilai Cacat (Defect):' }}</span>
                                <strong class="text-slate-800 font-mono">&lt; 3 (Triage 1 / Zero Major)</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">SCA Cupping Score:</span>
                                <strong class="text-emerald-700 font-mono font-bold">87.5 / 100 (Specialty)</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Route & Seaport:' : 'Rute & Pelabuhan:' }}</span>
                                <strong class="text-slate-800">{{ $isEn ? 'Belawan → Rotterdam (Netherlands)' : 'Belawan → Rotterdam (Belanda)' }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 uppercase font-mono block">{{ $isEn ? 'Active Waybill' : 'Resi Aktif' }}</span>
                            <span class="text-xs font-mono font-bold text-forest-800">AGLN-2026-GY001</span>
                        </div>
                        <a href="/shipments/1" class="btn-brand-accent px-3 py-1.5 rounded-xl text-xs font-bold text-white flex items-center gap-1">
                            <span>{{ $isEn ? 'View Shipment' : 'Lihat Pengiriman' }}</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 2: Alpukat Mentega Hijau Segar -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col group hover:border-forest-400 transition-all">
                <div class="h-52 relative overflow-hidden bg-slate-100 shrink-0">
                    <img src="/images/avocado.jpg" alt="Alpukat Mentega Segar Gayo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg text-[10px] font-black bg-forest-900/90 text-white backdrop-blur-xs border border-white/20 uppercase tracking-wider font-mono">
                        {{ $isEn ? 'Horticulture Cold Chain' : 'Rantai Dingin Hortikultura' }}
                    </span>
                    <span class="absolute top-3 right-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white font-mono shadow-xs">
                        Grade A Super
                    </span>
                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <div class="text-[11px] font-mono text-emerald-200">{{ $isEn ? '1,350 m ASL • Laut Tawar Valley' : '1.350 mdpl • Lembah Laut Tawar' }}</div>
                        <div class="text-base font-bold leading-tight">{{ $isEn ? 'Fresh Green Butter Avocado Takengon' : 'Alpukat Mentega Hijau Takengon' }}</div>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="p-3 rounded-2xl bg-forest-50/70 border border-forest-200/70 text-xs text-forest-900 italic leading-relaxed">
                            {{ $isEn ? '"Highland Gayo grade A butter avocado with rich, creamy, and fiber-free flesh texture."' : '"Alpukat mentega dataran tinggi Gayo kualitas grade A dengan tekstur lembut, tebal, dan bebas serat."' }}
                        </div>

                        <div class="mt-4 space-y-2 text-xs">
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Flesh Character:' : 'Karakter Daging:' }}</span>
                                <strong class="text-slate-800">{{ $isEn ? 'Butter Yellow, Creamy, Rich' : 'Kuning Mentega, Pulen, Gurih' }}</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Average Weight:' : 'Bobot Rata-rata:' }}</span>
                                <strong class="text-slate-800 font-mono">{{ $isEn ? '450 - 650 g / fruit' : '450 - 650 gram / buah' }}</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Reefer Container Temp:' : 'Suhu Reefer Container:' }}</span>
                                <strong class="text-sky-700 font-mono font-bold">{{ $isEn ? '5.8°C (Safe Range 5 - 7°C)' : '5.8°C (Rentang Aman 5 - 7°C)' }}</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Relative Humidity (RH):' : 'Kelembaban Relatif (RH):' }}</span>
                                <strong class="text-slate-800 font-mono">{{ $isEn ? '88% (Skin Anti-Dehydration)' : '88% (Anti Dehidrasi Kulit)' }}</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Air Circulation Vent:' : 'Ventilasi Sirkulasi Udara:' }}</span>
                                <strong class="text-slate-800 font-mono">{{ $isEn ? '15 cbm/h (Ethylene Gas Prevention)' : '15 cbm/h (Pencegah Gas Etilen)' }}</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Route & Seaport:' : 'Rute & Pelabuhan:' }}</span>
                                <strong class="text-slate-800">{{ $isEn ? 'Belawan → Pasir Panjang (Singapore)' : 'Belawan → Pasir Panjang (Singapura)' }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 uppercase font-mono block">{{ $isEn ? 'Active Waybill' : 'Resi Aktif' }}</span>
                            <span class="text-xs font-mono font-bold text-forest-800">AGLN-2026-GY002</span>
                        </div>
                        <a href="/shipments/2" class="btn-brand-accent px-3 py-1.5 rounded-xl text-xs font-bold text-white flex items-center gap-1">
                            <span>{{ $isEn ? 'View Shipment' : 'Lihat Pengiriman' }}</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 3: Kopi Arabika Wine Gayo (Micro-lot) -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col group hover:border-forest-400 transition-all">
                <div class="h-52 relative overflow-hidden bg-slate-100 shrink-0">
                    <img src="/images/coffee.jpg" alt="Kopi Wine Gayo Micro-lot" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 filter contrast-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg text-[10px] font-black bg-rose-950/90 text-rose-200 backdrop-blur-xs border border-rose-500/30 uppercase tracking-wider font-mono">
                        Exotic Micro-lot
                    </span>
                    <span class="absolute top-3 right-3 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-600 text-white font-mono shadow-xs">
                        {{ $isEn ? '30-Day Anaerobic' : 'Anaerob 30 Hari' }}
                    </span>
                    <div class="absolute bottom-3 left-3 right-3 text-white">
                        <div class="text-[11px] font-mono text-rose-200">{{ $isEn ? '1,550 m ASL • Burni Telong Slopes' : '1.550 mdpl • Lereng Burni Telong' }}</div>
                        <div class="text-base font-bold leading-tight">{{ $isEn ? 'Fermented Gayo Wine Arabica' : 'Arabika Wine Gayo Fermentasi' }}</div>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="p-3 rounded-2xl bg-rose-50/70 border border-rose-200/70 text-xs text-rose-950 italic leading-relaxed">
                            {{ $isEn ? '"Gayo Arabica beans undergoing 30-day sealed anaerobic fermentation with rich grape fruity notes and balanced acidity."' : '"Biji kopi Arabika Gayo proses fermentasi alami tertutup (anaerobic) selama 30 hari dengan aroma fruity anggur yang kaya dan keasaman seimbang."' }}
                        </div>

                        <div class="mt-4 space-y-2 text-xs">
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Flavor Profile:' : 'Profil Rasa:' }}</span>
                                <strong class="text-slate-800">Winey, Dark Cherry, Brown Sugar</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Fermentation:' : 'Fermentasi:' }}</span>
                                <strong class="text-slate-800">Dry Anaerobic Maceration</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Moisture Content:' : 'Kadar Air:' }}</span>
                                <strong class="text-forest-700 font-mono font-bold">{{ $isEn ? '11.1% (Room Temp Stable)' : '11.1% (Stabil Suhu Ruang)' }}</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">SCA Cupping Score:</span>
                                <strong class="text-rose-700 font-mono font-bold">89.25 / 100 (Exotic Cup)</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Primary Markets:' : 'Pasar Utama:' }}</span>
                                <strong class="text-slate-800">{{ $isEn ? 'Osaka (Japan) & Hamburg (Germany)' : 'Osaka (Jepang) & Hamburg (Jerman)' }}</strong>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                                <span class="text-slate-500">{{ $isEn ? 'Export Packaging:' : 'Kemasan Ekspor:' }}</span>
                                <strong class="text-slate-800">GrainPro Vacuum + Jute Bag 60kg</strong>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-slate-400 uppercase font-mono block">{{ $isEn ? 'Allocation Status' : 'Status Alokasi' }}</span>
                            <span class="text-xs font-mono font-bold text-amber-700">Batch Q2 2026 Reserved</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-bold font-mono">
                            Special Order
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 4. EDUKASI MULTIMODAL & ARMADA KAPAL SAMUDERA            -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
            <div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-forest-50 text-forest-800 border border-forest-200 uppercase tracking-wider font-mono">
                    {{ $isEn ? 'Integrated Multimodal Export Corridor' : 'Koridor Ekspor Multimoda Terpadu' }}
                </span>
                <h3 class="text-lg font-bold text-slate-900 mt-1">{{ $isEn ? 'End-to-End Highland-to-Ocean Supply Chain Corridor' : 'Alur Rantai Pasok Menyeluruh dari Dataran Tinggi ke Pelabuhan Dunia' }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ $isEn ? 'Seamless connectivity from highland Gayo plantations to transshipment hubs and global ocean export markets.' : 'Konektivitas terpadu dari sentra perkebunan dataran tinggi Gayo menuju pelabuhan singgah dan pasar ekspor global.' }}</p>
            </div>
            <span class="text-xs text-slate-400 font-mono hidden sm:inline">{{ $isEn ? '3-Stage Multimodal Transit' : 'Transit Multimoda 3 Tahap' }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Tahap 1: Truk Dataran Tinggi -->
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-forest-600 text-white flex items-center justify-center font-bold text-sm mb-3 shadow-xs">
                        01
                    </div>
                    <span class="text-[10px] font-bold text-forest-700 uppercase tracking-wider font-mono">{{ $isEn ? 'INLAND HIGHLAND ROUTE' : 'Jalur Darat (Pegunungan)' }}</span>
                    <h4 class="text-sm font-bold text-slate-900 mt-1">{{ $isEn ? 'Highland Refrigerated Container Trucks' : 'Truk Kontainer Berpendingin Dataran Tinggi' }}</h4>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        {{ $isEn ? 'Takengon is situated in the central mountains of Aceh with no direct maritime access. Refrigerated trucks haul cargo down winding mountain passes toward Bireuen, then proceed to the Port of Belawan (Medan) covering a distance of ± 420 km.' : 'Takengon berada di dataran tinggi pegunungan tengah Aceh tanpa akses pelabuhan langsung. Truk berpendingin membawa kargo menuruni jalur pegunungan menuju Bireuen lalu berlanjut ke Pelabuhan Belawan (Medan) menempuh jarak ± 420 km.' }}
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/80 text-[11px] font-mono text-slate-500 flex justify-between">
                    <span>{{ $isEn ? 'Transit Duration:' : 'Durasi Transit:' }}</span>
                    <strong class="text-slate-800">{{ $isEn ? '12 - 16 Hours' : '12 - 16 Jam' }}</strong>
                </div>
            </div>

            <!-- Tahap 2: Hub Pelabuhan Belawan -->
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-sky-700 text-white flex items-center justify-center font-bold text-sm mb-3 shadow-xs">
                        02
                    </div>
                    <span class="text-[10px] font-bold text-sky-700 uppercase tracking-wider font-mono">{{ $isEn ? 'PORT CONSOLIDATION HUB' : 'Hub Konsolidasi Ekspor' }}</span>
                    <h4 class="text-sm font-bold text-slate-900 mt-1">{{ $isEn ? 'Belawan Seaport Container Terminal' : 'Terminal Petikemas Pelabuhan Belawan' }}</h4>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        {{ $isEn ? 'At the seaport, cargo is inspected by Customs and Agricultural Quarantine (Phytosanitary). Containers receive official customs seals and are staged for transshipment onto ocean container vessels.' : 'Di pelabuhan, kargo diperiksa oleh Petugas Bea Cukai dan Karantina Tumbuhan Pertanian. Kontainer dipasang segel pabean resmi dan disiapkan untuk pemindahan muatan ke atas kapal kontainer samudera.' }}
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/80 text-[11px] font-mono text-slate-500 flex justify-between">
                    <span>{{ $isEn ? 'Facilities:' : 'Fasilitas:' }}</span>
                    <strong class="text-slate-800">{{ $isEn ? 'Reefer Plugs & Full-Scan X-Ray' : 'Colokan Listrik Berpendingin & Pemindai Sinar-X' }}</strong>
                </div>
            </div>

            <!-- Tahap 3: Kapal Samudera -->
            <div class="p-5 rounded-2xl bg-forest-900 text-white border border-forest-800 flex flex-col justify-between shadow-md">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-forest-500 text-white flex items-center justify-center font-bold text-sm mb-3 shadow-xs">
                        03
                    </div>
                    <span class="text-[10px] font-bold text-forest-200 uppercase tracking-wider font-mono">{{ $isEn ? 'INTERNATIONAL OCEAN CORRIDOR' : 'Jalur Laut Internasional' }}</span>
                    <h4 class="text-sm font-bold text-white mt-1">{{ $isEn ? 'Ocean Container Liner Fleet' : 'Armada Kapal Petikemas Samudera' }}</h4>
                    <p class="text-xs text-slate-200 mt-2 leading-relaxed">
                        {{ $isEn ? 'Ocean container vessels navigate cross-continental maritime corridors through the Malacca Strait to transshipment hubs (Singapore) and onward to the Port of Rotterdam (Europe). Ensuring safe, scheduled, and cost-effective transport for thousands of export tons.' : 'Kapal kontainer samudera memfasilitasi pelayaran lintas benua melintasi Selat Malaka menuju pelabuhan singgah di Singapura hingga berlabuh di Pelabuhan Rotterdam (Eropa). Menjamin pengangkutan ribuan ton komoditas ekspor secara aman, terjadwal, dan berbiaya efisien.' }}
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-white/10 text-[11px] font-mono text-forest-200 flex justify-between">
                    <span>{{ $isEn ? 'Sailing Duration:' : 'Waktu Pelayaran:' }}</span>
                    <strong class="text-white">{{ $isEn ? '2 - 24 Ocean Days' : '2 - 24 Hari Samudera' }}</strong>
                </div>
            </div>

        </div>

        <!-- Armada Visual Gallery Strip -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100">
            <div class="relative h-44 rounded-2xl overflow-hidden group">
                <img src="/images/ship.jpg" alt="Kapal Kontainer Samudera" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-3 left-4 right-4 text-white">
                    <span class="text-[10px] font-bold text-sky-300 uppercase tracking-wider font-mono">{{ $isEn ? 'Global Shipping Partner' : 'Mitra Pelayaran Global' }}</span>
                    <div class="text-sm font-bold">{{ $isEn ? 'Ocean Container Liner (Maersk Line • 1,250 TEU)' : 'Kapal Kontainer Samudera (Maersk Line • 1.250 TEU)' }}</div>
                </div>
            </div>

            <div class="relative h-44 rounded-2xl overflow-hidden group">
                <img src="/images/multimodal-port.jpg" alt="Terminal Petikemas Multimodal" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-3 left-4 right-4 text-white">
                    <span class="text-[10px] font-bold text-amber-300 uppercase tracking-wider font-mono">{{ $isEn ? 'Seaport Infrastructure' : 'Infrastruktur Pelabuhan' }}</span>
                    <div class="text-sm font-bold">{{ $isEn ? 'Container Terminal & International Logistics Hub' : 'Terminal Petikemas & Hub Logistik Internasional' }}</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
