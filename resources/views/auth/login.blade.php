@extends('layouts.app')

@section('title', 'Login — CargoTrace AgriLian')

@section('content')
<div class="max-w-md mx-auto my-12 px-4">
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200/90 overflow-hidden">
        
        <!-- Header with Highland Gradient -->
        <div class="bg-hero-gradient p-7 text-center relative overflow-hidden">
            <!-- Subtle Ambient Light -->
            <div class="absolute -top-12 -left-12 w-36 h-36 rounded-full bg-[#95D5B2]/15 blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -right-12 w-36 h-36 rounded-full bg-[#57C84D]/15 blur-2xl pointer-events-none"></div>

            <div class="relative z-10">
                <!-- Brand / User Logo (Siap Diganti dengan Logo Buatan Ayaa) -->
                <div id="login-brand-logo" class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#2D6A4F] to-[#1B4332] border border-[#95D5B2]/40 text-white flex items-center justify-center mx-auto mb-3 shadow-md shadow-black/20">
                    <svg class="w-6 h-6 text-[#95D5B2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                
                <!-- Judul Sederhana Sesuai Standar Login Modern -->
                <h1 class="text-2xl font-black text-white tracking-tight">Login</h1>
                <!-- Subtitle dengan Identitas AgriLian -->
                <p class="text-xs text-[#95D5B2] font-semibold mt-1">CargoTrace AgriLian Platform</p>
            </div>
        </div>

        <!-- Form Body -->
        <div class="p-6 sm:p-7 space-y-5">
            @if ($errors->any())
                <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@cargotrace.com') }}" placeholder="masukkan alamat email..." required autofocus
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#57C84D] focus:border-transparent transition-all">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                    <input type="password" id="password" name="password" value="password123" placeholder="masukkan kata sandi..." required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#57C84D] focus:border-transparent transition-all">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium select-none">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#1B4332] focus:ring-[#57C84D]">
                        Ingat sesi saya
                    </label>
                </div>

                <!-- Tombol 1 Kata: Masuk -->
                <button type="submit" class="btn-brand-accent w-full py-2.5 px-4 rounded-xl text-xs font-bold cursor-pointer transition-transform active:scale-[0.98] shadow-sm">
                    Masuk
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
