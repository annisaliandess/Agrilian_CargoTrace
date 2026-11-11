@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="max-w-md mx-auto my-10">
    <div class="bg-white rounded-xl shadow-xs border border-stone-200 p-8">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-espresso-900 text-stone-100 mb-3 border border-stone-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-xl font-extrabold text-espresso-950 tracking-tight">Portal Authentication</h1>
            <p class="text-xs text-stone-500 mt-1 font-mono">CargoTrace AgriLian Operations Network</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-xs font-mono font-semibold text-stone-700 mb-1">Account Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', 'admin@cargotrace.com') }}" required autofocus
                       class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs font-mono focus:outline-none focus:ring-1 focus:ring-stone-900 transition-all">
            </div>

            <div>
                <label for="password" class="block text-xs font-mono font-semibold text-stone-700 mb-1">Access Password</label>
                <input type="password" id="password" name="password" value="password123" required
                       class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs font-mono focus:outline-none focus:ring-1 focus:ring-stone-900 transition-all">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-stone-600 font-mono text-[11px]">
                    <input type="checkbox" name="remember" class="rounded border-stone-300 text-stone-900 focus:ring-stone-900">
                    Maintain Session
                </label>
            </div>

            <button type="submit" class="w-full py-2.5 px-4 rounded-lg bg-espresso-900 hover:bg-black text-white font-bold text-xs font-mono shadow-2xs transition-colors cursor-pointer">
                Authenticate &rarr;
            </button>
        </form>

        <!-- Fast Role Switcher for Evaluation -->
        <div class="mt-8 pt-5 border-t border-stone-100">
            <span class="block text-center text-[10px] font-mono font-bold tracking-wider text-stone-400 uppercase mb-3">
                Evaluation Demo Roles
            </span>
            <div class="grid grid-cols-1 gap-2 font-mono">
                <button type="button" onclick="fillDemo('admin@cargotrace.com')" class="flex items-center justify-between p-2 rounded-lg bg-stone-50 hover:bg-stone-100 border border-stone-200 text-left transition-colors cursor-pointer">
                    <div>
                        <div class="text-xs font-bold text-stone-900">Ayaa Liandes (Admin)</div>
                        <div class="text-[10px] text-stone-500">admin@cargotrace.com</div>
                    </div>
                    <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-stone-200 text-stone-800">ADMIN</span>
                </button>

                <button type="button" onclick="fillDemo('operator@cargotrace.com')" class="flex items-center justify-between p-2 rounded-lg bg-stone-50 hover:bg-stone-100 border border-stone-200 text-left transition-colors cursor-pointer">
                    <div>
                        <div class="text-xs font-bold text-stone-900">Reza Pratama (Dispatcher)</div>
                        <div class="text-[10px] text-stone-500">operator@cargotrace.com</div>
                    </div>
                    <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-stone-200 text-stone-800">OPERATOR</span>
                </button>

                <button type="button" onclick="fillDemo('buyer.amsterdam@eurocoffee.nl')" class="flex items-center justify-between p-2 rounded-lg bg-stone-50 hover:bg-stone-100 border border-stone-200 text-left transition-colors cursor-pointer">
                    <div>
                        <div class="text-xs font-bold text-stone-900">Amsterdam Coffee Roasters</div>
                        <div class="text-[10px] text-stone-500">buyer.amsterdam@eurocoffee.nl</div>
                    </div>
                    <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-stone-200 text-stone-800">CUSTOMER</span>
                </button>
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
