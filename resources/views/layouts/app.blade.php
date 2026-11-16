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
                        {{ app()->getLocale() === 'en' ? 'Export Operations' : 'Operasional Ekspor' }}
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-forest-500/30 text-white border-l-4 border-forest-200 shadow-sm font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-forest-200' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>{{ app()->getLocale() === 'en' ? 'Radar Dashboard' : 'Dasbor Radar' }}</span>
                        </a>

                        <a href="{{ route('shipments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('shipments.index') || request()->routeIs('shipments.show') ? 'bg-forest-500/30 text-white border-l-4 border-forest-200 shadow-sm font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('shipments.index') || request()->routeIs('shipments.show') ? 'text-forest-200' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <span>{{ app()->getLocale() === 'en' ? 'Cargo Manifests' : 'Manifes Kargo' }}</span>
                        </a>

                        <a href="{{ route('commodities.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('commodities.index') ? 'bg-forest-500/30 text-white border-l-4 border-forest-200 shadow-sm font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('commodities.index') ? 'text-forest-200' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            <span>{{ app()->getLocale() === 'en' ? 'Commodities & Fleet' : 'Komoditas & Armada' }}</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- User Profile Box & Logout (Bottom of Sidebar) -->
            <div class="p-3 border-t border-forest-800 bg-black/40">
                <div class="flex items-center justify-between p-2 rounded-xl bg-white/5 border border-forest-800">
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
                        <button type="submit" title="{{ $isEn ? 'Sign out' : 'Keluar dari akun' }}" class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/15 transition-colors cursor-pointer">
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
                        <span class="text-xs font-bold text-slate-800 font-mono hidden sm:inline">{{ app()->getLocale() === 'en' ? 'Takengon Central Logistics Hub' : 'Pusat Hub Logistik Takengon' }}</span>
                        <span class="text-slate-300 hidden sm:inline">•</span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            {{ app()->getLocale() === 'en' ? 'Telemetry System Online' : 'Sistem Telemetri Aktif' }}
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

                    <a href="{{ route('track.public') }}" class="btn-brand-outline px-3.5 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-2">
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
            <main class="flex-1 px-4 sm:px-8 py-6">
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
                            <span class="block text-[10px] font-semibold text-slate-500 uppercase tracking-wider font-mono">{{ app()->getLocale() === 'en' ? 'Highland Agro-Export Visibility' : 'Visibilitas Ekspor Agro Dataran Tinggi' }}</span>
                        </div>
                    </a>

                    <div class="flex items-center gap-3">
                        <!-- Language Switcher Pills (ID / EN) -->
                        <div class="flex items-center bg-slate-100 rounded-lg p-0.5 border border-slate-200 text-[11px] font-bold font-mono">
                            <a href="{{ route('lang.switch', 'id') }}" title="Bahasa Indonesia"
                               class="px-2 py-1 rounded-md transition-all {{ app()->getLocale() === 'id' ? 'bg-[#0B2B26] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">ID</a>
                            <a href="{{ route('lang.switch', 'en') }}" title="English"
                               class="px-2 py-1 rounded-md transition-all {{ app()->getLocale() === 'en' ? 'bg-[#0B2B26] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">EN</a>
                        </div>

                        <a href="{{ route('track.public') }}" class="btn-brand-outline px-3.5 py-1.5 rounded-lg text-xs font-semibold">
                            {{ app()->getLocale() === 'en' ? 'Track Waybill' : 'Cek Resi Kargo' }}
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-brand-accent px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-1.5 cursor-pointer">
                                <span>Dashboard</span>
                                <span>&rarr;</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-brand-accent px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-1.5 cursor-pointer">
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
