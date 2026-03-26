@extends('layouts.app')

@section('title', 'Admin - Kode Rekening & Etalase')

@section('content')
<div class="relative min-h-screen bg-slate-50 pb-12">
    {{-- Background subtle (Netral) --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-20 h-96 w-96 rounded-full bg-slate-200/40 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between animate-fade-up">
            <div>
                <nav class="mb-2 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition-colors">Admin</a>
                    <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                    <span>Kode Rekening</span>
                </nav>
                <div class="flex items-center gap-3">
                    <div class="bg-slate-900 text-white p-3 rounded-xl shadow-lg shadow-slate-950/20">
                        <i class="fa-solid fa-barcode text-lg"></i>
                    </div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kode Rekening <span class="text-slate-400">&</span> Etalase</h1>
                </div>
            </div>
            
            <a href="{{ route('admin.kode-rekenings.create') }}" 
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition-all active:scale-95">
                <i class="fa-solid fa-plus text-xs"></i>
                Tambah Kode Rekening
            </a>
        </div>

        {{-- Table Section --}}
        <div class="animate-fade-up border border-slate-200 bg-white rounded-xl shadow-sm overflow-hidden" style="animation-delay: 100ms">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 bg-white/80 backdrop-blur-md">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Kode Rekening</th>
                            <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Nama Rekening</th>
                            <th class="px-6 py-4 text-center text-[10px] font-bold uppercase tracking-widest text-slate-400">Jumlah Etalase</th>
                            <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-slate-400">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 overflow-y-auto">
                        @forelse($kodeRekenings as $index => $kr)
                            <tr class="group transition-colors hover:bg-slate-50/50">
                                <td class="whitespace-nowrap px-6 py-5">
                                    <span class="inline-block rounded-md bg-slate-100 px-3 py-1 font-mono text-sm font-semibold text-slate-600 border border-slate-200/50 uppercase tracking-tight">
                                        {{ $kr->kode_rekening }}
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="text-sm font-bold text-slate-900 leading-snug">
                                        {{ $kr->nama_rekening }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-5 text-center">
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600 border border-slate-200/50">
                                        {{ $kr->etalases_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 align-middle">
                                    <div class="flex items-center justify-end gap-2 text-slate-400">
                                        {{-- Tombol Edit / Kelola --}}
                                        <a href="{{ route('admin.kode-rekenings.edit', $kr) }}" 
                                           class="h-9 w-9 flex items-center justify-center rounded-lg hover:bg-slate-100 hover:text-slate-900 transition-colors" title="Kelola">
                                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.kode-rekenings.destroy', $kr) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kode rekening dan semua etalasenya?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                class="h-9 w-9 flex items-center justify-center rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors" 
                                                title="Hapus Rekening">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center text-slate-400">
                                    <i class="fa-solid fa-barcode text-4xl mb-4 opacity-30"></i>
                                    <p class="text-sm font-medium">Belum ada data kode rekening ditemukan.</p>
                                    <a href="{{ route('admin.kode-rekenings.create') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-slate-900 hover:text-slate-600">
                                        Tambah data pertama <i class="fa-solid fa-arrow-right text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($kodeRekenings->hasPages())
                <div class="border-t border-slate-100 bg-slate-50/50 px-6 py-4">
                    {{ $kodeRekenings->links() }}
                </div>
            @endif
        </div>

        {{-- Info Card --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-up" style="animation-delay: 200ms">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm flex items-center justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total Master Data</p>
                    <h3 class="mt-1 text-4xl font-black text-slate-900 tracking-tighter">{{ $kodeRekenings->total() }} <span class="text-lg font-medium text-slate-400 tracking-normal">Rekening</span></h3>
                </div>
                <div class="h-12 w-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-database"></i>
                </div>
            </div>
            
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">Tips Administrator</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Satu Kode Rekening dapat memiliki banyak sub-etalase untuk mempermudah kategorisasi belanja.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
</style>
@endsection