@extends('layouts.guest')

@section('title', 'Masuk')

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }
    @keyframes slideUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
    .animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>
@endpush

@section('content')
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-60 -translate-x-1/2 -translate-y-1/2"></div>
    
    <div class="w-full max-w-[420px] z-10 animate-slide-up">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-2 transition-transform hover:scale-105">
                <div class="bg-primary text-white p-2 rounded-lg shadow-lg">
                    <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                </div>
                <span class="font-bold text-2xl tracking-tight text-primary">Admin<span class="text-secondary">ris</span></span>
            </a>
        </div>

        <div class="glass-card rounded-[2.5rem] shadow-2xl shadow-blue-900/5 p-10 relative">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Selamat Datang</h2>

            @if (session('status'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    <i class="fa-solid fa-circle-check mr-2"></i> {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Email / Username</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@email.com" 
                        class="w-full px-5 py-3.5 bg-white/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-primary outline-none transition-all duration-300 @error('email') border-red-400 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <div class="flex justify-between items-center ml-1">
                        <label class="text-xs font-bold text-gray-400 uppercase">Kata Sandi</label>
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-primary hover:underline">Lupa Password?</a>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••" 
                        class="w-full px-5 py-3.5 bg-white/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-primary outline-none transition-all duration-300 @error('password') border-red-400 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center ml-1 mt-2">
                    <input id="remember" type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary" />
                    <label for="remember" class="ml-2 text-sm text-gray-500">Ingat saya</label>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all transform hover:scale-[1.02] active:scale-95 mt-4">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-6 flex items-center justify-between">
                <span class="w-1/5 border-b border-gray-200"></span>
                <span class="text-xs text-center text-gray-500 uppercase font-bold tracking-wider">Atau masuk dengan</span>
                <span class="w-1/5 border-b border-gray-200"></span>
            </div>

            <div class="mt-6">
                <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-3.5 rounded-2xl shadow-sm transition-all transform hover:scale-[1.02] active:scale-95">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                    Lanjutkan dengan Google
                </a>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-50 text-center">
                <p class="text-sm text-gray-500">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>
@endsection
