@extends('layouts.app')

@section('title', 'Daftar Pengiriman Kargo')

@section('content')
<div class="space-y-7">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-bold bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]">
                    <span class="w-2 h-2 rounded-full bg-[#57C84D] animate-pulse"></span>
                    Manifest Ekspor Multimodal
                </span>
                <span class="text-xs text-slate-300">&bull;</span>
                <span class="text-xs text-slate-500 font-semibold">Koridor Komoditas Agro Dataran Tinggi Gayo</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#1B4332] tracking-tight">Daftar Pengiriman Kargo</h1>
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
            <a href="{{ route('shipments.create') }}" class="btn-brand-primary px-5 py-2.5 rounded-xl text-xs font-black shadow-md shadow-[#1B4332]/20 flex items-center gap-2 self-start sm:self-auto cursor-pointer">
                <svg class="w-4 h-4 text-[#57C84D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Buat Manifest Baru</span>
            </a>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-sm">
        <form action="{{ route('shipments.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor resi atau komoditas..."
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
            </div>

            <div>
                <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
                    <option value="">Semua Status Kargo</option>
                    <option value="CREATED" {{ request('status') == 'CREATED' ? 'selected' : '' }}>CREATED</option>
                    <option value="BOOKED" {{ request('status') == 'BOOKED' ? 'selected' : '' }}>BOOKED</option>
                    <option value="PICKED_UP" {{ request('status') == 'PICKED_UP' ? 'selected' : '' }}>PICKED_UP</option>
                    <option value="IN_TRANSIT" {{ request('status') == 'IN_TRANSIT' ? 'selected' : '' }}>IN_TRANSIT</option>
                    <option value="DELIVERED" {{ request('status') == 'DELIVERED' ? 'selected' : '' }}>DELIVERED</option>
                </select>
            </div>

            <div>
                <select name="carrier_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-800 focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
                    <option value="">Semua Armada</option>
                    @foreach($carriers as $c)
                        <option value="{{ $c->id }}" {{ request('carrier_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->transport_mode }})</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="btn-brand-primary flex-1 py-2.5 px-4 rounded-xl text-xs font-extrabold cursor-pointer">
                    Terapkan Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'carrier_id']))
                    <a href="{{ route('shipments.index') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F8FAF9] border-b border-slate-200/80 text-slate-400 uppercase tracking-wider text-[10px] font-black">
                    <tr>
                        <th class="py-3.5 px-5 font-black text-slate-500">Nomor Resi</th>
                        <th class="py-3.5 px-5 font-black text-slate-500">Pembeli / Consignee</th>
                        <th class="py-3.5 px-5 font-black text-slate-500">Komoditas Agro</th>
                        <th class="py-3.5 px-5 font-black text-slate-500">Jalur Perjalanan</th>
                        <th class="py-3.5 px-5 font-black text-slate-500">Armada</th>
                        <th class="py-3.5 px-5 font-black text-slate-500">Status & ETA</th>
                        <th class="py-3.5 px-5 font-black text-slate-500 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($shipments as $s)
                        @php
                            $isCoffee = str_contains(strtolower($s->cargo_type), 'arabica') || str_contains(strtolower($s->cargo_type), 'coffee');
                            $isHorti = str_contains(strtolower($s->cargo_type), 'avocado') || str_contains(strtolower($s->cargo_type), 'chili');
                        @endphp
                        <tr class="hover:bg-[#F8FAF9] transition-colors group">
                            <td class="py-4 px-5 font-mono font-black text-[#1B4332]">
                                <a href="{{ route('shipments.show', $s->id) }}" class="hover:underline">
                                    {{ $s->tracking_number }}
                                </a>
                            </td>
                            <td class="py-4 px-5 font-bold text-slate-900">
                                {{ $s->customer->name ?? 'Confidential' }}
                            </td>
                            <td class="py-4 px-5">
                                <div class="font-extrabold text-slate-900 flex items-center gap-1.5">
                                    <span>{{ $isCoffee ? '☕' : ($isHorti ? '🥑' : '📦') }}</span>
                                    <span>{{ $s->cargo_type }}</span>
                                </div>
                                <div class="text-[11px] text-slate-400 font-semibold mt-0.5">
                                    {{ number_format($s->weight_kg, 0) }} kg &bull; {{ $s->volume_cbm ?? '-' }} CBM
                                </div>
                            </td>
                            <td class="py-4 px-5 text-xs">
                                <div class="font-bold text-slate-800">{{ $s->origin->name }} &rarr; {{ $s->destination->name }}</div>
                                <div class="text-[#1B4332] text-[11px] font-extrabold mt-0.5">Posisi: {{ $s->currentLocation->name ?? 'Dalam Perjalanan' }}</div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="font-bold text-slate-900">{{ $s->carrier->name }}</span>
                                <span class="block text-[10px] text-slate-400 font-mono font-bold">[{{ $s->carrier->transport_mode }}]</span>
                            </td>
                            <td class="py-4 px-5">
                                @php
                                    $badge = match($s->status) {
                                        'CREATED' => 'bg-slate-100 text-slate-800 border-slate-300',
                                        'BOOKED' => 'bg-blue-50 text-blue-900 border-blue-200',
                                        'PICKED_UP' => 'bg-amber-50 text-amber-900 border-amber-200',
                                        'IN_TRANSIT' => 'bg-[#F0FBF5] text-[#1B4332] border-[#95D5B2]',
                                        'DELIVERED' => 'bg-[#1B4332] text-white border-[#1B4332]',
                                        default => 'bg-slate-100 text-slate-800',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $badge }}">
                                    {{ $s->status }}
                                </span>
                                @if($s->is_delayed)
                                    <span class="block text-[10px] text-amber-700 font-extrabold mt-1">
                                        ⚠️ +{{ $s->delay_duration_hours }}j Tunda
                                    </span>
                                @else
                                    <span class="block text-[10px] text-slate-400 font-medium mt-1 font-mono">
                                        ETA: {{ \Carbon\Carbon::parse($s->estimated_arrival)->format('d M, H:i') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right space-x-1.5">
                                <a href="{{ route('shipments.show', $s->id) }}" class="btn-brand-outline px-3 py-1.5 rounded-xl text-xs inline-block">
                                    Kelola
                                </a>
                                <a href="{{ route('track.public', $s->tracking_number) }}" target="_blank" title="Buka Halaman Cek Resi" class="px-2.5 py-1.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-semibold inline-block transition-colors">
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
            <div class="p-4 border-t border-slate-200 bg-[#F8FAF9]">
                {{ $shipments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
