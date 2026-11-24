@extends('layouts.app')

@php
    $isEn = app()->getLocale() === 'en';
@endphp

@section('title', $isEn ? 'Create New Account — AgriLian' : 'Daftar Akun Baru — AgriLian')

@section('content')
<div class="max-w-xl mx-auto my-8 sm:my-12 px-4 sm:px-6">
    <div class="bg-gradient-to-b from-[#E7F5DC] via-[#F4F9EE] to-[#E7F5DC] rounded-3xl shadow-xl shadow-[#728156]/15 border-2 border-[#B6C99B] overflow-hidden">
        
        <!-- Header with Official Logo Bubble -->
        <div class="p-6 sm:p-7 text-center border-b border-[#CFE1B9] bg-gradient-to-b from-[#E7F5DC] to-[#CFE1B9]/50">
            <!-- Bubble Logo Badge -->
            <div class="inline-flex items-center gap-3 bg-white px-4 py-2 rounded-2xl border border-[#B6C99B] shadow-xs mb-3">
                <div class="w-8 h-8 rounded-xl bg-white p-0.5 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/logo.jpg') }}" alt="AgriLian Logo" class="w-full h-full object-contain">
                </div>
                <div class="text-left leading-tight">
                    <span class="text-xs sm:text-sm font-extrabold text-[#1D2617] tracking-tight block">AgriLian <span class="text-[#728156]">CargoTrace</span></span>
                    <span class="text-[9px] font-bold text-[#728156] uppercase tracking-wider font-mono">Multimodal Logistics</span>
                </div>
            </div>

            <h1 class="text-xl sm:text-2xl font-extrabold text-[#1D2617] tracking-tight">
                {{ $isEn ? 'Create New Account' : 'Pendaftaran Akun Baru' }}
            </h1>
            <p class="text-xs text-[#4C5836] font-medium mt-1 font-mono tracking-wide">
                {{ $isEn ? 'AgriLian CargoTrace Logistics Ecosystem' : 'Ekosistem Logistik Terpadu AgriLian CargoTrace' }}
            </p>
        </div>

        <!-- Form Body -->
        <div class="p-6 sm:p-8 bg-[#F7FAF4] space-y-4">
            @if ($errors->any())
                <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-xs font-bold text-[#1D2617] mb-1.5">
                        {{ $isEn ? 'Full Name / Company Entity' : 'Nama Lengkap / Nama Usaha' }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               placeholder="{{ $isEn ? 'e.g. CV Gayo Highland Mandiri' : 'Contoh: Koperasi Kopi Gayo Mandiri' }}" required autofocus
                               class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-[#CFE1B9] text-xs font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#728156] focus:border-transparent transition-all shadow-2xs bg-white">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-[#1D2617] mb-1.5">
                        {{ $isEn ? 'Active Email Address' : 'Alamat Email Aktif' }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               placeholder="nama@email.com" required
                               class="w-full pl-10 pr-3.5 py-2.5 rounded-xl border border-[#CFE1B9] text-xs font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#728156] focus:border-transparent transition-all shadow-2xs bg-white">
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-xs font-bold text-[#1D2617] mb-1.5">
                        {{ $isEn ? 'Account Category / Role' : 'Peran / Kategori Akun' }}
                    </label>
                    <select id="role" name="role" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-[#CFE1B9] text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#728156] focus:border-transparent transition-all bg-white shadow-2xs">
                        <option value="customer" selected>{{ $isEn ? 'Consignor / Commodity Shipper / Buyer' : 'Pengirim Barang / Pelanggan Kargo' }}</option>
                        <option value="operator">{{ $isEn ? 'Logistics Operations Staff' : 'Staf Operasional Logistik' }}</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold text-[#1D2617] mb-1.5">
                            {{ $isEn ? 'Password' : 'Kata Sandi' }}
                        </label>
                        <input type="password" id="password" name="password" 
                               placeholder="Minimal 8 karakter" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-[#CFE1B9] text-xs font-mono font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#728156] focus:border-transparent transition-all shadow-2xs bg-white">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-[#1D2617] mb-1.5">
                            {{ $isEn ? 'Confirm Password' : 'Ulangi Kata Sandi' }}
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               placeholder="Ketik ulang sandi" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-[#CFE1B9] text-xs font-mono font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#728156] focus:border-transparent transition-all shadow-2xs bg-white">
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn-brand-accent w-full py-2.5 px-4 rounded-xl text-xs font-bold cursor-pointer transition-transform active:scale-[0.98] shadow-md flex items-center justify-center gap-2 mt-2">
                    <span>{{ $isEn ? 'Complete Registration' : 'Selesaikan Pendaftaran' }}</span>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <!-- Tautan ke Halaman Login -->
            <div class="pt-4 border-t border-[#CFE1B9] text-center text-xs text-[#4C5836]">
                {{ $isEn ? 'Already registered?' : 'Sudah memiliki akun?' }}
                <a href="{{ route('login') }}" class="font-bold text-[#728156] hover:text-[#384226] transition-colors ml-1">
                    {{ $isEn ? 'Sign in to Portal' : 'Masuk ke Portal di sini' }}
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
