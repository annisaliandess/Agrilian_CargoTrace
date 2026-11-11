<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#FAF9F6]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CargoTrace AgriLian') }} — @yield('title', 'Highland Agro-Export Visibility')</title>

    <!-- Typography: Instrument Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|jetbrains-mono:400,500,600" rel="stylesheet" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Tailwind CSS (Instant CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        espresso: {
                            800: '#292524',
                            900: '#1c1917',
                            950: '#0c0a09',
                        },
                        canopy: {
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                            950: '#052e16',
                        },
                        parchment: {
                            50: '#fafaf9',
                            100: '#f5f5f4',
                            200: '#e7e5e4',
                            300: '#d6d3d1',
                        },
                        ochre: {
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                        }
                    },
                    fontFamily: {
                        sans: ['"Instrument Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
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

        /* Custom subtle scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f5f5f4;
        }
        ::-webkit-scrollbar-thumb {
            background: #d6d3d1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a29e;
        }
    </style>
</head>
<body class="h-full flex flex-col font-sans text-stone-800 antialiased selection:bg-canopy-800 selection:text-white bg-[#FAF9F6]">

    <!-- Top Utility Metadata Strip -->
    <div class="bg-espresso-950 text-stone-300 text-[11px] border-b border-stone-800 py-1.5 px-4 sm:px-8">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1.5 font-medium text-stone-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>Highland Agro-Corridor: Takengon &bull; Belawan &bull; Singapore &bull; Rotterdam</span>
                </span>
                <span class="hidden md:inline text-stone-500">|</span>
                <span class="hidden md:inline text-stone-400 font-mono text-[10px]">OpenWeather Live Node: 4.6293°N, 96.8458°E</span>
            </div>
            <div class="flex items-center gap-4 text-[10px] font-mono text-stone-400">
                <span>SYSTEM VERSION 1.2</span>
                <span class="hidden sm:inline text-stone-500">&bull;</span>
                <span class="hidden sm:inline text-stone-300">Unimal Web Programming 2</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-sm border-b border-stone-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand Title -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-lg bg-espresso-900 border border-stone-700 flex items-center justify-center text-white shadow-xs group-hover:bg-canopy-900 transition-colors shrink-0">
                            <!-- Clean minimal cargo seal icon -->
                            <svg class="w-5 h-5 text-stone-200 group-hover:text-emerald-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-base font-bold tracking-tight text-espresso-950">CargoTrace</span>
                                <span class="font-mono text-xs font-semibold px-1.5 py-0.5 rounded bg-stone-100 text-canopy-900 border border-stone-200">AgriLian</span>
                            </div>
                            <span class="block text-[10px] tracking-wider uppercase font-medium text-stone-500">
                                Multimodal Agro-Export Platform
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="flex items-center gap-1 sm:gap-3">
                    <a href="{{ route('track.public') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ request()->routeIs('track.public') ? 'bg-stone-900 text-white' : 'text-stone-600 hover:text-stone-900 hover:bg-stone-100' }}">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Cargo Radar
                        </span>
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ request()->routeIs('dashboard') ? 'bg-stone-900 text-white' : 'text-stone-600 hover:text-stone-900 hover:bg-stone-100' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('shipments.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ request()->routeIs('shipments.*') ? 'bg-stone-900 text-white' : 'text-stone-600 hover:text-stone-900 hover:bg-stone-100' }}">
                            Consignments
                        </a>

                        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                            <a href="{{ route('shipments.create') }}" class="hidden sm:inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-canopy-800 text-white hover:bg-canopy-900 transition-colors shadow-xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>+ New Manifest</span>
                            </a>
                        @endif

                        <!-- User Profile Badge & Logout -->
                        <div class="flex items-center gap-2 pl-3 border-l border-stone-200">
                            <div class="text-right hidden sm:block">
                                <div class="text-xs font-bold text-stone-900 leading-tight">{{ auth()->user()->name }}</div>
                                <span class="inline-block font-mono text-[9px] uppercase tracking-wider font-semibold px-1 py-0.2 rounded bg-stone-100 text-stone-600 border border-stone-200">
                                    {{ auth()->user()->role }}
                                </span>
                            </div>

                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" title="Logout" class="p-1.5 rounded-lg text-stone-400 hover:text-rose-700 hover:bg-stone-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold bg-espresso-900 text-white hover:bg-black transition-colors shadow-xs">
                            Sign In
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Flash Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-3.5 rounded-lg bg-emerald-50/80 border border-emerald-200 text-emerald-950 flex items-center justify-between text-xs shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 shrink-0"></span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="p-3.5 rounded-lg bg-amber-50/80 border border-amber-200 text-amber-950 flex items-center justify-between text-xs shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0"></span>
                    <span class="font-medium">{{ session('warning') }}</span>
                </div>
            </div>
        @endif

        @if(session('error') || (isset($errors) && $errors->any()))
            <div class="p-3.5 rounded-lg bg-rose-50/80 border border-rose-200 text-rose-950 text-xs shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-600 shrink-0"></span>
                    <div class="font-medium">
                        {{ session('error') ?? 'Please check the entered form parameters.' }}
                        @if(isset($errors) && $errors->any())
                            <ul class="list-disc list-inside mt-1 text-[11px] text-rose-800 space-y-0.5">
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

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <!-- Refined Footer -->
    <footer class="mt-auto border-t border-stone-200 bg-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-stone-500">
            <div class="flex flex-wrap items-center gap-2">
                <strong class="text-stone-800 font-semibold">CargoTrace AgriLian</strong>
                <span class="text-stone-300">&bull;</span>
                <span>Takengon &bull; Bireuen &bull; Belawan &bull; Singapore &bull; Rotterdam</span>
            </div>
            <div class="flex items-center gap-3 text-[11px]">
                <span>Designed by <strong class="text-stone-700">Annisa Liandes</strong> &bull; Universitas Malikussaleh</span>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
