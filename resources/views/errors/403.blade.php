@php
    $isEn = app()->getLocale() === 'en';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEn ? '403 - Access Restricted • AgriLian CargoTrace' : '403 - Akses Dibatasi • AgriLian CargoTrace' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="min-h-screen bg-[#F8FAFC] flex flex-col justify-between text-slate-800">

    <header class="p-6 flex items-center justify-between max-w-5xl mx-auto w-full">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white p-1 border border-slate-200 shadow-xs flex items-center justify-center">
                <img src="/images/logo.jpg" alt="AgriLian Logo" class="w-full h-full object-contain">
            </div>
            <div>
                <span class="text-sm font-bold text-slate-900 block leading-tight">AgriLian</span>
                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider block font-mono">CargoTrace Platform</span>
            </div>
        </div>
        <a href="/dashboard" class="px-3.5 py-1.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition-colors">
            {{ $isEn ? 'Dashboard' : 'Dasbor' }}
        </a>
    </header>

    <main class="flex-1 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-xl text-center space-y-5">
            <div class="w-16 h-16 rounded-2xl bg-rose-50 text-rose-700 border border-rose-200 flex items-center justify-center mx-auto text-2xl font-black font-mono shadow-xs">
                403
            </div>

            <div>
                <span class="text-[11px] font-bold text-rose-600 uppercase tracking-widest font-mono">
                    {{ $isEn ? 'Authorization Denied (RBAC)' : 'Otorisasi Ditolak (RBAC)' }}
                </span>
                <h1 class="text-xl font-bold text-slate-900 mt-1">
                    {{ $isEn ? 'Operational Access Restricted' : 'Akses Operasional Dibatasi' }}
                </h1>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    {{ $isEn ? 'Your account does not possess the required role permissions to open or modify this cargo manifest. Please contact your system Administrator.' : 'Akun Anda tidak memiliki hak akses otorisasi untuk membuka atau memodifikasi berkas manifes kargo ini. Silakan hubungi Administrator sistem.' }}
                </p>
            </div>

            <div class="pt-2 flex flex-col sm:flex-row gap-2 justify-center">
                <a href="/dashboard" class="px-5 py-2.5 rounded-xl bg-[#051F20] hover:bg-[#0B2B26] text-white text-xs font-bold transition-all shadow-md">
                    {{ $isEn ? 'Return to Safe Dashboard' : 'Kembali ke Dasbor Aman' }}
                </a>
            </div>
        </div>
    </main>

    <footer class="p-6 text-center text-xs text-slate-400 font-mono">
        &copy; 2026 AgriLian Logistics Systems &bull; {{ $isEn ? 'Role-Based Access Security' : 'Keamanan Akses Berbasis Peran' }}
    </footer>

</body>
</html>
