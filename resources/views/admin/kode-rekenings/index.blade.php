@extends('layouts.app')

@section('title', 'Admin - Kode Rekening & Etalase')

@section('content')
<div class="relative min-h-screen bg-slate-50/50 pb-12">
    {{-- Background Ornaments --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-20 h-80 w-80 rounded-full bg-emerald-100/40 blur-3xl"></div>
        <div class="absolute right-0 bottom-10 h-96 w-96 rounded-full bg-blue-100/30 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-10 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between animate-fade-up">
            <div>
                <nav class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">&larr; Dashboard Admin</a>
                </nav>
                <div class="flex items-center gap-3">
                    <div class="bg-emerald-600 text-white p-2.5 rounded-xl shadow-lg shadow-emerald-900/20">
                        <i class="fa-solid fa-barcode text-lg"></i>
                    </div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kode Rekening <span class="text-emerald-600">&</span> Etalase</h1>
                </div>
            </div>
            
            <a href="{{ route('admin.kode-rekenings.create') }}" 
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 hover:-translate-y-1 transition-all">
                <i class="fa-solid fa-plus"></i>
                Tambah Kode Rekening
            </a>
        </div>

        {{-- Table Section --}}
        <div class="animate-fade-up delay-100 shadow-xl shadow-slate-200/50 rounded-[2.5rem] overflow-hidden border border-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 bg-white/80 backdrop-blur-md">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Kode Rekening</th>
                            <th class="px-6 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Nama Rekening</th>
                            <th class="px-6 py-5 text-center text-[10px] font-bold uppercase tracking-widest text-slate-400">Jumlah Etalase</th>
                            <th class="px-6 py-5 text-center text-[10px] font-bold uppercase tracking-widest text-slate-400">Opsi Kelola</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($kodeRekenings as $index => $kr)
                            <tr class="group transition-colors hover:bg-white/90">
                                <td class="whitespace-nowrap px-6 py-5">
                                    <span class="inline-block rounded-lg bg-emerald-50 px-3 py-1 text-xs font-mono font-bold text-emerald-700 border border-emerald-100 uppercase">
                                        {{ $kr->kode_rekening }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-800 group-hover:text-emerald-600 transition-colors leading-snug">
                                        {{ $kr->nama_rekening }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-5 text-center">
                                    <div class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                                        <i class="fa-solid fa-layer-group text-[10px] text-slate-400"></i>
                                        <span class="text-sm font-black text-slate-700 tabular-nums">{{ $kr->etalases_count }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Tombol Edit / Kelola --}}
                                        <a href="{{ route('admin.kode-rekenings.edit', $kr) }}" 
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-emerald-600 hover:text-white transition-all group/btn shadow-sm">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            Kelola
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.kode-rekenings.destroy', $kr) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kode rekening dan semua etalasenya?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                class="h-9 w-9 flex items-center justify-center rounded-xl text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all" 
                                                title="Hapus Rekening">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="h-20 w-20 flex items-center justify-center rounded-full bg-slate-50 text-slate-200 mb-4">
                                            <i class="fa-solid fa-barcode text-4xl"></i>
                                        </div>
                                        <p class="text-slate-500 font-medium">Belum ada data kode rekening ditemukan.</p>
                                        <a href="{{ route('admin.kode-rekenings.create') }}" class="mt-4 text-sm font-bold text-emerald-600 hover:underline">Tambah data pertama &rarr;</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($kodeRekenings->hasPages())
                <div class="border-t border-slate-100 bg-white/50 px-6 py-5">
                    {{ $kodeRekenings->links() }}
                </div>
            @endif
        </div>

        {{-- Info Card --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4 animate-fade-up delay-200">
            <div class="rounded-3xl bg-emerald-600 p-6 text-white shadow-lg shadow-emerald-900/10">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest opacity-80">Total Master Data</p>
                        <h3 class="mt-1 text-3xl font-black">{{ $kodeRekenings->total() }} <span class="text-lg font-medium opacity-60">Rekening</span></h3>
                    </div>
                    <i class="fa-solid fa-database text-3xl opacity-20"></i>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Tips Administrator</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Satu Kode Rekening dapat memiliki banyak sub-etalase untuk mempermudah kategorisasi belanja.</p>
                    </div>
                </div>
            </div>
        </div>
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
</style>
@endsection