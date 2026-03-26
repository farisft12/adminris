@extends('layouts.app')

@section('title', 'Master Data Pejabat')

@section('content')
<div class="relative min-h-screen bg-slate-50/50 pb-12 font-sans">
    {{-- Background Decoration --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-20 h-[30rem] w-[30rem] rounded-full bg-indigo-100/40 blur-3xl"></div>
        <div class="absolute right-0 bottom-0 h-[25rem] w-[25rem] rounded-full bg-rose-100/20 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-8 animate-fade-up">
            <nav class="mb-3 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-500 transition-colors">Admin</a>
                <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                <span class="text-indigo-500">Master Data</span>
            </nav>
            <div class="flex items-center gap-4">
                <div class="bg-white text-rose-600 p-3.5 rounded-2xl shadow-sm border border-slate-100">
                    <i class="fa-solid fa-user-tie text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Data Pejabat</h1>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Pengaturan penandatangan pada Kwitansi & Nota Persetujuan.</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 animate-fade-in rounded-2xl bg-emerald-50 p-4 border border-emerald-100 flex items-center gap-3 shadow-sm">
                <div class="h-8 w-8 rounded-full bg-emerald-500 flex items-center justify-center text-white shadow-sm">
                    <i class="fa-solid fa-check text-xs"></i>
                </div>
                <p class="text-sm font-bold text-emerald-700 tracking-tight">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')

            <div class="grid gap-8 sm:grid-cols-2">
                {{-- Bendahara Card --}}
                <div class="animate-fade-up rounded-[2.5rem] border border-white bg-white/70 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-xl p-10 overflow-hidden relative group" style="animation-delay: 100ms">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-indigo-50/50 blur-2xl group-hover:scale-125 transition-transform duration-700"></div>
                    
                    <div class="relative">
                        <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-white shadow-sm">
                            <i class="fa-solid fa-coins text-indigo-500"></i>
                            <span class="text-indigo-600">Pejabat Keuangan</span>
                        </div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight mb-8">Data Bendahara</h2>
                        
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Lengkap</label>
                                <input type="text" name="bendahara_nama" required 
                                    value="{{ old('bendahara_nama', $settings['bendahara_nama'] ?? '') }}"
                                    class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-4 text-slate-800 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-bold text-sm shadow-sm"
                                    placeholder="Masukkan nama bendahara..." />
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">NIP</label>
                                <input type="text" name="bendahara_nip" required 
                                    value="{{ old('bendahara_nip', $settings['bendahara_nip'] ?? '') }}"
                                    class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-4 text-slate-800 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-mono font-bold text-sm shadow-sm"
                                    placeholder="Masukkan NIP..." />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kabag Card --}}
                <div class="animate-fade-up rounded-[2.5rem] border border-white bg-white/70 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-xl p-10 overflow-hidden relative group" style="animation-delay: 200ms">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-rose-50/50 blur-2xl group-hover:scale-125 transition-transform duration-700"></div>
                    
                    <div class="relative">
                        <div class="inline-flex items-center gap-2 rounded-full bg-rose-50 px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-white shadow-sm">
                            <i class="fa-solid fa-briefcase text-rose-500"></i>
                            <span class="text-rose-600">Pejabat Struktural</span>
                        </div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tight mb-8">Data Kabag</h2>
                        
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Lengkap</label>
                                <input type="text" name="kabag_nama" required 
                                    value="{{ old('kabag_nama', $settings['kabag_nama'] ?? '') }}"
                                    class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-4 text-slate-800 focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 transition-all font-bold text-sm shadow-sm"
                                    placeholder="Masukkan nama Kabag..." />
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">NIP</label>
                                <input type="text" name="kabag_nip" required 
                                    value="{{ old('kabag_nip', $settings['kabag_nip'] ?? '') }}"
                                    class="block w-full rounded-2xl border-slate-200 bg-white/50 px-5 py-4 text-slate-800 focus:border-rose-500 focus:ring-4 focus:ring-rose-500/10 transition-all font-mono font-bold text-sm shadow-sm"
                                    placeholder="Masukkan NIP..." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center pt-8">
                <button type="submit" 
                    class="px-12 py-4 bg-slate-900 text-white rounded-2xl font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-slate-900/20 hover:bg-emerald-600 hover:shadow-emerald-600/30 active:scale-95 transition-all">
                    Simpan Perubahan <i class="fa-solid fa-cloud-arrow-up ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    .font-sans { font-family: 'Inter', sans-serif; }
    @keyframes fadeUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { 0% { opacity: 0; } 100% { opacity: 1; } }
    .animate-fade-up { animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
</style>
@endsection
