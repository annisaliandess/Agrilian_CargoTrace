@extends('layouts.app')

@php
    $isEn = app()->getLocale() === 'en';
@endphp

@section('title', $isEn ? 'Create New Export Manifest' : 'Buat Manifest Kargo Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-forest-50 text-forest-800 border border-forest-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-forest-600 animate-pulse"></span>
                    {{ $isEn ? 'New Export Manifest Entry' : 'Entri Manifest Ekspor Baru' }}
                </span>
                <span class="text-xs text-slate-300">&bull;</span>
                <span class="text-xs text-slate-500 font-medium">Takengon Highland Logistics Hub</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $isEn ? 'Issue New Export Manifest' : 'Terbitkan Manifest Ekspor Baru' }}</h1>
        </div>
        <a href="{{ route('shipments.index') }}" class="btn-brand-outline px-3.5 py-1.5 rounded-xl text-xs flex items-center gap-1.5 font-semibold">
            &larr; {{ $isEn ? 'Back to Manifest Roster' : 'Kembali ke Daftar Kargo' }}
        </a>
    </div>

    <form action="{{ route('shipments.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- 1. Consignee & Routing Logistics -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-2xs space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2.5 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                {{ $isEn ? '1. Buyer & Multimodal Logistics Corridor' : '1. Pembeli & Koridor Logistik Multimodal' }}
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">{{ $isEn ? 'Overseas Buyer / Consignee *' : 'Pembeli / Consignee Luar Negeri *' }}</label>
                    <select name="customer_id" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-medium focus:ring-1 focus:ring-slate-900 focus:outline-none">
                        <option value="">{{ $isEn ? 'Select Buyer / Consignee...' : 'Pilih Pembeli / Consignee...' }}</option>
                        @foreach($customers as $cust)
                            <option value="{{ $cust->id }}" {{ old('customer_id') == $cust->id ? 'selected' : '' }}>
                                {{ $cust->name }} ({{ $cust->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">{{ $isEn ? 'Carrier Fleet / Transport Mode *' : 'Armada Pengangkut / Carrier *' }}</label>
                    <select name="carrier_id" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-mono font-semibold focus:ring-1 focus:ring-slate-900 focus:outline-none">
                        <option value="">{{ $isEn ? 'Select Carrier Fleet...' : 'Pilih Armada Pengangkut...' }}</option>
                        @foreach($carriers as $carrier)
                            <option value="{{ $carrier->id }}" {{ old('carrier_id') == $carrier->id ? 'selected' : '' }}>
                                {{ $carrier->name }} [{{ $carrier->transport_mode }}]
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">{{ $isEn ? 'Origin Warehouse *' : 'Gudang Asal (Origin) *' }}</label>
                    <select name="origin_id" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-medium focus:ring-1 focus:ring-slate-900 focus:outline-none">
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ (old('origin_id') == $loc->id || $loc->code === 'IDTKN') ? 'selected' : '' }}>
                                {{ $loc->name }} ({{ $loc->city }}, {{ $loc->country }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">{{ $isEn ? 'Destination Port *' : 'Pelabuhan Tujuan (Destination) *' }}</label>
                    <select name="destination_id" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs bg-white font-medium focus:ring-1 focus:ring-slate-900 focus:outline-none">
                        <option value="">{{ $isEn ? 'Select Destination Port...' : 'Pilih Pelabuhan Tujuan...' }}</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ (old('destination_id') == $loc->id || $loc->code === 'NLRTM') ? 'selected' : '' }}>
                                {{ $loc->name }} ({{ $loc->city }}, {{ $loc->country }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- 2. Commodity Classification & Volume -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-2xs space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 border-b border-slate-100 pb-2.5 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                {{ $isEn ? '2. Commodity Classification & Scheduling' : '2. Klasifikasi Komoditas & Estimasi Waktu' }}
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">{{ $isEn ? 'Commodity Name / Cargo Description *' : 'Nama Komoditas / Jenis Muatan *' }}</label>
                    <input type="text" name="cargo_type" value="{{ old('cargo_type', 'Kopi Arabika Gayo Specialty Grade 1 (Organik Fairtrade)') }}" required
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-semibold focus:ring-1 focus:ring-slate-900 focus:outline-none">
                    <div class="flex items-center gap-2 mt-1.5 text-[11px] text-slate-500">
                        <span class="font-medium">{{ $isEn ? 'Quick Presets:' : 'Preset Pilihan:' }}</span>
                        <button type="button" onclick="document.querySelector('[name=cargo_type]').value='Kopi Arabika Gayo Specialty Grade 1 (Organik Fairtrade)'" class="hover:underline text-emerald-800 font-semibold">Kopi Gayo Organik</button>
                        <span>&bull;</span>
                        <button type="button" onclick="document.querySelector('[name=cargo_type]').value='Alpukat Mentega Gayo & Cabai Merah Segar (Rantai Dingin)'" class="hover:underline text-emerald-800 font-semibold">Alpukat & Cabai Dingin</button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">{{ $isEn ? 'Total Weight (KG) *' : 'Total Bobot (KG) *' }}</label>
                    <input type="number" step="0.01" name="weight_kg" value="{{ old('weight_kg', '12000') }}" required
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono font-bold focus:ring-1 focus:ring-slate-900 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">{{ $isEn ? 'Estimated Volume (CBM)' : 'Estimasi Volume (CBM)' }}</label>
                    <input type="number" step="0.01" name="volume_cbm" value="{{ old('volume_cbm', '30.00') }}"
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono font-bold focus:ring-1 focus:ring-slate-900 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">{{ $isEn ? 'Scheduled Loading Time *' : 'Jadwal Muat Truk *' }}</label>
                    <input type="datetime-local" name="expected_departure" value="{{ old('expected_departure', now()->format('Y-m-d\TH:i')) }}" required
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono font-medium focus:ring-1 focus:ring-slate-900 focus:outline-none">
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">{{ $isEn ? 'Destination Port Target Arrival (ETA) *' : 'Target Estimasi Tiba di Pelabuhan Akhir (ETA) *' }}</label>
                    <input type="datetime-local" name="expected_arrival" value="{{ old('expected_arrival', now()->addDays(21)->format('Y-m-d\TH:i')) }}" required
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono font-medium focus:ring-1 focus:ring-slate-900 focus:outline-none">
                </div>
            </div>
        </div>

        <!-- 3. Packing Manifest Items (Multi-Item Dynamic) -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-2xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2.5">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    {{ $isEn ? '3. Lot Specifications & Packaging (Multi-Item)' : '3. Spesifikasi Lot Barang & Kemasan (Multi-Item)' }}
                </h3>
                <button type="button" onclick="addItemRow()" class="px-3 py-1 rounded-lg bg-forest-50 hover:bg-forest-100 text-forest-800 border border-forest-200 text-xs font-bold font-mono flex items-center gap-1 transition-colors cursor-pointer">
                    <span>+ {{ $isEn ? 'Add Commodity Lot' : 'Tambah Lot Komoditas' }}</span>
                </button>
            </div>

            <div id="items-container" class="space-y-3">
                <div class="item-row p-3.5 rounded-xl bg-slate-50 border border-slate-200/70 grid grid-cols-1 sm:grid-cols-12 gap-3 text-xs items-end">
                    <div class="sm:col-span-5">
                        <label class="block font-semibold text-slate-700 mb-1">{{ $isEn ? 'Lot Description / Bag Specification *' : 'Deskripsi Lot / Karung *' }}</label>
                        <input type="text" name="items[0][item_name]" value="Arabica Gayo Wet Hulled Premium Lot #01" required
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white font-medium focus:ring-1 focus:ring-slate-900">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block font-semibold text-slate-700 mb-1">{{ $isEn ? 'Quantity (Bags/Units) *' : 'Jumlah (Karung/Koli) *' }}</label>
                        <input type="number" name="items[0][quantity]" value="200" min="1" required
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white font-mono font-bold focus:ring-1 focus:ring-slate-900">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block font-semibold text-slate-700 mb-1">{{ $isEn ? 'Total Weight (kg) *' : 'Berat Total (kg) *' }}</label>
                        <input type="number" step="0.01" name="items[0][weight_kg]" value="12000" min="0.1" required
                               class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white font-mono font-bold focus:ring-1 focus:ring-slate-900">
                    </div>
                    <div class="sm:col-span-1 flex justify-center pb-1">
                        <button type="button" disabled class="p-1.5 text-slate-300 cursor-not-allowed" title="{{ $isEn ? 'Minimum 1 primary item' : 'Minimal 1 item utama' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('shipments.index') }}" class="btn-brand-outline px-4 py-2 rounded-xl text-xs font-semibold">
                {{ $isEn ? 'Cancel' : 'Batal' }}
            </a>
            <button type="submit" class="btn-brand-accent px-5 py-2.5 rounded-xl text-xs font-bold shadow-xs cursor-pointer">
                {{ $isEn ? 'Issue Manifest & Register Consignment →' : 'Terbitkan Manifest & Daftarkan Kargo →' }}
            </button>
        </div>
    </form>
</div>

<script>
    let itemIndex = 1;
    function addItemRow() {
        const container = document.getElementById('items-container');
        const row = document.createElement('div');
        row.className = 'item-row p-3.5 rounded-xl bg-slate-50 border border-slate-200/70 grid grid-cols-1 sm:grid-cols-12 gap-3 text-xs items-end';
        row.innerHTML = `
            <div class="sm:col-span-5">
                <label class="block font-semibold text-slate-700 mb-1">{{ $isEn ? 'Lot Description / Bag Specification *' : 'Deskripsi Lot / Karung *' }}</label>
                <input type="text" name="items[${itemIndex}][item_name]" placeholder="{{ $isEn ? 'e.g. Arabica Gayo Wine Anaerobic Lot #02' : 'Misal: Arabica Gayo Wine Anaerob Lot #02' }}" required
                       class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white font-medium focus:ring-1 focus:ring-slate-900">
            </div>
            <div class="sm:col-span-3">
                <label class="block font-semibold text-slate-700 mb-1">{{ $isEn ? 'Quantity (Bags/Units) *' : 'Jumlah (Karung/Koli) *' }}</label>
                <input type="number" name="items[${itemIndex}][quantity]" value="50" min="1" required
                       class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white font-mono font-bold focus:ring-1 focus:ring-slate-900">
            </div>
            <div class="sm:col-span-3">
                <label class="block font-semibold text-slate-700 mb-1">{{ $isEn ? 'Total Weight (kg) *' : 'Berat Total (kg) *' }}</label>
                <input type="number" step="0.01" name="items[${itemIndex}][weight_kg]" value="3000" min="0.1" required
                       class="w-full px-3 py-1.5 rounded-lg border border-slate-300 bg-white font-mono font-bold focus:ring-1 focus:ring-slate-900">
            </div>
            <div class="sm:col-span-1 flex justify-center pb-1">
                <button type="button" onclick="this.closest('.item-row').remove()" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg cursor-pointer transition-colors" title="{{ $isEn ? 'Remove this lot' : 'Hapus Lot Ini' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        `;
        container.appendChild(row);
        itemIndex++;
    }
</script>
@endsection
