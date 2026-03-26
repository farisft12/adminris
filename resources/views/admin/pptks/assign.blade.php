@extends('layouts.app')

@section('title', 'Admin - Penugasan PPTK')

@section('content')
<div class="relative min-h-screen bg-slate-50 pb-12">
    {{-- Background subtle (Netral) --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-20 h-96 w-96 rounded-full bg-slate-200/40 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between animate-fade-up">
            <div>
                <nav class="mb-2 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition-colors">Admin</a>
                    <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                    <span>Penugasan PPTK</span>
                </nav>
                <div class="flex items-center gap-3">
                    <div class="bg-slate-900 text-white p-3 rounded-xl shadow-lg shadow-slate-950/20">
                        <i class="fa-solid fa-clipboard-list text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Matriks Penugasan PPTK</h1>
                        <p class="mt-1 text-sm text-slate-500">Tentukan Pejabat Pelaksana Teknis Kegiatan untuk setiap sub kegiatan.</p>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('admin.pptks.index') }}" 
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-white border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 hover:border-slate-400 transition-all active:scale-95 outline-none focus:ring-2 focus:ring-slate-200">
                <i class="fa-solid fa-user-tie text-xs opacity-60"></i>
                Kelola Data PPTK
            </a>
        </div>

        {{-- Form Section --}}
        <form method="POST" action="{{ route('admin.pptk.assign.store') }}" 
            class="animate-fade-up border border-slate-200 bg-white rounded-xl shadow-sm overflow-hidden" style="animation-delay: 100ms">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 bg-white/80 backdrop-blur-md">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Tahun</th>
                            <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Sub Kegiatan</th>
                            <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Pejabat PPTK</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 overflow-y-auto">
                        @forelse($subKegiatans as $sk)
                            {{-- Gunakan $sk->id sebagai kunci array untuk input --}}
                            <tr class="group transition-colors hover:bg-slate-50/50">
                                <td class="whitespace-nowrap px-6 py-5 align-top">
                                    <span class="inline-block rounded-md bg-slate-100 px-3 py-1 font-mono text-sm font-semibold text-slate-600 border border-slate-200/50 uppercase tracking-tight">
                                        {{ $sk->year->tahun ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 align-top">
                                    <div class="text-sm font-bold text-slate-900 leading-snug">
                                        {{ $sk->nama_sub_kegiatan }}
                                    </div>
                                    <div class="text-xs font-mono text-slate-400 mt-1 uppercase tracking-tight">Kode Sub: {{ $sk->kode_sub ?: '-' }}</div>
                                </td>
                                <td class="px-6 py-5 align-top">
                                    {{-- PERBAIKAN DI SINI: name="assignments[{{ $sk->id }}]..." --}}
                                    <input type="hidden" name="assignments[{{ $sk->id }}][sub_kegiatan_id]" value="{{ $sk->id }}" />
                                    <div class="relative relative-input-group">
                                        <select name="assignments[{{ $sk->id }}][pptk_id]" 
                                            class="block w-full min-w-[280px] rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 shadow-sm focus:border-slate-500 focus:ring-slate-500 transition-colors cursor-pointer appearance-none outline-none">
                                            <option value="">-- Tidak ada / Belum Ditunjuk --</option>
                                            @foreach($pptks as $pptk)
                                                {{-- Sesuaikan old() dengan kunci ID baru --}}
                                                <option value="{{ $pptk->id }}" {{ (int) old('assignments.'.$sk->id.'.pptk_id', $sk->pptk_id) === (int) $pptk->id ? 'selected' : '' }}>
                                                    {{ $pptk->nama_pptk }}{{ $pptk->nip ? ' (NIP. '.$pptk->nip.')' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-20 text-center text-slate-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fa-solid fa-folder-open text-4xl mb-4 opacity-30"></i>
                                        <p class="text-sm font-medium">Belum ada data sub kegiatan.</p>
                                        <p class="text-xs text-slate-500 mt-1 mb-4">Tambah sub kegiatan terlebih dahulu di menu Admin.</p>
                                        <a href="{{ route('sub-kegiatan.index') }}" class="text-xs font-bold text-slate-900 hover:text-slate-600 uppercase tracking-widest bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">Buka Sub Kegiatan</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subKegiatans->isNotEmpty())
                {{-- Footer Form: Tombol Simpan --}}
                <div class="border-t border-slate-100 bg-slate-50/50 px-6 py-5 flex items-center justify-end">
                    <button type="submit" 
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition-all active:scale-95 shrink-0 outline-none focus:ring-2 focus:ring-slate-950/20">
                        <i class="fa-solid fa-save text-xs opacity-70"></i>
                        Simpan Perubahan Matriks
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>

<style>
    /* Hilangkan panah default select di beberapa browser */
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    [x-cloak] { display: none !important; }

    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }

    /* Styling minimalis untuk paginasi Tailwind default */
    .pagination-minimalist nav {
        @apply flex items-center gap-1;
    }
    .pagination-minimalist nav span[aria-current="page"] span,
    .pagination-minimalist nav a {
        @apply px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-xs font-bold transition-all;
    }
    .pagination-minimalist nav a {
        @apply text-slate-600 hover:bg-slate-50 hover:border-slate-300;
    }
    .pagination-minimalist nav span[aria-current="page"] span {
        @apply bg-slate-900 text-white border-slate-950 shadow-sm;
    }
    .pagination-minimalist nav svg {
        @apply w-4 h-4;
    }
</style>
@endsection