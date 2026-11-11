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
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        },
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
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

        /* Sleek scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="h-full font-sans text-slate-800 antialiased selection:bg-emerald-600 selection:text-white bg-slate-50">

@php
    $isPublicTracker = request()->routeIs('track.public') || request()->routeIs('home') || request()->routeIs('login');
    $useSidebar = auth()->check() && !$isPublicTracker;
@endphp

@if($useSidebar)
    <!-- ======================================================== -->
    <!-- SIDEBAR LAYOUT (For Dashboard, Shipments, Admin & Operator)-->
    <!-- ======================================================== -->
    <div class="min-h-full flex">
        <!-- Sidebar Column -->
        <aside class="w-64 bg-white border-r border-slate-200 flex flex-col fixed inset-y-0 z-40 transition-transform">
            <!-- Brand Logo Area -->
            <div class="h-16 flex items-center px-6 border-b border-slate-100">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center text-white shadow-sm shadow-emerald-600/30 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 leading-none">
                            <span class="text-base font-extrabold text-slate-900 tracking-tight">CargoTrace</span>
                        </div>
                        <span class="text-[11px] font-bold text-emerald-600 tracking-wide uppercase mt-0.5 block">
                            AgriLian Portal
                        </span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 px-4 py-5 space-y-6 overflow-y-auto">
                <!-- Group 1: Core Operations -->
                <div>
                    <div class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">
                        Core Operations
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-700 shadow-2xs font-extrabold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-emerald-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard Radar</span>
                        </a>

                        <a href="{{ route('shipments.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('shipments.index') || request()->routeIs('shipments.show') ? 'bg-emerald-50 text-emerald-700 shadow-2xs font-extrabold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('shipments.index') || request()->routeIs('shipments.show') ? 'text-emerald-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <span>Shipments Roster</span>
                        </a>

                        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                            <a href="{{ route('shipments.create') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('shipments.create') ? 'bg-emerald-50 text-emerald-700 shadow-2xs font-extrabold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                <svg class="w-4 h-4 {{ request()->routeIs('shipments.create') ? 'text-emerald-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>+ New Consignment</span>
                            </a>
                        @endif
                    </nav>
                </div>

                <!-- Group 2: Public Portal & Telemetry -->
                <div>
                    <div class="px-3 text-[10px] font-extrabold uppercase tracking-wider text-slate-400 mb-2">
                        External Links
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('track.public') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-all">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <span>Public Waybill Tracker</span>
                            </div>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- User Profile & Sign Out Footer in Sidebar -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/70">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-extrabold text-slate-900 truncate leading-snug">{{ auth()->user()->name }}</div>
                            <span class="inline-block text-[10px] font-bold uppercase tracking-wider text-emerald-700">
                                {{ auth()->user()->role }}
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Logout" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-white transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Right Main Workspace -->
        <div class="flex-1 pl-64 flex flex-col min-h-screen">
            <!-- Top Header Bar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sm:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-slate-400 font-mono">Takengon Central Logistics Hub</span>
                    <span class="text-slate-300">&bull;</span>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Live Corridor Active
                    </span>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('track.public') }}" class="text-xs font-bold text-slate-600 hover:text-emerald-700 flex items-center gap-1.5 transition-colors">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Cek Resi</span>
                    </a>
                </div>
            </header>

            <!-- Alerts -->
            <div class="px-6 sm:px-8 mt-4">
                @if(session('success'))
                    <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center gap-2.5 text-xs font-semibold shadow-2xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 shrink-0"></span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('warning'))
                    <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 flex items-center gap-2.5 text-xs font-semibold shadow-2xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0"></span>
                        <span>{{ session('warning') }}</span>
                    </div>
                @endif
                @if(session('error') || (isset($errors) && $errors->any()))
                    <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-semibold shadow-2xs">
                        <div class="flex items-center gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-600 shrink-0"></span>
                            <div>
                                {{ session('error') ?? 'Please check the form inputs.' }}
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

            <!-- Footer -->
            <footer class="border-t border-slate-200 bg-white py-4 px-6 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div>
                    <strong class="text-slate-800 font-bold">CargoTrace AgriLian</strong> &bull; Takengon &bull; Belawan &bull; Singapore &bull; Rotterdam
                </div>
                <div>
                    Annisa Liandes (Ayaa) &bull; <strong class="text-slate-700">Universitas Malikussaleh</strong>
                </div>
            </footer>
        </div>
    </div>

@else
    <!-- ======================================================== -->
    <!-- STANDALONE TOP-NAV LAYOUT (For Public Tracker & Sign In) -->
    <!-- ======================================================== -->
    <div class="min-h-full flex flex-col">
        <!-- Top Nav Header -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center text-white shadow-sm shadow-emerald-600/30 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-base font-extrabold text-slate-900 tracking-tight">CargoTrace <span class="text-emerald-600">AgriLian</span></span>
                            <span class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Highland Agro-Export Visibility</span>
                        </div>
                    </a>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('track.public') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200">
                            Cargo Radar
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg text-xs font-bold bg-slate-900 text-white hover:bg-black transition-colors shadow-xs">
                                Masuk Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-xs font-bold bg-slate-900 text-white hover:bg-black transition-colors shadow-xs">
                                Sign In
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
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 shrink-0"></span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('warning'))
                <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 flex items-center gap-2.5 text-xs font-semibold shadow-2xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0"></span>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif
            @if(session('error') || (isset($errors) && $errors->any()))
                <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-semibold shadow-2xs">
                    <div class="flex items-center gap-2.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600 shrink-0"></span>
                        <div>
                            {{ session('error') ?? 'Please check the form inputs.' }}
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
                    <strong class="text-slate-800 font-bold">CargoTrace AgriLian</strong>
                    <span>&bull;</span>
                    <span>Rantai Pasok Agro Dataran Tinggi Gayo ke Pasar Internasional</span>
                </div>
                <div>
                    Annisa Liandes &bull; <strong class="text-slate-700">Universitas Malikussaleh (Unimal)</strong>
                </div>
            </div>
        </footer>
    </div>
@endif

    @stack('scripts')
</body>
</html>
