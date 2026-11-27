<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriLian CargoTrace') }} — @yield('title', 'Highland Agro-Export Visibility')</title>

    <!-- Modern Human-Crafted Typography: Outfit & Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Official AgriLian Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpg') }}">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Tailwind CSS (Instant CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        forest: {
                            50: '#E7F5DC',
                            100: '#CFE1B9',
                            200: '#B6C99B',
                            300: '#98A77C',
                            400: '#88976C',
                            500: '#728156',
                            600: '#5F6D46',
                            700: '#4C5836',
                            800: '#384226',
                            900: '#1D2617',
                            950: '#11180D',
                        },
                        brand: {
                            50: '#E7F5DC',
                            100: '#CFE1B9',
                            200: '#B6C99B',
                            300: '#98A77C',
                            400: '#88976C',
                            500: '#728156',
                            600: '#5F6D46',
                            700: '#4C5836',
                            800: '#384226',
                            900: '#1D2617',
                            950: '#11180D',
                        },
                        sage: {
                            50: '#E7F5DC',
                            100: '#CFE1B9',
                            200: '#B6C99B',
                            300: '#98A77C',
                            400: '#88976C',
                            500: '#728156',
                            600: '#5F6D46',
                            700: '#4C5836',
                            800: '#384226',
                            900: '#1D2617',
                            950: '#11180D',
                        },
                        coffee: {
                            500: '#A86F44',
                            700: '#6E473B',
                            900: '#291C0E',
                        },
                        navy: {
                            800: '#1D2617',
                            900: '#11180D',
                            950: '#0B1008',
                        }
                    },
                    fontFamily: {
                        sans: ['"Outfit"', '"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                        heading: ['"Outfit"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Chart.js for High-Precision Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .leaflet-container {
            font-family: inherit;
        }
        /* Bulletproof SVG safety */
        svg {
            display: inline-block;
            vertical-align: middle;
            flex-shrink: 0;
            max-width: 100%;
        }
        svg:not([width]) {
            width: 1.125rem;
            height: 1.125rem;
        }
        svg.w-6 { width: 24px !important; height: 24px !important; }
        svg.w-5 { width: 20px !important; height: 20px !important; }
        svg.w-4 { width: 16px !important; height: 16px !important; }
        svg.w-3\.5 { width: 14px !important; height: 14px !important; }

        /* Highland Sage & Deep Olive Obsidian Sidebar */
        .bg-sidebar-gradient {
            background: linear-gradient(180deg, #11180D 0%, #1D2617 55%, #151F10 100%);
        }

        /* Earthy Olive & Sage Accent Button */
        .btn-brand-accent {
            background: linear-gradient(135deg, #728156 0%, #5F6D46 100%);
            color: #FFFFFF !important;
            font-weight: 700;
            box-shadow: 0 3px 12px -2px rgba(114, 129, 86, 0.45);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid #88976C;
        }
        .btn-brand-accent:hover {
            background: linear-gradient(135deg, #88976C 0%, #728156 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px -2px rgba(114, 129, 86, 0.55);
        }

        /* Deep Smoked Olive Button */
        .btn-brand-primary {
            background-color: #1D2617;
            color: #FFFFFF !important;
            font-weight: 600;
            border: 1px solid #384226;
            transition: all 0.15s ease-in-out;
            box-shadow: 0 1px 3px 0 rgba(29, 38, 23, 0.25);
        }
        .btn-brand-primary:hover {
            background-color: #11180D;
            box-shadow: 0 3px 8px 0 rgba(17, 24, 13, 0.35);
            transform: translateY(-0.5px);
        }

        /* Clean White Outline Button */
        .btn-brand-outline {
            background-color: #FFFFFF;
            border: 1px solid #CFE1B9;
            color: #1E293B !important;
            font-weight: 600;
            transition: all 0.15s ease-in-out;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        }
        .btn-brand-outline:hover {
            background-color: #E7F5DC;
            border-color: #B6C99B;
            color: #1D2617 !important;
        }

        /* Tactile Button Click & Active States with Highland Green Shadow (Kesan Bayangan Warna Hijau Saat Diklik) */
        .btn-brand-accent:active,
        .btn-brand-primary:active,
        .btn-brand-outline:active,
        button:active:not(:disabled),
        a[class*="btn"]:active,
        [role="button"]:active,
        a:active:not([href="#"]),
        .btn-tactile:active {
            transform: scale(0.96) translateY(1.5px) !important;
            box-shadow: 0 0 0 3px rgba(182, 201, 155, 0.65), 0 6px 18px rgba(114, 129, 86, 0.45), inset 0 2px 4px rgba(56, 66, 38, 0.25) !important;
            filter: brightness(0.96) contrast(1.05);
        }

        /* Focus-visible with smooth green glow */
        button:focus-visible,
        a:focus-visible,
        [role="button"]:focus-visible {
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(182, 201, 155, 0.70), 0 4px 14px rgba(114, 129, 86, 0.35) !important;
        }

        .btn-brand-accent:active {
            background: linear-gradient(135deg, #4C5836 0%, #384226 100%) !important;
        }

        .btn-brand-primary:active {
            background-color: #0B1008 !important;
            border-color: #1D2617 !important;
        }

        .btn-brand-outline:active {
            background-color: #CFE1B9 !important;
            border-color: #728156 !important;
            color: #1D2617 !important;
        }

        /* Sleek scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F1F5F9;
        }
        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }
    </style>
</head>
<body class="h-full font-sans text-slate-800 antialiased selection:bg-[#728156] selection:text-white bg-gradient-to-br from-[#F5F8F1] via-[#ECF3E5] to-[#F1F6EC]">

@php
    $isAuthOnlyPage = request()->routeIs('login') || request()->routeIs('register');
    $useSidebar = auth()->check() && !$isAuthOnlyPage;
@endphp

@if($useSidebar)
    <!-- ======================================================== -->
    <!-- AUTHENTICATED COLLAPSIBLE SIDEBAR LAYOUT                 -->
    <!-- ======================================================== -->
    <div class="min-h-full flex relative overflow-x-hidden">

        <!-- Mobile Drawer Backdrop Overlay -->
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-30 hidden lg:hidden transition-opacity"></div>

        <!-- Sidebar Column (Bisa Dibuka dan Ditutup) -->
        <aside id="app-sidebar" class="w-64 bg-sidebar-gradient text-white flex flex-col fixed inset-y-0 left-0 z-40 shadow-2xl border-r border-[#1D2617] transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
            <!-- Brand Logo Area with Bubble Badge (Clickable to Toggle Sidebar) -->
            <div class="h-16 flex items-center justify-between px-4 border-b border-[#384226]/40 bg-black/25">
                <button type="button" onclick="toggleSidebar()" title="{{ app()->getLocale() === 'en' ? 'Collapse navigation menu' : 'Sembunyikan menu' }}"
                        class="inline-flex items-center gap-2.5 px-2.5 py-1.5 rounded-2xl bg-white/10 hover:bg-white/15 border border-[#B6C99B]/30 transition-all min-w-0 group cursor-pointer text-left active:scale-95">
                    <div class="w-8 h-8 rounded-xl bg-white p-0.5 flex items-center justify-center shadow-xs shrink-0 border border-white/20 group-hover:scale-105 transition-transform">
                        <img src="{{ asset('images/logo.jpg') }}" alt="AgriLian Logo" class="w-full h-full object-contain">
                    </div>
                    <div class="min-w-0 pr-1">
                        <span class="text-xs font-extrabold text-white tracking-tight block leading-tight">AgriLian <span class="text-[#CFE1B9]">CargoTrace</span></span>
                        <span class="text-[8px] font-semibold text-[#B6C99B] tracking-wider uppercase block font-mono">{{ app()->getLocale() === 'en' ? 'Highland Agro Visibility' : 'Visibilitas Ekspor Agro' }}</span>
                    </div>
                </button>

                <!-- Tombol Tutup Sidebar di Dalam -->
                <button type="button" onclick="toggleSidebar()" title="{{ app()->getLocale() === 'en' ? 'Collapse menu' : 'Sembunyikan menu' }}" class="p-1.5 rounded-xl text-[#CFE1B9]/70 hover:text-white hover:bg-white/10 transition-colors cursor-pointer active:scale-90">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 px-3 py-5 space-y-6 overflow-y-auto">
                <!-- Group 1: Core Operations -->
                <div>
                    <div class="px-3 text-[10px] font-bold uppercase tracking-widest text-[#B6C99B] mb-2 font-mono flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#728156]"></span>
                        <span>{{ app()->getLocale() === 'en' ? 'Export Operations' : 'Operasional Ekspor' }}</span>
                    </div>
                    <nav class="space-y-1.5">
                        <!-- 1. Dasbor Radar -->
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-semibold transition-all group {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-[#728156] to-[#5F6D46] text-white shadow-md shadow-black/20 border border-[#88976C]/60 font-bold' : 'text-[#CFE1B9] hover:text-white hover:bg-white/10' }}">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'bg-white/5 text-[#CFE1B9] group-hover:bg-white/10 group-hover:text-white' }} transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <span>{{ app()->getLocale() === 'en' ? 'Radar Dashboard' : 'Dasbor Radar' }}</span>
                            @if(request()->routeIs('dashboard'))
                                <span class="w-1.5 h-1.5 rounded-full bg-[#E7F5DC] ml-auto animate-pulse"></span>
                            @endif
                        </a>

                        <!-- 2. Tambah Pengiriman (Khusus Admin / Operator) -->
                        @if(auth()->user()->isOperator() || auth()->user()->isAdmin())
                            <a href="{{ route('shipments.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-semibold transition-all group {{ request()->routeIs('shipments.create') ? 'bg-gradient-to-r from-[#728156] to-[#5F6D46] text-white shadow-md shadow-black/20 border border-[#88976C]/60 font-bold' : 'text-[#CFE1B9] hover:text-white hover:bg-white/10' }}">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 {{ request()->routeIs('shipments.create') ? 'bg-white/20 text-white' : 'bg-white/5 text-[#CFE1B9] group-hover:bg-white/10 group-hover:text-white' }} transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                </div>
                                <span class="flex-1">{{ app()->getLocale() === 'en' ? 'Create Shipment' : 'Tambah Pengiriman' }}</span>
                                @if(request()->routeIs('shipments.create'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#E7F5DC] ml-auto animate-pulse"></span>
                                @else
                                    <span class="text-[9px] font-mono font-bold bg-[#728156]/40 text-[#E7F5DC] px-1.5 py-0.5 rounded-md border border-[#B6C99B]/30">+ Baru</span>
                                @endif
                            </a>
                        @endif

                        <!-- 3. Daftar Pengiriman (Shipments) -->
                        <a href="{{ route('shipments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-semibold transition-all group {{ (request()->routeIs('shipments.index') || request()->routeIs('shipments.show')) && !request()->routeIs('shipments.create') && !request('delayed') ? 'bg-gradient-to-r from-[#728156] to-[#5F6D46] text-white shadow-md shadow-black/20 border border-[#88976C]/60 font-bold' : 'text-[#CFE1B9] hover:text-white hover:bg-white/10' }}">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 {{ (request()->routeIs('shipments.index') || request()->routeIs('shipments.show')) && !request()->routeIs('shipments.create') && !request('delayed') ? 'bg-white/20 text-white' : 'bg-white/5 text-[#CFE1B9] group-hover:bg-white/10 group-hover:text-white' }} transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <span>{{ app()->getLocale() === 'en' ? 'Shipments' : 'Daftar Pengiriman' }}</span>
                            @if((request()->routeIs('shipments.index') || request()->routeIs('shipments.show')) && !request()->routeIs('shipments.create') && !request('delayed'))
                                <span class="w-1.5 h-1.5 rounded-full bg-[#E7F5DC] ml-auto animate-pulse"></span>
                            @endif
                        </a>

                        <!-- 4. Pelacakan Waybill (Tracking) -->
                        <a href="{{ route('track.public') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-semibold transition-all group {{ request()->routeIs('track.public') ? 'bg-gradient-to-r from-[#728156] to-[#5F6D46] text-white shadow-md shadow-black/20 border border-[#88976C]/60 font-bold' : 'text-[#CFE1B9] hover:text-white hover:bg-white/10' }}">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 {{ request()->routeIs('track.public') ? 'bg-white/20 text-white' : 'bg-white/5 text-[#CFE1B9] group-hover:bg-white/10 group-hover:text-white' }} transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <span>{{ app()->getLocale() === 'en' ? 'Tracking' : 'Pelacakan Waybill' }}</span>
                            @if(request()->routeIs('track.public'))
                                <span class="w-1.5 h-1.5 rounded-full bg-[#E7F5DC] ml-auto animate-pulse"></span>
                            @endif
                        </a>

                        <!-- 5. Kendala Kargo (Exceptions - Matching Slide) -->
                        <a href="{{ route('shipments.index', ['delayed' => 1]) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-semibold transition-all group {{ request('delayed') ? 'bg-gradient-to-r from-[#728156] to-[#5F6D46] text-white shadow-md shadow-black/20 border border-[#88976C]/60 font-bold' : 'text-[#CFE1B9] hover:text-white hover:bg-white/10' }}">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 {{ request('delayed') ? 'bg-white/20 text-white' : 'bg-white/5 text-[#CFE1B9] group-hover:bg-white/10 group-hover:text-white' }} transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <span class="flex-1">{{ app()->getLocale() === 'en' ? 'Exceptions' : 'Kendala Kargo' }}</span>
                            <span class="text-[9px] font-mono font-bold bg-rose-500/30 text-rose-200 px-1.5 py-0.5 rounded-md border border-rose-400/40">Alert</span>
                        </a>

                        <!-- 6. Armada Ekspedisi (Carriers - Matching Slide) -->
                        <a href="{{ route('commodities.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-semibold transition-all group {{ request()->routeIs('commodities.index') ? 'bg-gradient-to-r from-[#728156] to-[#5F6D46] text-white shadow-md shadow-black/20 border border-[#88976C]/60 font-bold' : 'text-[#CFE1B9] hover:text-white hover:bg-white/10' }}">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 {{ request()->routeIs('commodities.index') ? 'bg-white/20 text-white' : 'bg-white/5 text-[#CFE1B9] group-hover:bg-white/10 group-hover:text-white' }} transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                            </div>
                            <span>{{ app()->getLocale() === 'en' ? 'Carriers' : 'Armada Ekspedisi' }}</span>
                            @if(request()->routeIs('commodities.index'))
                                <span class="w-1.5 h-1.5 rounded-full bg-[#E7F5DC] ml-auto animate-pulse"></span>
                            @endif
                        </a>

                        <!-- 7. Laporan & Ekspor (Reports - Matching Slide) -->
                        <a href="{{ route('shipments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-2xl text-xs font-semibold transition-all group text-[#CFE1B9] hover:text-white hover:bg-white/10">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 bg-white/5 text-[#CFE1B9] group-hover:bg-white/10 group-hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <span>{{ app()->getLocale() === 'en' ? 'Reports' : 'Laporan & Ekspor' }}</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- User Profile Box & Logout (Bottom of Sidebar) -->
            <div class="p-3 border-t border-[#384226]/40 bg-black/30">
                <div class="flex items-center justify-between p-2.5 rounded-2xl bg-white/5 hover:bg-white/10 border border-[#B6C99B]/30 transition-all">
                    @php
                        $userRole = auth()->user()->role;
                        $isEn = app()->getLocale() === 'en';
                        $displayName = match($userRole) {
                            'admin' => 'Administrator',
                            'operator' => $isEn ? 'Operations Staff' : 'Staf Operasional',
                            default => auth()->user()->name,
                        };
                        $displayRole = match($userRole) {
                            'admin' => $isEn ? 'System Admin' : 'Admin Sistem',
                            'operator' => $isEn ? 'Field Operator' : 'Operator Lapangan',
                            default => $isEn ? 'Customer Account' : 'Akun Pelanggan',
                        };
                        $initial = match($userRole) {
                            'admin' => 'A',
                            'operator' => 'S',
                            default => strtoupper(substr(auth()->user()->name, 0, 1)),
                        };
                    @endphp
                    <div class="flex items-center gap-2.5 flex-1 min-w-0 mr-2">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#728156] to-[#4C5836] text-white flex items-center justify-center font-bold text-xs shrink-0 border border-[#B6C99B]/50 font-mono shadow-xs">
                            {{ $initial }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-xs font-bold text-white truncate" title="{{ $displayName }}">{{ $displayName }}</div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span class="text-[9px] font-bold text-[#CFE1B9] uppercase tracking-wider font-mono">{{ $displayRole }}</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                        @csrf
                        <button type="submit" title="{{ $isEn ? 'Sign out' : 'Keluar dari akun' }}" class="p-2 rounded-xl text-[#CFE1B9]/70 hover:text-white hover:bg-white/15 transition-all cursor-pointer flex items-center justify-center active:scale-90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Right Main Workspace -->
        <div id="main-content" class="flex-1 min-w-0 w-full max-w-full overflow-x-hidden pl-0 lg:pl-64 flex flex-col min-h-screen transition-all duration-300 ease-in-out bg-gradient-to-br from-[#F6F9F2] via-[#EDF3E6] to-[#F2F7ED]">
            <!-- Top Header Bar -->
            <header class="h-16 bg-white/95 backdrop-blur-md border-b border-[#CFE1B9] flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30 shadow-[0_1px_3px_rgba(0,0,0,0.04)]">
                <div class="flex items-center gap-3">
                    <!-- Tombol Logo + Brand Name (Sekaligus Tombol Pemicu Buka/Tutup Menu Navigasi) -->
                    <!-- Muncul saat sidebar ditutup / collapsed atau di layar mobile. Disembunyikan saat sidebar terbuka di desktop agar tidak double (satu aja!) -->
                    <button type="button" onclick="toggleSidebar()" id="navbar-brand-btn" title="{{ app()->getLocale() === 'en' ? 'Toggle Navigation Menu' : 'Buka Menu Navigasi' }}"
                            class="inline-flex items-center gap-2 px-2.5 py-1.5 rounded-2xl bg-[#E7F5DC] hover:bg-[#CFE1B9] border border-[#B6C99B] transition-all shadow-2xs group active:scale-95 cursor-pointer shrink-0 min-w-0">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-white p-0.5 flex items-center justify-center border border-[#B6C99B]/60 shadow-2xs group-hover:scale-105 transition-transform shrink-0">
                            <img src="{{ asset('images/logo.jpg') }}" alt="AgriLian Logo" class="w-full h-full object-contain">
                        </div>
                        <div class="leading-tight text-left min-w-0 pr-1">
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs sm:text-sm font-extrabold text-[#1D2617] tracking-tight block truncate">AgriLian <span class="text-[#728156]">CargoTrace</span></span>
                                <span class="w-1.5 h-1.5 rounded-full bg-[#728156] animate-pulse shrink-0"></span>
                            </div>
                            <span class="block text-[8px] font-bold text-[#728156] uppercase tracking-wider font-mono hidden sm:block">{{ app()->getLocale() === 'en' ? 'Highland Agro Visibility' : 'Visibilitas Ekspor Agro' }}</span>
                        </div>
                    </button>

                    <!-- Status Telemetri & Info Koridor (Selalu Aktif di Navbar Layar Tablet & Desktop) -->
                    <div class="hidden md:flex items-center gap-2 pl-1">
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#1D2617] bg-[#E7F5DC] px-2.5 py-1 rounded-full border border-[#B6C99B]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#728156] animate-pulse"></span>
                            <span class="font-mono text-[11px] font-bold">{{ app()->getLocale() === 'en' ? 'Takengon Hub • Telemetry Online' : 'Pusat Hub Takengon • Sistem Telemetri Aktif' }}</span>
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Quick Waybill Search Bar -->
                    <form action="{{ route('track.public') }}" method="GET" class="hidden md:flex items-center relative">
                        <input type="text" name="tracking_number" placeholder="{{ __('Cari Resi Kargo...') }}"
                               class="w-48 lg:w-56 pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs font-mono font-medium focus:outline-none focus:ring-1 focus:ring-forest-600 bg-slate-50 focus:bg-white transition-all shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </form>

                    <!-- Language Switcher Pills (ID / EN) -->
                    <div class="flex items-center bg-slate-100 rounded-lg p-0.5 border border-slate-200 text-[11px] font-bold font-mono">
                        <a href="{{ route('lang.switch', 'id') }}" title="Bahasa Indonesia"
                           class="px-2 py-1 rounded-md transition-all {{ app()->getLocale() === 'id' ? 'bg-[#0B2B26] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">ID</a>
                        <a href="{{ route('lang.switch', 'en') }}" title="English"
                           class="px-2 py-1 rounded-md transition-all {{ app()->getLocale() === 'en' ? 'bg-[#0B2B26] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">EN</a>
                    </div>

                    <!-- In-App Notification Bell & Modal Dropdown (Zero OS / Browser Alerts) -->
                    @if(auth()->check())
                        @php
                            $navNotifications = \App\Models\Notification::where('user_id', auth()->id())
                                ->latest()
                                ->take(6)
                                ->get();
                            $navUnreadCount = \App\Models\Notification::where('user_id', auth()->id())
                                ->where('is_read', false)
                                ->count();
                        @endphp
                        <div class="relative">
                            <button type="button" onclick="toggleNotificationDropdown()" id="notif-bell-btn" title="{{ app()->getLocale() === 'en' ? 'System Notifications' : 'Notifikasi Sistem' }}"
                                    class="relative p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors border border-slate-200 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if($navUnreadCount > 0)
                                    <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-rose-600 text-white text-[9px] font-extrabold flex items-center justify-center animate-pulse">
                                        {{ $navUnreadCount }}
                                    </span>
                                @endif
                            </button>

                            <!-- Custom Notification Modal/Dropdown -->
                            <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 z-50 overflow-hidden">
                                <div class="p-3.5 bg-sidebar-gradient text-white flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-forest-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                        <span class="text-xs font-bold font-mono tracking-tight">{{ __('Notifikasi') }} ({{ $navUnreadCount }})</span>
                                    </div>
                                    @if($navUnreadCount > 0)
                                        <form action="{{ route('notifications.markRead') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-[10px] text-forest-200 hover:text-white underline font-medium cursor-pointer">
                                                {{ __('Tandai Semua Sudah Dibaca') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                                    @forelse($navNotifications as $notif)
                                        <div class="p-3 hover:bg-slate-50 transition-colors {{ !$notif->is_read ? 'bg-emerald-50/40' : '' }}">
                                            <div class="flex items-start gap-2.5">
                                                <span class="w-2 h-2 rounded-full mt-1.5 shrink-0 {{ !$notif->is_read ? 'bg-emerald-500 ring-4 ring-emerald-100' : 'bg-slate-300' }}"></span>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-xs font-bold text-slate-800 leading-snug">{{ $notif->title }}</p>
                                                    <p class="text-[11px] text-slate-600 mt-0.5 leading-relaxed">{{ $notif->message }}</p>
                                                    <span class="text-[9px] text-slate-400 mt-1 block font-mono">{{ $notif->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-6 text-center text-xs text-slate-400">
                                            {{ __('Belum ada notifikasi') }}
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif

                    <a href="{{ route('track.public') }}" class="btn-brand-outline px-3 py-1.5 rounded-lg text-xs font-semibold hidden sm:inline-flex items-center gap-2 shrink-0">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>{{ __('Cek Resi') }}</span>
                    </a>
                </div>
            </header>

            <!-- Alerts / Custom Web Toast Container -->
            <div id="agrilian-toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none transition-all duration-300">
                @if(session('success'))
                    <div id="toast-success" class="pointer-events-auto bg-white/95 backdrop-blur-md border border-emerald-300 rounded-2xl p-4 shadow-xl flex items-start gap-3 transition-all duration-300 transform translate-y-0 opacity-100 animate-slide-in">
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="flex-1 min-w-0 pt-0.5">
                            <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider font-mono">{{ app()->getLocale() === 'en' ? 'Operation Success' : 'Berhasil' }}</div>
                            <div class="text-xs font-semibold text-slate-800 mt-0.5">{{ session('success') }}</div>
                        </div>
                        <button onclick="dismissToast('toast-success')" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100 transition-colors cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif
                @if(session('warning'))
                    <div id="toast-warning" class="pointer-events-auto bg-white/95 backdrop-blur-md border border-amber-300 rounded-2xl p-4 shadow-xl flex items-start gap-3 transition-all duration-300 transform translate-y-0 opacity-100 animate-slide-in">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0 pt-0.5">
                            <div class="text-[11px] font-bold text-amber-800 uppercase tracking-wider font-mono">{{ app()->getLocale() === 'en' ? 'Warning Alert' : 'Peringatan' }}</div>
                            <div class="text-xs font-semibold text-slate-800 mt-0.5">{{ session('warning') }}</div>
                        </div>
                        <button onclick="dismissToast('toast-warning')" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100 transition-colors cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif
                @if(session('error') || (isset($errors) && $errors->any()))
                    <div id="toast-error" class="pointer-events-auto bg-white/95 backdrop-blur-md border border-rose-300 rounded-2xl p-4 shadow-xl flex items-start gap-3 transition-all duration-300 transform translate-y-0 opacity-100 animate-slide-in">
                        <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0 pt-0.5">
                            <div class="text-[11px] font-bold text-rose-800 uppercase tracking-wider font-mono">{{ app()->getLocale() === 'en' ? 'Attention Required' : 'Perhatian' }}</div>
                            <div class="text-xs font-semibold text-slate-800 mt-0.5">
                                {{ session('error') ?? (app()->getLocale() === 'en' ? 'Please check your input form.' : 'Silakan periksa formulir input Anda.') }}
                                @if(isset($errors) && $errors->any())
                                    <ul class="list-disc list-inside mt-1 text-[11px] font-normal text-rose-700">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <button onclick="dismissToast('toast-error')" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100 transition-colors cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Main Page Slot -->
            <main class="flex-1 min-w-0 w-full max-w-full overflow-x-hidden px-3 sm:px-6 lg:px-8 py-5 sm:py-6">
                @yield('content')
            </main>

            <!-- Workspace Footer -->
            <footer class="border-t border-slate-200 bg-white py-4 px-4 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div>
                    <strong class="text-slate-800 font-semibold">AgriLian CargoTrace</strong> &bull; Takengon &bull; Bireuen &bull; Belawan &bull; Singapore &bull; Rotterdam
                </div>
                <div>
                    &copy; 2026 AgriLian Logistics Systems &bull; <span class="text-slate-600 font-medium">{{ app()->getLocale() === 'en' ? 'Enterprise Multimodal Visibility' : 'Visibilitas Ekspor Multimoda Terpadu' }}</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Script Buka/Tutup Sidebar (Collapsible Persistence & Mobile Overlay) -->
    <script>
        function toggleNotificationDropdown() {
            const dropdown = document.getElementById('notif-dropdown');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(e) {
            const btn = document.getElementById('notif-bell-btn');
            const dropdown = document.getElementById('notif-dropdown');
            if (dropdown && btn && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        function updateNavbarBrandVisibility(isCollapsed) {
            const navbarBrandBtn = document.getElementById('navbar-brand-btn');
            if (!navbarBrandBtn) return;
            const isDesktop = window.innerWidth >= 1024;
            if (isDesktop && !isCollapsed) {
                // Di layar desktop saat sidebar terbuka: sembunyikan logo di navbar agar tidak double (satu aja!)
                navbarBrandBtn.classList.add('lg:hidden');
            } else {
                // Saat sidebar ditutup / collapsed atau di mobile: tampilkan tombol logo brand di navbar
                navbarBrandBtn.classList.remove('lg:hidden');
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('app-sidebar');
            const mainContent = document.getElementById('main-content');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (!sidebar || !mainContent) return;

            const isDesktop = window.innerWidth >= 1024;
            const isClosed = sidebar.classList.contains('-translate-x-full');

            if (isClosed) {
                // Buka sidebar
                sidebar.classList.remove('-translate-x-full');
                if (isDesktop) {
                    sidebar.classList.add('lg:translate-x-0');
                    mainContent.classList.remove('pl-0');
                    mainContent.classList.add('lg:pl-64');
                    localStorage.setItem('cargotrace_sidebar_collapsed', 'false');
                } else {
                    sidebar.classList.add('translate-x-0');
                    if (backdrop) backdrop.classList.remove('hidden');
                }
                updateNavbarBrandVisibility(false);
            } else {
                // Tutup sidebar
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.remove('lg:translate-x-0');
                if (isDesktop) {
                    mainContent.classList.remove('lg:pl-64');
                    mainContent.classList.add('pl-0');
                    localStorage.setItem('cargotrace_sidebar_collapsed', 'true');
                } else if (backdrop) {
                    backdrop.classList.add('hidden');
                }
                updateNavbarBrandVisibility(true);
            }

            // Sesuaikan ubin Leaflet Map agar tidak terpotong saat sidebar bergerak
            if (window.routeMap) {
                setTimeout(() => {
                    try { window.routeMap.invalidateSize(); } catch(e) {}
                }, 310);
            }
        }

        // Terapkan preferensi buka/tutup saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('app-sidebar');
            const mainContent = document.getElementById('main-content');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (!sidebar || !mainContent) return;

            const isDesktop = window.innerWidth >= 1024;
            const savedState = localStorage.getItem('cargotrace_sidebar_collapsed');

            if (!isDesktop) {
                // Mobile default: tutup sidebar, tanpa padding kiri
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.remove('lg:translate-x-0');
                mainContent.classList.remove('lg:pl-64');
                mainContent.classList.add('pl-0');
                if (backdrop) backdrop.classList.add('hidden');
                updateNavbarBrandVisibility(true);
            } else if (savedState === 'true') {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('lg:translate-x-0');
                mainContent.classList.remove('lg:pl-64');
                mainContent.classList.add('pl-0');
                updateNavbarBrandVisibility(true);
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('lg:translate-x-0');
                mainContent.classList.add('lg:pl-64');
                mainContent.classList.remove('pl-0');
                updateNavbarBrandVisibility(false);
            }

            // Responsif saat ukuran layar browser diubah
            window.addEventListener('resize', function() {
                const isNowDesktop = window.innerWidth >= 1024;
                const isNowClosed = sidebar.classList.contains('-translate-x-full');
                if (!isNowDesktop) {
                    mainContent.classList.remove('lg:pl-64');
                    mainContent.classList.add('pl-0');
                } else if (!isNowClosed) {
                    mainContent.classList.add('lg:pl-64');
                    mainContent.classList.remove('pl-0');
                }
                updateNavbarBrandVisibility(isNowClosed);
            });
        });
    </script>

@else
    <!-- STANDALONE TOP-NAV LAYOUT (Public Tracker & Sign In) -->
    <div class="min-h-full flex flex-col">
        <!-- Top Nav Header -->
        <header class="bg-white border-b border-stone-200 sticky top-0 z-40 shadow-2xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-2.5 py-1.5 rounded-2xl bg-[#E7F5DC] hover:bg-[#CFE1B9] border border-[#B6C99B] transition-all shadow-2xs group min-w-0 shrink-0">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-white p-0.5 sm:p-1 flex items-center justify-center border border-[#B6C99B]/60 shadow-2xs group-hover:scale-105 transition-transform shrink-0">
                            <img src="{{ asset('images/logo.jpg') }}" alt="AgriLian Logo" class="w-full h-full object-contain">
                        </div>
                        <div class="leading-tight pr-1 min-w-0">
                            <span class="text-xs sm:text-sm font-extrabold text-[#1D2617] tracking-tight block truncate">AgriLian <span class="text-[#728156]">CargoTrace</span></span>
                            <span class="block text-[8px] font-bold text-[#728156] uppercase tracking-wider font-mono hidden sm:block">{{ app()->getLocale() === 'en' ? 'Highland Agro-Export Visibility' : 'Visibilitas Ekspor Agro Dataran Tinggi' }}</span>
                        </div>
                    </a>

                    <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                        <!-- Language Switcher Pills (ID / EN) -->
                        <div class="flex items-center bg-slate-100 rounded-lg p-0.5 border border-slate-200 text-[10px] sm:text-[11px] font-bold font-mono">
                            <a href="{{ route('lang.switch', 'id') }}" title="Bahasa Indonesia"
                               class="px-1.5 sm:px-2 py-1 rounded-md transition-all {{ app()->getLocale() === 'id' ? 'bg-[#1D2617] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">ID</a>
                            <a href="{{ route('lang.switch', 'en') }}" title="English"
                               class="px-1.5 sm:px-2 py-1 rounded-md transition-all {{ app()->getLocale() === 'en' ? 'bg-[#1D2617] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">EN</a>
                        </div>

                        <a href="{{ route('track.public') }}" class="btn-brand-outline px-2.5 sm:px-3.5 py-1.5 rounded-lg text-xs font-semibold hidden md:inline-flex">
                            {{ app()->getLocale() === 'en' ? 'Track Waybill' : 'Cek Resi Kargo' }}
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-brand-accent px-3.5 sm:px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-1.5 cursor-pointer shrink-0">
                                <span>Dashboard</span>
                                <span>&rarr;</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-brand-accent px-3.5 sm:px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-1.5 cursor-pointer shrink-0">
                                <span>{{ app()->getLocale() === 'en' ? 'Sign In' : 'Masuk' }}</span>
                                <span>&rarr;</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash messages / Custom Web Toast Container (Guest Mode) -->
        <div id="agrilian-guest-toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none transition-all duration-300">
            @if(session('success'))
                <div id="toast-guest-success" class="pointer-events-auto bg-white/95 backdrop-blur-md border border-emerald-300 rounded-2xl p-4 shadow-xl flex items-start gap-3 transition-all duration-300 transform translate-y-0 opacity-100">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div class="flex-1 min-w-0 pt-0.5">
                        <div class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider font-mono">{{ app()->getLocale() === 'en' ? 'Operation Success' : 'Berhasil' }}</div>
                        <div class="text-xs font-semibold text-slate-800 mt-0.5">{{ session('success') }}</div>
                    </div>
                    <button onclick="dismissToast('toast-guest-success')" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100 transition-colors cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
            @if(session('warning'))
                <div id="toast-guest-warning" class="pointer-events-auto bg-white/95 backdrop-blur-md border border-amber-300 rounded-2xl p-4 shadow-xl flex items-start gap-3 transition-all duration-300 transform translate-y-0 opacity-100">
                    <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0 pt-0.5">
                        <div class="text-[11px] font-bold text-amber-800 uppercase tracking-wider font-mono">{{ app()->getLocale() === 'en' ? 'Warning Alert' : 'Peringatan' }}</div>
                        <div class="text-xs font-semibold text-slate-800 mt-0.5">{{ session('warning') }}</div>
                    </div>
                    <button onclick="dismissToast('toast-guest-warning')" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100 transition-colors cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
            @if(session('error') || (isset($errors) && $errors->any()))
                <div id="toast-guest-error" class="pointer-events-auto bg-white/95 backdrop-blur-md border border-rose-300 rounded-2xl p-4 shadow-xl flex items-start gap-3 transition-all duration-300 transform translate-y-0 opacity-100">
                    <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0 pt-0.5">
                        <div class="text-[11px] font-bold text-rose-800 uppercase tracking-wider font-mono">{{ app()->getLocale() === 'en' ? 'Attention Required' : 'Perhatian' }}</div>
                        <div class="text-xs font-semibold text-slate-800 mt-0.5">
                            {{ session('error') ?? (app()->getLocale() === 'en' ? 'Please check your input form.' : 'Silakan periksa formulir input.') }}
                            @if(isset($errors) && $errors->any())
                                <ul class="list-disc list-inside mt-1 text-[11px] font-normal text-rose-700">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <button onclick="dismissToast('toast-guest-error')" class="text-slate-400 hover:text-slate-700 p-1 rounded-lg hover:bg-slate-100 transition-colors cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif
        </div>

        <!-- Public Content -->
        <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>

        <!-- Public Footer -->
        <footer class="border-t border-slate-200 bg-white py-6 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <strong class="text-slate-800 font-semibold">AgriLian CargoTrace</strong>
                    <span>&bull;</span>
                    <span>{{ app()->getLocale() === 'en' ? 'Highland Gayo Agro Supply Chain to Global Ocean Ports' : 'Rantai Pasok Agro Dataran Tinggi Gayo ke Pasar Internasional' }}</span>
                </div>
                <div>
                    &copy; 2026 AgriLian Logistics Systems &bull; <span class="text-slate-600 font-medium">{{ app()->getLocale() === 'en' ? 'Enterprise Multimodal Visibility' : 'Visibilitas Ekspor Multimoda Terpadu' }}</span>
                </div>
            </div>
        </footer>
    </div>
@endif

    <script>
        function dismissToast(id) {
            const el = document.getElementById(id);
            if (el) {
                el.classList.add('opacity-0', 'translate-x-4');
                setTimeout(() => {
                    if (el && el.parentNode) {
                        el.remove();
                    }
                }, 300);
            }
        }

        // Auto-dismiss custom web toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                document.querySelectorAll('[id^="toast-"]').forEach(el => {
                    dismissToast(el.id);
                });
            }, 5000);
        });
    </script>
    @stack('scripts')
</body>
</html>
