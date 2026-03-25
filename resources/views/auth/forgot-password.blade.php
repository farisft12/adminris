@extends('layouts.guest')
@section('title', 'Lupa Password')

@push('styles')
<style>
    .glass-card { background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.4); }
    @keyframes slideUp { 0% { opacity:0; transform:translateY(20px); } 100% { opacity:1; transform:translateY(0); } }
    .animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards; }
</style>
@endpush

@section('content')
    <div class="fixed top-0 right-0 w-96 h-96 bg-red-100 rounded-full blur-3xl opacity-50 translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

    <div class="w-full max-w-[440px] z-10 animate-slide-up">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-2 transition-transform hover:scale-105">
                <span class="font-bold text-2xl tracking-tight text-primary">Admin<span class="text-secondary">ris</span></span>
            </a>
        </div>

        <div class="glass-card rounded-[2.5rem] shadow-2xl shadow-blue-900/5 p-8 sm:p-10 relative">
            <div class="text-center mb-6">
                <div class="mx-auto mb-4 h-14 w-14 rounded-full bg-red-50 flex items-center justify-center">
                    <i class="fa-solid fa-key text-2xl text-red-400"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Lupa Password?</h2>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.</p>
            </div>

            @if (session('status'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    <i class="fa-solid fa-circle-check mr-2"></i> {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@email.com"
                        class="w-full px-5 py-3.5 bg-white/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-primary outline-none transition-all duration-300 @error('email') border-red-400 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all transform hover:scale-[1.02] active:scale-95">
                    Kirim Link Reset Password
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-50 text-center">
                <p class="text-sm text-gray-500">
                    Ingat passwordnya? <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">Kembali ke Login</a>
                </p>
            </div>
        </div>
    </div>
@endsection
