@extends('layouts.app')

@section('title', 'Kargo ' . $shipment->tracking_number)

@section('content')
<div class="space-y-6">

    <!-- Top Action & Waybill Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            @php
                $isCoffee = str_contains(strtolower($shipment->cargo_type), 'arabica') || str_contains(strtolower($shipment->cargo_type), 'coffee');
                $isHorti = str_contains(strtolower($shipment->cargo_type), 'avocado') || str_contains(strtolower($shipment->cargo_type), 'chili');
            @endphp

            <div class="flex items-center gap-2 mb-1.5">
                @if($isCoffee)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200">
                        ☕ Kopi Arabika Gayo Specialty
                    </span>
                @elseif($isHorti)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-900 border border-emerald-200">
                        🥑 Hortikultura Rantai Dingin
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200">
                        📦 Komoditas Pertanian
                    </span>
                @endif
                <span class="text-xs font-bold text-slate-500">&bull; {{ $shipment->carrier->name }}</span>
            </div>

            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-black text-slate-900 font-mono tracking-tight">{{ $shipment->tracking_number }}</h1>
                <a href="{{ route('track.public', $shipment->tracking_number) }}" target="_blank" class="px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors flex items-center gap-1.5">
                    <span>Lihat Halaman Publik</span>
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
            <p class="text-xs text-slate-600 mt-1 font-medium">
                Pembeli: <strong class="text-slate-900">{{ $shipment->customer->name ?? 'Confidential' }}</strong> &bull; Komoditas: <strong class="text-slate-900">{{ $shipment->cargo_type }}</strong>
            </p>
        </div>

        <!-- Badges -->
        <div class="flex flex-wrap items-center gap-2">
            @php
                $badgeStyle = match($shipment->status) {
                    'CREATED' => 'bg-slate-100 text-slate-800 border-slate-300',
                    'BOOKED' => 'bg-blue-50 text-blue-900 border-blue-200',
                    'PICKED_UP' => 'bg-amber-50 text-amber-900 border-amber-200',
                    'IN_TRANSIT' => 'bg-emerald-50 text-emerald-800 border-emerald-300 animate-pulse',
                    'DELIVERED' => 'bg-emerald-600 text-white border-emerald-600',
                    default => 'bg-slate-100 text-slate-800',
                };
            @endphp
            <span class="px-4 py-1.5 rounded-xl text-xs font-black uppercase tracking-wider border {{ $badgeStyle }}">
                {{ $shipment->status }}
            </span>

            @if($shipment->is_delayed)
                <span class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-amber-50 text-amber-900 border border-amber-300 flex items-center gap-1.5">
                    ⚠️ Tertunda +{{ $shipment->delay_duration_hours }} Jam ({{ $shipment->delay_severity }})
                </span>
            @endif
        </div>
    </div>

    <!-- Main Grid: 2 Cols Left, 1 Col Right -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Stepper, Map, Operator Panel, Timeline -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Stepper Progress Bar Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 text-xs">
                    <span class="text-slate-400 font-extrabold uppercase text-[10px] tracking-wider">Status Perjalanan Kargo</span>
                    <span class="text-slate-900 font-bold">{{ $shipment->origin->city }} &rarr; {{ $shipment->destination->city }}</span>
                </div>

                @php
                    $steps = ['CREATED', 'BOOKED', 'PICKED_UP', 'IN_TRANSIT', 'DELIVERED'];
                    $currentIdx = array_search($shipment->status, $steps);
                    if ($currentIdx === false) $currentIdx = 0;
                @endphp

                <div class="grid grid-cols-5 gap-2 mt-4">
                    @foreach($steps as $idx => $step)
                        <div>
                            <div class="h-2 rounded-full transition-colors {{ $idx <= $currentIdx ? 'bg-emerald-600' : 'bg-slate-200' }}"></div>
                            <div class="mt-2 text-center">
                                <span class="text-[10px] font-extrabold uppercase tracking-wide block {{ $idx <= $currentIdx ? 'text-slate-900' : 'text-slate-400' }}">
                                    {{ str_replace('_', ' ', $step) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Map Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3 px-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                        <h3 class="text-sm font-extrabold text-slate-900">Peta Rute Multimodal Pelayaran & Darat</h3>
                    </div>
                    <span class="text-xs text-slate-400 font-medium">Leaflet.js &bull; OpenStreetMap</span>
                </div>
                <div id="shipment-map" class="w-full h-80 rounded-xl border border-slate-200"></div>
            </div>

            <!-- Operator Control Panel (Admin & Operator only) -->
            @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-6">
                    <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                        <h3 class="text-sm font-black uppercase tracking-wider text-slate-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                            Panel Kendali Operator & Dispatch
                        </h3>
                        <span class="text-xs font-bold text-slate-400">Hak Akses: {{ auth()->user()->role }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- 1. Status Transition Form -->
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <h4 class="text-xs font-black uppercase tracking-wider text-slate-800 mb-1">1. Majukan Status Kargo</h4>
                            <p class="text-[11px] text-slate-500 mb-3 font-medium">Service layer memvalidasi urutan siklus secara ketat (CREATED &rarr; BOOKED &rarr; PICKED UP &rarr; IN TRANSIT &rarr; DELIVERED).</p>

                            @php
                                $allowedMap = [
                                    'CREATED' => ['BOOKED'],
                                    'BOOKED' => ['PICKED_UP'],
                                    'PICKED_UP' => ['IN_TRANSIT'],
                                    'IN_TRANSIT' => ['DELIVERED'],
                                    'DELIVERED' => [],
                                ];
                                $allowed = $allowedMap[$shipment->status] ?? [];
                            @endphp

                            @if(count($allowed) > 0)
                                <form action="{{ route('shipments.status', $shipment->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Status Valid Selanjutnya</label>
                                        <select name="status" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-extrabold text-slate-900">
                                            @foreach($allowed as $target)
                                                <option value="{{ $target }}">{{ $target }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Checkpoint Terkait</label>
                                        <select name="location_id" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-semibold">
                                            @foreach($locations as $l)
                                                <option value="{{ $l->id }}" {{ $shipment->current_location_id == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <input type="text" name="notes" placeholder="Catatan operator (misal: Kontainer dimuat di Belawan)..." class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-medium">
                                    </div>
                                    <button type="submit" class="w-full py-2.5 px-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-xs transition-colors cursor-pointer">
                                        Perbarui Status Kargo &rarr;
                                    </button>
                                </form>
                            @else
                                <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold">
                                    ✓ Kargo telah DELIVERED. Status akhir tercapai.
                                </div>
                            @endif
                        </div>

                        <!-- 2. Log Checkpoint Milestone Event -->
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <h4 class="text-xs font-black uppercase tracking-wider text-slate-800 mb-1">2. Catat Titik Checkpoint</h4>
                            <p class="text-[11px] text-slate-500 mb-3 font-medium">Tambahkan titik pemindaian transit tanpa mengubah status utama kargo.</p>

                            <form action="{{ route('shipments.events.store', $shipment->id) }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Checkpoint *</label>
                                    <select name="location_id" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-semibold">
                                        @foreach($locations as $l)
                                            <option value="{{ $l->id }}">{{ $l->name }} ({{ $l->city }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Pemindaian *</label>
                                    <input type="text" name="description" placeholder="misal: Melewati pos Bireuen, suhu & kelembaban stabil..." required
                                           class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-medium">
                                </div>
                                <button type="submit" class="w-full py-2.5 px-3 rounded-lg bg-slate-900 hover:bg-black text-white font-extrabold text-xs shadow-xs transition-colors cursor-pointer">
                                    + Simpan Checkpoint
                                </button>
                            </form>
                        </div>

                        <!-- 3. Report Exception Modal / Form (Spans full width) -->
                        <div class="md:col-span-2 p-5 rounded-xl bg-amber-50 border border-amber-200">
                            <h4 class="text-xs font-black uppercase tracking-wider text-amber-950 mb-1">3. Laporkan Kendala Rute & Hitung Ulang Estimasi Sampai</h4>
                            <p class="text-[11px] text-amber-800 mb-3 font-medium">Mengevaluasi data API cuaca OpenWeather secara otomatis jika terkait cuaca, menghitung durasi keterlambatan, dan mengirim peringatan.</p>

                            <form action="{{ route('shipments.exceptions.store', $shipment->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-bold text-amber-950 mb-1">Kategori Kendala *</label>
                                    <select name="exception_type" required class="w-full px-3 py-2 rounded-lg border border-amber-300 text-xs bg-white font-bold text-amber-950">
                                        <option value="WEATHER_DELAY">WEATHER_DELAY (Longsor / Hujan Deras)</option>
                                        <option value="CUSTOMS_HOLD">CUSTOMS_HOLD (Karantina / Bea Cukai)</option>
                                        <option value="PORT_CONGESTION">PORT_CONGESTION (Antrean Dermaga Kapal)</option>
                                        <option value="DAMAGED">DAMAGED (Pemeriksaan Segel / Kemasan)</option>
                                        <option value="MISROUTED">MISROUTED</option>
                                        <option value="DOCUMENTATION_ISSUE">DOCUMENTATION_ISSUE</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-amber-950 mb-1">Tingkat Keparahan *</label>
                                    <select name="severity" required class="w-full px-3 py-2 rounded-lg border border-amber-300 text-xs bg-white font-bold text-amber-950">
                                        <option value="LOW">LOW (+4 jam tunda)</option>
                                        <option value="MEDIUM" selected>MEDIUM (+8 jam tunda)</option>
                                        <option value="HIGH">HIGH (+24 jam tunda)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-amber-950 mb-1">Estimasi Tertunda (Jam)</label>
                                    <input type="number" name="estimated_delay_hours" value="12" min="1" max="720" class="w-full px-3 py-2 rounded-lg border border-amber-300 text-xs bg-white font-bold">
                                </div>

                                <div class="sm:col-span-3">
                                    <label class="block text-xs font-bold text-amber-950 mb-1">Laporan Rincian Kejadian *</label>
                                    <input type="text" name="description" placeholder="Jelaskan kendala (misal: Hujan badai lebat di Km 48 jalan Takengon-Bireuen, ditutup sementara oleh BPBD)..." required
                                           class="w-full px-3 py-2 rounded-lg border border-amber-300 text-xs bg-white font-medium">
                                </div>

                                <div class="sm:col-span-3 text-right">
                                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-extrabold text-xs shadow-xs transition-colors cursor-pointer">
                                        ⚠️ Tandai Kendala Kargo
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Chronological Milestones Timeline -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <h3 class="text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Riwayat Audit Checkpoint Kargo ({{ $shipment->trackingEvents->count() }})</span>
                </h3>

                <div class="relative pl-6 space-y-5 before:content-[''] before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                    @forelse($shipment->trackingEvents as $event)
                        <div class="relative">
                            <div class="absolute -left-6 top-1.5 w-3 h-3 rounded-full bg-emerald-600 ring-4 ring-emerald-50"></div>
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="font-extrabold text-xs text-slate-900 flex items-center gap-2">
                                        <span>{{ $event->location->name ?? 'Titik Checkpoint' }}</span>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800">{{ $event->status }}</span>
                                    </div>
                                    <span class="text-xs font-bold text-slate-500">{{ \Carbon\Carbon::parse($event->event_time)->format('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-xs text-slate-600 mt-1.5 leading-relaxed font-medium">{{ $event->description }}</p>
                                @if($event->creator)
                                    <div class="text-[11px] text-slate-400 mt-2 font-medium">
                                        Dicatat oleh: {{ $event->creator->name }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic">Belum ada riwayat checkpoint.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right 1 Col: Dynamic Weather Station, Packing Manifest, Holds -->
        <div class="space-y-6">

            <!-- Dynamic Live Weather Station Card -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-2xl p-6 shadow-md border border-slate-700 relative overflow-hidden" id="weather-card">
                <div class="flex items-center justify-between pb-3 border-b border-slate-700/80 text-xs">
                    <span class="text-emerald-400 font-extrabold tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        Stasiun Cuaca Real-Time
                    </span>
                    <button type="button" onclick="refreshLiveWeather({{ $shipment->current_location_id ?? $shipment->origin_id }})" class="p-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors cursor-pointer" title="Perbarui Data Cuaca">
                        <svg class="w-4 h-4" id="refresh-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </button>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <div class="text-4xl font-black tracking-tight" id="weather-temp">{{ $weather['temp_c'] ?? 20 }}°C</div>
                        <div class="text-sm font-bold text-emerald-300 mt-0.5" id="weather-condition">{{ $weather['condition'] ?? 'Cuaca Normal' }}</div>
                        <div class="text-xs text-slate-300 font-medium mt-1 flex items-center gap-1" id="weather-location">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            <span>{{ $weather['location_name'] ?? ($shipment->currentLocation->name ?? 'Takengon') }}</span>
                        </div>
                    </div>

                    <!-- Graphical Weather Icon Badge -->
                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center text-3xl shadow-inner" id="weather-icon-box">
                        @php
                            $cond = strtolower($weather['condition'] ?? '');
                            $icon = '⛅';
                            if (str_contains($cond, 'rain') || str_contains($cond, 'hujan')) $icon = '🌧️';
                            else if (str_contains($cond, 'clear') || str_contains($cond, 'cerah')) $icon = '☀️';
                            else if (str_contains($cond, 'thunder') || str_contains($cond, 'petir')) $icon = '⛈️';
                        @endphp
                        <span>{{ $icon }}</span>
                    </div>
                </div>

                <!-- Live Agronomic Gauges -->
                <div class="grid grid-cols-3 gap-2 mt-5 pt-4 border-t border-slate-700/80 text-center text-xs">
                    <div class="bg-white/5 rounded-xl p-2">
                        <span class="text-[10px] text-slate-400 block font-semibold uppercase">Curah Hujan</span>
                        <strong class="text-sm font-extrabold text-white mt-0.5 block" id="weather-rain">{{ $weather['rain_mm'] ?? 0 }} mm</strong>
                    </div>
                    <div class="bg-white/5 rounded-xl p-2">
                        <span class="text-[10px] text-slate-400 block font-semibold uppercase">Angin</span>
                        <strong class="text-sm font-extrabold text-white mt-0.5 block" id="weather-wind">{{ $weather['wind_speed_kmh'] ?? 12 }} km/h</strong>
                    </div>
                    <div class="bg-white/5 rounded-xl p-2">
                        <span class="text-[10px] text-slate-400 block font-semibold uppercase">Kelembaban</span>
                        <strong class="text-sm font-extrabold text-white mt-0.5 block" id="weather-humidity">{{ $weather['humidity'] ?? 65 }}%</strong>
                    </div>
                </div>

                <div class="mt-4 text-xs font-semibold p-2.5 rounded-xl {{ ($weather['is_hazardous'] ?? false) ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/20' }}" id="weather-summary">
                    {{ $weather['alert_summary'] ?? 'Cuaca terpantau aman untuk jalur lintas pegunungan Takengon-Bireuen.' }}
                </div>
            </div>

            <!-- Exceptions & Resolution Action Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-3 pb-3 border-b border-slate-100">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">
                        Catatan Kendala ({{ $shipment->exceptions->count() }})
                    </h3>
                    @if($shipment->is_delayed)
                        <span class="text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                            +{{ $shipment->delay_duration_hours }}j Tunda
                        </span>
                    @endif
                </div>

                <div class="space-y-3">
                    @forelse($shipment->exceptions as $exc)
                        <div class="p-3.5 rounded-xl {{ $exc->status === 'RESOLVED' ? 'bg-slate-50 border-slate-200' : 'bg-amber-50/70 border-amber-200' }} border text-xs">
                            <div class="flex items-center justify-between">
                                <span class="font-extrabold {{ $exc->status === 'RESOLVED' ? 'text-slate-900' : 'text-amber-950' }} text-xs">{{ $exc->exception_type }}</span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $exc->status === 'RESOLVED' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $exc->status }}
                                </span>
                            </div>
                            <p class="text-slate-600 mt-1 leading-relaxed text-xs font-medium">{{ $exc->description }}</p>

                            @if($exc->status !== 'RESOLVED' && (auth()->user()->isAdmin() || auth()->user()->isOperator()))
                                <form action="{{ route('exceptions.resolve', $exc->id) }}" method="POST" class="mt-3 pt-2.5 border-t border-amber-200 flex gap-2">
                                    @csrf
                                    <input type="text" name="resolution_notes" placeholder="Catatan resolusi (misal: Jalan kembali dibuka BPBD)..." required
                                           class="flex-1 px-3 py-1.5 rounded-lg border border-amber-300 bg-white text-xs font-medium">
                                    <button type="submit" class="px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs cursor-pointer">
                                        Selesaikan
                                    </button>
                                </form>
                            @elseif($exc->resolution_notes)
                                <div class="mt-2 pt-2 border-t border-slate-100 text-emerald-800 text-[11px] font-bold">
                                    Selesai: {{ $exc->resolution_notes }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic py-2">Tidak ada kendala pada kargo ini.</div>
                    @endforelse
                </div>
            </div>

            <!-- Cargo Packing Manifest Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-3 pb-3 border-b border-slate-100">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-800">
                        Rincian Barang Kargo
                    </h3>
                    <span class="text-xs font-black px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800">
                        {{ number_format($shipment->weight_kg, 0) }} KG
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($shipment->items as $item)
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                            <div class="font-extrabold text-slate-900">{{ $item->item_name }}</div>
                            <div class="flex justify-between text-slate-600 mt-1 font-semibold">
                                <span>Jumlah: <strong>{{ $item->quantity }} unit</strong></span>
                                <span>Berat: <strong>{{ number_format($item->weight_kg, 0) }} kg</strong></span>
                            </div>
                            <div class="text-[11px] text-slate-400 mt-1">Kemasan: {{ $item->package_type }}</div>
                            @if($item->description)
                                <p class="text-[11px] text-slate-500 italic mt-1">{{ $item->description }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-xs text-slate-400 italic">Tidak ada rincian barang.</div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapEl = document.getElementById('shipment-map');
        if (!mapEl) return;

        const originLat = {{ $shipment->origin->latitude }};
        const originLon = {{ $shipment->origin->longitude }};
        const destLat = {{ $shipment->destination->latitude }};
        const destLon = {{ $shipment->destination->longitude }};
        const currentLat = {{ $shipment->currentLocation->latitude ?? $shipment->origin->latitude }};
        const currentLon = {{ $shipment->currentLocation->longitude ?? $shipment->origin->longitude }};

        const map = L.map('shipment-map').setView([currentLat, currentLon], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([originLat, originLon]).addTo(map)
            .bindPopup("<b>Asal:</b> {{ $shipment->origin->name }}<br>{{ $shipment->origin->city }} [{{ $shipment->origin->code }}]");

        L.marker([destLat, destLon]).addTo(map)
            .bindPopup("<b>Tujuan:</b> {{ $shipment->destination->name }}<br>{{ $shipment->destination->city }} [{{ $shipment->destination->code }}]");

        const isDelayed = {{ $shipment->is_delayed ? 'true' : 'false' }};
        L.circleMarker([currentLat, currentLon], {
            radius: 9,
            color: isDelayed ? '#d97706' : '#059669',
            fillColor: isDelayed ? '#f59e0b' : '#10b981',
            fillOpacity: 0.95,
            weight: 3
        }).addTo(map).bindPopup("<b>Posisi Checkpoint Kargo Saat Ini:</b><br>{{ $shipment->currentLocation->name ?? 'Dalam Perjalanan' }}<br>Status: <b>{{ $shipment->status }}</b>").openPopup();

        const routePoints = [
            [originLat, originLon],
            [currentLat, currentLon],
            [destLat, destLon]
        ];

        L.polyline(routePoints, {
            color: isDelayed ? '#d97706' : '#059669',
            weight: 3,
            opacity: 0.8,
            dashArray: '6, 8'
        }).addTo(map);

        const bounds = L.latLngBounds([
            [originLat, originLon],
            [currentLat, currentLon],
            [destLat, destLon]
        ]);
        map.fitBounds(bounds, { padding: [40, 40] });
    });

    // Dynamic Live Weather Refresh via AJAX
    function refreshLiveWeather(locationId) {
        const icon = document.getElementById('refresh-icon');
        if (icon) icon.classList.add('animate-spin');

        fetch(`/api/weather?location_id=${locationId}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data) {
                    const w = data.data;
                    document.getElementById('weather-temp').innerText = `${w.temp_c}°C`;
                    document.getElementById('weather-condition').innerText = w.condition;
                    document.getElementById('weather-rain').innerText = `${w.rain_mm} mm`;
                    document.getElementById('weather-wind').innerText = `${w.wind_speed_kmh} km/h`;
                    document.getElementById('weather-humidity').innerText = `${w.humidity}%`;
                    document.getElementById('weather-summary').innerText = w.alert_summary;

                    let emoji = '⛅';
                    const c = w.condition.toLowerCase();
                    if (c.includes('rain') || c.includes('hujan')) emoji = '🌧️';
                    else if (c.includes('clear') || c.includes('cerah')) emoji = '☀️';
                    else if (c.includes('thunder') || c.includes('petir')) emoji = '⛈️';
                    document.getElementById('weather-icon-box').innerHTML = `<span>${emoji}</span>`;
                }
            })
            .catch(err => console.error('Weather refresh error:', err))
            .finally(() => {
                if (icon) icon.classList.remove('animate-spin');
            });
    }
</script>
@endpush
@endsection
