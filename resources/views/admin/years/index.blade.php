@extends('layouts.app')

@section('title', 'Admin - Tahun Anggaran')

@section('content')
<div class="relative min-h-screen bg-slate-50 pb-12">
    {{-- Background subtle (Netral) --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-20 h-96 w-96 rounded-full bg-slate-200/40 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between animate-fade-up">
            <div>
                <nav class="mb-2 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition-colors">Admin</a>
                    <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                    <span>Tahun Anggaran</span>
                </nav>
                <div class="flex items-center gap-3">
                    <div class="bg-slate-900 text-white p-3 rounded-xl shadow-lg shadow-slate-950/20">
                        <i class="fa-solid fa-calendar-days text-lg"></i>
                    </div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tahun <span class="text-slate-400">Anggaran</span></h1>
                </div>
            </div>
            
            <a href="{{ route('admin.years.create') }}" 
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition-all active:scale-95">
                <i class="fa-solid fa-plus text-xs"></i>
                Tambah Tahun
            </a>
        </div>

        {{-- Table Section --}}
        <div class="animate-fade-up border border-slate-200 bg-white rounded-xl shadow-sm overflow-hidden" style="animation-delay: 100ms">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 bg-white/80 backdrop-blur-md">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-widest text-slate-400">Tahun Anggaran</th>
                            <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-widest text-slate-400">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 overflow-y-auto">
                        @forelse($years as $y)
                            <tr class="group transition-colors hover:bg-slate-50/50">
                                <td class="px-6 py-5 align-middle">
                                    <span class="inline-block rounded-md bg-slate-100 px-4 py-1.5 font-mono text-sm font-semibold text-slate-600 border border-slate-200/50 uppercase tracking-tight">
                                        Tahun {{ $y->tahun }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 align-middle">
                                    <div class="flex items-center justify-end gap-2 text-slate-400">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.years.edit', $y) }}" 
                                           class="h-9 w-9 flex items-center justify-center rounded-lg hover:bg-slate-100 hover:text-slate-900 transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.years.destroy', $y) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tahun ini? Semua data terkait tahun ini mungkin akan terpengaruh.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                class="h-9 w-9 flex items-center justify-center rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors" 
                                                title="Hapus">
                                                <i class="fa-solid fa-trash-can text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-20 text-center text-slate-400">
                                    <i class="fa-solid fa-calendar-xmark text-4xl mb-4 opacity-30"></i>
                                    <p class="text-sm font-medium">Belum ada data tahun anggaran ditemukan.</p>
                                    <a href="{{ route('admin.years.create') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-slate-900 hover:text-slate-600">
                                        Tambah data pertama <i class="fa-solid fa-arrow-right text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($years->hasPages())
                <div class="border-t border-slate-100 bg-slate-50/50 px-6 py-4">
                    {{ $years->links() }}
                </div>
            @endif
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