@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 mb-3 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Portal Sign In</h1>
            <p class="text-xs text-slate-500 mt-1">Access CargoTrace AgriLian Logistics Network</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', 'admin@cargotrace.com') }}" required autofocus
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                <input type="password" id="password" name="password" value="password123" required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    Remember session
                </label>
            </div>

            <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm transition-colors cursor-pointer">
                Sign In to Platform
            </button>
        </form>

        <!-- Fast Demo Credentials Switcher for Evaluation / Presentation -->
        <div class="mt-8 pt-6 border-t border-slate-100">
            <span class="block text-center text-[11px] font-semibold tracking-wider text-slate-400 uppercase mb-3">
                Quick Demo Role Switcher
            </span>
            <div class="grid grid-cols-1 gap-2">
                <button type="button" onclick="fillDemo('admin@cargotrace.com')" class="flex items-center justify-between p-2.5 rounded-xl bg-purple-50 hover:bg-purple-100 border border-purple-200 text-left transition-colors cursor-pointer">
                    <div>
                        <div class="text-xs font-bold text-purple-900">Admin (Ayaa Liandes)</div>
                        <div class="text-[11px] text-purple-700">admin@cargotrace.com</div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-purple-200 text-purple-800">Admin</span>
                </button>

                <button type="button" onclick="fillDemo('operator@cargotrace.com')" class="flex items-center justify-between p-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-left transition-colors cursor-pointer">
                    <div>
                        <div class="text-xs font-bold text-amber-900">Operator (Gayo Dispatcher)</div>
                        <div class="text-[11px] text-amber-700">operator@cargotrace.com</div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-amber-200 text-amber-800">Operator</span>
                </button>

                <button type="button" onclick="fillDemo('buyer.amsterdam@eurocoffee.nl')" class="flex items-center justify-between p-2.5 rounded-xl bg-blue-50 hover:bg-blue-100 border border-blue-200 text-left transition-colors cursor-pointer">
                    <div>
                        <div class="text-xs font-bold text-blue-900">Customer (Amsterdam Roasters)</div>
                        <div class="text-[11px] text-blue-700">buyer.amsterdam@eurocoffee.nl</div>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-200 text-blue-800">Customer</span>
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
