@extends('layouts.app')

@section('title', 'Selamat Datang — AgriLian')

@section('content')
<div class="max-w-md mx-auto my-12 px-4">
    <div class="bg-white rounded-2xl shadow-lg border border-slate-200/90 overflow-hidden">
        
        <!-- Header with Highland Gradient -->
        <div class="bg-hero-gradient p-7 text-center relative overflow-hidden">
            <!-- Subtle Ambient Light -->
            <div class="absolute -top-12 -left-12 w-36 h-36 rounded-full bg-emerald-500/10 blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -right-12 w-36 h-36 rounded-full bg-cyan-500/10 blur-2xl pointer-events-none"></div>

            <div class="relative z-10">
                <!-- Brand / User Logo (Siap Diganti dengan Logo Buatan Ayaa) -->
                <div id="login-brand-logo" class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#1E293B] to-[#0F172A] border border-slate-700 text-white flex items-center justify-center mx-auto mb-3 shadow-md shadow-black/20">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                
                <!-- Judul Hangat & Ramah Sesuai Pilihan Ayaa -->
                <h1 class="text-2xl font-black text-white tracking-tight">Selamat Datang</h1>
                <!-- Subtitle Bersih & Beridentitas Brand AgriLian -->
                <p class="text-xs text-emerald-400 font-semibold mt-1 tracking-wide">AgriLian</p>
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
                    <div class="relative">
                        <input type="password" id="password" name="password" value="password123" placeholder="masukkan kata sandi..." required
                               class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#57C84D] focus:border-transparent transition-all">
                        
                        <!-- Toggle Tampilkan/Sembunyikan Kata Sandi (Mata Terbuka & Tertutup) -->
                        <button type="button" onclick="togglePasswordVisibility()" title="Tampilkan / Sembunyikan kata sandi"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-700 cursor-pointer transition-colors focus:outline-none">
                            <!-- Mata Terbuka (Default Saat Tersembunyi) -->
                            <svg id="eye-open-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <!-- Mata Tertutup / Silang (Muncul Saat Kata Sandi Diperlihatkan) -->
                            <svg id="eye-closed-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium select-none">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#1B4332] focus:ring-[#57C84D]">
                        Ingat sesi saya
                    </label>
                </div>

                <!-- Tombol Berkelas Pilihan Ayaa: Masuk ke Portal -->
                <button type="submit" class="btn-brand-accent w-full py-2.5 px-4 rounded-xl text-xs font-bold cursor-pointer transition-transform active:scale-[0.98] shadow-sm flex items-center justify-center gap-2">
                    <span>Masuk ke Portal</span>
                    <svg class="w-3.5 h-3.5 text-[#052014]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>
        </div>

    </div>
</div>

<script>
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
