@extends('layouts.app')

@section('title', 'Consignments Manifest')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="font-mono text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-stone-200/70 text-stone-700">
                    Trade Manifest Roster
                </span>
                <span class="text-xs text-stone-400">&bull;</span>
                <span class="text-xs text-stone-500 font-mono">Multimodal Agro Logistics</span>
            </div>
            <h1 class="text-2xl font-extrabold text-espresso-950 tracking-tight">Agro-Export Consignments</h1>
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
            <a href="{{ route('shipments.create') }}" class="px-4 py-2 rounded-lg bg-canopy-800 hover:bg-canopy-900 text-white text-xs font-bold shadow-2xs transition-colors flex items-center gap-1.5 self-start sm:self-auto cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Register New Manifest</span>
            </a>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-xl p-4 border border-stone-200 shadow-2xs">
        <form action="{{ route('shipments.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tracking # or commodity..."
                       class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs font-mono focus:ring-1 focus:ring-stone-900 focus:outline-none">
            </div>

            <div>
                <select name="status" class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs font-mono focus:ring-1 focus:ring-stone-900 focus:outline-none">
                    <option value="">All Statuses</option>
                    <option value="CREATED" {{ request('status') == 'CREATED' ? 'selected' : '' }}>CREATED</option>
                    <option value="BOOKED" {{ request('status') == 'BOOKED' ? 'selected' : '' }}>BOOKED</option>
                    <option value="PICKED_UP" {{ request('status') == 'PICKED_UP' ? 'selected' : '' }}>PICKED_UP</option>
                    <option value="IN_TRANSIT" {{ request('status') == 'IN_TRANSIT' ? 'selected' : '' }}>IN_TRANSIT</option>
                    <option value="DELIVERED" {{ request('status') == 'DELIVERED' ? 'selected' : '' }}>DELIVERED</option>
                </select>
            </div>

            <div>
                <select name="carrier_id" class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs font-mono focus:ring-1 focus:ring-stone-900 focus:outline-none">
                    <option value="">All Carriers</option>
                    @foreach($carriers as $c)
                        <option value="{{ $c->id }}" {{ request('carrier_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->transport_mode }})</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2 rounded-lg bg-espresso-900 hover:bg-black text-white text-xs font-bold transition-colors cursor-pointer font-mono">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'carrier_id', 'delayed']))
                    <a href="{{ route('shipments.index') }}" class="px-3 py-2 rounded-lg bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-mono transition-colors">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 font-mono uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3 px-4 font-bold">Consignment ID</th>
                        <th class="py-3 px-4 font-bold">Consignee Buyer</th>
                        <th class="py-3 px-4 font-bold">Agro Commodity</th>
                        <th class="py-3 px-4 font-bold">Transit Corridor</th>
                        <th class="py-3 px-4 font-bold">Fleet</th>
                        <th class="py-3 px-4 font-bold">Status & ETA</th>
                        <th class="py-3 px-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700">
                    @forelse($shipments as $s)
                        @php
                            $isCoffee = str_contains(strtolower($s->cargo_type), 'arabica') || str_contains(strtolower($s->cargo_type), 'coffee');
                            $isHorti = str_contains(strtolower($s->cargo_type), 'avocado') || str_contains(strtolower($s->cargo_type), 'chili');
                        @endphp
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-stone-900">
                                <a href="{{ route('shipments.show', $s->id) }}" class="hover:text-canopy-800">
                                    {{ $s->tracking_number }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-stone-900">
                                {{ $s->customer->name ?? 'Confidential' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-stone-900 flex items-center gap-1.5">
                                    @if($isCoffee)
                                        <span class="text-[10px]">☕</span>
                                    @elseif($isHorti)
                                        <span class="text-[10px]">🥑</span>
                                    @endif
                                    <span>{{ $s->cargo_type }}</span>
                                </div>
                                <div class="text-[10px] font-mono text-stone-400 mt-0.5">
                                    {{ number_format($s->weight_kg, 0) }} kg &bull; {{ $s->volume_cbm ?? '-' }} CBM
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-[11px]">
                                <div class="font-semibold text-stone-800">{{ $s->origin->name }} &rarr; {{ $s->destination->name }}</div>
                                <div class="text-canopy-900 font-mono text-[10px] font-semibold">At: {{ $s->currentLocation->name ?? 'In Transit' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-medium text-stone-900">{{ $s->carrier->name }}</span>
                                <span class="block text-[10px] font-mono text-stone-400">[{{ $s->carrier->transport_mode }}]</span>
                            </td>
                            <td class="py-3.5 px-4">
                                @php
                                    $badge = match($s->status) {
                                        'CREATED' => 'bg-stone-100 text-stone-800 border-stone-300',
                                        'BOOKED' => 'bg-blue-50 text-blue-900 border-blue-200',
                                        'PICKED_UP' => 'bg-amber-50 text-amber-900 border-amber-200',
                                        'IN_TRANSIT' => 'bg-emerald-50 text-emerald-900 border-emerald-300',
                                        'DELIVERED' => 'bg-stone-900 text-white border-stone-900',
                                        default => 'bg-stone-100 text-stone-800',
                                    };
                                @endphp
                                <span class="px-2 py-0.5 rounded font-mono text-[9px] font-bold uppercase border {{ $badge }}">
                                    {{ $s->status }}
                                </span>
                                @if($s->is_delayed)
                                    <span class="block text-[9px] font-mono text-amber-800 font-bold mt-1">
                                        ⚠️ +{{ $s->delay_duration_hours }}h Delay
                                    </span>
                                @else
                                    <span class="block text-[10px] font-mono text-stone-400 mt-1">
                                        ETA: {{ \Carbon\Carbon::parse($s->estimated_arrival)->format('d M, H:i') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1 font-mono">
                                <a href="{{ route('shipments.show', $s->id) }}" class="px-2.5 py-1 rounded bg-stone-100 text-stone-800 hover:bg-stone-200 font-semibold text-[11px] transition-colors">
                                    Manage
                                </a>
                                <a href="{{ route('track.public', $s->tracking_number) }}" target="_blank" title="Open Public Radar" class="px-2 py-1 rounded bg-stone-50 text-stone-500 hover:bg-stone-100 text-[11px] transition-colors">
                                    Radar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-stone-400 italic">No consignments match the query.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($shipments->hasPages())
            <div class="p-4 border-t border-stone-200 bg-stone-50/50">
                {{ $shipments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
