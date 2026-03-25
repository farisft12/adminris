@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="relative min-h-screen overflow-hidden bg-slate-50/50">
    {{-- Decorative Background Elements (Consistent with Landing/Login) --}}
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -left-20 top-0 h-[500px] w-[500px] rounded-full bg-blue-100/50 blur-3xl opacity-60 animate-pulse"></div>
        <div class="absolute -right-20 bottom-0 h-[500px] w-[500px] rounded-full bg-indigo-100/50 blur-3xl opacity-60"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <header class="mb-12 animate-fade-up">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-primary text-white p-2.5 rounded-xl shadow-lg shadow-blue-900/20">
                    <i class="fa-solid fa-chart-pie text-xl"></i>
                </div>
                <span class="text-sm font-bold uppercase tracking-[0.2em] text-primary">Panel Administrasi</span>
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                Dashboard <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Keuangan</span>
            </h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-500 leading-relaxed">
                Silakan pilih tahun anggaran untuk mulai mengelola Sub Kegiatan dan dokumen belanja.
            </p>
        </header>

        {{-- Section: Pilih Tahun --}}
        <section class="mb-16">
            <div class="flex items-center gap-2 mb-6 ml-1 animate-fade-up delay-100">
                <i class="fa-solid fa-calendar-days text-primary/60"></i>
                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400">Pilih Tahun Anggaran</h2>
            </div>
            
            <div class="grid grid-cols-2 gap-4 sm:flex sm:flex-wrap sm:gap-6">
                @foreach($years as $index => $year)
                    @php
                        $isActive = $yearId == $year->id;
                        $delay = min(($index + 2) * 100, 1000);
                    @endphp
                    <a href="{{ route('dashboard', ['year_id' => $year->id]) }}"
                        style="animation-delay: {{ $delay }}ms"
                        class="animate-fade-up relative flex min-h-[100px] w-full sm:w-auto sm:min-w-[140px] flex-col items-center justify-center overflow-hidden rounded-[2rem] border transition-all duration-500 ease-out group {{ $isActive ? 'border-primary text-white shadow-2xl shadow-blue-500/30 scale-105 z-10' : 'border-white bg-white/70 text-slate-600 shadow-sm backdrop-blur-md hover:-translate-y-2 hover:shadow-xl hover:border-blue-200 hover:text-primary active:scale-95' }}">
                        
                        @if($isActive)
                            {{-- Full Submerge Liquid CSS Animation --}}
                            <div class="absolute inset-0 overflow-hidden rounded-[2rem] z-0 pointer-events-none">
                                <div class="absolute inset-0 animate-water-fill-up">
                                    {{-- Back Wave --}}
                                    <div class="absolute bottom-[calc(100%-10px)] left-0 w-[200%] h-[30px] opacity-40 animate-wave-flow-slow"  
                                         style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1200 120\' preserveAspectRatio=\'none\'%3E%3Cpath d=\'M0 60C300 120 300 0 600 60C900 120 900 0 1200 60L1200 120L0 120Z\' fill=\'%231e40af\'/%3E%3C/svg%3E'); background-size: 50% 100%;"></div>
                                    {{-- Front Wave --}}
                                    <div class="absolute bottom-[100%] left-0 w-[200%] h-[30px] animate-wave-flow" 
                                         style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1200 120\' preserveAspectRatio=\'none\'%3E%3Cpath d=\'M0 60C300 0 300 120 600 60C900 0 900 120 1200 60L1200 120L0 120Z\' fill=\'%231e40af\'/%3E%3C/svg%3E'); background-size: 50% 100%;"></div>
                                    {{-- Base Solid Water --}}
                                    <div class="absolute inset-0 bg-primary"></div>
                                </div>
                            </div>
                            <div class="absolute top-0 right-0 p-3 z-10">
                                <i class="fa-solid fa-circle-check text-white/80 text-lg"></i>
                            </div>
                        @endif
                        
                        <span class="relative z-10 text-3xl font-black tracking-tighter">{{ $year->tahun }}</span>
                        <span class="relative z-10 text-[10px] uppercase font-bold tracking-widest opacity-60 mt-1">Tahun Aktif</span>
                        
                        @if(!$isActive)
                            <div class="absolute bottom-0 w-full h-1 bg-primary translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        @endif
                    </a>
                @endforeach
            </div>
        </section>

        @if($yearId)
        {{-- Section: Sub Kegiatan --}}
        <section class="animate-fade-up" style="animation-delay: 400ms">
            <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">Sub Kegiatan</h2>
                    <p class="text-slate-500 text-sm mt-1">Menampilkan data untuk tahun anggaran <b>{{ $selectedYear->tahun ?? '' }}</b></p>
                </div>

                <form action="{{ route('dashboard') }}" method="get" class="relative group">
                    <input type="hidden" name="year_id" value="{{ $yearId }}">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="search" name="search" value="{{ old('search', $search ?? '') }}"
                        placeholder="Cari kode atau nama kegiatan..."
                        class="w-full lg:w-80 pl-11 pr-4 py-3.5 bg-white/80 border border-transparent rounded-2xl shadow-sm backdrop-blur-md focus:ring-4 focus:ring-blue-100 focus:bg-white focus:border-primary outline-none transition-all">
                </form>
            </div>

            @if($subKegiatans->isEmpty())
                <div class="rounded-[2.5rem] border-2 border-dashed border-slate-200 bg-white/40 px-8 py-20 text-center backdrop-blur-sm">
                    <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-3xl bg-slate-100 text-slate-300">
                        <i class="fa-solid fa-folder-open text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-700">Tidak ada data ditemukan</h3>
                    <p class="mt-2 text-slate-500 max-w-xs mx-auto text-sm">Coba kata kunci lain atau hubungi administrator untuk input data baru.</p>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach($subKegiatans as $index => $sk)
                        <div class="animate-fade-up" style="animation-delay: {{ ($index + 1) * 50 + 500 }}ms">
                            <a href="{{ route('sub-kegiatan.show', $sk) }}{{ $yearId ? '?year_id=' . $yearId : '' }}"
                                class="group flex items-center gap-5 rounded-[1.5rem] border border-white bg-white/60 p-5 shadow-sm backdrop-blur-md transition-all duration-300 hover:shadow-xl hover:shadow-blue-900/5 hover:bg-white hover:border-blue-100 active:scale-[0.99]">
                                
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 group-hover:bg-primary group-hover:text-white transition-all duration-500 shadow-inner">
                                    <i class="fa-solid fa-file-lines text-xl"></i>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-primary uppercase tracking-wider group-hover:bg-blue-100">Sub Kegiatan</span>
                                        <span class="text-xs font-mono text-slate-400">{{ $sk->kode_sub }}</span>
                                    </div>
                                    <h3 class="font-bold text-slate-800 text-lg leading-tight truncate group-hover:text-primary transition-colors">
                                        {{ $sk->nama_sub_kegiatan }}
                                    </h3>
                                </div>

                                <div class="shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-slate-50 group-hover:bg-primary group-hover:text-white transition-all">
                                    <i class="fa-solid fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
        @else
            {{-- Empty State: No Year Selected --}}
            <div class="animate-fade-up rounded-[3rem] border border-white bg-white/40 p-16 text-center backdrop-blur-md shadow-sm" style="animation-delay: 300ms">
                <div class="relative mx-auto mb-8 w-24 h-24">
                    <div class="absolute inset-0 bg-blue-100 rounded-full animate-ping opacity-20"></div>
                    <div class="relative flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-slate-50 to-slate-200 text-slate-400 shadow-inner">
                        <i class="fa-solid fa-arrow-up text-3xl animate-bounce"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-800">Mulai Pengelolaan</h3>
                <p class="mt-3 text-slate-500 max-w-md mx-auto">Pilih salah satu <b>Tahun Anggaran</b> di atas untuk memunculkan daftar sub kegiatan yang tersedia.</p>
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    @keyframes waterFillUp {
        0% { transform: translateY(100%); }
        100% { transform: translateY(0%); }
    }
    .animate-water-fill-up {
        animation: waterFillUp 7s cubic-bezier(0.2, 0.8, 0.2, 1) forwards !important;
    }
    @keyframes waveFlow {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-wave-flow {
        animation: waveFlow 5.5s linear infinite;
    }
    .animate-wave-flow-slow {
        animation: waveFlow 8s linear infinite reverse;
    }
</style>
@endsection