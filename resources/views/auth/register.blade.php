@extends('layouts.app')

@section('title', 'Daftar Akun Baru — AgriLian')

@section('content')
<div class="max-w-md mx-auto my-10 px-4">
    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden">
        
        <!-- Header Bersih & Profesional (Tanpa Gimmick AI) -->
        <div class="bg-white p-7 text-center border-b border-stone-100">
            <!-- Brand Logo -->
            <div class="w-12 h-12 rounded-2xl bg-stone-900 border border-stone-700 text-white flex items-center justify-center mx-auto mb-3 shadow-xs">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            
            <h1 class="text-xl font-bold text-stone-900 tracking-tight">Pendaftaran Akun Baru</h1>
            <p class="text-xs text-stone-500 mt-1">Bergabung dengan ekosistem logistik ekspor Highland AgriLian</p>
        </div>

        <!-- Form Body -->
        <div class="p-6 sm:p-7 space-y-4">
            @if ($errors->any())
                <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <div>&bull; {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-xs font-semibold text-stone-700 mb-1.5">Nama Lengkap / Perusahaan</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: CV Gayo Highland Mandiri" required autofocus
                           class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs font-medium text-stone-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-stone-700 mb-1.5">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="alamat email aktif..." required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs font-medium text-stone-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label for="role" class="block text-xs font-semibold text-stone-700 mb-1.5">Peran / Kategori Akun</label>
                    <select id="role" name="role" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs font-semibold text-stone-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all bg-white">
                        <option value="customer" selected>Mitra Eksportir / Buyer Kopi & Agro</option>
                        <option value="operator">Staf Operasional Gudang & Logistik</option>
                    </select>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-stone-700 mb-1.5">Kata Sandi (Minimal 8 Karakter)</label>
                    <input type="password" id="password" name="password" placeholder="buat kata sandi baru..." required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs font-mono font-medium text-stone-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-stone-700 mb-1.5">Konfirmasi Kata Sandi</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="ulangi kata sandi..." required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs font-mono font-medium text-stone-900 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn-brand-accent w-full py-2.5 px-4 rounded-xl text-xs font-bold cursor-pointer transition-transform active:scale-[0.98] shadow-sm flex items-center justify-center gap-2 mt-2">
                    <span>Daftar Akun Baru</span>
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <!-- Tautan ke Halaman Login -->
            <div class="pt-3 border-t border-stone-100 text-center text-xs text-stone-500">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-bold text-amber-700 hover:text-amber-800 transition-colors">
                    Masuk di sini
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
