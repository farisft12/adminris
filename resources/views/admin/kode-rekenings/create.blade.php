@extends('layouts.app')

@section('title', 'Tambah Kode Rekening')

@section('content')
<div class="relative min-h-screen bg-slate-50 pb-12">
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-20 h-96 w-96 rounded-full bg-slate-200/40 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-10 animate-fade-up">
            <nav class="mb-2 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition-colors">Admin</a>
                <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                <a href="{{ route('admin.kode-rekenings.index') }}" class="hover:text-slate-600 transition-colors">Kode Rekening</a>
                <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                <span>Tambah</span>
            </nav>
            <div class="flex items-center gap-3">
                <div class="bg-slate-900 text-white p-3 rounded-xl shadow-lg shadow-slate-950/20">
                    <i class="fa-solid fa-barcode text-lg"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Kode Rekening</h1>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.kode-rekenings.store') }}" class="animate-fade-up border border-slate-200 bg-white rounded-2xl shadow-sm p-8" style="animation-delay: 100ms">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="kode_rekening" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Kode Rekening</label>
                    <input id="kode_rekening" type="text" name="kode_rekening" value="{{ old('kode_rekening') }}" required placeholder="5.1.02.01.001.00042"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 transition-all focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20 outline-none shadow-sm font-mono" />
                    @error('kode_rekening')<p class="mt-2 text-xs font-bold text-red-600 ml-1"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="nama_rekening" class="block text-[11px] font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Nama Rekening</label>
                    <input id="nama_rekening" type="text" name="nama_rekening" value="{{ old('nama_rekening') }}" required placeholder="Belanja Jasa Pelaksanaan..."
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-900 transition-all focus:border-slate-500 focus:ring-2 focus:ring-slate-500/20 outline-none shadow-sm" />
                    @error('nama_rekening')<p class="mt-2 text-xs font-bold text-red-600 ml-1"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.kode-rekenings.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-white border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition-all active:scale-95">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition-all active:scale-95">
                    <i class="fa-solid fa-save text-xs opacity-70"></i> Simpan Rekening
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fadeUp { 0% { opacity: 0; transform: translateY(10px); } 100% { opacity: 1; transform: translateY(0); } }
    .animate-fade-up { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
</style>
@endsection
