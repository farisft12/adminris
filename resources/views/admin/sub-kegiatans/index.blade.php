@extends('layouts.app')

@section('title', 'Admin - Sub Kegiatan')

@section('content')
<div class="relative min-h-screen bg-slate-50 pb-12">
    {{-- Background subtle (hanya satu warna lembut agar tidak ramai) --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-20 h-96 w-96 rounded-full bg-slate-200/40 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between animate-fade-up">
            <div>
                <nav class="mb-2 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition-colors">Admin</a>
                    <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    <span>Sub Kegiatan</span>
                </nav>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Manajemen Sub Kegiatan</h1>
            </div>
            
            <a href="{{ route('admin.sub-kegiatans.create') }}" 
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition-all active:scale-95">
                <i class="fa-solid fa-plus text-xs"></i>
                Tambah Sub Kegiatan
            </a>
        </div>

        {{-- Filter Section --}}
        <div class="mb-6 animate-fade-up" style="animation-delay: 100ms">
            <form method="GET" class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                <div class="flex flex-1 items-center gap-3 pl-2">
                    <i class="fa-solid fa-calendar text-slate-400 text-sm"></i>
                    <select name="year_id" class="w-full bg-transparent text-sm font-medium text-slate-700 outline-none border-none focus:ring-0 cursor-pointer">
                        <option value="">Semua Tahun Anggaran</option>
                        @foreach($years as $y)
                            <option value="{{ $y->id }}" {{ request('year_id') == $y->id ? 'selected' : '' }}>Tahun {{ $y->tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="h-6 w-px bg-slate-200"></div>
                <button type="submit" class="px-4 py-1.5 text-sm font-bold text-slate-700 hover:text-slate-900 transition-colors">
                    Filter
                </button>
            </form>
        </div>

        {{-- Table Section --}}
        <div class="animate-fade-up border border-slate-200 bg-white rounded-xl shadow-sm overflow-hidden" style="animation-delay: 200ms">
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
                            <tr x-data="{ open: false }" class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-4 text-center">
                                    @if($sk->kodeRekenings->isNotEmpty())
                                        <button @click="open = !open" class="flex h-7 w-7 items-center justify-center rounded border border-slate-200 bg-white text-slate-400 hover:text-slate-900 transition-all" :class="{ 'rotate-90 border-slate-900 text-slate-900': open }">
                                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                        </button>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-4">
                                    <span class="text-sm font-semibold text-slate-600">{{ $sk->year->tahun ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-sm font-bold text-slate-900 leading-snug">{{ $sk->nama_sub_kegiatan }}</div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-4">
                                    <span class="text-xs font-mono font-medium text-slate-400">{{ $sk->kode_sub ?: '-' }}</span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-right">
                                    <span class="text-sm font-bold text-slate-900 tabular-nums">
                                        {{ number_format($sk->anggaran ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.sub-kegiatans.edit', $sk) }}" class="text-slate-400 hover:text-slate-900 transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.sub-kegiatans.destroy', $sk) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                                {{-- Collapsible Detail --}}
                                <template x-if="open">
                                    <tr>
                                        <td colspan="6" class="bg-slate-50/30 px-6 py-4">
                                            <div class="rounded-lg border border-slate-200 bg-white shadow-sm overflow-hidden">
                                                <div class="border-b border-slate-100 bg-slate-50/50 px-5 py-3 flex justify-between items-center">
                                                    <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-wider">Distribusi Anggaran Rekening</h4>
                                                    <i class="fa-solid fa-calculator text-slate-300"></i>
                                                </div>

                                                <form method="POST" action="{{ route('admin.sub-kegiatans.anggaran-kode-rekening.update', $sk) }}" class="p-5">
                                                    @csrf @method('PUT')
                                                    @if(request('year_id'))<input type="hidden" name="year_id" value="{{ request('year_id') }}" />@endif

                                                    <table class="min-w-full text-sm mb-6">
                                                        <tbody class="divide-y divide-slate-100">
                                                            @foreach($sk->kodeRekenings as $kr)
                                                                <tr>
                                                                    <td class="py-3 pr-4">
                                                                        <div class="text-[10px] font-mono text-slate-400 uppercase tracking-tighter">{{ $kr->kode_rekening }}</div>
                                                                        <div class="font-semibold text-slate-700">{{ $kr->nama_rekening }}</div>
                                                                    </td>
                                                                    <td class="py-3 text-right">
                                                                        <input type="number" name="anggaran[{{ $kr->id }}]" value="{{ old('anggaran.'.$kr->id, $kr->pivot->anggaran ?? 0) }}" 
                                                                            class="w-full max-w-[180px] rounded-md border-slate-200 bg-slate-50 px-3 py-1.5 text-right font-bold text-slate-800 focus:bg-white focus:ring-1 focus:ring-slate-900 outline-none transition-all" />
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    @php
                                                        $totalKodeRek = $sk->kodeRekenings->sum(fn($kr) => (float)($kr->pivot->anggaran ?? 0));
                                                        $anggaranSk = (float)($sk->anggaran ?? 0);
                                                        $selisih = $anggaranSk - $totalKodeRek;
                                                    @endphp

                                                    <div class="flex flex-wrap items-center justify-between gap-4 border-t border-slate-100 pt-5">
                                                        <div class="flex gap-8">
                                                            <div>
                                                                <div class="text-[9px] font-bold text-slate-400 uppercase">Pagu</div>
                                                                <div class="text-sm font-bold text-slate-900">{{ number_format($anggaranSk, 0, ',', '.') }}</div>
                                                            </div>
                                                            <div>
                                                                <div class="text-[9px] font-bold text-slate-400 uppercase">Terpakai</div>
                                                                <div class="text-sm font-bold text-slate-900">{{ number_format($totalKodeRek, 0, ',', '.') }}</div>
                                                            </div>
                                                            <div>
                                                                <div class="text-[9px] font-bold text-slate-400 uppercase">Selisih</div>
                                                                <div class="text-sm font-bold {{ $selisih != 0 ? 'text-amber-600' : 'text-emerald-600' }}">
                                                                    {{ number_format($selisih, 0, ',', '.') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-xs font-bold text-white hover:bg-slate-800 transition-all">
                                                            Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-20 text-center text-slate-400">
                                    <p class="text-sm">Data tidak ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($subKegiatans->hasPages())
            <div class="mt-6">
                {{ $subKegiatans->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.5s ease-out forwards;
    }
</style>
@endsection