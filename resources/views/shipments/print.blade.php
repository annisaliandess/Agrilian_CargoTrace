@php
    $isEn = app()->getLocale() === 'en';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEn ? 'Multimodal Export Waybill' : 'Surat Jalan Ekspor Multimodal' }} - {{ $shipment->tracking_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0f172a;
            background: #f8fafc;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-page {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 1.5cm !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8">

    <!-- Top Action Bar (Screen only, hidden on print) -->
    <div class="max-w-4xl mx-auto mb-6 no-print flex items-center justify-between bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('shipments.show', $shipment->id) }}" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                &larr; {{ $isEn ? 'Back to Details' : 'Kembali ke Rincian' }}
            </a>
            <span class="text-xs text-slate-400">|</span>
            <span class="text-xs font-semibold text-slate-600">
                {{ $isEn ? 'Physical Multimodal Export Waybill Document' : 'Dokumen Fisik Surat Jalan Ekspor Multimodal' }}
            </span>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-[#051F20] hover:bg-[#0B2B26] text-white text-xs font-bold shadow-md flex items-center gap-2 cursor-pointer transition-all">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>{{ $isEn ? 'Print Document (Print / PDF)' : 'Cetak Dokumen (Print / PDF)' }}</span>
            </button>
        </div>
    </div>

    <!-- Official A4 Canvas Paper Document -->
    <div class="max-w-4xl mx-auto bg-white border border-slate-300 rounded-3xl p-8 sm:p-12 shadow-xl print-page space-y-6">

        <!-- 1. Header Kop Surat Resmi -->
        <div class="flex items-start justify-between border-b-2 border-slate-900 pb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white border border-slate-300 p-1 flex items-center justify-center shrink-0">
                    <img src="/images/logo.jpg" alt="AgriLian Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-xl font-black text-slate-900 tracking-tight leading-tight">AGRILIAN CARGOTRACE LOGISTICS</h1>
                    <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wider font-mono">
                        {{ $isEn ? 'Highland Agro-Export Multimodal Visibility Platform' : 'Platform Visibilitas Ekspor Agro Multimoda Dataran Tinggi' }}
                    </div>
                    <div class="text-[10px] text-slate-500 mt-0.5">
                        {{ $isEn ? 'Central Hub: Jl. Takengon - Bireuen Km 4, Central Aceh • Belawan Port Terminal • Rotterdam Direct' : 'Hub Pusat: Jl. Takengon - Bireuen Km 4, Aceh Tengah • Terminal Pelabuhan Belawan • Rotterdam Langsung' }}
                    </div>
                </div>
            </div>

            <!-- Barcode & QR Code Pelacakan Resmi -->
            <div class="flex items-center gap-3.5">
                <div class="bg-white p-1 rounded-xl border border-slate-300 shadow-2xs flex flex-col items-center">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=90x90&color=051F20&bgcolor=FFFFFF&data={{ urlencode(url('/track/' . $shipment->tracking_number)) }}" 
                         alt="QR Pelacakan Kargo" class="w-16 h-16 object-contain">
                    <span class="text-[7px] font-mono font-bold text-slate-600 uppercase tracking-tight mt-0.5">
                        {{ $isEn ? 'SCAN QR TO TRACK' : 'PINDAI QR LACAK' }}
                    </span>
                </div>

                <div class="text-right flex flex-col items-end">
                    <div class="bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-300 flex flex-col items-center">
                        <svg class="h-6 w-36 text-slate-900" viewBox="0 0 176 26" fill="currentColor">
                            <rect x="0" y="0" width="2" height="26"/><rect x="4" y="0" width="1" height="26"/><rect x="7" y="0" width="3" height="26"/><rect x="12" y="0" width="1" height="26"/><rect x="15" y="0" width="2" height="26"/><rect x="19" y="0" width="4" height="26"/><rect x="25" y="0" width="1" height="26"/><rect x="28" y="0" width="2" height="26"/><rect x="32" y="0" width="3" height="26"/><rect x="37" y="0" width="1" height="26"/><rect x="40" y="0" width="2" height="26"/><rect x="44" y="0" width="4" height="26"/><rect x="50" y="0" width="2" height="26"/><rect x="54" y="0" width="1" height="26"/><rect x="57" y="0" width="3" height="26"/><rect x="62" y="0" width="1" height="26"/><rect x="65" y="0" width="2" height="26"/><rect x="69" y="0" width="4" height="26"/><rect x="75" y="0" width="2" height="26"/><rect x="79" y="0" width="1" height="26"/><rect x="82" y="0" width="3" height="26"/><rect x="87" y="0" width="2" height="26"/><rect x="91" y="0" width="1" height="26"/><rect x="94" y="0" width="4" height="26"/><rect x="100" y="0" width="2" height="26"/><rect x="104" y="0" width="1" height="26"/><rect x="107" y="0" width="3" height="26"/><rect x="112" y="0" width="1" height="26"/><rect x="115" y="0" width="3" height="26"/><rect x="120" y="0" width="2" height="26"/><rect x="124" y="0" width="1" height="26"/><rect x="127" y="0" width="4" height="26"/><rect x="133" y="0" width="2" height="26"/><rect x="137" y="0" width="1" height="26"/><rect x="140" y="0" width="3" height="26"/><rect x="145" y="0" width="2" height="26"/><rect x="149" y="0" width="1" height="26"/><rect x="152" y="0" width="3" height="26"/><rect x="157" y="0" width="2" height="26"/><rect x="161" y="0" width="1" height="26"/><rect x="164" y="0" width="4" height="26"/><rect x="170" y="0" width="2" height="26"/><rect x="174" y="0" width="2" height="26"/>
                        </svg>
                        <span class="text-[9px] font-mono tracking-widest text-slate-800 font-bold uppercase mt-1">*{{ $shipment->tracking_number }}*</span>
                    </div>
                    <div class="text-[9px] text-slate-500 font-mono mt-1">
                        {{ $isEn ? 'Printed:' : 'Dicetak:' }} {{ now()->format('d M Y, H:i') }} &bull; {{ $isEn ? 'Security Key:' : 'Kunci Keamanan API:' }} <strong class="text-slate-700">SEC-{{ strtoupper(substr(md5($shipment->tracking_number), 0, 8)) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Dokumen Title & Status Strip -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-slate-100 p-3.5 rounded-xl border border-slate-200">
            <div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider font-mono">
                    {{ $isEn ? 'Document Type:' : 'Jenis Dokumen:' }}
                </span>
                <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-tight">
                    {{ $isEn ? 'MULTIMODAL EXPORT CONSIGNMENT WAYBILL' : 'SURAT JALAN PENGIRIMAN EKSPOR MULTIMODAL' }}
                </h2>
            </div>
            <div class="flex items-center gap-2 font-mono text-xs">
                <span class="text-slate-500">{{ $isEn ? 'Cargo Status:' : 'Status Kargo:' }}</span>
                <span class="px-2.5 py-0.5 rounded-md font-bold uppercase border bg-white text-slate-900 border-slate-300">
                    {{ $isEn ? match($shipment->status) {
                        'In Transit' => 'In Transit',
                        'Delayed' => 'Delayed',
                        'Delivered' => 'Delivered',
                        'Customs Hold' => 'Customs Hold',
                        default => $shipment->status,
                    } : match($shipment->status) {
                        'In Transit' => 'Dalam Perjalanan',
                        'Delayed' => 'Tertunda',
                        'Delivered' => 'Terkirim',
                        'Customs Hold' => 'Tertahan Bea Cukai',
                        default => $shipment->status,
                    } }}
                </span>
            </div>
        </div>

        <!-- 3. Rincian Pihak & Rute Ekspor (2 Columns) -->
        <div class="grid grid-cols-2 gap-6 text-xs border border-slate-200 rounded-2xl p-4">
            <!-- Kolom Pengirim -->
            <div class="space-y-1.5 border-r border-slate-200 pr-4">
                <div class="text-[10px] font-bold text-slate-400 uppercase font-mono">
                    {{ $isEn ? '1. SHIPPER & ORIGIN' : '1. PENGIRIM & ASAL' }}
                </div>
                <div class="font-bold text-sm text-slate-900">
                    {{ $isEn ? 'Gayo Highland Organic Farmers Cooperative' : 'Koperasi Tani Dataran Tinggi Gayo Organik' }}
                </div>
                <div class="text-slate-600">Hub: {{ $shipment->origin->name ?? ($isEn ? 'Takengon Central Hub' : 'Pusat Hub Takengon') }}</div>
                <div class="text-slate-600">{{ $isEn ? 'Location:' : 'Lokasi:' }} {{ $shipment->origin->city ?? 'Takengon' }}, {{ $shipment->origin->country ?? 'Indonesia' }} (1.400 mdpl)</div>
                <div class="text-slate-600 font-mono text-[11px] pt-1">
                    {{ $isEn ? 'Scheduled Departure:' : 'Jadwal Keberangkatan:' }} <strong>{{ \Carbon\Carbon::parse($shipment->expected_departure)->format('d M Y, H:i') }} WIB</strong>
                </div>
            </div>

            <!-- Kolom Penerima -->
            <div class="space-y-1.5 pl-2">
                <div class="text-[10px] font-bold text-slate-400 uppercase font-mono">
                    {{ $isEn ? '2. CONSIGNEE & DESTINATION' : '2. PENERIMA & TUJUAN' }}
                </div>
                <div class="font-bold text-sm text-slate-900">{{ $shipment->customer->name ?? 'International Coffee Importers B.V.' }}</div>
                <div class="text-slate-600">Email: {{ $shipment->customer->email ?? 'buyer@agrilian.com' }}</div>
                <div class="text-slate-600">{{ $isEn ? 'Destination Port:' : 'Pelabuhan Tujuan:' }} {{ $shipment->destination->name ?? 'Port of Rotterdam' }} ({{ $shipment->destination->city ?? 'Rotterdam' }}, {{ $isEn ? 'Netherlands' : 'Belanda' }})</div>
                <div class="text-slate-600 font-mono text-[11px] pt-1">
                    {{ $isEn ? 'Target Arrival (ETA):' : 'Perkiraan Tiba (ETA):' }} <strong>{{ \Carbon\Carbon::parse($shipment->expected_arrival)->format('d M Y, H:i') }}</strong>
                </div>
            </div>
        </div>

        <!-- 4. Moda Transportasi Multimodal & Armada -->
        <div class="grid grid-cols-3 gap-4 text-xs border border-slate-200 rounded-2xl p-4 bg-slate-50/60">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase font-mono block">
                    {{ $isEn ? 'Carrying Fleet' : 'Armada Pengangkut' }}
                </span>
                <strong class="text-slate-900 font-mono">{{ $shipment->carrier->name ?? 'Maersk Line Multimodal' }}</strong>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase font-mono block">
                    {{ $isEn ? 'Transport Mode' : 'Moda Transportasi' }}
                </span>
                <strong class="text-slate-900 font-mono">
                    {{ $isEn ? 'MULTIMODAL (TRUCK • OCEAN VESSEL)' : 'MULTIMODA (TRUK • KAPAL SAMUDERA)' }}
                </strong>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase font-mono block">
                    {{ $isEn ? 'Official Customs Seal' : 'Segel Pabean Bea Cukai' }}
                </span>
                <strong class="text-slate-900 font-mono">ID-CUSTOMS-{{ substr(md5($shipment->tracking_number), 0, 8) }}</strong>
            </div>
        </div>

        <!-- 5. Tabel Rincian Barang (Item Specification) -->
        <div class="space-y-2">
            <div class="text-[10px] font-bold text-slate-400 uppercase font-mono">
                {{ $isEn ? '3. CARGO SPECIFICATIONS & PACKING LIST' : '3. RINCIAN SPESIFIKASI MUATAN BARANG' }}
            </div>
            <table class="w-full text-xs border border-slate-300 rounded-xl overflow-hidden">
                <thead class="bg-slate-100 text-slate-700 font-mono text-[11px] border-b border-slate-300">
                    <tr>
                        <th class="py-2.5 px-3 text-left">No.</th>
                        <th class="py-2.5 px-3 text-left">{{ $isEn ? 'Commodity & Lot Description' : 'Deskripsi Komoditas & Lot' }}</th>
                        <th class="py-2.5 px-3 text-left">{{ $isEn ? 'Packaging Type' : 'Jenis Kemasan' }}</th>
                        <th class="py-2.5 px-3 text-right">{{ $isEn ? 'Quantity' : 'Kuantitas' }}</th>
                        <th class="py-2.5 px-3 text-right">{{ $isEn ? 'Weight (kg)' : 'Berat (kg)' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($shipment->items as $idx => $item)
                        <tr>
                            <td class="py-2.5 px-3 font-mono text-slate-500">{{ $idx + 1 }}</td>
                            <td class="py-2.5 px-3 font-semibold text-slate-900">
                                {{ $item->item_name }}
                                @if($item->description)
                                    <span class="block text-[10px] text-slate-500 font-normal">{{ $item->description }}</span>
                                @endif
                            </td>
                            <td class="py-2.5 px-3 text-slate-600 font-mono">{{ $item->package_type ?? ($isEn ? 'GrainPro Hermetic + Jute Bag' : 'Kantong GrainPro + Goni') }}</td>
                            <td class="py-2.5 px-3 text-right font-mono font-bold">{{ number_format($item->quantity) }} {{ $isEn ? 'Bags/Units' : 'Karung/Koli' }}</td>
                            <td class="py-2.5 px-3 text-right font-mono font-bold">{{ number_format($item->weight_kg, 2) }} kg</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-2.5 px-3 font-mono text-slate-500">1</td>
                            <td class="py-2.5 px-3 font-semibold text-slate-900">{{ $shipment->cargo_type }}</td>
                            <td class="py-2.5 px-3 text-slate-600 font-mono">{{ $isEn ? 'Standard Export Packaging' : 'Kemasan Ekspor Standar' }}</td>
                            <td class="py-2.5 px-3 text-right font-mono font-bold">{{ $isEn ? '1 Container Lot' : '1 Lot Kontainer' }}</td>
                            <td class="py-2.5 px-3 text-right font-mono font-bold">{{ number_format($shipment->weight_kg, 2) }} kg</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-slate-50 font-mono border-t border-slate-300 font-bold">
                    <tr>
                        <td colspan="4" class="py-2.5 px-3 text-right text-slate-700">
                            {{ $isEn ? 'TOTAL CARGO TONNAGE:' : 'TOTAL TONASE MUATAN:' }}
                        </td>
                        <td class="py-2.5 px-3 text-right text-slate-900 text-sm">{{ number_format($shipment->weight_kg, 2) }} kg</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- 6. Kepatuhan Fitosanitari & Parameter Mutu -->
        <div class="grid grid-cols-2 gap-4 text-xs p-3.5 rounded-xl border border-slate-200 bg-slate-50">
            <div>
                <span class="text-[10px] font-bold text-slate-500 uppercase font-mono block">
                    {{ $isEn ? 'Commodity Quality Parameters:' : 'Parameter Mutu Komoditas:' }}
                </span>
                <span class="text-slate-700 font-medium leading-relaxed block mt-0.5">
                    {{ $isEn ? 'Moisture Content: 11.4% • Defect Count: < 3 (Grade 1) • SCA Score: 87.5 • Fairtrade Organic' : 'Kadar Air: 11,4% • Nilai Cacat: < 3 (Mutu 1) • Skor SCA: 87,5 • Organik Fairtrade' }}
                </span>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-500 uppercase font-mono block">
                    {{ $isEn ? 'Export Foreign Exchange Valuation:' : 'Valuasi Devisa Ekspor:' }}
                </span>
                <span class="text-slate-900 font-mono font-bold block mt-0.5">
                    {{ $valuation['usd_formatted'] ?? '$ 138,000 USD' }} ({{ $valuation['eur_formatted'] ?? '€ 130,800 EUR' }})
                </span>
            </div>
        </div>

        <!-- 7. Lembar Tanda Tangan Resmi (3 Kolom) -->
        <div class="pt-6 border-t border-slate-300 space-y-3">
            <div class="text-[10px] font-bold text-slate-400 uppercase font-mono">
                {{ $isEn ? '4. CONSIGNMENT HANDOVER & AUTHENTICATION (SIGNATURES)' : '4. PENGESAHAN & SERAH TERIMA MUATAN (TANDA TANGAN RESMI)' }}
            </div>
            <div class="grid grid-cols-3 gap-6 text-center text-xs">
                <!-- Kolom 1 -->
                <div class="border border-slate-200 rounded-xl p-4 flex flex-col justify-between h-36">
                    <span class="font-bold text-slate-700">
                        {{ $isEn ? 'Origin Warehouse Officer' : 'Petugas Gudang Asal' }}<br>
                        <span class="font-normal text-[10px] text-slate-500">({{ $isEn ? 'Takengon Central Hub' : 'Pusat Hub Takengon' }})</span>
                    </span>
                    <div class="border-b border-dashed border-slate-400 w-3/4 mx-auto mb-1"></div>
                    <span class="text-[11px] font-mono text-slate-600">( {{ $isEn ? 'Dispatch Officer' : 'Petugas Dispatcher' }} )</span>
                </div>

                <!-- Kolom 2 -->
                <div class="border border-slate-200 rounded-xl p-4 flex flex-col justify-between h-36">
                    <span class="font-bold text-slate-700">
                        {{ $isEn ? 'Driver / Carrier' : 'Pengemudi / Pengangkut' }}<br>
                        <span class="font-normal text-[10px] text-slate-500">({{ $isEn ? 'Truck & Ocean Fleet' : 'Armada Truk & Kapal' }})</span>
                    </span>
                    <div class="border-b border-dashed border-slate-400 w-3/4 mx-auto mb-1"></div>
                    <span class="text-[11px] font-mono text-slate-600">( {{ $isEn ? 'Driver / Vessel Master' : 'Pengemudi / Nakhoda' }} )</span>
                </div>

                <!-- Kolom 3 -->
                <div class="border border-slate-200 rounded-xl p-4 flex flex-col justify-between h-36">
                    <span class="font-bold text-slate-700">
                        {{ $isEn ? 'Quarantine & Customs' : 'Karantina & Bea Cukai' }}<br>
                        <span class="font-normal text-[10px] text-slate-500">({{ $isEn ? 'Belawan Seaport Terminal' : 'Terminal Pelabuhan Belawan' }})</span>
                    </span>
                    <div class="border-b border-dashed border-slate-400 w-3/4 mx-auto mb-1"></div>
                    <span class="text-[11px] font-mono text-slate-600">( {{ $isEn ? 'Inspecting Officer' : 'Pejabat Pemeriksa' }} )</span>
                </div>
            </div>
        </div>

        <!-- Footer Notice -->
        <div class="text-[9px] text-slate-400 font-mono text-center pt-2">
            {{ $isEn ? 'This document is legally issued by AgriLian CargoTrace Multimodal Export Visibility System • Authenticity verification via:' : 'Dokumen ini diterbitkan secara sah oleh Sistem Visibilitas Ekspor AgriLian CargoTrace • Verifikasi keaslian dokumen via:' }} {{ url('/track/' . $shipment->tracking_number) }}
        </div>
    </div>

</body>
</html>
