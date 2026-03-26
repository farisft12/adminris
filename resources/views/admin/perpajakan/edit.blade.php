@extends('layouts.app')

@section('title', 'Admin - Pengaturan Perpajakan')

@section('content')
<div class="relative min-h-screen bg-slate-50 pb-12">
    {{-- Background subtle (Netral) --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-20 top-20 h-96 w-96 rounded-full bg-slate-200/40 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-10 animate-fade-up">
            <nav class="mb-2 flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.15em] text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-slate-600 transition-colors">Admin</a>
                <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                <span>Pengaturan Perpajakan</span>
            </nav>
            <div class="flex items-center gap-3">
                <div class="bg-slate-900 text-white p-3 rounded-xl shadow-lg shadow-slate-950/20">
                    <i class="fa-solid fa-percent text-lg"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tarif Pajak Global</h1>
                    <p class="mt-1 text-sm text-slate-500">Atur nilai standar untuk PPN, PPh 23, dan PPh 21 dalam format desimal (contoh: 0.11 = 11%).</p>
                </div>
            </div>
        </div>

        {{-- Form Section --}}
        {{-- Fixed: Karakter tersembunyi dihapus di class dan radius diperhalus --}}
        <form method="POST" action="{{ route('admin.perpajakan.update') }}" 
            class="animate-fade-up border border-slate-200 bg-white rounded-2xl shadow-sm p-8" style="animation-delay: 100ms">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                {{-- PPN Rate --}}
                {{-- Perbaikan Visual: Menggunakan kontainer kartu untuk setiap input agar lebih terorganisir --}}
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-5 shadow-inner transition-all hover:border-slate-200 hover:bg-slate-100/50">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <label for="ppn_rate" class="block text-sm font-bold text-slate-800">Tarif PPN Global (PPN)</label>
                        {{-- Badge Dinamis: Menampilkan persentase berdasarkan nilai desimal aktual --}}
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-xs font-bold text-blue-700 font-mono border border-blue-200">
                            {{ ($perpajakan->ppn_rate * 100) }}%
                        </span>
                    </div>
                    <div class="relative relative-input-group">
                        {{-- Input Modern: Padding disesuaikan, font mono untuk presisi desimal --}}
                        <input id="ppn_rate" type="number" name="ppn_rate" step="0.0001" min="0" max="1" value="{{ old('ppn_rate', $perpajakan->ppn_rate) }}" required 
                            class="block w-full rounded-lg border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-900 shadow-sm focus:border-slate-500 focus:ring-slate-500 transition-colors outline-none font-mono tracking-tight" />
                        {{-- Hint Teks: Memberikan konteks format input --}}
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-xs text-slate-400 tracking-normal font-sans">format desimal</div>
                    </div>
                    {{-- Perbaikan Error: Tampilan error lebih clean dengan ikon --}}
                    @error('ppn_rate')<p class="mt-2 text-xs font-bold text-red-600 animate-fade-in"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>@enderror
                </div>

                {{-- PPh 23 Rate --}}
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-5 shadow-inner transition-all hover:border-slate-200 hover:bg-slate-100/50">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <label for="pph23_rate" class="block text-sm font-bold text-slate-800">Tarif PPh 23 Global (PPh 23)</label>
                        <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-1 text-xs font-bold text-amber-700 font-mono border border-amber-200">
                            {{ ($perpajakan->pph23_rate * 100) }}%
                        </span>
                    </div>
                    <div class="relative relative-input-group">
                        <input id="pph23_rate" type="number" name="pph23_rate" step="0.0001" min="0" max="1" value="{{ old('pph23_rate', $perpajakan->pph23_rate) }}" required 
                            class="block w-full rounded-lg border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-900 shadow-sm focus:border-slate-500 focus:ring-slate-500 transition-colors outline-none font-mono tracking-tight" />
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-xs text-slate-400 tracking-normal font-sans">format desimal</div>
                    </div>
                    @error('pph23_rate')<p class="mt-2 text-xs font-bold text-red-600 animate-fade-in"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>@enderror
                </div>

                {{-- PPh 21 Rate --}}
                <div class="rounded-xl border border-slate-100 bg-slate-50 p-5 shadow-inner transition-all hover:border-slate-200 hover:bg-slate-100/50">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <label for="pph21_rate" class="block text-sm font-bold text-slate-800">Tarif PPh 21 Global (PPh 21)</label>
                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700 font-mono border border-emerald-200">
                            {{ ($perpajakan->pph21_rate * 100) }}%
                        </span>
                    </div>
                    <div class="relative relative-input-group">
                        <input id="pph21_rate" type="number" name="pph21_rate" step="0.0001" min="0" max="1" value="{{ old('pph21_rate', $perpajakan->pph21_rate) }}" required 
                            class="block w-full rounded-lg border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-900 shadow-sm focus:border-slate-500 focus:ring-slate-500 transition-colors outline-none font-mono tracking-tight" />
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-xs text-slate-400 tracking-normal font-sans">format desimal</div>
                    </div>
                    @error('pph21_rate')<p class="mt-2 text-xs font-bold text-red-600 animate-fade-in"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Action Buttons --}}
            {{-- Fixed: Karakter tersembunyi dihapus di class --}}
            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" 
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-white border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 hover:border-slate-400 transition-all active:scale-95 outline-none focus:ring-2 focus:ring-slate-200">
                    Batal
                </a>
                <button type="submit" 
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition-all active:scale-95 outline-none focus:ring-2 focus:ring-slate-950/20">
                    <i class="fa-solid fa-save text-xs opacity-70"></i>
                    Simpan Perubahan Tarif
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Fixed: Menghapus spasi ganda dan karakter transparan di class Tailwind */
    [x-cloak] { display: none !important; }

    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    /* Memastikan hint teks desimal memiliki warna yang tepat saat input difokuskan */
    .relative-input-group input:focus + div {
        color: #64748b; /* slate-500 */
    }
</style>
@endsection