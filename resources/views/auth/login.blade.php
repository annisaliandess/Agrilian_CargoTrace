@extends('layouts.app')

@section('title', 'Login Staf & Dispatcher')

@section('content')
<div class="max-w-md mx-auto my-10">
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden">
        
        <!-- Automark Inspired Gradient Header -->
        <div class="bg-hero-gradient p-7 text-center relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-32 h-32 rounded-full bg-[#57C84D]/20 blur-2xl pointer-events-none"></div>
            
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#2D6A4F] to-[#1B4332] border border-[#95D5B2]/40 text-white flex items-center justify-center mx-auto mb-3 shadow-md">
                <svg class="w-6 h-6 text-[#57C84D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            
            <h1 class="text-xl font-black text-white tracking-tight">Otentikasi Staf & Operator</h1>
            <p class="text-xs text-[#D8F3DC] mt-1 font-medium">CargoTrace AgriLian Operations Portal</p>
        </div>

        <div class="p-7 space-y-5">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Alamat Email Staf</label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@cargotrace.com') }}" required autofocus
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#57C84D] transition-all">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi (Password)</label>
                    <input type="password" id="password" name="password" value="password123" required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#57C84D] transition-all">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 text-xs font-medium">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#1B4332] focus:ring-[#57C84D]">
                        Ingat sesi saya
                    </label>
                </div>

                <button type="submit" class="btn-brand-primary w-full py-3 px-4 rounded-xl text-xs font-black shadow-md shadow-[#1B4332]/25 cursor-pointer">
                    Masuk ke Dashboard Operasional &rarr;
                </button>
            </form>

            <!-- Fast Role Switcher for Demo Evaluation -->
            <div class="pt-5 border-t border-slate-100">
                <span class="block text-center text-[10px] font-black tracking-wider text-slate-400 uppercase mb-2.5">
                    Tombol Cepat Akun Demo (1-Klik Isi)
                </span>
                <div class="grid grid-cols-1 gap-2">
                    <button type="button" onclick="fillDemo('admin@cargotrace.com')" class="flex items-center justify-between p-2.5 rounded-xl bg-[#F8FAF9] hover:bg-[#F0FBF5] border border-slate-200/80 hover:border-[#95D5B2] text-left transition-all cursor-pointer group">
                        <div>
                            <div class="text-xs font-black text-slate-900 group-hover:text-[#1B4332]">Ayaa Liandes (Admin Utama)</div>
                            <div class="text-[10px] text-slate-400 font-mono">admin@cargotrace.com</div>
                        </div>
                        <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-[#1B4332] text-white">ADMIN</span>
                    </button>

                    <button type="button" onclick="fillDemo('operator@cargotrace.com')" class="flex items-center justify-between p-2.5 rounded-xl bg-[#F8FAF9] hover:bg-[#F0FBF5] border border-slate-200/80 hover:border-[#95D5B2] text-left transition-all cursor-pointer group">
                        <div>
                            <div class="text-xs font-black text-slate-900 group-hover:text-[#1B4332]">Reza Pratama (Dispatcher Lapangan)</div>
                            <div class="text-[10px] text-slate-400 font-mono">operator@cargotrace.com</div>
                        </div>
                        <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-[#57C84D] text-[#0A2016]">OPERATOR</span>
                    </button>

                    <button type="button" onclick="fillDemo('buyer.amsterdam@eurocoffee.nl')" class="flex items-center justify-between p-2.5 rounded-xl bg-[#F8FAF9] hover:bg-[#F0FBF5] border border-slate-200/80 hover:border-[#95D5B2] text-left transition-all cursor-pointer group">
                        <div>
                            <div class="text-xs font-black text-slate-900 group-hover:text-[#1B4332]">Amsterdam Coffee Roasters</div>
                            <div class="text-[10px] text-slate-400 font-mono">buyer.amsterdam@eurocoffee.nl</div>
                        </div>
                        <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-slate-200 text-slate-700">CUSTOMER</span>
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
