@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="relative min-h-screen overflow-hidden bg-slate-50/50">
    {{-- Background Ornaments --}}
    <div class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute -left-20 top-0 h-[500px] w-[500px] rounded-full bg-blue-100/40 blur-3xl"></div>
        <div class="absolute -right-20 bottom-0 h-[500px] w-[500px] rounded-full bg-indigo-100/30 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <header class="mb-12 animate-fade-up">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-primary text-white p-2.5 rounded-xl shadow-lg shadow-blue-900/20">
                    <i class="fa-solid fa-gears text-xl"></i>
                </div>
                <span class="text-sm font-bold uppercase tracking-[0.2em] text-primary">Master Control</span>
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                Dashboard <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Administrator</span>
            </h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-500 leading-relaxed">
                Kelola data fundamental sistem mulai dari tahun anggaran hingga pengaturan tarif perpajakan.
            </p>
        </header>

        {{-- Grid Menu Master Data --}}
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @php
                $adminMenus = [
                    [
                        'route' => 'admin.users.index',
                        'title' => 'Manajemen User',
                        'desc' => 'Daftar dan pantau seluruh pengguna terdaftar di sistem.',
                        'icon' => 'fa-user-shield',
                        'color' => 'indigo'
                    ],
                    [
                        'route' => 'admin.data-overview',
                        'title' => 'Data & Statistik',
                        'desc' => 'Ringkasan data, grafik anggaran, dan statistik administrasi.',
                        'icon' => 'fa-chart-line',
                        'color' => 'blue'
                    ],
                    [
                        'route' => 'admin.pejabat.index',
                        'title' => 'Bendahara & Kabag',
                        'desc' => 'Atur nama pejabat yang muncul di Kwitansi & Nota Persetujuan.',
                        'icon' => 'fa-signature',
                        'color' => 'emerald'
                    ],
                    [
                        'route' => 'admin.years.index', 
                        'title' => 'Tahun Anggaran', 
                        'desc' => 'Tambah & kelola periode tahun (2026, 2027, ...).', 
                        'icon' => 'fa-calendar-check',
                        'color' => 'blue'
                    ],
                    [
                        'route' => 'admin.sub-kegiatans.index', 
                        'title' => 'Sub Kegiatan', 
                        'desc' => 'Manajemen hierarki sub kegiatan per tahun.', 
                        'icon' => 'fa-sitemap',
                        'color' => 'indigo'
                    ],
                    [
                        'route' => 'admin.kode-rekenings.index', 
                        'title' => 'Kode Rekening', 
                        'desc' => 'Kelola database kode rekening & etalase belanja.', 
                        'icon' => 'fa-barcode',
                        'color' => 'emerald'
                    ],
                    [
                        'route' => 'admin.pptk.assign', 
                        'title' => 'Penugasan PPTK', 
                        'desc' => 'Hubungkan Sub Kegiatan dengan pejabat terkait.', 
                        'icon' => 'fa-user-gear',
                        'color' => 'amber'
                    ],
                    [
                        'route' => 'admin.pptks.index', 
                        'title' => 'Database Pegawai', 
                        'desc' => 'Tambah dan kelola data master nama-nama PPTK.', 
                        'icon' => 'fa-users-viewfinder',
                        'color' => 'sky'
                    ],
                    [
                        'route' => 'admin.perpajakan.edit', 
                        'title' => 'Tarif Perpajakan', 
                        'desc' => 'Atur persentase PPN, PPh 21, 22, dan PPh 23.', 
                        'icon' => 'fa-calculator',
                        'color' => 'rose'
                    ],
                ];
            @endphp

            @foreach($adminMenus as $index => $card)
                @php 
                    $delay = ($index + 1) * 100;
                    $colorClasses = [
                        'blue' => 'bg-blue-50 text-blue-600',
                        'indigo' => 'bg-indigo-50 text-indigo-600',
                        'emerald' => 'bg-emerald-50 text-emerald-600',
                        'amber' => 'bg-amber-50 text-amber-600',
                        'sky' => 'bg-sky-50 text-sky-600',
                        'rose' => 'bg-rose-50 text-rose-600',
                    ];
                @endphp
                
                <a href="{{ route($card['route']) }}"
                    style="animation-delay: {{ $delay }}ms"
                    class="animate-fade-up group relative flex flex-col gap-4 rounded-[2rem] border border-white bg-white/70 p-8 shadow-sm backdrop-blur-md transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-900/10 hover:bg-white hover:border-blue-100 active:scale-[0.98]">
                    
                    {{-- Icon Box --}}
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl {{ $colorClasses[$card['color']] }} transition-all duration-500 group-hover:scale-110 shadow-inner">
                        <i class="fa-solid {{ $card['icon'] }} text-2xl"></i>
                    </div>

                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-slate-800 transition-colors group-hover:text-primary">
                            {{ $card['title'] }}
                        </h2>
                        <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                            {{ $card['desc'] }}
                        </p>
                    </div>

                    {{-- Arrow --}}
                    <div class="mt-4 flex items-center text-xs font-bold uppercase tracking-widest text-slate-400 group-hover:text-primary transition-colors">
                        Buka Menu 
                        <i class="fa-solid fa-arrow-right ml-2 transition-transform group-hover:translate-x-2"></i>
                    </div>

                    {{-- Hover Decoration --}}
                    <div class="absolute top-6 right-8 h-2 w-2 rounded-full bg-slate-200 transition-all duration-500 group-hover:scale-[3] group-hover:bg-primary/10"></div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<style>
    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(25px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
</style>
@endsection