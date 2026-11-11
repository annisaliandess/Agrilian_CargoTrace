<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CargoTrace AgriLian') }} — @yield('title', 'Highland Agro-Export Platform')</title>

    <!-- Plus Jakarta Sans & JetBrains Mono Fonts (Supreme Readability) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|jetbrains-mono:400,500,600" rel="stylesheet" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Tailwind CSS (Instant CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pine: {
                            deep: '#1B4332',     /* Forest Pine Utama */
                            mid: '#2D6A4F',
                            leaf: '#40916C',
                            soft: '#74C69D',
                            mint: '#95D5B2',
                            ice: '#D8F3DC',
                        },
                        accent: {
                            vibrant: '#57C84D',
                            glow: '#4ade80',
                        },
                        slate: {
                            50: '#F8FAFC',
                            100: '#F1F5F9',
                            200: '#E2E8F0',
                            300: '#CBD5E1',
                            400: '#94A3B8',
                            500: '#64748B',
                            600: '#475569',
                            700: '#334155',
                            800: '#1E293B',
                            900: '#0F172A',
                            950: '#020617',
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
        svg {
            display: inline-block;
            vertical-align: middle;
            flex-shrink: 0;
        }
        svg.w-6 { width: 24px !important; height: 24px !important; }
        svg.w-5 { width: 20px !important; height: 20px !important; }
        svg.w-4 { width: 16px !important; height: 16px !important; }
        svg.w-3\.5 { width: 14px !important; height: 14px !important; }

        /* Subtle Enterprise Gradients */
        .bg-sidebar-gradient {
            background: linear-gradient(180deg, #1B4332 0%, #153829 60%, #0F281E 100%);
        }
        .bg-hero-gradient {
            background: linear-gradient(145deg, #0F281E 0%, #1B4332 55%, #245841 100%);
        }

        /* Buttons with tactile feedback */
        .btn-brand-primary {
            background: linear-gradient(135deg, #1B4332 0%, #2D6A4F 100%);
            color: #FFFFFF;
            transition: all 0.15s ease-in-out;
            box-shadow: 0 1px 3px 0 rgba(27, 67, 50, 0.2);
        }
        .btn-brand-primary:hover {
            background: linear-gradient(135deg, #245841 0%, #1B4332 100%);
            box-shadow: 0 4px 12px 0 rgba(27, 67, 50, 0.3);
            transform: translateY(-0.5px);
        }

        .btn-brand-outline {
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            color: #1E293B;
            font-weight: 600;
            transition: all 0.15s ease-in-out;
        }
        .btn-brand-outline:hover {
            background: #F8FAFC;
            border-color: #94A3B8;
            color: #0F172A;
        }

        /* Sleek scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
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
<body class="h-full font-sans text-slate-800 antialiased selection:bg-[#1B4332] selection:text-white bg-slate-50">

@php
    $isPublicTracker = request()->routeIs('track.public') || request()->routeIs('home') || request()->routeIs('login');
    $useSidebar = auth()->check() && !$isPublicTracker;
@endphp

@if($useSidebar)
    <!-- ======================================================== -->
    <!-- AUTHENTICATED COLLAPSIBLE SIDEBAR LAYOUT                 -->
    <!-- ======================================================== -->
    <div class="min-h-full flex relative overflow-x-hidden">

        <!-- Sidebar Column (Bisa Dibuka dan Ditutup) -->
        <aside id="app-sidebar" class="w-64 bg-sidebar-gradient text-white flex flex-col fixed inset-y-0 left-0 z-40 shadow-xl border-r border-[#1B4332]/40 transition-transform duration-300 ease-in-out">
            <!-- Brand Logo Area + Internal Close Button -->
            <div class="h-16 flex items-center justify-between px-5 border-b border-white/10 bg-black/15">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#2D6A4F] to-[#1B4332] border border-[#95D5B2]/30 flex items-center justify-center text-white shadow-md shadow-black/20 group-hover:scale-105 transition-transform shrink-0">
                        <svg class="w-5 h-5 text-[#95D5B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <span class="text-sm font-bold text-white tracking-tight block leading-tight">CargoTrace</span>
                        <span class="text-[10px] font-semibold text-[#95D5B2] tracking-wider uppercase block mt-0.5">AgriLian Portal</span>
                    </div>
                </a>

                <!-- Tombol Tutup Sidebar di Dalam -->
                <button type="button" onclick="toggleSidebar()" title="Sembunyikan menu" class="p-1.5 rounded-lg text-[#95D5B2] hover:text-white hover:bg-white/10 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 px-3 py-5 space-y-6 overflow-y-auto">
                <!-- Group 1: Core Operations -->
                <div>
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-[#95D5B2]/70 mb-2">
                        Operasional Ekspor
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-white/15 text-white border-l-4 border-[#57C84D] shadow-sm font-bold' : 'text-[#95D5B2] hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-[#57C84D]' : 'text-[#95D5B2]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard Radar</span>
                        </a>

                        <a href="{{ route('shipments.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('shipments.index') || request()->routeIs('shipments.show') ? 'bg-white/15 text-white border-l-4 border-[#57C84D] shadow-sm font-bold' : 'text-[#95D5B2] hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('shipments.index') || request()->routeIs('shipments.show') ? 'text-[#57C84D]' : 'text-[#95D5B2]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <span>Manifes Kargo (Roster)</span>
                        </a>

                        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                            <a href="{{ route('shipments.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('shipments.create') ? 'bg-white/15 text-white border-l-4 border-[#57C84D] shadow-sm font-bold' : 'text-[#95D5B2] hover:text-white hover:bg-white/10' }}">
                                <svg class="w-4 h-4 {{ request()->routeIs('shipments.create') ? 'text-[#57C84D]' : 'text-[#95D5B2]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>+ Buat Manifest Baru</span>
                            </a>
                        @endif
                    </nav>
                </div>

                <!-- Group 2: Public Portal -->
                <div>
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-[#95D5B2]/70 mb-2">
                        Portal Publik
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('track.public') }}" target="_blank" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-[#95D5B2] hover:text-white hover:bg-white/10 transition-all group">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-[#95D5B2] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <span>Halaman Cek Resi</span>
                            </span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-white/15 text-[#95D5B2] group-hover:text-white">↗</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- User Profile Box & Logout (Bottom of Sidebar) -->
            <div class="p-3 border-t border-white/10 bg-black/20">
                <div class="flex items-center justify-between p-2 rounded-xl bg-white/5 border border-white/10">
                    <div class="flex items-center gap-2.5 overflow-hidden">
                        <div class="w-8 h-8 rounded-lg bg-[#2D6A4F] text-white flex items-center justify-center font-bold text-xs shrink-0 border border-[#95D5B2]/40">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#57C84D]"></span>
                                <span class="text-[10px] font-medium text-[#95D5B2] uppercase tracking-wider">{{ auth()->user()->role }}</span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Keluar dari akun" class="p-1.5 rounded-lg text-[#95D5B2] hover:text-white hover:bg-white/15 transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Right Main Workspace (Lebar menyesuaikan saat sidebar ditutup) -->
        <div id="main-content" class="flex-1 pl-64 flex flex-col min-h-screen transition-all duration-300 ease-in-out">
            <!-- Top Header Bar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30 shadow-2xs">
                <div class="flex items-center gap-3">
                    <!-- Tombol Buka / Tutup Sidebar (Hamburger Toggle) -->
                    <button type="button" onclick="toggleSidebar()" id="sidebar-toggle-btn" title="Buka / Tutup Menu Navigasi"
                            class="p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors cursor-pointer border border-slate-200 shadow-2xs flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span class="text-xs font-semibold hidden md:inline text-slate-600" id="sidebar-toggle-text">Menu</span>
                    </button>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-700 font-mono hidden sm:inline">Takengon Central Logistics Hub</span>
                        <span class="text-slate-300 hidden sm:inline">•</span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                            Koridor Ekspor Aktif
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('track.public') }}" class="btn-brand-outline px-3.5 py-1.5 rounded-xl text-xs flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Cek Resi Publik</span>
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
                    <strong class="text-slate-800 font-semibold">CargoTrace AgriLian</strong> &bull; Takengon &bull; Bireuen &bull; Belawan &bull; Singapore &bull; Rotterdam
                </div>
                <div>
                    Annisa Liandes (Ayaa) &bull; <strong class="text-slate-700">Universitas Malikussaleh (Unimal)</strong>
                </div>
            </footer>
        </div>
    </div>

    <!-- Script Buka/Tutup Sidebar (Collapsible Persistence) -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('app-sidebar');
            const mainContent = document.getElementById('main-content');
            if (!sidebar || !mainContent) return;

            const isClosed = sidebar.classList.contains('-translate-x-full');

            if (isClosed) {
                // Buka sidebar
                sidebar.classList.remove('-translate-x-full');
                mainContent.classList.remove('pl-0');
                mainContent.classList.add('pl-64');
                localStorage.setItem('cargotrace_sidebar_collapsed', 'false');
            } else {
                // Tutup sidebar
                sidebar.classList.add('-translate-x-full');
                mainContent.classList.remove('pl-64');
                mainContent.classList.add('pl-0');
                localStorage.setItem('cargotrace_sidebar_collapsed', 'true');
            }
        }

        // Terapkan preferensi buka/tutup saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('app-sidebar');
            const mainContent = document.getElementById('main-content');
            if (!sidebar || !mainContent) return;

            // Di layar mobile selalu tutup awal, di desktop ikuti localStorage
            const isMobile = window.innerWidth < 1024;
            const savedState = localStorage.getItem('cargotrace_sidebar_collapsed');

            if (isMobile || savedState === 'true') {
                sidebar.classList.add('-translate-x-full');
                mainContent.classList.remove('pl-64');
                mainContent.classList.add('pl-0');
            }
        });
    </script>

@else
    <!-- ======================================================== -->
    <!-- STANDALONE TOP-NAV LAYOUT (Public Tracker & Sign In)     -->
    <!-- ======================================================== -->
    <div class="min-h-full flex flex-col">
        <!-- Top Nav Header -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-2xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#1B4332] to-[#2D6A4F] border border-[#95D5B2]/40 flex items-center justify-center text-white shadow-sm shadow-[#1B4332]/20 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5 text-[#95D5B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-base font-bold text-slate-900 tracking-tight">CargoTrace <span class="text-[#1B4332]">AgriLian</span></span>
                            <span class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Highland Agro-Export Visibility</span>
                        </div>
                    </a>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('track.public') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 border border-slate-200 hover:bg-slate-200 transition-colors">
                            Cek Resi Kargo
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-brand-primary px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5">
                                <span>Dashboard</span>
                                <span>&rarr;</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-brand-primary px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5">
                                <span>Login Staff</span>
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
                    <strong class="text-slate-800 font-semibold">CargoTrace AgriLian</strong>
                    <span>&bull;</span>
                    <span>Rantai Pasok Agro Dataran Tinggi Gayo ke Pasar Internasional</span>
                </div>
                <div>
                    Annisa Liandes (Ayaa) &bull; <strong class="text-slate-700">Universitas Malikussaleh (Unimal)</strong>
                </div>
            </div>
        </footer>
    </div>
@endif

    @stack('scripts')
</body>
</html>
