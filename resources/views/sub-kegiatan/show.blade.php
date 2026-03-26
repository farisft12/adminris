@extends('layouts.app')

@section('title', $subKegiatan->nama_sub_kegiatan)

@section('content')
<div class="relative min-h-[60vh]">
    {{-- Soft background sesuai style awal --}}
    <div class="pointer-events-none absolute inset-0 -top-8 -z-10 overflow-hidden">
        <div class="absolute -left-40 -top-40 h-80 w-80 rounded-full bg-blue-100/40 blur-3xl"></div>
        <div class="absolute -right-40 -bottom-40 h-80 w-80 rounded-full bg-slate-200/30 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        {{-- Breadcrumb --}}
        <nav class="mb-6 flex flex-wrap items-center gap-2 text-sm text-slate-500 animate-fade-up">
            <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
            <span class="opacity-50">/</span>
            <span class="font-medium text-slate-900 truncate max-w-[200px]">{{ $subKegiatan->nama_sub_kegiatan }}</span>
        </nav>

        {{-- Header sesuai style Dashboard --}}
        <header class="mb-10 animate-fade-up">
            <p class="mb-2 text-xs font-bold uppercase tracking-widest text-primary">Sub Kegiatan</p>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $subKegiatan->nama_sub_kegiatan }}</h1>
            @if($subKegiatan->year)
                <p class="mt-2 text-slate-600 flex items-center gap-2">
                    <i class="fa-regular fa-calendar"></i> Tahun Anggaran {{ $subKegiatan->year->tahun }}
                </p>
            @endif
        </header>

        {{-- Grid Menu Utama --}}
        <div class="grid gap-6 sm:grid-cols-2">
            {{-- Tombol Masuk Ke Data --}}
            <a href="{{ route('sub-kegiatan.kode-rekenings.index', $subKegiatan) }}"
                class="group animate-fade-up flex min-h-[120px] items-center gap-5 rounded-xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:border-primary/30 hover:bg-white hover:shadow-xl hover:shadow-primary/5 active:scale-[0.98]">
                
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-primary transition-all duration-300 group-hover:bg-primary group-hover:text-white">
                    <i class="fa-solid fa-layer-group text-2xl"></i>
                </span>
                
                <div class="min-w-0 flex-1">
                    <span class="block text-lg font-bold text-slate-900 group-hover:text-primary transition-colors">Kelola Administrasi</span>
                    <span class="mt-1 block text-sm text-slate-500 leading-snug">Pilih kode rekening dan kelola rincian data belanja.</span>
                </div>
                
                <span class="shrink-0 text-slate-300 transition-all duration-300 group-hover:translate-x-1 group-hover:text-primary">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            </a>

            {{-- Tombol Print NPD --}}
            <a href="{{ route('sub-kegiatan.npd', $subKegiatan) }}"
                class="group animate-fade-up flex min-h-[120px] items-center gap-5 rounded-xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:border-indigo-200 hover:bg-white hover:shadow-xl hover:shadow-indigo-500/5 active:scale-[0.98]">
                
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-slate-50 text-slate-600 transition-all duration-300 group-hover:bg-indigo-600 group-hover:text-white">
                    <i class="fa-solid fa-print text-2xl"></i>
                </span>
                
                <div class="min-w-0 flex-1">
                    <span class="block text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">Cetak NPD</span>
                    <span class="mt-1 block text-sm text-slate-500 leading-snug">Generate dan cetak Nota Pencairan Dana digital.</span>
                </div>
                
                <span class="shrink-0 text-slate-300 transition-all duration-300 group-hover:translate-x-1 group-hover:text-indigo-600">
                    <i class="fa-solid fa-chevron-right text-[10px] sm:text-base"></i>
                </span>
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.6s ease-out forwards;
    }
</style>
@endsection