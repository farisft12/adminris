@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="relative">
    {{-- Subtle background --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-32 left-1/2 h-72 w-[46rem] -translate-x-1/2 rounded-full bg-slate-200/35 blur-3xl"></div>
        <div class="absolute -bottom-48 -right-40 h-96 w-96 rounded-full bg-indigo-100/35 blur-3xl"></div>
    </div>

    <div class="mx-auto grid min-h-[calc(100vh-4rem)] max-w-7xl items-center gap-10 px-4 py-10 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-14">
        <div class="dashboard-enter">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Sistem internal</p>
            <h1 class="mt-3 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
                {{ config('app.name', 'Adminris') }}
            </h1>
            <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-600 sm:text-lg">
                Aplikasi administrasi belanja untuk pengelolaan Sub Kegiatan, kode rekening, PPTK, dan dokumen NPD secara rapi dan terstruktur.
            </p>

            <div class="mt-7 flex flex-wrap items-center gap-3">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Daftar Akun
                    </a>
                @endauth
            </div>

            <div class="mt-8 grid max-w-xl gap-3 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-200/80 bg-white/80 p-4 shadow-sm backdrop-blur-sm">
                    <p class="text-sm font-semibold text-slate-900">Cepat & konsisten</p>
                    <p class="mt-1 text-sm text-slate-600">Tampilan bersih, fokus ke pekerjaan utama.</p>
                </div>
                <div class="rounded-2xl border border-slate-200/80 bg-white/80 p-4 shadow-sm backdrop-blur-sm">
                    <p class="text-sm font-semibold text-slate-900">Terstruktur</p>
                    <p class="mt-1 text-sm text-slate-600">Data master dan dokumen tertata per tahun.</p>
                </div>
            </div>
        </div>

        <div class="dashboard-enter dashboard-stagger-2">
            <div class="rounded-3xl border border-slate-200/80 bg-white/80 p-6 shadow-sm backdrop-blur-sm sm:p-8">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-900 text-base font-semibold text-white shadow-sm">
                            {{ strtoupper(substr(config('app.name', 'A'), 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Akses cepat</p>
                            <p class="text-xs text-slate-500">Mulai dari menu yang sering dipakai</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid gap-3">
                    @auth
                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                            <p class="text-sm text-slate-600">Login sebagai</p>
                            <p class="mt-1 truncate text-base font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="mt-1 inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700">{{ auth()->user()->role }}</p>
                        </div>
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
                           class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Lanjutkan ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Masuk untuk mulai
                        </a>
                        <p class="text-sm text-slate-600">
                            Belum punya akun? Silakan daftar, atau hubungi admin jika akun dikelola internal.
                        </p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
