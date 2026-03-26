@extends('layouts.app')

@section('title', 'Admin - Sub Kegiatan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between animate-fade-in">
        <div>
            <nav class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-900">&larr; Dashboard Admin</a>
            </nav>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Sub Kegiatan</h1>
        </div>
        
        <a href="{{ route('admin.sub-kegiatans.create') }}" 
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-800 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 active:scale-95 transition-all">
            <i class="fa-solid fa-plus text-xs"></i>
            Tambah Sub Kegiatan
        </a>
    </div>

    {{-- Filter Section --}}
    <div class="mb-6 animate-fade-in" style="animation-delay: 100ms">
        <form method="GET" class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
            <div class="flex flex-1 items-center gap-2 pl-2">
                <i class="fa-solid fa-calendar-alt text-slate-400"></i>
                <select name="year_id" class="w-full rounded-lg border-none bg-transparent px-3 py-2 text-sm font-medium text-slate-700 focus:ring-0 outline-none cursor-pointer">
                    <option value="">Semua Tahun Anggaran</option>
                    @foreach($years as $y)
                        <option value="{{ $y->id }}" {{ request('year_id') == $y->id ? 'selected' : '' }}>Tahun {{ $y->tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="h-6 w-px bg-slate-200"></div>
            <button type="submit" class="px-5 py-2 text-sm font-bold text-slate-700 hover:text-slate-900 transition-colors">
                Filter
            </button>
        </form>
    </div>

    {{-- Table Section --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm animate-fade-in" style="animation-delay: 200ms">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="w-12 px-4 py-4"></th>
                        <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Tahun</th>
                        <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Sub Kegiatan</th>
                        <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Kode</th>
                        <th class="px-4 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-slate-400">Pagu Anggaran</th>
                        <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-slate-400">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($subKegiatans as $sk)
                        {{-- Set x-data open=false di level baris TR --}}
                        <tr x-data="{ open: false }" class="group transition-colors hover:bg-slate-50/50" :class="{ 'bg-slate-50/50': open }">
                            <td class="px-4 py-4 text-center align-top">
                                @if($sk->kodeRekenings->isNotEmpty())
                                    <button @click="open = !open" 
                                        class="flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-400 shadow-sm hover:border-slate-300 hover:text-slate-900 transition-all outline-none"
                                        :class="{ 'rotate-90 border-slate-900 text-slate-900 bg-slate-100': open }">
                                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                    </button>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm font-semibold text-slate-600 align-top">
                                {{ $sk->year->tahun ?? '-' }}
                            </td>
                            <td class="px-4 py-4 align-top">
                                <div class="text-sm font-bold text-slate-900 leading-snug">{{ $sk->nama_sub_kegiatan }}</div>
                                
                                {{-- PERBAIKAN UTAMA: Konten Expand ditaruh DI DALAM sel Nama Sub Kegiatan --}}
                                @if($sk->kodeRekenings->isNotEmpty())
                                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" class="mt-6 animate-fade-in">
                                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5">
                                            
                                            <div class="flex items-center justify-between mb-5 pb-4 border-b border-slate-100">
                                                <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-wider">Distribusi Anggaran Rekening</h4>
                                                <div class="text-[11px] font-mono text-slate-400 uppercase tracking-tight">Kode Sub: {{ $sk->kode_sub }}</div>
                                            </div>

                                            <form method="POST" action="{{ route('admin.sub-kegiatans.anggaran-kode-rekening.update', $sk) }}">
                                                @csrf @method('PUT')
                                                @if(request('year_id'))<input type="hidden" name="year_id" value="{{ request('year_id') }}" />@endif

                                                <div class="overflow-hidden rounded-xl border border-slate-100 mb-6 shadow-sm">
                                                    <table class="min-w-full text-sm divide-y divide-slate-100">
                                                        <thead class="bg-slate-50">
                                                            <tr>
                                                                <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-500 uppercase">Rekening</th>
                                                                <th class="px-4 py-3 text-right text-[10px] font-bold text-slate-500 uppercase">Pagu (Rp)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-slate-50 bg-white">
                                                            @foreach($sk->kodeRekenings as $kr)
                                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                                    <td class="px-4 py-3">
                                                                        <div class="text-xs font-mono text-slate-400 font-bold tracking-tight">{{ $kr->kode_rekening }}</div>
                                                                        <div class="font-semibold text-slate-700 mt-0.5">{{ $kr->nama_rekening }}</div>
                                                                    </td>
                                                                    <td class="px-4 py-3 text-right">
                                                                        <input type="number" name="anggaran[{{ $kr->id }}]" value="{{ old('anggaran.'.$kr->id, $kr->pivot->anggaran ?? 0) }}" min="0" step="0.01" 
                                                                            class="w-full max-w-[180px] rounded-lg border-slate-200 bg-slate-50 px-4 py-2 text-right font-bold text-slate-800 focus:bg-white focus:ring-1 focus:ring-slate-900 transition-all tabular-nums shadow-inner outline-none" />
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                @php
                                                    $totalKodeRek = $sk->kodeRekenings->sum(fn($kr) => (float)($kr->pivot->anggaran ?? 0));
                                                    $anggaranSk = (float)($sk->anggaran ?? 0);
                                                    $selisih = $anggaranSk - $totalKodeRek;
                                                @endphp

                                                <div class="flex flex-wrap items-center justify-between gap-4 p-5 rounded-2xl border border-slate-100 bg-slate-50 shadow-inner">
                                                    <div class="flex gap-8 text-center tabular-nums">
                                                        <div>
                                                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Pagu Sub Kegiatan</div>
                                                            <div class="text-sm font-bold text-slate-800">{{ number_format($anggaranSk, 0, ',', '.') }}</div>
                                                        </div>
                                                        <div>
                                                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Total Terbagi</div>
                                                            <div class="text-sm font-bold text-slate-800">{{ number_format($totalKodeRek, 0, ',', '.') }}</div>
                                                        </div>
                                                        <div>
                                                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Selisih</div>
                                                            <div class="text-sm font-black {{ $selisih != 0 ? 'text-amber-600' : 'text-emerald-600' }}">
                                                                {{ number_format($selisih, 0, ',', '.') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-5 py-2.5 text-xs font-bold text-white shadow-lg shadow-slate-900/10 hover:bg-black transition-all active:scale-95">
                                                        <i class="fa-solid fa-save text-[10px]"></i>
                                                        Simpan Anggaran
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 font-mono text-xs text-slate-400 tracking-tight align-top">
                                {{ $sk->kode_sub ?: '-' }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-right text-sm font-bold text-slate-900 tabular-nums align-top">
                                {{ number_format($sk->anggaran ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex items-center justify-end gap-2 text-slate-400">
                                    <a href="{{ route('admin.sub-kegiatans.edit', $sk) }}" class="h-8 w-8 flex items-center justify-center rounded-lg hover:bg-slate-100 hover:text-slate-900 transition-colors" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.sub-kegiatans.destroy', $sk) }}" method="POST" class="inline" onsubmit="return confirm('Hapus sub kegiatan ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="h-8 w-8 flex items-center justify-center rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors opacity-60 hover:opacity-100">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center text-slate-400">
                                <i class="fa-solid fa-folder-open text-4xl mb-4 opacity-30"></i>
                                <p class="text-sm font-medium">Belum ada data sub kegiatan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($subKegiatans->hasPages())
            <div class="border-t border-slate-100 px-6 py-4 bg-slate-50/20">
                {{ $subKegiatans->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Tambahkan x-cloak agar elemen tersembunyi tidak flash saat load --}}
<style>
    [x-cloak] { display: none !important; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
@endsection