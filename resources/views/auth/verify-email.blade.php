@extends('layouts.guest')
@section('title', 'Verifikasi Email')

@push('styles')
<style>
    .glass-card { background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.4); }
    @keyframes slideUp { 0% { opacity:0; transform:translateY(20px); } 100% { opacity:1; transform:translateY(0); } }
    .animate-slide-up { animation: slideUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards; }
</style>
@endpush

@section('content')
    <div class="fixed top-0 left-0 w-96 h-96 bg-amber-100 rounded-full blur-3xl opacity-50 -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

    <div class="w-full max-w-[440px] z-10 animate-slide-up">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-2 transition-transform hover:scale-105">
                <span class="font-bold text-2xl tracking-tight text-primary">Admin<span class="text-secondary">ris</span></span>
            </a>
        </div>

        <div class="glass-card rounded-[2.5rem] shadow-2xl shadow-blue-900/5 p-8 sm:p-10 text-center">
            <div class="mx-auto mb-6 h-16 w-16 rounded-full bg-amber-50 flex items-center justify-center">
                <i class="fa-regular fa-envelope text-3xl text-amber-500"></i>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-3">Verifikasi Email Anda</h2>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                Kami telah mengirimkan link verifikasi ke alamat email Anda. Silakan cek inbox (atau folder spam) dan klik link tersebut untuk mengaktifkan akun.
            </p>

            @if (session('status'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    <i class="fa-solid fa-circle-check mr-2"></i> {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-primary hover:bg-blue-900 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all transform hover:scale-[1.02] active:scale-95">
                    <i class="fa-solid fa-rotate-right mr-2"></i> Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 font-semibold transition-colors">
                    Keluar dan Coba Email Lain &rarr;
                </button>
            </form>
        </div>
    </div>
@endsection
