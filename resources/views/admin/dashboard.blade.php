@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="relative min-h-[60vh]">
    {{-- Soft background --}}
    <div class="pointer-events-none absolute inset-0 -top-8 -z-10 overflow-hidden">
        <div class="absolute -left-40 top-0 h-72 w-72 rounded-full bg-slate-200/30 blur-3xl"></div>
        <div class="absolute -bottom-20 -right-32 h-64 w-64 rounded-full bg-indigo-100/25 blur-3xl"></div>
        <div class="absolute left-1/2 top-20 h-48 w-80 -translate-x-1/2 rounded-full bg-sky-100/20 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        {{-- Header --}}
        <header class="dashboard-enter mb-10 sm:mb-12">
            <p class="mb-2 text-sm font-medium uppercase tracking-widest text-slate-500">Adminris</p>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Dashboard Admin</h1>
            <p class="mt-3 max-w-xl text-slate-600 sm:text-lg">Kelola data master: tahun, sub kegiatan, kode rekening & etalase, PPTK, dan pengaturan perpajakan.</p>
        </header>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach([
                ['route' => 'admin.years.index', 'title' => 'Tahun', 'desc' => 'Tambah dan kelola tahun anggaran (2026, 2027, ...).', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['route' => 'admin.sub-kegiatans.index', 'title' => 'Sub Kegiatan', 'desc' => 'Tambah dan kelola sub kegiatan per tahun.', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['route' => 'admin.kode-rekenings.index', 'title' => 'Kode Rekening & Etalase', 'desc' => 'Kelola kode rekening dan etalase per kode.', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                ['route' => 'admin.pptk.assign', 'title' => 'PPTK', 'desc' => 'Sub kegiatan mana saja, siapa PPTK-nya.', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ['route' => 'admin.pptks.index', 'title' => 'Data PPTK', 'desc' => 'Tambah dan kelola daftar nama PPTK.', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['route' => 'admin.perpajakan.edit', 'title' => 'Perpajakan', 'desc' => 'Pengaturan tarif PPN, PPH 23, PPH 21.', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ] as $index => $card)
                @php $stagger = min($index + 1, 20); @endphp
                <a href="{{ route($card['route']) }}"
                    class="dashboard-enter dashboard-stagger-{{ $stagger }} group flex items-start gap-4 rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-sm backdrop-blur-sm transition-all duration-300 ease-out hover:-translate-y-1 hover:border-slate-300 hover:bg-white hover:shadow-xl hover:shadow-slate-200/50 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 active:scale-[0.99]">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600 transition-all duration-300 group-hover:bg-slate-800 group-hover:text-white sm:h-14 sm:w-14">
                        <svg class="h-6 w-6 sm:h-7 sm:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
                    </span>
                    <div class="min-w-0 flex-1">
                        <h2 class="font-semibold text-slate-900 transition-colors group-hover:text-slate-800">{{ $card['title'] }}</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ $card['desc'] }}</p>
                    </div>
                    <span class="shrink-0 text-slate-400 transition-all duration-300 group-hover:translate-x-1 group-hover:text-slate-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
