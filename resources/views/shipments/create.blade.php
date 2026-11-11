@extends('layouts.app')

@section('title', 'Register New Agro-Export Manifest')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="font-mono text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-stone-200/70 text-stone-700">
                    Export Manifest Entry
                </span>
                <span class="text-xs text-stone-400">&bull;</span>
                <span class="text-xs text-stone-500 font-mono">Takengon Origin Hub</span>
            </div>
            <h1 class="text-2xl font-extrabold text-espresso-950 tracking-tight">Issue New Consignment Manifest</h1>
        </div>
        <a href="{{ route('shipments.index') }}" class="text-xs font-mono font-semibold text-stone-600 hover:text-stone-900">
            &larr; Back to Consignments
        </a>
    </div>

    <form action="{{ route('shipments.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Consignment Metadata Card -->
        <div class="bg-white rounded-xl p-6 border border-stone-200 shadow-2xs space-y-4">
            <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-stone-900 border-b border-stone-100 pb-2">
                1. Consignee & Routing Logistics
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-mono font-semibold text-stone-700 mb-1">Consignee Buyer *</label>
                    <select name="customer_id" required class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs bg-white focus:ring-1 focus:ring-stone-900 focus:outline-none">
                        <option value="">Select Consignee...</option>
                        @foreach($customers as $cust)
                            <option value="{{ $cust->id }}" {{ old('customer_id') == $cust->id ? 'selected' : '' }}>
                                {{ $cust->name }} ({{ $cust->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono font-semibold text-stone-700 mb-1">Carrier Fleet *</label>
                    <select name="carrier_id" required class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs bg-white font-mono focus:ring-1 focus:ring-stone-900 focus:outline-none">
                        <option value="">Select Carrier...</option>
                        @foreach($carriers as $carrier)
                            <option value="{{ $carrier->id }}" {{ old('carrier_id') == $carrier->id ? 'selected' : '' }}>
                                {{ $carrier->name }} [{{ $carrier->transport_mode }}]
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono font-semibold text-stone-700 mb-1">Origin Logistics Hub *</label>
                    <select name="origin_id" required class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs bg-white focus:ring-1 focus:ring-stone-900 focus:outline-none">
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ (old('origin_id') == $loc->id || $loc->code === 'IDTKN') ? 'selected' : '' }}>
                                {{ $loc->name }} ({{ $loc->city }}) - {{ $loc->type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono font-semibold text-stone-700 mb-1">Destination Logistics Port *</label>
                    <select name="destination_id" required class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs bg-white focus:ring-1 focus:ring-stone-900 focus:outline-none">
                        <option value="">Select Destination Port...</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ (old('destination_id') == $loc->id || $loc->code === 'NLRTM') ? 'selected' : '' }}>
                                {{ $loc->name }} ({{ $loc->city }}, {{ $loc->country }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Commodity & Specifications Card -->
        <div class="bg-white rounded-xl p-6 border border-stone-200 shadow-2xs space-y-4">
            <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-stone-900 border-b border-stone-100 pb-2">
                2. Commodity Classification & Volume
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-3">
                    <label class="block text-xs font-mono font-semibold text-stone-700 mb-1">Commodity / Cargo Type *</label>
                    <input type="text" name="cargo_type" value="{{ old('cargo_type', 'Arabica Gayo Specialty Grade 1 (Fair Trade Organic)') }}" required
                           class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs focus:ring-1 focus:ring-stone-900 focus:outline-none font-semibold">
                    <div class="flex items-center gap-2 mt-1.5 text-[10px] font-mono text-stone-500">
                        <span>Presets:</span>
                        <button type="button" onclick="document.querySelector('[name=cargo_type]').value='Arabica Gayo Specialty Grade 1 (Fair Trade Organic)'" class="hover:underline text-canopy-800">☕ Gayo Arabica Organic</button>
                        <span>&bull;</span>
                        <button type="button" onclick="document.querySelector('[name=cargo_type]').value='Takengon Butter Avocado & Fresh Red Chili (Cold-Chain)'" class="hover:underline text-canopy-800">🥑 Avocado & Chili Cold-Chain</button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono font-semibold text-stone-700 mb-1">Gross Weight (KG) *</label>
                    <input type="number" step="0.01" name="weight_kg" value="{{ old('weight_kg', '12000') }}" required
                           class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs font-mono focus:ring-1 focus:ring-stone-900 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono font-semibold text-stone-700 mb-1">Volume (CBM)</label>
                    <input type="number" step="0.01" name="volume_cbm" value="{{ old('volume_cbm', '30.00') }}"
                           class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs font-mono focus:ring-1 focus:ring-stone-900 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-mono font-semibold text-stone-700 mb-1">Expected Departure *</label>
                    <input type="datetime-local" name="expected_departure" value="{{ old('expected_departure', now()->format('Y-m-d\TH:i')) }}" required
                           class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs font-mono focus:ring-1 focus:ring-stone-900 focus:outline-none">
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-xs font-mono font-semibold text-stone-700 mb-1">Expected Destination Arrival *</label>
                    <input type="datetime-local" name="expected_arrival" value="{{ old('expected_arrival', now()->addDays(21)->format('Y-m-d\TH:i')) }}" required
                           class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs font-mono focus:ring-1 focus:ring-stone-900 focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Packing Manifest Items -->
        <div class="bg-white rounded-xl p-6 border border-stone-200 shadow-2xs space-y-4">
            <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-stone-900 border-b border-stone-100 pb-2">
                3. Packing Specifications
            </h3>

            <div class="p-4 rounded-lg bg-stone-50 border border-stone-200 grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
                <div class="sm:col-span-2">
                    <label class="block font-mono font-semibold text-stone-700 mb-1">Lot Specification *</label>
                    <input type="text" name="items[0][item_name]" value="Arabica Gayo Wet Hulled Premium Lot #01" required
                           class="w-full px-2.5 py-1.5 rounded border border-stone-300 bg-white">
                </div>
                <div>
                    <label class="block font-mono font-semibold text-stone-700 mb-1">Units (Bags/Crates) *</label>
                    <input type="number" name="items[0][quantity]" value="200" required
                           class="w-full px-2.5 py-1.5 rounded border border-stone-300 bg-white font-mono">
                </div>
                <div>
                    <label class="block font-mono font-semibold text-stone-700 mb-1">Weight (kg) *</label>
                    <input type="number" step="0.01" name="items[0][weight_kg]" value="12000" required
                           class="w-full px-2.5 py-1.5 rounded border border-stone-300 bg-white font-mono">
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 font-mono">
            <a href="{{ route('shipments.index') }}" class="px-4 py-2 rounded-lg border border-stone-300 bg-white hover:bg-stone-50 text-stone-700 text-xs font-semibold transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-5 py-2 rounded-lg bg-canopy-800 hover:bg-canopy-900 text-white font-bold text-xs shadow-2xs transition-colors cursor-pointer">
                Issue Manifest & Book Cargo
            </button>
        </div>
    </form>
</div>
@endsection
