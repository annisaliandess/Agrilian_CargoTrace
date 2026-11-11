@extends('layouts.app')

@section('title', 'Buat Manifest Kargo Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-7">

    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-bold bg-[#F0FBF5] text-[#1B4332] border border-[#95D5B2]">
                    <span class="w-2 h-2 rounded-full bg-[#57C84D] animate-pulse"></span>
                    Entri Manifest Ekspor Baru
                </span>
                <span class="text-xs text-slate-300">&bull;</span>
                <span class="text-xs text-slate-500 font-semibold">Takengon Highland Logistics Hub</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#1B4332] tracking-tight">Terbitkan Manifest Ekspor Baru</h1>
        </div>
        <a href="{{ route('shipments.index') }}" class="btn-brand-outline px-4 py-2 rounded-xl text-xs flex items-center gap-1.5 font-bold">
            &larr; Kembali ke Daftar Kargo
        </a>
    </div>

    <form action="{{ route('shipments.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- 1. Consignee & Routing Logistics -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-sm space-y-4">
            <h3 class="text-xs font-black uppercase tracking-wider text-[#1B4332] border-b border-slate-100 pb-3 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#57C84D]"></span>
                1. Pembeli & Koridor Logistik Multimodal
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pembeli / Consignee Luar Negeri *</label>
                    <select name="customer_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white font-semibold focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
                        <option value="">Pilih Pembeli / Consignee...</option>
                        @foreach($customers as $cust)
                            <option value="{{ $cust->id }}" {{ old('customer_id') == $cust->id ? 'selected' : '' }}>
                                {{ $cust->name }} ({{ $cust->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Armada Pengangkut / Carrier *</label>
                    <select name="carrier_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white font-mono font-bold focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
                        <option value="">Pilih Armada Pengangkut...</option>
                        @foreach($carriers as $carrier)
                            <option value="{{ $carrier->id }}" {{ old('carrier_id') == $carrier->id ? 'selected' : '' }}>
                                {{ $carrier->name }} [{{ $carrier->transport_mode }}]
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Gudang Asal (Origin) *</label>
                    <select name="origin_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white font-semibold focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ (old('origin_id') == $loc->id || $loc->code === 'IDTKN') ? 'selected' : '' }}>
                                {{ $loc->name }} ({{ $loc->city }}, {{ $loc->country }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pelabuhan Tujuan (Destination) *</label>
                    <select name="destination_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white font-semibold focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
                        <option value="">Pilih Pelabuhan Tujuan...</option>
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
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-sm space-y-4">
            <h3 class="text-xs font-black uppercase tracking-wider text-[#1B4332] border-b border-slate-100 pb-3 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#57C84D]"></span>
                2. Klasifikasi Komoditas & Estimasi Waktu
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Komoditas / Jenis Muatan *</label>
                    <input type="text" name="cargo_type" value="{{ old('cargo_type', 'Kopi Arabika Gayo Specialty Grade 1 (Organik Fairtrade)') }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
                    <div class="flex items-center gap-2 mt-2 text-[11px] text-slate-500">
                        <span class="font-bold">Pintasan Cepat:</span>
                        <button type="button" onclick="document.querySelector('[name=cargo_type]').value='Kopi Arabika Gayo Specialty Grade 1 (Organik Fairtrade)'" class="hover:underline text-[#1B4332] font-semibold">☕ Kopi Gayo Organik</button>
                        <span>&bull;</span>
                        <button type="button" onclick="document.querySelector('[name=cargo_type]').value='Alpukat Mentega Gayo & Cabai Merah Segar (Rantai Dingin)'" class="hover:underline text-[#1B4332] font-semibold">🥑 Alpukat & Cabai Dingin</button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Total Bobot (KG) *</label>
                    <input type="number" step="0.01" name="weight_kg" value="{{ old('weight_kg', '12000') }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Estimasi Volume (CBM)</label>
                    <input type="number" step="0.01" name="volume_cbm" value="{{ old('volume_cbm', '30.00') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jadwal Muat Truk *</label>
                    <input type="datetime-local" name="expected_departure" value="{{ old('expected_departure', now()->format('Y-m-d\TH:i')) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Target Estimasi Tiba di Pelabuhan Akhir (ETA) *</label>
                    <input type="datetime-local" name="expected_arrival" value="{{ old('expected_arrival', now()->addDays(21)->format('Y-m-d\TH:i')) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-[#57C84D] focus:outline-none">
                </div>
            </div>
        </div>

        <!-- 3. Packing Manifest Items -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-sm space-y-4">
            <h3 class="text-xs font-black uppercase tracking-wider text-[#1B4332] border-b border-slate-100 pb-3 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#57C84D]"></span>
                3. Spesifikasi Lot Barang & Kemasan
            </h3>

            <div class="p-4 rounded-2xl bg-[#F8FAF9] border border-slate-200/70 grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi Lot / Karung *</label>
                    <input type="text" name="items[0][item_name]" value="Arabica Gayo Wet Hulled Premium Lot #01" required
                           class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-medium focus:ring-2 focus:ring-[#57C84D]">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Jumlah (Karung/Crate) *</label>
                    <input type="number" name="items[0][quantity]" value="200" required
                           class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-mono font-bold focus:ring-2 focus:ring-[#57C84D]">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Berat Total (kg) *</label>
                    <input type="number" step="0.01" name="items[0][weight_kg]" value="12000" required
                           class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-white font-mono font-bold focus:ring-2 focus:ring-[#57C84D]">
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('shipments.index') }}" class="btn-brand-outline px-5 py-3 rounded-xl text-xs font-bold">
                Batal
            </a>
            <button type="submit" class="btn-brand-primary px-6 py-3 rounded-xl text-xs font-black shadow-md shadow-[#1B4332]/20 cursor-pointer">
                Terbitkan Manifest & Daftarkan Kargo &rarr;
            </button>
        </div>
    </form>
</div>
@endsection
