@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="relative min-h-[60vh]">
    {{-- Soft background --}}
    <div class="pointer-events-none absolute inset-0 -top-8 -z-10 overflow-hidden">
        <div class="absolute -left-40 -top-40 h-80 w-80 rounded-full bg-indigo-100/40 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 h-80 w-80 rounded-full bg-slate-200/30 blur-3xl"></div>
        <div class="absolute left-1/2 top-0 h-64 w-96 -translate-x-1/2 rounded-full bg-sky-100/30 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        {{-- Header --}}
        <header class="dashboard-enter mb-10 sm:mb-12">
            <p class="mb-2 text-sm font-medium uppercase tracking-widest text-indigo-600">Adminris</p>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Dashboard</h1>
            <p class="mt-3 max-w-xl text-slate-600 sm:text-lg">Pilih tahun lalu sub kegiatan untuk mengelola data belanja.</p>
        </header>

        {{-- Pilih Tahun --}}
        <section class="mb-12">
            <h2 class="dashboard-enter dashboard-stagger-1 mb-5 text-sm font-semibold uppercase tracking-wider text-slate-500">Pilih Tahun</h2>
            <div class="grid grid-cols-2 gap-4 sm:flex sm:flex-wrap sm:gap-5">
                @foreach($years as $index => $year)
                    @php
                        $isActive = $yearId == $year->id;
                        $stagger = min($index + 2, 20);
                    @endphp
                    <a href="{{ route('dashboard', ['year_id' => $year->id]) }}"
                        class="dashboard-enter dashboard-stagger-{{ $stagger }} group relative flex min-h-[80px] items-center justify-center overflow-hidden rounded-2xl border px-6 py-5 text-center transition-all duration-300 ease-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:min-h-0 sm:min-w-[130px] sm:px-8 sm:py-6 {{ $isActive ? 'border-indigo-200 bg-gradient-to-br from-indigo-600 to-indigo-700 text-white shadow-lg shadow-indigo-500/25 scale-[1.02]' : 'border-slate-200/80 bg-white/80 text-slate-700 shadow-sm backdrop-blur-sm hover:-translate-y-1 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/50 active:scale-[0.98]' }}">
                        @if($isActive)
                            <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent"></div>
                            <span class="absolute right-3 top-3 opacity-90 sm:right-4 sm:top-4" aria-hidden="true">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </span>
                        @endif
                        <span class="relative text-2xl font-bold sm:text-3xl">{{ $year->tahun }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        @if($yearId)
        {{-- Sub Kegiatan --}}
        <section>
            <div class="dashboard-enter dashboard-stagger-5 mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">Sub Kegiatan — Tahun {{ $selectedYear->tahun ?? '' }}</h2>
                <form action="{{ route('dashboard') }}" method="get" class="flex gap-2">
                    <input type="hidden" name="year_id" value="{{ $yearId }}">
                    <label for="dashboard-search" class="sr-only">Cari sub kegiatan</label>
                    <input id="dashboard-search" type="search" name="search" value="{{ old('search', $search ?? '') }}"
                        placeholder="Cari nama atau kode sub kegiatan..."
                        class="w-full min-w-[200px] rounded-xl border border-slate-200/80 bg-white/80 px-4 py-2.5 text-slate-700 shadow-sm backdrop-blur-sm placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 sm:w-64">
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-slate-200/80 bg-white/80 px-4 py-2.5 text-slate-700 shadow-sm backdrop-blur-sm hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span class="ml-1.5 sm:ml-2">Cari</span>
                    </button>
                </form>
            </div>
            @if($subKegiatans->isEmpty())
                <div class="dashboard-enter dashboard-stagger-6 rounded-2xl border border-slate-200/80 bg-white/60 px-8 py-14 text-center backdrop-blur-sm">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    @if(!empty($search))
                        <p class="mt-5 text-base font-medium text-slate-600">Tidak ada sub kegiatan yang cocok dengan "{{ $search }}".</p>
                        <p class="mt-1 text-sm text-slate-500">Coba kata kunci lain atau kosongkan pencarian.</p>
                    @else
                        <p class="mt-5 text-base font-medium text-slate-600">Belum ada sub kegiatan untuk tahun ini.</p>
                        <p class="mt-1 text-sm text-slate-500">Data sub kegiatan dapat ditambahkan oleh administrator.</p>
                    @endif
                </div>
            @else
                <ul class="flex flex-col gap-4" role="list">
                    @foreach($subKegiatans as $index => $sk)
                        @php $stagger = min($index + 7, 20); @endphp
                        <li class="dashboard-enter dashboard-stagger-{{ $stagger }}">
                            <a href="{{ route('sub-kegiatan.show', $sk) }}{{ $yearId ? '?year_id=' . $yearId : '' }}"
                                class="group flex min-h-[72px] w-full items-center gap-4 rounded-xl border border-slate-200/80 bg-white/80 px-6 py-4 shadow-sm backdrop-blur-sm transition-all duration-300 ease-out hover:border-indigo-200 hover:bg-white hover:shadow-md hover:shadow-indigo-500/10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:scale-[0.99] sm:min-h-[80px] sm:px-8 sm:py-5">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-50 to-slate-100 text-indigo-600 transition-all duration-300 group-hover:from-indigo-600 group-hover:to-indigo-700 group-hover:text-white sm:h-12 sm:w-12">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <span class="block font-semibold text-slate-900 transition-colors group-hover:text-indigo-700">{{ $sk->nama_sub_kegiatan }}</span>
                                    @if($sk->kode_sub)
                                        <span class="mt-0.5 block text-sm text-slate-500">{{ $sk->kode_sub }}</span>
                                    @endif
                                </div>
                                <span class="shrink-0 text-slate-400 transition-all duration-300 group-hover:translate-x-0.5 group-hover:text-indigo-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
        @else
        {{-- Empty state: no year selected --}}
        <section class="dashboard-enter dashboard-stagger-3 rounded-2xl border border-slate-200/80 bg-white/60 px-8 py-16 text-center backdrop-blur-sm sm:py-20">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200/80 text-slate-400">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <p class="mt-6 text-lg font-medium text-slate-700">Pilih tahun di atas</p>
            <p class="mt-2 text-sm text-slate-500">Pilih salah satu tahun untuk melihat daftar Sub Kegiatan.</p>
        </section>
        @endif
    </div>
</div>
@endsection
