@extends('layouts.app')

@php
    $isEn = app()->getLocale() === 'en';
@endphp

@section('title', $isEn ? 'Cargo Shipments Manifest' : 'Daftar Pengiriman Kargo')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-forest-50 text-forest-800 border border-forest-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-forest-600 animate-pulse"></span>
                    {{ $isEn ? 'Active Consignments' : 'Pengiriman Kargo Aktif' }}
                </span>
                <span class="text-xs text-slate-300">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">{{ $isEn ? 'Highland Gayo Agro Corridor' : 'Koridor Komoditas Agro Dataran Tinggi Gayo' }}</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $isEn ? 'Cargo Shipment List' : 'Daftar Pengiriman Kargo' }}</h1>
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
            <a href="{{ route('shipments.create') }}" class="btn-brand-accent px-4 py-2 rounded-xl text-xs font-bold shadow-xs flex items-center gap-1.5 self-start sm:self-auto cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>{{ $isEn ? 'Create New Shipment' : 'Buat Pengiriman Baru' }}</span>
            </a>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs">
        <form action="{{ route('shipments.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $isEn ? 'Search waybill or commodity...' : 'Cari nomor resi atau komoditas...' }}"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-medium focus:ring-1 focus:ring-slate-900 focus:outline-none">
            </div>

            <div>
                <select name="status" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-800 focus:ring-1 focus:ring-slate-900 focus:outline-none">
                    <option value="">{{ $isEn ? 'All Cargo Status' : 'Semua Status Kargo' }}</option>
                    <option value="CREATED" {{ request('status') == 'CREATED' ? 'selected' : '' }}>CREATED</option>
                    <option value="BOOKED" {{ request('status') == 'BOOKED' ? 'selected' : '' }}>BOOKED</option>
                    <option value="PICKED_UP" {{ request('status') == 'PICKED_UP' ? 'selected' : '' }}>PICKED_UP</option>
                    <option value="IN_TRANSIT" {{ request('status') == 'IN_TRANSIT' ? 'selected' : '' }}>IN_TRANSIT</option>
                    <option value="DELIVERED" {{ request('status') == 'DELIVERED' ? 'selected' : '' }}>DELIVERED</option>
                </select>
            </div>

            <div>
                <select name="carrier_id" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-800 focus:ring-1 focus:ring-slate-900 focus:outline-none">
                    <option value="">{{ $isEn ? 'All Carriers' : 'Semua Armada' }}</option>
                    @foreach($carriers as $c)
                        <option value="{{ $c->id }}" {{ request('carrier_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->transport_mode }})</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="btn-brand-primary flex-1 py-2 px-3.5 rounded-xl text-xs font-bold cursor-pointer">
                    {{ $isEn ? 'Apply Filter' : 'Terapkan Filter' }}
                </button>
                @if(request()->hasAny(['search', 'status', 'carrier_id']))
                    <a href="{{ route('shipments.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[10px] font-bold">
                    <tr>
                        <th class="py-3 px-4 font-bold">{{ $isEn ? 'Waybill No.' : 'Nomor Resi / Surat Jalan' }}</th>
                        <th class="py-3 px-4 font-bold">{{ $isEn ? 'Buyer / Consignee' : 'Penerima / Pembeli' }}</th>
                        <th class="py-3 px-4 font-bold">{{ $isEn ? 'Commodity & Weight' : 'Komoditas & Bobot' }}</th>
                        <th class="py-3 px-4 font-bold">{{ $isEn ? 'Route & Location' : 'Rute & Posisi Terkini' }}</th>
                        <th class="py-3 px-4 font-bold">{{ $isEn ? 'Carrier Fleet' : 'Armada Pengangkut' }}</th>
                        <th class="py-3 px-4 font-bold">{{ $isEn ? 'Status & ETA' : 'Status & Estimasi Tiba' }}</th>
                        <th class="py-3 px-4 font-bold text-right">{{ $isEn ? 'Actions' : 'Aksi' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($shipments as $s)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-slate-900">
                                <a href="{{ route('shipments.show', $s->id) }}" class="text-forest-700 hover:underline">
                                    {{ $s->tracking_number }}
                                </a>
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-900">
                                {{ $s->customer->name ?? 'Confidential' }}
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $thumb = str_contains(strtolower($s->cargo_type), 'arabica') || str_contains(strtolower($s->cargo_type), 'coffee') 
                                        ? '/images/coffee.jpg' 
                                        : (str_contains(strtolower($s->cargo_type), 'avocado') || str_contains(strtolower($s->cargo_type), 'chili') ? '/images/avocado.jpg' : '/images/ship.jpg');
                                @endphp
                                <div class="flex items-center gap-2.5">
                                    <img src="{{ $thumb }}" alt="" class="w-8 h-8 rounded-lg object-cover border border-slate-200 shrink-0">
                                    <div>
                                        <div class="font-semibold text-slate-900">{{ $s->cargo_type }}</div>
                                        <div class="text-[11px] text-slate-400 mt-0.5">{{ number_format($s->weight_kg, 0) }} kg &bull; {{ $s->volume_cbm ?? '-' }} CBM</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-xs">
                                <div class="font-medium text-slate-800">{{ $s->origin->name }} &rarr; {{ $s->destination->name }}</div>
                                <div class="text-stone-500 text-[11px] font-semibold mt-0.5">{{ $isEn ? 'Location:' : 'Posisi:' }} {{ $s->currentLocation->name ?? ($isEn ? 'In Transit' : 'Dalam Perjalanan') }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-semibold text-slate-900">{{ $s->carrier->name }}</span>
                                <span class="block text-[10px] text-slate-400 font-mono font-medium">[{{ $s->carrier->transport_mode }}]</span>
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $badge = match($s->status) {
                                        'CREATED' => 'bg-slate-100 text-slate-800 border-slate-300',
                                        'BOOKED' => 'bg-blue-50 text-blue-900 border-blue-200',
                                        'PICKED_UP' => 'bg-indigo-50 text-indigo-900 border-indigo-200',
                                        'IN_TRANSIT' => 'bg-blue-50 text-blue-800 border-blue-200',
                                        'DELIVERED' => 'bg-emerald-50 text-emerald-800 border-emerald-300 font-bold',
                                        default => 'bg-slate-100 text-slate-800',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase border {{ $badge }}">
                                    {{ $s->status }}
                                </span>
                                @if($s->is_delayed)
                                    <span class="block text-[10px] text-amber-700 font-semibold mt-1">
                                        +{{ $s->delay_duration_hours }}{{ $isEn ? 'h Delayed' : 'j Tunda' }}
                                    </span>
                                @else
                                    <span class="block text-[10px] text-slate-400 font-medium mt-1 font-mono">
                                        ETA: {{ \Carbon\Carbon::parse($s->estimated_arrival)->format('d M, H:i') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right space-x-1.5">
                                <a href="{{ route('shipments.show', $s->id) }}" class="btn-brand-outline px-2.5 py-1 rounded-lg text-xs inline-block">
                                    {{ $isEn ? 'Manage' : 'Kelola' }}
                                </a>
                                <a href="{{ route('track.public', $s->tracking_number) }}" target="_blank" title="{{ $isEn ? 'Open Waybill Tracking' : 'Buka Halaman Cek Resi' }}" class="px-2 py-1 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-medium inline-block transition-colors">
                                    Radar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 italic">{{ $isEn ? 'No shipments match the selected filters.' : 'Tidak ada pengiriman yang cocok dengan filter.' }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($shipments->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $shipments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
