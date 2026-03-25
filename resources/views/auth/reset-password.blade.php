@extends('layouts.guest')
@section('title', 'Reset Password')

@push('styles')
<style>
    .glass-card { background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.4); }
    @keyframes slideUp { 0% { opacity:0; transform:translateY(20px); } 100% { opacity:1; transform:translateY(0); } }
    .animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards; }
</style>
@endpush

@section('content')
    <div class="fixed bottom-0 left-0 w-96 h-96 bg-green-100 rounded-full blur-3xl opacity-50 -translate-x-1/2 translate-y-1/2 pointer-events-none"></div>

    <div class="w-full max-w-[440px] z-10 animate-slide-up">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-2 transition-transform hover:scale-105">
                <span class="font-bold text-2xl tracking-tight text-primary">Admin<span class="text-secondary">ris</span></span>
            </a>
        </div>

        <div class="glass-card rounded-[2.5rem] shadow-2xl shadow-blue-900/5 p-8 sm:p-10 relative">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Buat Password Baru</h2>
                <p class="text-sm text-gray-500 mt-2">Masukkan password baru untuk akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $email) }}" required readonly
                        class="w-full px-5 py-3.5 bg-slate-100 border border-gray-100 rounded-2xl outline-none text-gray-500 cursor-not-allowed">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Password Baru</label>
                    <input type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter"
                        class="w-full px-5 py-3.5 bg-white/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-primary outline-none transition-all duration-300 @error('password') border-red-400 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password baru"
                        class="w-full px-5 py-3.5 bg-white/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-blue-50 focus:border-primary outline-none transition-all duration-300">
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all transform hover:scale-[1.02] active:scale-95">
                    Reset Password Sekarang
                </button>
            </form>
        </div>
    </div>
@endsection
