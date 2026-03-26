@extends('layouts.app')

@section('title', 'Data & Statistik')

@section('content')
<div class="relative min-h-screen bg-slate-50/50 pb-12 font-sans">
    {{-- Background Ornaments --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-0 h-[30rem] w-[30rem] rounded-full bg-blue-100/40 blur-3xl"></div>
        <div class="absolute right-0 bottom-0 h-[25rem] w-[25rem] rounded-full bg-indigo-100/40 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-10 animate-fade-up">
            <nav class="mb-3 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-500 transition-colors">Admin</a>
                <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                <span class="text-indigo-500">Data & Statistik</span>
            </nav>
            <div class="flex items-center gap-4">
                <div class="bg-white text-indigo-600 p-3.5 rounded-2xl shadow-sm border border-slate-100">
                    <i class="fa-solid fa-chart-pie text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Data & Statistik</h1>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Ringkasan keseluruhan performa anggaran dan data sistem.</p>
                </div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-10">
            @php
                $boxes = [
                    ['label' => 'Total Pengguna', 'value' => $stats['users'], 'icon' => 'fa-users', 'bg' => 'bg-violet-50', 'text' => 'text-violet-600'],
                    ['label' => 'Sub Kegiatan', 'value' => $stats['sub_kegiatans'], 'icon' => 'fa-sitemap', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
                    ['label' => 'Pagu Anggaran', 'value' => 'Rp ' . number_format($stats['total_anggaran'], 0, ',', '.'), 'icon' => 'fa-wallet', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
                    ['label' => 'Total Realisasi', 'value' => 'Rp ' . number_format($stats['total_realisasi'], 0, ',', '.'), 'icon' => 'fa-receipt', 'bg' => 'bg-rose-50', 'text' => 'text-rose-600'],
                ];
            @endphp
            @foreach($boxes as $i => $b)
                <div class="group animate-fade-up rounded-3xl border border-white bg-white/70 p-6 shadow-sm backdrop-blur-xl hover:shadow-md transition-all duration-300" style="animation-delay: {{ ($i+1)*50 }}ms">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">{{ $b['label'] }}</p>
                        <div class="h-10 w-10 flex items-center justify-center rounded-xl {{ $b['bg'] }} {{ $b['text'] }} transition-transform group-hover:scale-110 shadow-sm border border-white">
                            <i class="fa-solid {{ $b['icon'] }} text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight leading-none">{{ $b['value'] }}</h3>
                </div>
            @endforeach
        </div>

        {{-- Charts Section --}}
        <div class="grid gap-8 lg:grid-cols-3 mb-8">
            {{-- Doughnut: Distribusi Realisasi --}}
            <div class="animate-fade-up lg:col-span-1 rounded-[2.5rem] border border-white bg-white/70 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-xl p-8" style="animation-delay: 400ms">
                <div class="mb-8">
                    <h2 class="text-lg font-black text-slate-800 tracking-tight">Distribusi Realisasi</h2>
                    <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">Top 5 Sub Kegiatan</p>
                </div>
                
                <div class="relative flex justify-center items-center" style="height: 220px;">
                    <canvas id="chartDoughnut"></canvas>
                </div>

                <div class="mt-8 space-y-4">
                    @foreach($chartAnggaran->take(5) as $sk)
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="font-bold text-slate-600 truncate max-w-[60%]" title="{{ $sk['label'] }}">{{ $sk['label'] }}</span>
                                <span class="font-black text-indigo-600 italic">Rp {{ number_format($sk['terpakai'], 0, ',', '.') }}</span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100/50 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full" 
                                    style="width: {{ $sk['anggaran'] > 0 ? min(($sk['terpakai'] / $sk['anggaran']) * 100, 100) : 0 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Bar Chart: Realisasi Bulanan --}}
            <div class="animate-fade-up lg:col-span-2 rounded-[2.5rem] border border-white bg-white/70 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-xl p-8 flex flex-col" style="animation-delay: 500ms">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-lg font-black text-slate-800 tracking-tight">Realisasi Anggaran Bulanan</h2>
                        <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">Akumulasi Realisasi dalam Rupiah (Rp)</p>
                    </div>
                    <div class="h-12 w-12 flex items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-inner border border-white">
                        <i class="fa-solid fa-money-bill-trend-up text-lg"></i>
                    </div>
                </div>
                
                <div class="relative flex-1" style="min-height: 350px;">
                    <canvas id="chartBarBulanan"></canvas>
                </div>
            </div>
        </div>

        {{-- Detailed Table --}}
        <div class="animate-fade-up rounded-[2.5rem] border border-white bg-white/70 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-xl overflow-hidden mb-8" style="animation-delay: 600ms">
            <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-black text-slate-800 tracking-tight">Anggaran per Sub Kegiatan</h2>
                    <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">Detail Pagu dan Realisasi</p>
                </div>
                <div class="h-12 w-12 flex items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 shadow-inner border border-white">
                    <i class="fa-solid fa-table-list text-lg"></i>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50/50 text-left">
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Sub Kegiatan</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Pagu Anggaran</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Realisasi (Terpakai)</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Sisa Anggaran</th>
                            <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Serapan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($subKegiatanList as $sk)
                            <tr class="group hover:bg-white transition-all duration-300">
                                <td class="px-10 py-5">
                                    <div class="font-bold text-slate-700 leading-tight">{{ $sk->nama_sub_kegiatan }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono mt-1 font-bold">{{ $sk->kode_sub ?? '-' }}</div>
                                </td>
                                <td class="px-10 py-5 text-right font-black text-slate-800">Rp {{ number_format($sk->anggaran, 0, ',', '.') }}</td>
                                <td class="px-10 py-5 text-right font-black text-indigo-600">Rp {{ number_format($sk->realisasi ?? 0, 0, ',', '.') }}</td>
                                <td class="px-10 py-5 text-right font-black text-slate-400">Rp {{ number_format($sk->anggaran - ($sk->realisasi ?? 0), 0, ',', '.') }}</td>
                                <td class="px-10 py-5">
                                    @php $percent = $sk->anggaran > 0 ? min(($sk->realisasi / $sk->anggaran) * 100, 100) : 0; @endphp
                                    <div class="flex items-center justify-center gap-3">
                                        <div class="h-2 w-24 bg-slate-100 rounded-full overflow-hidden shadow-inner">
                                            <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full" style="width:{{ $percent }}%"></div>
                                        </div>
                                        <span class="text-[10px] font-black text-slate-500">{{ round($percent, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($subKegiatanList->hasPages())
                <div class="px-10 py-6 border-t border-slate-100 bg-slate-50/30">
                    {{ $subKegiatanList->links() }}
                </div>
            @endif
        </div>

        {{-- Efisiensi Section --}}
        <div class="animate-fade-up rounded-[2.5rem] border border-white bg-white/70 shadow-[0_15px_50px_rgb(0,0,0,0.03)] backdrop-blur-xl p-10 overflow-hidden relative" style="animation-delay: 700ms">
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-indigo-50/50 blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-12">
                <div class="md:w-3/5">
                    <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.2em] mb-6 border border-white shadow-sm">
                        <span class="h-2 w-2 animate-pulse rounded-full bg-indigo-500"></span>
                        <span class="text-indigo-600">Analisis Performa Anggaran</span>
                    </div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tighter mb-5 leading-tight">Efisiensi Penyerapan<br>Dana Administrasi</h2>
                    <p class="text-slate-500 text-sm font-medium leading-relaxed max-w-lg">
                        Rasio total pengeluaran terhadap pagu anggaran yang tersedia untuk tahun berjalan ({{ $activeYear }}). Administrasi yang akurat dimulai dari pemantauan data yang presisi secara real-time.
                    </p>
                </div>
                
                <div class="md:w-2/5 group">
                    @php
                        $efisiensi = $stats['total_anggaran'] > 0 
                            ? (($stats['total_realisasi'] / $stats['total_anggaran']) * 100) 
                            : 0;
                    @endphp
                    <div class="p-8 rounded-[2.5rem] bg-slate-50 border border-white shadow-inner relative overflow-hidden">
                        <div class="flex items-end justify-between mb-5">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Total Penyerapan</span>
                            <div class="text-right">
                                <span class="text-5xl font-black text-slate-900 tracking-tighter">{{ round($efisiensi, 1) }}</span>
                                <span class="text-xl font-black text-slate-300">%</span>
                            </div>
                        </div>
                        
                        <div class="h-6 w-full bg-white rounded-2xl p-1 shadow-sm border border-slate-100 mb-8 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-500 via-indigo-600 to-violet-600 rounded-xl transition-all duration-1000 shadow-lg group-hover:brightness-110" 
                                style="width: {{ min($efisiensi, 100) }}%">
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-5 rounded-3xl bg-white border border-slate-100 shadow-sm transition-transform group-hover:scale-[1.02]">
                            <div class="h-11 w-11 flex items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 shadow-inner">
                                <i class="fa-solid fa-coins text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest leading-none mb-1">Total Realisasi Terpakai</p>
                                <p class="text-slate-900 text-base font-black tracking-tight">Rp {{ number_format($stats['total_realisasi'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tooltipStyle = { 
        backgroundColor: 'rgba(255, 255, 255, 0.98)',
        titleColor: '#0f172a',
        bodyColor: '#475569',
        borderColor: '#f1f5f9',
        borderWidth: 1,
        titleFont: { size: 14, weight: '800', family: "'Inter', sans-serif" }, 
        bodyFont: { size: 12, weight: '600', family: "'Inter', sans-serif" }, 
        padding: 16, 
        cornerRadius: 16,
        displayColors: true,
        boxPadding: 8,
        shadowColor: 'rgba(0,0,0,0.1)',
        shadowBlur: 10
    };

    // 1. Doughnut Chart
    const dataAnggaran = @json($chartAnggaran).slice(0, 5);
    new Chart(document.getElementById('chartDoughnut'), {
        type: 'doughnut',
        data: {
            labels: dataAnggaran.map(d => d.label),
            datasets: [{
                data: dataAnggaran.map(d => d.terpakai),
                backgroundColor: [
                    '#6366f1', // Indigo
                    '#8b5cf6', // Violet
                    '#ec4899', // Pink
                    '#10b981', // Emerald
                    '#f59e0b'  // Amber
                ],
                borderWidth: 0,
                hoverOffset: 12,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { display: false },
                tooltip: { 
                    ...tooltipStyle,
                    callbacks: {
                        label: ctx => ` Rp ${ctx.parsed.toLocaleString('id-ID')}`
                    }
                }
            }
        }
    });

    // 2. Bar Chart Realisasi Bulanan
    const dataBulanan = @json($chartBulanan);
    new Chart(document.getElementById('chartBarBulanan'), {
        type: 'bar',
        data: {
            labels: dataBulanan.map(d => d.label),
            datasets: [{
                label: 'Realisasi (Rp)',
                data: dataBulanan.map(d => d.value),
                backgroundColor: 'rgba(99, 102, 241, 0.8)',
                hoverBackgroundColor: '#4f46e5',
                borderRadius: 12,
                barPercentage: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...tooltipStyle,
                    callbacks: { label: ctx => ` Rp ${ctx.parsed.y.toLocaleString('id-ID')}` }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11, weight: '800' }, color: '#94a3b8' }, border: { display: false } },
                y: { 
                    grid: { color: '#f1f5f9', drawBorder: false }, 
                    ticks: { 
                        font: { size: 11, weight: '600' }, 
                        color: '#cbd5e1', 
                        padding: 10,
                        callback: v => v >= 1e9 ? (v/1e9).toFixed(1)+'M' : v >= 1e6 ? (v/1e6).toFixed(0)+'Jt' : v.toLocaleString('id-ID')
                    }, 
                    border: { display: false }, 
                    beginAtZero: true 
                }
            }
        }
    });
});
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    .font-sans { font-family: 'Inter', sans-serif; }
    @keyframes fadeUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
    .animate-fade-up { animation: fadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
</style>
@endsection