@extends('layouts.app')

@section('title', 'Login Staf & Dispatcher')

@section('content')
<div class="max-w-md mx-auto my-10">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Header -->
        <div class="bg-hero-gradient p-6 text-center relative overflow-hidden">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#2D6A4F] to-[#1B4332] border border-[#95D5B2]/40 text-white flex items-center justify-center mx-auto mb-2.5 shadow-sm">
                <svg class="w-5 h-5 text-[#95D5B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            
            <h1 class="text-lg font-bold text-white tracking-tight">Otentikasi Staf & Operator</h1>
            <p class="text-xs text-slate-300 mt-0.5">CargoTrace AgriLian Operations Portal</p>
        </div>

        <div class="p-6 space-y-5">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email Staf</label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@cargotrace.com') }}" required autofocus
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 transition-all">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi (Password)</label>
                    <input type="password" id="password" name="password" value="password123" required
                           class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono font-medium text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 transition-all">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                        Ingat sesi saya
                    </label>
                </div>

                <button type="submit" class="btn-brand-primary w-full py-2.5 px-4 rounded-lg text-xs font-bold shadow-xs cursor-pointer">
                    Masuk ke Dashboard Operasional &rarr;
                </button>
            </form>

            <!-- Fast Role Switcher for Demo Evaluation -->
            <div class="pt-4 border-t border-slate-100">
                <span class="block text-center text-[10px] font-bold tracking-wider text-slate-400 uppercase mb-2">
                    Akun Demo Evaluasi (1-Klik Isi)
                </span>
                <div class="grid grid-cols-1 gap-1.5">
                    <button type="button" onclick="fillDemo('admin@cargotrace.com')" class="flex items-center justify-between p-2 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-left transition-colors cursor-pointer">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Ayaa Liandes (Admin Utama)</div>
                            <div class="text-[10px] text-slate-500 font-mono">admin@cargotrace.com</div>
                        </div>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-200 text-slate-800">ADMIN</span>
                    </button>

                    <button type="button" onclick="fillDemo('operator@cargotrace.com')" class="flex items-center justify-between p-2 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-left transition-colors cursor-pointer">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Reza Pratama (Dispatcher Lapangan)</div>
                            <div class="text-[10px] text-slate-500 font-mono">operator@cargotrace.com</div>
                        </div>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800">OPERATOR</span>
                    </button>

                    <button type="button" onclick="fillDemo('buyer.amsterdam@eurocoffee.nl')" class="flex items-center justify-between p-2 rounded-lg bg-slate-50 hover:bg-slate-100 border border-slate-200 text-left transition-colors cursor-pointer">
                        <div>
                            <div class="text-xs font-bold text-slate-900">Amsterdam Coffee Roasters</div>
                            <div class="text-[10px] text-slate-500 font-mono">buyer.amsterdam@eurocoffee.nl</div>
                        </div>
                        <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600">CUSTOMER</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function fillDemo(email) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = 'password123';
    }
</script>
@endsection
