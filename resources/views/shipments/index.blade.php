@extends('layouts.app')

@php
    $isEn = app()->getLocale() === 'en';
@endphp

@section('title', $isEn ? 'Cargo Shipment List' : 'Daftar Pengiriman Kargo')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#E7F5DC] text-[#384226] border border-[#B6C99B] font-mono shadow-2xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#728156] animate-pulse"></span>
                    {{ $isEn ? 'Active Consignments' : 'Pengiriman Kargo Aktif' }}
                </span>
                <span class="text-xs text-[#B6C99B]">&bull;</span>
                <span class="text-xs text-[#4C5836] font-semibold">{{ $isEn ? 'Highland Gayo Agro Corridor' : 'Koridor Komoditas Agro Dataran Tinggi Gayo' }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1D2617] tracking-tight">{{ $isEn ? 'Cargo Shipment List' : 'Daftar Pengiriman Kargo' }}</h1>
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
            <a href="{{ route('shipments.create') }}" class="btn-brand-accent px-4 py-2.5 rounded-2xl text-xs font-bold shadow-md flex items-center gap-1.5 self-start sm:self-auto cursor-pointer active:scale-95">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>{{ $isEn ? 'Create New Shipment' : 'Buat Pengiriman Baru' }}</span>
            </a>
        @endif
    </div>

    <!-- Filter Bar (Soft Sage Gradation, No Sterile White) -->
    <div class="bg-gradient-to-r from-white via-[#F7FAF2] to-white rounded-3xl p-5 border-2 border-[#CFE1B9] shadow-sm">
        <form action="{{ route('shipments.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $isEn ? 'Search waybill or commodity...' : 'Cari nomor resi atau komoditas...' }}"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-[#CFE1B9] text-xs font-medium text-slate-800 bg-white focus:ring-2 focus:ring-[#728156] focus:border-transparent focus:outline-none transition-all shadow-2xs">
            </div>

            <div>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-[#CFE1B9] text-xs font-semibold text-slate-800 bg-white focus:ring-2 focus:ring-[#728156] focus:border-transparent focus:outline-none transition-all shadow-2xs">
                    <option value="">{{ $isEn ? 'All Cargo Status' : 'Semua Status Kargo' }}</option>
                    <option value="CREATED" {{ request('status') == 'CREATED' ? 'selected' : '' }}>CREATED</option>
                    <option value="BOOKED" {{ request('status') == 'BOOKED' ? 'selected' : '' }}>BOOKED</option>
                    <option value="PICKED_UP" {{ request('status') == 'PICKED_UP' ? 'selected' : '' }}>PICKED_UP</option>
                    <option value="IN_TRANSIT" {{ request('status') == 'IN_TRANSIT' ? 'selected' : '' }}>IN_TRANSIT</option>
                    <option value="DELIVERED" {{ request('status') == 'DELIVERED' ? 'selected' : '' }}>DELIVERED</option>
                </select>
            </div>

            <div>
                <select name="carrier_id" class="w-full px-3.5 py-2.5 rounded-xl border border-[#CFE1B9] text-xs font-semibold text-slate-800 bg-white focus:ring-2 focus:ring-[#728156] focus:border-transparent focus:outline-none transition-all shadow-2xs">
                    <option value="">{{ $isEn ? 'All Carriers' : 'Semua Armada' }}</option>
                    @foreach($carriers as $c)
                        <option value="{{ $c->id }}" {{ request('carrier_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->transport_mode }})</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="btn-brand-accent flex-1 py-2.5 px-4 rounded-xl text-xs font-bold cursor-pointer shadow-sm active:scale-95">
                    {{ $isEn ? 'Apply Filter' : 'Terapkan Filter' }}
                </button>
                @if(request()->hasAny(['search', 'status', 'carrier_id']))
                    <a href="{{ route('shipments.index') }}" class="px-3.5 py-2.5 rounded-xl bg-[#E7F5DC] hover:bg-[#CFE1B9] text-[#384226] text-xs font-bold border border-[#B6C99B] transition-colors active:scale-95">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Card (Earthy Sage Header & Soft Rows) -->
    <div class="bg-white/95 rounded-3xl border-2 border-[#CFE1B9] shadow-md overflow-hidden backdrop-blur-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gradient-to-r from-[#E7F5DC] via-[#F1F6EA] to-[#E7F5DC] border-b-2 border-[#B6C99B] text-[#384226] uppercase tracking-wider text-[10px] font-extrabold font-mono">
                    <tr>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Waybill No.' : 'Nomor Resi / Surat Jalan' }}</th>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Buyer / Consignee' : 'Penerima / Pembeli' }}</th>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Commodity & Weight' : 'Komoditas & Bobot' }}</th>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Route & Location' : 'Rute & Posisi Terkini' }}</th>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Carrier Fleet' : 'Armada Pengangkut' }}</th>
                        <th class="py-3.5 px-4 font-bold">{{ $isEn ? 'Status & ETA' : 'Status & Estimasi Tiba' }}</th>
                        <th class="py-3.5 px-4 font-bold text-right">{{ $isEn ? 'Actions' : 'Aksi' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E7F5DC]/80 text-slate-700">
                    @forelse($shipments as $s)
                        <tr class="{{ $loop->even ? 'bg-[#F9FBF7]' : 'bg-white' }} hover:bg-[#E7F5DC]/45 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-[#1D2617]">
                                <a href="{{ route('shipments.show', $s->id) }}" class="text-[#728156] hover:text-[#384226] hover:underline flex items-center gap-1">
                                    <span>{{ $s->tracking_number }}</span>
                                </a>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $s->customer->name ?? 'Confidential' }}
                            </td>
                            <td class="py-3.5 px-4">
                                @php
                                    $thumb = str_contains(strtolower($s->cargo_type), 'arabica') || str_contains(strtolower($s->cargo_type), 'coffee') 
                                        ? '/images/coffee.jpg' 
                                        : (str_contains(strtolower($s->cargo_type), 'avocado') || str_contains(strtolower($s->cargo_type), 'chili') ? '/images/avocado.jpg' : '/images/ship.jpg');
                                @endphp
                                <div class="flex items-center gap-2.5">
                                    <img src="{{ $thumb }}" alt="" class="w-8 h-8 rounded-xl object-cover border border-[#CFE1B9] shrink-0 shadow-2xs">
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $s->cargo_type }}</div>
                                        <div class="text-[11px] text-slate-500 font-mono mt-0.5">{{ number_format($s->weight_kg, 0) }} kg &bull; {{ $s->volume_cbm ?? '-' }} CBM</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                <div class="font-bold text-slate-800">{{ $s->origin->name }} &rarr; {{ $s->destination->name }}</div>
                                <div class="text-[#728156] text-[11px] font-semibold mt-0.5">{{ $isEn ? 'Location:' : 'Posisi:' }} {{ $s->currentLocation->name ?? ($isEn ? 'In Transit' : 'Dalam Perjalanan') }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900">{{ $s->carrier->name }}</span>
                                <span class="block text-[10px] text-[#728156] font-mono font-bold mt-0.5">[{{ $s->carrier->transport_mode }}]</span>
                            </td>
                            <td class="py-3.5 px-4">
                                @php
                                    $badge = match($s->status) {
                                        'CREATED' => 'bg-[#E7F5DC] text-[#384226] border-[#B6C99B]',
                                        'BOOKED' => 'bg-sky-50 text-sky-900 border-sky-300',
                                        'PICKED_UP' => 'bg-indigo-50 text-indigo-900 border-indigo-300',
                                        'IN_TRANSIT' => 'bg-sky-100 text-sky-950 border-sky-300 font-bold',
                                        'DELIVERED' => 'bg-emerald-50 text-emerald-900 border-emerald-300 font-bold',
                                        default => 'bg-slate-100 text-slate-800 border-slate-200',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase border font-mono {{ $badge }}">
                                    {{ $s->status }}
                                </span>
                                @if($s->is_delayed)
                                    <span class="block text-[10px] text-amber-700 font-bold mt-1 font-mono">
                                        +{{ $s->delay_duration_hours }}{{ $isEn ? 'h Delayed' : 'j Tunda' }}
                                    </span>
                                @else
                                    <span class="block text-[10px] text-slate-500 font-medium mt-1 font-mono">
                                        ETA: {{ \Carbon\Carbon::parse($s->estimated_arrival)->format('d M, H:i') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('shipments.show', $s->id) }}" class="px-3 py-1.5 rounded-xl bg-[#E7F5DC] hover:bg-[#CFE1B9] text-[#1D2617] border border-[#B6C99B] text-xs font-bold inline-block shadow-2xs active:scale-95 transition-all">
                                    {{ auth()->user()->isCustomer() ? ($isEn ? 'Detail' : 'Detail') : ($isEn ? 'Manage' : 'Kelola') }}
                                </a>
                                <a href="{{ route('track.public', $s->tracking_number) }}" target="_blank" title="{{ $isEn ? 'Open Waybill Tracking' : 'Buka Halaman Cek Resi' }}" 
                                   class="px-2.5 py-1.5 rounded-xl bg-white text-slate-700 hover:text-[#1D2617] hover:bg-[#E7F5DC] border border-[#CFE1B9] text-xs font-semibold inline-block transition-all shadow-2xs active:scale-95">
                                    Radar
                                </a>
                                @if(auth()->user()->isCustomer())
                                    <button type="button" onclick="openClaimModal({{ $s->id }}, '{{ $s->tracking_number }}')" class="px-2.5 py-1.5 rounded-xl text-xs font-bold bg-[#FFF5F5] hover:bg-rose-50 text-rose-700 border border-rose-200 inline-flex items-center gap-1 cursor-pointer transition-all shadow-2xs active:scale-95" title="{{ $isEn ? 'Report Discrepancy / Return Claim' : 'Lapor Ketidaksesuaian Mutu / Klaim Kerusakan' }}">
                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <span>{{ $isEn ? 'Claim' : 'Klaim' }}</span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-400 italic">{{ $isEn ? 'No shipments match the selected filters.' : 'Tidak ada pengiriman yang cocok dengan filter.' }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($shipments->hasPages())
            <div class="p-4 border-t border-[#CFE1B9] bg-[#F7FAF2]">
                {{ $shipments->links() }}
            </div>
        @endif
    </div>

    <!-- Custom In-App Modal: Lapor Ketidaksesuaian / Klaim Kerusakan (Customer Self-Service) -->
    <div id="claimModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border-2 border-[#CFE1B9]">
            <div class="flex items-center justify-between pb-4 border-b border-[#E7F5DC]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-200 font-bold text-base shadow-2xs">
                        ⚠️
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold text-[#1D2617]">{{ $isEn ? 'Report Cargo Discrepancy' : 'Lapor Ketidaksesuaian Kargo' }}</h3>
                        <p class="text-xs text-[#4C5836]">{{ $isEn ? 'Waybill Number:' : 'Nomor Resi:' }} <span id="modalTrackingNumber" class="font-mono font-bold text-[#728156]"></span></p>
                    </div>
                </div>
                <button type="button" onclick="closeClaimModal()" class="p-1.5 rounded-xl text-stone-400 hover:text-stone-700 hover:bg-[#E7F5DC] cursor-pointer transition-colors active:scale-90">✕</button>
            </div>

            <form id="claimForm" method="POST" action="" class="mt-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[#1D2617] uppercase tracking-wider mb-1 font-mono">{{ $isEn ? 'Issue Type / Discrepancy' : 'Jenis Kendala / Ketidaksesuaian' }}</label>
                    <select name="exception_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs font-semibold focus:ring-2 focus:ring-[#728156] focus:border-[#728156] bg-white transition-all">
                        <option value="DAMAGED">{{ $isEn ? 'Physical Cargo Damage (Packaging / Wet / Torn Jute Bags)' : 'Kargo Rusak Fisik (Kemasan / Karung Basah / Rusak)' }}</option>
                        <option value="DOCUMENTATION_ISSUE">{{ $isEn ? 'Coffee Quality Discrepancy / Quarantine Document Issue' : 'Ketidaksesuaian Mutu Kopi / Dokumen Karantina' }}</option>
                        <option value="MISROUTED">{{ $isEn ? 'Misrouted / Container Return Request' : 'Salah Rute / Permohonan Retur Kontainer' }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#1D2617] uppercase tracking-wider mb-1 font-mono">{{ $isEn ? 'Urgency Level (Severity)' : 'Tingkat Urgensi (Severity)' }}</label>
                    <select name="severity" required class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs font-semibold focus:ring-2 focus:ring-[#728156] focus:border-[#728156] bg-white transition-all">
                        <option value="MEDIUM">{{ $isEn ? 'MEDIUM — Field Verification / Quality Inspection Required' : 'MEDIUM — Butuh Verifikasi / Uji Mutu Lapangan' }}</option>
                        <option value="HIGH">{{ $isEn ? 'HIGH — Critical / Halt Consignment Immediately' : 'HIGH — Kritis / Stop Pengiriman Segera' }}</option>
                        <option value="LOW">{{ $isEn ? 'LOW — Minor Evaluation Note' : 'LOW — Catatan Minor Evaluasi' }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#1D2617] uppercase tracking-wider mb-1 font-mono">{{ $isEn ? 'Issue Description / Reason for Claim' : 'Rincian Masalah / Alasan Klaim' }}</label>
                    <textarea name="description" rows="3" required placeholder="{{ $isEn ? 'Describe quality discrepancy, moisture variance, or cargo damage found...' : 'Jelaskan ketidaksesuaian mutu, kadar air, atau kerusakan kargo yang ditemukan...' }}"
                              class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#728156] focus:border-[#728156] bg-white transition-all"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#E7F5DC]">
                    <button type="button" onclick="closeClaimModal()" class="btn-brand-outline px-4 py-2 rounded-xl text-xs font-bold active:scale-95 cursor-pointer">{{ $isEn ? 'Cancel' : 'Batal' }}</button>
                    <button type="submit" class="btn-brand-accent px-5 py-2.5 rounded-xl text-xs font-bold shadow-md cursor-pointer active:scale-95">{{ $isEn ? 'Submit Claim Report' : 'Kirim Laporan Klaim' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openClaimModal(shipmentId, trackingNumber) {
        const modal = document.getElementById('claimModal');
        const form = document.getElementById('claimForm');
        const num = document.getElementById('modalTrackingNumber');
        if (modal && form && num) {
            num.innerText = trackingNumber;
            form.action = `/shipments/${shipmentId}/exceptions`;
            modal.classList.remove('hidden');
        }
    }
    function closeClaimModal() {
        const modal = document.getElementById('claimModal');
        if (modal) modal.classList.add('hidden');
    }
</script>
@endpush
@endsection
