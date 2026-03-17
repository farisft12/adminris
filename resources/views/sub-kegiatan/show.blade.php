@extends('layouts.app')

@section('title', $subKegiatan->nama_sub_kegiatan)

@section('content')
<div class="relative min-h-[60vh]">
    <div class="pointer-events-none absolute inset-0 -top-8 -z-10 overflow-hidden">
        <div class="absolute -left-40 -top-40 h-80 w-80 rounded-full bg-indigo-100/40 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 h-80 w-80 rounded-full bg-slate-200/30 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        <nav class="mb-6 flex items-center gap-2 text-sm text-slate-600">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-900">Dashboard</a>
            <span aria-hidden="true">/</span>
            <span class="font-medium text-slate-900">{{ $subKegiatan->nama_sub_kegiatan }}</span>
        </nav>

        <h1 class="mb-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">{{ $subKegiatan->nama_sub_kegiatan }}</h1>
        @if($subKegiatan->year)
            <p class="mb-10 text-slate-600">Tahun {{ $subKegiatan->year->tahun }}</p>
        @endif

        <div class="grid gap-5 sm:grid-cols-2">
            <a href="{{ route('sub-kegiatan.kode-rekenings.index', $subKegiatan) }}"
                class="group flex min-h-[120px] items-center gap-4 rounded-xl border border-slate-200/80 bg-white/80 p-6 shadow-sm backdrop-blur-sm transition-all duration-300 hover:border-indigo-200 hover:bg-white hover:shadow-lg hover:shadow-indigo-500/10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-50 to-slate-100 text-indigo-600 transition-all duration-300 group-hover:from-indigo-600 group-hover:to-indigo-700 group-hover:text-white">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </span>
                <div>
                    <span class="block font-semibold text-slate-900 group-hover:text-indigo-700">Masuk Ke Data</span>
                    <span class="mt-0.5 block text-sm text-slate-500">Pilih kode rekening lalu kelola data administrasi</span>
                </div>
                <span class="ml-auto shrink-0 text-slate-400 group-hover:text-indigo-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </a>

            <a href="{{ route('sub-kegiatan.npd', $subKegiatan) }}"
                class="group flex min-h-[120px] items-center gap-4 rounded-xl border border-slate-200/80 bg-white/80 p-6 shadow-sm backdrop-blur-sm transition-all duration-300 hover:border-indigo-200 hover:bg-white hover:shadow-lg hover:shadow-indigo-500/10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-slate-100 to-slate-200/80 text-slate-600 transition-all duration-300 group-hover:from-indigo-600 group-hover:to-indigo-700 group-hover:text-white">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                </span>
                <div>
                    <span class="block font-semibold text-slate-900 group-hover:text-indigo-700">Print NPD</span>
                    <span class="mt-0.5 block text-sm text-slate-500">Cetak Nota Pencairan Dana</span>
                </div>
                <span class="ml-auto shrink-0 text-slate-400 group-hover:text-indigo-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </a>
        </div>
    </div>
</div>
@endsection
