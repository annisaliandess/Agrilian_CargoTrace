@extends('layouts.app')

@section('title', 'Daftar Pengiriman Kargo')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800">
                    Manifes Ekspor
                </span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs text-slate-500 font-semibold">Logistik Multimodal Pertanian</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Pengiriman Kargo</h1>
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
            <a href="{{ route('shipments.create') }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black shadow-xs transition-colors flex items-center gap-1.5 self-start sm:self-auto cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Buat Manifest Baru</span>
            </a>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-2xs">
        <form action="{{ route('shipments.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor resi atau barang..."
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="CREATED" {{ request('status') == 'CREATED' ? 'selected' : '' }}>CREATED</option>
                    <option value="BOOKED" {{ request('status') == 'BOOKED' ? 'selected' : '' }}>BOOKED</option>
                    <option value="PICKED_UP" {{ request('status') == 'PICKED_UP' ? 'selected' : '' }}>PICKED_UP</option>
                    <option value="IN_TRANSIT" {{ request('status') == 'IN_TRANSIT' ? 'selected' : '' }}>IN_TRANSIT</option>
                    <option value="DELIVERED" {{ request('status') == 'DELIVERED' ? 'selected' : '' }}>DELIVERED</option>
                </select>
            </div>

            <div>
                <select name="carrier_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="">Semua Armada</option>
                    @foreach($carriers as $c)
                        <option value="{{ $c->id }}" {{ request('carrier_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->transport_mode }})</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-black text-white text-xs font-extrabold transition-colors cursor-pointer">
                    Terapkan Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'carrier_id', 'delayed']))
                    <a href="{{ route('shipments.index') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-400 uppercase tracking-wider text-[10px] font-extrabold">
                    <tr>
                        <th class="py-3 px-4 font-bold">Nomor Resi</th>
                        <th class="py-3 px-4 font-bold">Pembeli / Consignee</th>
                        <th class="py-3 px-4 font-bold">Komoditas Agro</th>
                        <th class="py-3 px-4 font-bold">Jalur Perjalanan</th>
                        <th class="py-3 px-4 font-bold">Armada</th>
                        <th class="py-3 px-4 font-bold">Status & ETA</th>
                        <th class="py-3 px-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($shipments as $s)
                        @php
                            $isCoffee = str_contains(strtolower($s->cargo_type), 'arabica') || str_contains(strtolower($s->cargo_type), 'coffee');
                            $isHorti = str_contains(strtolower($s->cargo_type), 'avocado') || str_contains(strtolower($s->cargo_type), 'chili');
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                                <a href="{{ route('shipments.show', $s->id) }}" class="text-emerald-700 hover:underline">
                                    {{ $s->tracking_number }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $s->customer->name ?? 'Confidential' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 flex items-center gap-1.5">
                                    @if($isCoffee)
                                        <span class="text-xs">☕</span>
                                    @elseif($isHorti)
                                        <span class="text-xs">🥑</span>
                                    @endif
                                    <span>{{ $s->cargo_type }}</span>
                                </div>
                                <div class="text-[11px] text-slate-400 font-medium mt-0.5">
                                    {{ number_format($s->weight_kg, 0) }} kg &bull; {{ $s->volume_cbm ?? '-' }} CBM
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                <div class="font-semibold text-slate-800">{{ $s->origin->name }} &rarr; {{ $s->destination->name }}</div>
                                <div class="text-emerald-700 text-[11px] font-bold">Posisi: {{ $s->currentLocation->name ?? 'Dalam Perjalanan' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900">{{ $s->carrier->name }}</span>
                                <span class="block text-[10px] text-slate-400 font-semibold">[{{ $s->carrier->transport_mode }}]</span>
                            </td>
                            <td class="py-3.5 px-4">
                                @php
                                    $badge = match($s->status) {
                                        'CREATED' => 'bg-slate-100 text-slate-800 border-slate-300',
                                        'BOOKED' => 'bg-blue-50 text-blue-900 border-blue-200',
                                        'PICKED_UP' => 'bg-amber-50 text-amber-900 border-amber-200',
                                        'IN_TRANSIT' => 'bg-emerald-50 text-emerald-800 border-emerald-300',
                                        'DELIVERED' => 'bg-emerald-600 text-white border-emerald-600',
                                        default => 'bg-slate-100 text-slate-800',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase border {{ $badge }}">
                                    {{ $s->status }}
                                </span>
                                @if($s->is_delayed)
                                    <span class="block text-[10px] text-amber-700 font-bold mt-1">
                                        ⚠️ +{{ $s->delay_duration_hours }}j Tunda
                                    </span>
                                @else
                                    <span class="block text-[10px] text-slate-400 font-medium mt-1">
                                        ETA: {{ \Carbon\Carbon::parse($s->estimated_arrival)->format('d M, H:i') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1.5">
                                <a href="{{ route('shipments.show', $s->id) }}" class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-800 hover:bg-emerald-100 font-bold text-xs transition-colors">
                                    Kelola
                                </a>
                                <a href="{{ route('track.public', $s->tracking_number) }}" target="_blank" title="Buka Halaman Radar Publik" class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-semibold transition-colors">
                                    Radar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 italic">Tidak ada pengiriman yang cocok dengan filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($shipments->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                {{ $shipments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
