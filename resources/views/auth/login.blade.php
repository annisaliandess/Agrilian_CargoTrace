@extends('layouts.app')

@php
    $isEn = app()->getLocale() === 'en';
@endphp

@section('title', $isEn ? 'Portal Sign In — AgriLian CargoTrace' : 'Masuk ke Portal — AgriLian CargoTrace')

@section('content')
<div class="max-w-4xl lg:max-w-5xl mx-auto my-5 sm:my-8 px-3 sm:px-4">
    <!-- Login Card: Gambar Lebih Besar (7 Kolom) & Form Ramping Lega Tidak Penuh (5 Kolom) -->
    <div class="bg-gradient-to-b from-[#E7F5DC] via-[#F4F9EE] to-[#E7F5DC] rounded-2xl sm:rounded-3xl shadow-xl shadow-[#728156]/15 border-2 border-[#B6C99B] overflow-hidden grid grid-cols-1 sm:grid-cols-12 items-stretch">
        
        <!-- Kolom Samping Kiri: Panel Gambar Lebih Besar (7 Kolom / ~58% Lebar Kartu) -->
        <div class="sm:col-span-7 relative overflow-hidden flex flex-col justify-between p-6 sm:p-7 lg:p-8 text-white min-h-[180px] sm:min-h-full">
            <!-- Background Image Kopi Agro Dataran Tinggi -->
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/coffee.jpg') }}');"></div>
            
            <!-- Directional Shading / Gradient Overlay Bernuansa Highland Forest Gelap -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#11180D] via-[#1D2617]/85 to-[#1D2617]/65 backdrop-blur-[0.5px]"></div>
            
            <!-- Konten Panel Gambar Samping Kiri -->
            <div class="relative z-10 flex flex-col justify-between h-full space-y-4 sm:space-y-6">
                <!-- Bagian Atas: Badge Koridor & Headline Informatif -->
                <div>
                    <!-- Badge Koridor Multimoda (Tanpa Logo & Nama Brand Sesuai Arahan) -->
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/45 backdrop-blur-md border border-white/20 text-[10px] sm:text-[11px] font-mono text-[#CFE1B9] font-semibold w-fit mb-2.5 sm:mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#B6C99B] animate-pulse"></span>
                        {{ $isEn ? 'Takengon — Belawan — Europe Corridor' : 'Koridor Takengon — Belawan — Eropa' }}
                    </div>

                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white tracking-tight leading-tight">
                        {{ $isEn ? 'Highland Agro-Cargo Visibility & Tracking System' : 'Sistem Visibilitas & Pelacakan Kargo Agro Dataran Tinggi' }}
                    </h2>
                    
                    <p class="text-xs sm:text-sm text-stone-200/90 leading-relaxed mt-2 sm:mt-2.5 font-normal max-w-lg">
                        {{ $isEn ? 'Integrated cargo monitoring from Gayo highland plantations to premier worldwide destination ports.' : 'Pemantauan pengiriman kargo terpadu dari perkebunan dataran tinggi Gayo hingga ke pelabuhan tujuan dunia.' }}
                    </p>
                </div>

                <!-- Bagian Bawah: 3 Feature Badges Real-Time (Rapi di Desktop, Tersembunyi di HP agar Tidak Menumpuk Panjang) -->
                <div class="hidden sm:flex flex-col space-y-2.5 pt-3">
                    <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-white/95 font-medium">
                        <div class="w-5 h-5 rounded-lg bg-[#728156]/50 flex items-center justify-center shrink-0 text-[#CFE1B9]">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <span class="text-xs leading-tight">{{ $isEn ? '100% Real-Time Shipment Telemetry' : '100% Telemetri Resi Pengiriman Real-Time' }}</span>
                    </div>

                    <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-white/95 font-medium">
                        <div class="w-5 h-5 rounded-lg bg-[#728156]/50 flex items-center justify-center shrink-0 text-[#CFE1B9]">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="text-xs leading-tight">{{ $isEn ? 'Automated Weather Delay Detection' : 'Deteksi Keterlambatan Cuaca Otomatis' }}</span>
                    </div>

                    <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-white/95 font-medium">
                        <div class="w-5 h-5 rounded-lg bg-[#728156]/50 flex items-center justify-center shrink-0 text-[#CFE1B9]">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs leading-tight">{{ $isEn ? 'Integrated ECB Forex Valuation' : 'Valuasi Devisa Terintegrasi Bank Sentral Eropa' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Samping Kanan: Formulir Masuk Ramping & Lega (Tidak Sesak & Tidak Penuh) -->
        <div class="sm:col-span-5 bg-[#F7FAF4] p-5 sm:p-7 lg:p-8 flex flex-col justify-center items-center">
            <div class="w-full max-w-[340px] flex flex-col justify-between h-full py-1">
                <div>
                    <!-- Top Header: Sub-label & Tautan Cepat Lacak Resi -->
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[9px] font-mono font-bold tracking-wider text-[#728156] uppercase">
                            {{ $isEn ? 'PORTAL AUTHENTICATION' : 'OTENTIKASI PORTAL' }}
                        </span>
                        <a href="{{ route('track.public') }}" class="text-[11px] font-semibold text-[#728156] hover:text-[#384226] transition-colors flex items-center gap-1 font-mono">
                            <span>{{ $isEn ? 'Track Waybill →' : 'Lacak Resi →' }}</span>
                        </a>
                    </div>

                    <!-- Judul Utama Halaman Masuk (Lebih Ringkas & Elegan) -->
                    <h1 class="text-lg sm:text-xl font-bold text-[#1D2617] tracking-tight mb-3">
                        {{ $isEn ? 'Sign In to Your Account' : 'Masuk ke Akun Anda' }}
                    </h1>

                    <!-- Quick Demo Login Switcher (Kompak, Ramping & Bersih) -->
                    <div class="p-2 sm:p-2.5 bg-[#E7F5DC]/90 rounded-xl border border-[#B6C99B] mb-3">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[9px] font-bold uppercase tracking-wider text-[#4C5836] font-mono flex items-center gap-1">
                                <svg class="w-3 h-3 text-[#728156]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                {{ $isEn ? 'Quick Demo (1-Click):' : 'Akun Demo (1-Klik):' }}
                            </span>
                            <span class="text-[8px] text-[#384226] bg-[#CFE1B9] px-1.5 py-0.2 rounded-full font-mono font-bold">Siap Demo</span>
                        </div>
                        <div class="grid grid-cols-3 gap-1.5">
                            <button type="button" onclick="fillCredentials('admin@agrilian.com', 'password123')"
                                    class="px-1 py-1 rounded-lg bg-white border border-[#CFE1B9] hover:border-[#728156] hover:bg-[#CFE1B9]/40 text-[10px] font-bold text-[#1D2617] transition-all shadow-2xs text-center cursor-pointer">
                                <span class="block text-[8px] text-slate-400 font-mono font-normal">Manajer</span>
                                Admin
                            </button>
                            <button type="button" onclick="fillCredentials('operator@agrilian.com', 'password123')"
                                    class="px-1 py-1 rounded-lg bg-white border border-[#CFE1B9] hover:border-[#728156] hover:bg-[#CFE1B9]/40 text-[10px] font-bold text-[#1D2617] transition-all shadow-2xs text-center cursor-pointer">
                                <span class="block text-[8px] text-slate-400 font-mono font-normal">Lapangan</span>
                                Operator
                            </button>
                            <button type="button" onclick="fillCredentials('buyer.amsterdam@gmail.com', 'password123')"
                                    class="px-1 py-1 rounded-lg bg-white border border-[#CFE1B9] hover:border-[#728156] hover:bg-[#CFE1B9]/40 text-[10px] font-bold text-[#1D2617] transition-all shadow-2xs text-center cursor-pointer">
                                <span class="block text-[8px] text-slate-400 font-mono font-normal">Pengirim</span>
                                Pelanggan
                            </button>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="p-2.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 flex items-center gap-2 mb-2.5">
                            <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-[11px]">{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <!-- Form Inputs: Ramping, Lega & Ergonomis -->
                    <form action="{{ route('login.post') }}" method="POST" class="space-y-2.5 sm:space-y-3">
                        @csrf
                        <div>
                            <label for="email" class="block text-[11px] font-bold text-[#1D2617] mb-1">
                                {{ $isEn ? 'Email Address' : 'Alamat Email' }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email', 'admin@agrilian.com') }}" 
                                       placeholder="nama@email.com" required autofocus
                                       class="w-full pl-8 pr-3 py-2 rounded-xl border border-[#CFE1B9] text-xs font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#728156] focus:border-transparent transition-all shadow-2xs bg-white">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-[11px] font-bold text-[#1D2617] mb-1">
                                {{ $isEn ? 'Password' : 'Kata Sandi' }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <input type="password" id="password" name="password" value="password123" 
                                       placeholder="{{ $isEn ? 'enter your password...' : 'masukkan kata sandi...' }}" required
                                       class="w-full pl-8 pr-8 py-2 rounded-xl border border-[#CFE1B9] text-xs font-mono font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#728156] focus:border-transparent transition-all shadow-2xs bg-white">
                                
                                <!-- Toggle Password Visibility -->
                                <button type="button" onclick="togglePasswordVisibility()" title="{{ $isEn ? 'Show / hide password' : 'Tampilkan / Sembunyikan kata sandi' }}"
                                        class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-700 cursor-pointer transition-colors focus:outline-none">
                                    <svg id="eye-open-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eye-closed-icon" class="w-3.5 h-3.5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center text-xs pt-0.5">
                            <label class="flex items-center gap-1.5 cursor-pointer text-slate-700 font-medium select-none text-[11px]">
                                <input type="checkbox" name="remember" class="rounded border-[#CFE1B9] text-[#728156] focus:ring-[#728156]">
                                {{ $isEn ? 'Remember this session' : 'Ingat sesi saya' }}
                            </label>
                        </div>

                        <!-- Tombol Masuk Utama (Brand Accent #728156) -->
                        <button type="submit" class="btn-brand-accent w-full py-2.5 px-3 rounded-xl text-xs font-bold cursor-pointer transition-transform active:scale-[0.98] shadow-md flex items-center justify-center gap-1.5">
                            <span>{{ $isEn ? 'Sign in to Portal' : 'Masuk ke Portal Pengiriman' }}</span>
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Tautan ke Halaman Register -->
                <div class="pt-2.5 mt-3 border-t border-[#CFE1B9] text-center text-[11px] text-[#4C5836]">
                    {{ $isEn ? "Don't have an account yet?" : 'Belum memiliki akun?' }}
                    <a href="{{ route('register') }}" class="font-bold text-[#728156] hover:text-[#384226] transition-colors ml-1">
                        {{ $isEn ? 'Register Here' : 'Daftar di Sini' }}
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function fillCredentials(email, pwd) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = pwd;
    }

    function togglePasswordVisibility() {
        const pwdInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eye-open-icon');
        const eyeClosed = document.getElementById('eye-closed-icon');
        
        if (!pwdInput) return;
        
        if (pwdInput.type === 'password') {
            pwdInput.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            pwdInput.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }
</script>
@endsection
