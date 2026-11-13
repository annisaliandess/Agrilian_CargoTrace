<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAFC]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgriLian CargoTrace') }} — @yield('title', 'Highland Agro-Export Visibility')</title>

    <!-- Plus Jakarta Sans & JetBrains Mono Fonts (Supreme Readability) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|jetbrains-mono:400,500,600" rel="stylesheet" />

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
                            50: '#DAF1DE',
                            100: '#C1E6C8',
                            200: '#8EB69B',
                            300: '#649A76',
                            400: '#3D7D5E',
                            500: '#235347',
                            600: '#163832',
                            700: '#0E2E28',
                            800: '#0B2B26',
                            900: '#051F20',
                            950: '#031415',
                        },
                        brand: {
                            50: '#DAF1DE',
                            100: '#C1E6C8',
                            200: '#8EB69B',
                            300: '#649A76',
                            400: '#3D7D5E',
                            500: '#235347',
                            600: '#163832',
                            700: '#0E2E28',
                            800: '#0B2B26',
                            900: '#051F20',
                            950: '#031415',
                        },
                        coffee: {
                            500: '#A86F44',
                            700: '#6E473B',
                            900: '#291C0E',
                        },
                        navy: {
                            800: '#0B2B26',
                            900: '#051F20',
                            950: '#031415',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    }
                }
            }
        }
    </script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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

        /* Modern Highland Forest & Pine Sidebar */
        .bg-sidebar-gradient {
            background: linear-gradient(180deg, #051F20 0%, #0B2B26 60%, #031415 100%);
        }

        /* High-Precision Highland Pine Button */
        .btn-brand-accent {
            background-color: #163832;
            color: #FFFFFF !important;
            font-weight: 700;
            box-shadow: 0 2px 8px -1px rgba(11, 43, 38, 0.45);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid #235347;
        }
        .btn-brand-accent:hover {
            background-color: #0B2B26;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px -1px rgba(5, 31, 32, 0.6);
        }

        /* Enterprise Obsidian Button */
        .btn-brand-primary {
            background-color: #0B2B26;
            color: #FFFFFF !important;
            font-weight: 600;
            border: 1px solid #163832;
            transition: all 0.15s ease-in-out;
            box-shadow: 0 1px 3px 0 rgba(11, 43, 38, 0.2);
        }
        .btn-brand-primary:hover {
            background-color: #051F20;
            box-shadow: 0 3px 8px 0 rgba(5, 31, 32, 0.3);
            transform: translateY(-0.5px);
        }

        /* Clean White Outline Button */
        .btn-brand-outline {
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            color: #1E293B !important;
            font-weight: 600;
            transition: all 0.15s ease-in-out;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        }
        .btn-brand-outline:hover {
            background-color: #F8FAFC;
            border-color: #CBD5E1;
            color: #0F172A !important;
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
<body class="h-full font-sans text-slate-800 antialiased selection:bg-forest-600 selection:text-white bg-[#F8FAFC]">

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
        <aside id="app-sidebar" class="w-64 bg-sidebar-gradient text-white flex flex-col fixed inset-y-0 left-0 z-40 shadow-2xl border-r border-slate-800/80 transition-transform duration-300 ease-in-out">
            <!-- Brand Logo Area + Internal Close Button -->
            <div class="h-16 flex items-center justify-between px-5 border-b border-forest-800/80 bg-black/30">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-white p-1 flex items-center justify-center shadow-sm shrink-0 border border-white/20 group-hover:scale-105 transition-transform">
                        <img src="{{ asset('images/logo.jpg') }}" alt="AgriLian Logo" class="w-full h-full object-contain">
                    </div>
                    <div class="min-w-0">
                        <span class="text-sm font-bold text-white tracking-tight block leading-tight">AgriLian</span>
                        <span class="text-[10px] font-semibold text-forest-200 tracking-wider uppercase block mt-0.5 font-mono">CargoTrace Platform</span>
                    </div>
                </a>

                <!-- Tombol Tutup Sidebar di Dalam -->
                <button type="button" onclick="toggleSidebar()" title="Sembunyikan menu" class="p-1.5 rounded-lg text-forest-200/70 hover:text-white hover:bg-white/10 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 px-3 py-5 space-y-6 overflow-y-auto">
                <!-- Group 1: Core Operations -->
                <div>
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-forest-200/70 mb-2 font-mono">
                        Operasional Ekspor
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-forest-500/30 text-white border-l-4 border-forest-200 shadow-sm font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-forest-200' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard Radar</span>
                        </a>

                        <a href="{{ route('shipments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('shipments.index') || request()->routeIs('shipments.show') ? 'bg-forest-500/30 text-white border-l-4 border-forest-200 shadow-sm font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('shipments.index') || request()->routeIs('shipments.show') ? 'text-forest-200' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <span>Manifes Kargo (Roster)</span>
                        </a>

                        <a href="{{ route('track.public') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('track.public') ? 'bg-forest-500/30 text-white border-l-4 border-forest-200 shadow-sm font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('track.public') ? 'text-forest-200' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Pelacakan & Cek Resi</span>
                        </a>

                        <a href="{{ route('commodities.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('commodities.index') ? 'bg-forest-500/30 text-white border-l-4 border-forest-200 shadow-sm font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('commodities.index') ? 'text-forest-200' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            <span>Katalog Komoditas & Armada</span>
                        </a>

                        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                            <a href="{{ route('shipments.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('shipments.create') ? 'bg-forest-500/30 text-white border-l-4 border-forest-200 shadow-sm font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                                <svg class="w-4 h-4 {{ request()->routeIs('shipments.create') ? 'text-forest-200' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Buat Manifest Baru</span>
                            </a>
                        @endif
                    </nav>
                </div>

                <!-- Group 2: Public Portal -->
                <div>
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-forest-200/70 mb-2 font-mono">
                        Portal Publik
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('track.public') }}" target="_blank" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-white hover:bg-white/5 transition-all group">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-forest-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <span>Halaman Cek Resi</span>
                            </span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-white/10 text-slate-300 group-hover:text-white font-mono">↗</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- User Profile Box & Logout (Bottom of Sidebar) -->
            <div class="p-3 border-t border-forest-800 bg-black/40">
                <div class="flex items-center justify-between p-2 rounded-xl bg-white/5 border border-forest-800">
                    @php
                        $userRole = auth()->user()->role;
                        $displayName = match($userRole) {
                            'admin' => 'Administrator',
                            'operator' => 'Operations Staff',
                            default => auth()->user()->name,
                        };
                        $displayRole = match($userRole) {
                            'admin' => 'System Admin',
                            'operator' => 'Field Operator',
                            default => 'Customer Account',
                        };
                        $initial = match($userRole) {
                            'admin' => 'A',
                            'operator' => 'S',
                            default => strtoupper(substr(auth()->user()->name, 0, 1)),
                        };
                    @endphp
                    <div class="flex items-center gap-2.5 overflow-hidden">
                        <div class="w-8 h-8 rounded-lg bg-forest-500/25 text-forest-200 flex items-center justify-center font-bold text-xs shrink-0 border border-forest-500/40 font-mono">
                            {{ $initial }}
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">{{ $displayName }}</div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span class="text-[10px] font-medium text-forest-200/80 uppercase tracking-wider font-mono">{{ $displayRole }}</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Keluar dari akun" class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/15 transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Right Main Workspace -->
        <div id="main-content" class="flex-1 pl-64 flex flex-col min-h-screen transition-all duration-300 ease-in-out">
            <!-- Top Header Bar -->
            <header class="h-16 bg-white border-b border-slate-200/90 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30 shadow-[0_1px_2px_rgba(0,0,0,0.03)]">
                <div class="flex items-center gap-3">
                    <!-- Tombol Buka / Tutup Sidebar (Hamburger Toggle) -->
                    <button type="button" onclick="toggleSidebar()" id="sidebar-toggle-btn" title="Buka / Tutup Menu Navigasi"
                            class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors cursor-pointer border border-slate-200 shadow-2xs flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span class="text-xs font-semibold hidden md:inline text-slate-700" id="sidebar-toggle-text">Menu</span>
                    </button>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-800 font-mono hidden sm:inline">Takengon Central Logistics Hub</span>
                        <span class="text-slate-300 hidden sm:inline">•</span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Sistem Telemetri Aktif
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Quick Waybill Search Bar -->
                    <form action="{{ route('track.public') }}" method="GET" class="hidden md:flex items-center relative">
                        <input type="text" name="tracking_number" placeholder="Cari Resi Kargo..."
                               class="w-56 lg:w-64 pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 text-xs font-mono font-medium focus:outline-none focus:ring-1 focus:ring-forest-600 bg-slate-50 focus:bg-white transition-all shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </form>

                    <a href="{{ route('track.public') }}" class="btn-brand-outline px-3.5 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Cek Resi</span>
                    </a>
                </div>
            </header>

            <!-- Alerts / Flash Messages -->
            <div class="px-4 sm:px-8 mt-4">
                @if(session('success'))
                    <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center gap-2.5 text-xs font-semibold shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-600 shrink-0"></span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('warning'))
                    <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-300 text-amber-900 flex items-center gap-2.5 text-xs font-semibold shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                        <span>{{ session('warning') }}</span>
                    </div>
                @endif
                @if(session('error') || (isset($errors) && $errors->any()))
                    <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-300 text-rose-900 text-xs font-semibold shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-rose-600 shrink-0"></span>
                            <div>
                                {{ session('error') ?? 'Silakan periksa formulir Anda.' }}
                                @if(isset($errors) && $errors->any())
                                    <ul class="list-disc list-inside mt-1 text-[11px] font-normal text-rose-800">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Main Page Slot -->
            <main class="flex-1 px-4 sm:px-8 py-6">
                @yield('content')
            </main>

            <!-- Workspace Footer -->
            <footer class="border-t border-slate-200 bg-white py-4 px-4 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div>
                    <strong class="text-slate-800 font-semibold">AgriLian CargoTrace</strong> &bull; Takengon &bull; Bireuen &bull; Belawan &bull; Singapore &bull; Rotterdam
                </div>
                <div>
                    &copy; 2026 AgriLian Logistics Systems &bull; <span class="text-slate-600 font-medium">Enterprise Multimodal Visibility</span>
                </div>
            </footer>
        </div>
    </div>

    <!-- Script Buka/Tutup Sidebar (Collapsible Persistence & Mobile Overlay) -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('app-sidebar');
            const mainContent = document.getElementById('main-content');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (!sidebar || !mainContent) return;

            const isClosed = sidebar.classList.contains('-translate-x-full');
            const isDesktop = window.innerWidth >= 1024;

            if (isClosed) {
                // Buka sidebar
                sidebar.classList.remove('-translate-x-full');
                if (isDesktop) {
                    mainContent.classList.remove('pl-0');
                    mainContent.classList.add('pl-64');
                    localStorage.setItem('cargotrace_sidebar_collapsed', 'false');
                } else if (backdrop) {
                    backdrop.classList.remove('hidden');
                }
            } else {
                // Tutup sidebar
                sidebar.classList.add('-translate-x-full');
                if (isDesktop) {
                    mainContent.classList.remove('pl-64');
                    mainContent.classList.add('pl-0');
                    localStorage.setItem('cargotrace_sidebar_collapsed', 'true');
                } else if (backdrop) {
                    backdrop.classList.add('hidden');
                }
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
                mainContent.classList.remove('pl-64');
                mainContent.classList.add('pl-0');
                if (backdrop) backdrop.classList.add('hidden');
            } else if (savedState === 'true') {
                sidebar.classList.add('-translate-x-full');
                mainContent.classList.remove('pl-64');
                mainContent.classList.add('pl-0');
            }
        });
    </script>

@else
    <!-- STANDALONE TOP-NAV LAYOUT (Public Tracker & Sign In) -->
    <div class="min-h-full flex flex-col">
        <!-- Top Nav Header -->
        <header class="bg-white border-b border-stone-200 sticky top-0 z-40 shadow-2xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 p-1 flex items-center justify-center border border-slate-200 shadow-2xs group-hover:scale-105 transition-transform shrink-0">
                            <img src="{{ asset('images/logo.jpg') }}" alt="AgriLian Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <span class="text-base font-bold text-slate-900 tracking-tight">AgriLian <span class="text-forest-600 font-extrabold">CargoTrace</span></span>
                            <span class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider font-mono">Highland Agro-Export Visibility</span>
                        </div>
                    </a>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('track.public') }}" class="btn-brand-outline px-3.5 py-1.5 rounded-lg text-xs font-semibold">
                            Cek Resi Kargo
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-brand-accent px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-1.5 cursor-pointer">
                                <span>Dashboard</span>
                                <span>&rarr;</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-brand-accent px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-1.5 cursor-pointer">
                                <span>Masuk</span>
                                <span>&rarr;</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash messages -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            @if(session('success'))
                <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center gap-2.5 text-xs font-semibold shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-600 shrink-0"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('warning'))
                <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-300 text-amber-900 flex items-center gap-2.5 text-xs font-semibold shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif
            @if(session('error') || (isset($errors) && $errors->any()))
                <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-300 text-rose-900 text-xs font-semibold shadow-2xs">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-rose-600 shrink-0"></span>
                        <div>
                            {{ session('error') ?? 'Silakan periksa formulir input.' }}
                            @if(isset($errors) && $errors->any())
                                <ul class="list-disc list-inside mt-1 text-[11px] font-normal text-rose-800">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
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
                    <span>Rantai Pasok Agro Dataran Tinggi Gayo ke Pasar Internasional</span>
                </div>
                <div>
                    &copy; 2026 AgriLian Logistics Systems &bull; <span class="text-slate-600 font-medium">Enterprise Multimodal Visibility</span>
                </div>
            </div>
        </footer>
    </div>
@endif

    @stack('scripts')
</body>
</html>
