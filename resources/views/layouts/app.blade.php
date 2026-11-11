<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F8FAF9]">
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
                            deep: '#1B4332',     /* Hijau Gelap Utama (Warna Awal) */
                            mid: '#2D6A4F',      /* Hijau Hutan Sedang */
                            leaf: '#40916C',     /* Hijau Daun Segar */
                            soft: '#74C69D',     /* Mint Lembut */
                            mint: '#95D5B2',     /* Hijau Muda Lembut (Warna Akhir) */
                            ice: '#D8F3DC',      /* Tint Sejuk */
                        },
                        accent: {
                            vibrant: '#57C84D',  /* Hijau Terang / Segar (Aksen) */
                            glow: '#4ade80',
                        },
                        slate: {
                            50: '#F8FAF9',       /* Background Lembut Adem di Mata */
                            100: '#F0F4F2',
                            200: '#E2E8E5',
                            300: '#CBD5D0',
                            400: '#94A39D',
                            500: '#64746F',
                            600: '#475551',
                            700: '#33413D',
                            800: '#1E2925',
                            900: '#0F1714',
                            950: '#060B09',
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

        /* Bespoke Agro-Industrial Gradients */
        .bg-brand-gradient {
            background: linear-gradient(135deg, #1B4332 0%, #2D6A4F 60%, #40916C 100%);
        }
        .bg-hero-gradient {
            background: linear-gradient(145deg, #0A1E16 0%, #1B4332 50%, #23543F 100%);
        }
        .bg-sidebar-gradient {
            background: linear-gradient(180deg, #1B4332 0%, #143527 60%, #0D2219 100%);
        }
        .bg-accent-gradient {
            background: linear-gradient(135deg, #57C84D 0%, #2D6A4F 100%);
        }
        .bg-mint-soft {
            background: linear-gradient(135deg, #F0FBF5 0%, #E2F7EC 100%);
        }

        /* Gradient Text (Automark Style) */
        .text-gradient-mint {
            background: linear-gradient(135deg, #95D5B2 0%, #57C84D 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .text-gradient-forest {
            background: linear-gradient(135deg, #1B4332 0%, #2D6A4F 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Buttons with tactile feedback */
        .btn-brand-primary {
            background: linear-gradient(135deg, #1B4332 0%, #2D6A4F 100%);
            color: #FFFFFF;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px -2px rgba(27, 67, 50, 0.4);
        }
        .btn-brand-primary:hover {
            background: linear-gradient(135deg, #2D6A4F 0%, #1B4332 100%);
            box-shadow: 0 6px 20px -2px rgba(27, 67, 50, 0.5);
            transform: translateY(-1px);
        }

        .btn-brand-accent {
            background: linear-gradient(135deg, #57C84D 0%, #40916C 100%);
            color: #071E14;
            font-weight: 800;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px -2px rgba(87, 200, 77, 0.45);
        }
        .btn-brand-accent:hover {
            filter: brightness(1.08);
            box-shadow: 0 6px 20px -2px rgba(87, 200, 77, 0.6);
            transform: translateY(-1px);
        }

        .btn-brand-outline {
            background: #FFFFFF;
            border: 1.5px solid #95D5B2;
            color: #1B4332;
            font-weight: 700;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-brand-outline:hover {
            background: #F0FBF5;
            border-color: #57C84D;
            transform: translateY(-1px);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F0F4F2;
        }
        ::-webkit-scrollbar-thumb {
            background: #CBD5D0;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #95D5B2;
        }
    </style>
</head>
<body class="h-full font-sans text-slate-800 antialiased selection:bg-[#1B4332] selection:text-[#95D5B2] bg-[#F8FAF9]">

@php
    $isPublicTracker = request()->routeIs('track.public') || request()->routeIs('home') || request()->routeIs('login');
    $useSidebar = auth()->check() && !$isPublicTracker;
@endphp

@if($useSidebar)
    <!-- ======================================================== -->
    <!-- AUTHENTICATED SIDEBAR LAYOUT (Dashboard, Shipments, CRUD) -->
    <!-- ======================================================== -->
    <div class="min-h-full flex">
        <!-- Sidebar Column (Deep Pine Gradient) -->
        <aside class="w-64 bg-sidebar-gradient text-white flex flex-col fixed inset-y-0 z-40 shadow-xl border-r border-[#1B4332]/40">
            <!-- Brand Logo Area -->
            <div class="h-18 flex items-center px-6 border-b border-white/10 bg-black/15">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#2D6A4F] to-[#1B4332] border border-[#95D5B2]/30 flex items-center justify-center text-white shadow-md shadow-black/20 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-[#57C84D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 leading-none">
                            <span class="text-base font-extrabold text-white tracking-tight">CargoTrace</span>
                        </div>
                        <span class="text-[11px] font-bold text-[#95D5B2] tracking-wider uppercase mt-1 block">
                            AgriLian Portal
                        </span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 px-3 py-5 space-y-6 overflow-y-auto">
                <!-- Group 1: Core Operations -->
                <div>
                    <div class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-[#95D5B2]/70 mb-2">
                        Operasional Ekspor
                    </div>
                    <nav class="space-y-1.5">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-white/15 to-white/5 text-white border-l-4 border-[#57C84D] shadow-sm' : 'text-[#95D5B2] hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-[#57C84D]' : 'text-[#95D5B2]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard Radar</span>
                        </a>

                        <a href="{{ route('shipments.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('shipments.index') || request()->routeIs('shipments.show') ? 'bg-gradient-to-r from-white/15 to-white/5 text-white border-l-4 border-[#57C84D] shadow-sm' : 'text-[#95D5B2] hover:text-white hover:bg-white/10' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('shipments.index') || request()->routeIs('shipments.show') ? 'text-[#57C84D]' : 'text-[#95D5B2]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <span>Manifes Kargo (Roster)</span>
                        </a>

                        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                            <a href="{{ route('shipments.create') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('shipments.create') ? 'bg-gradient-to-r from-white/15 to-white/5 text-white border-l-4 border-[#57C84D] shadow-sm' : 'text-[#95D5B2] hover:text-white hover:bg-white/10' }}">
                                <svg class="w-4 h-4 {{ request()->routeIs('shipments.create') ? 'text-[#57C84D]' : 'text-[#95D5B2]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>+ Buat Kargo Baru</span>
                            </a>
                        @endif
                    </nav>
                </div>

                <!-- Group 2: Public Portal & Links -->
                <div>
                    <div class="px-3 text-[10px] font-extrabold uppercase tracking-widest text-[#95D5B2]/70 mb-2">
                        Portal Publik
                    </div>
                    <nav class="space-y-1.5">
                        <a href="{{ route('track.public') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold text-[#95D5B2] hover:text-white hover:bg-white/10 transition-all group">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-[#95D5B2] group-hover:text-[#57C84D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <span>Cek Resi Publik</span>
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
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#57C84D] to-[#2D6A4F] text-[#0A2016] flex items-center justify-center font-black text-xs shrink-0 shadow-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-extrabold text-white truncate">{{ auth()->user()->name }}</div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#57C84D] animate-pulse"></span>
                                <span class="text-[10px] font-semibold text-[#95D5B2] uppercase tracking-wider">{{ auth()->user()->role }}</span>
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

        <!-- Right Main Workspace -->
        <div class="flex-1 pl-64 flex flex-col min-h-screen">
            <!-- Top Header Bar (Crisp White + Fine Border) -->
            <header class="h-18 bg-white border-b border-slate-200/80 flex items-center justify-between px-6 sm:px-8 sticky top-0 z-30 shadow-2xs">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-extrabold text-[#1B4332] font-mono">Takengon Highland Central Hub</span>
                    <span class="text-slate-300">•</span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1B4332] bg-[#F0FBF5] px-2.5 py-1 rounded-full border border-[#95D5B2]/60">
                        <span class="w-2 h-2 rounded-full bg-[#57C84D] animate-pulse"></span>
                        Koridor Ekspor Aktif
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('track.public') }}" class="btn-brand-outline px-3.5 py-1.5 rounded-xl text-xs flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-[#1B4332]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Cari Resi Publik</span>
                    </a>
                </div>
            </header>

            <!-- Alerts / Flash Messages -->
            <div class="px-6 sm:px-8 mt-4">
                @if(session('success'))
                    <div class="p-3.5 rounded-xl bg-[#F0FBF5] border border-[#95D5B2] text-[#1B4332] flex items-center gap-2.5 text-xs font-bold shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-[#57C84D] shrink-0"></span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('warning'))
                    <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-300 text-amber-900 flex items-center gap-2.5 text-xs font-bold shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                        <span>{{ session('warning') }}</span>
                    </div>
                @endif
                @if(session('error') || (isset($errors) && $errors->any()))
                    <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-300 text-rose-900 text-xs font-bold shadow-2xs">
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
            <main class="flex-1 px-6 sm:px-8 py-6">
                @yield('content')
            </main>

            <!-- Workspace Footer -->
            <footer class="border-t border-slate-200 bg-white py-4 px-6 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div>
                    <strong class="text-[#1B4332] font-bold">CargoTrace AgriLian</strong> &bull; Takengon &bull; Bireuen &bull; Belawan &bull; Singapore &bull; Rotterdam
                </div>
                <div>
                    Annisa Liandes (Ayaa) &bull; <strong class="text-slate-700">Universitas Malikussaleh (Unimal)</strong>
                </div>
            </footer>
        </div>
    </div>

@else
    <!-- ======================================================== -->
    <!-- STANDALONE TOP-NAV LAYOUT (For Public Tracker & Sign In) -->
    <!-- ======================================================== -->
    <div class="min-h-full flex flex-col">
        <!-- Top Nav Header (Automark Inspired Clean Pill Bar) -->
        <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-40 shadow-2xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-18">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#1B4332] to-[#2D6A4F] border border-[#95D5B2]/40 flex items-center justify-center text-white shadow-md shadow-[#1B4332]/20 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5 text-[#57C84D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-base font-extrabold text-[#1B4332] tracking-tight">CargoTrace <span class="text-[#2D6A4F]">AgriLian</span></span>
                            <span class="block text-[10px] font-bold text-[#40916C] uppercase tracking-wider">Highland Agro-Export Visibility</span>
                        </div>
                    </a>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('track.public') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold text-[#1B4332] bg-[#F0FBF5] border border-[#95D5B2]/60 hover:bg-[#E2F7EC] transition-colors">
                            Cek Resi Kargo
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-brand-primary px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2">
                                <span>Masuk Dashboard</span>
                                <span>&rarr;</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-brand-primary px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2">
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
                <div class="p-3.5 rounded-xl bg-[#F0FBF5] border border-[#95D5B2] text-[#1B4332] flex items-center gap-2.5 text-xs font-bold shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-[#57C84D] shrink-0"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('warning'))
                <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-300 text-amber-900 flex items-center gap-2.5 text-xs font-bold shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif
            @if(session('error') || (isset($errors) && $errors->any()))
                <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-300 text-rose-900 text-xs font-bold shadow-2xs">
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
                    <strong class="text-[#1B4332] font-bold">CargoTrace AgriLian</strong>
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
