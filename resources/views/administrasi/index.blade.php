@extends('layouts.app')

@section('title', 'Data Administrasi')

@section('content')
<div class="relative min-h-screen bg-slate-50 pb-12">
    {{-- Background Decoration - Fixed: pointer-events-none agar tidak menghalangi klik --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
        <div class="absolute -left-20 top-20 h-96 w-96 rounded-full bg-blue-100/40 blur-3xl opacity-50"></div>
        <div class="absolute right-0 bottom-10 h-96 w-96 rounded-full bg-indigo-100/30 blur-3xl opacity-50"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Navigation / Breadcrumb - Fixed: Semua link aktif bisa diklik --}}
        @if(isset($selectedSubKegiatan) && $selectedSubKegiatan)
            <nav class="mb-6 flex flex-wrap items-center gap-2 text-[11px] font-bold uppercase tracking-[0.15em] text-slate-400 animate-fade-up">
                <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors flex items-center">
                    <i class="fa-solid fa-house-chimney mr-1.5 text-[10px]"></i> Dashboard
                </a>
                
                <i class="fa-solid fa-chevron-right text-[8px] opacity-40"></i>
                
                <a href="{{ route('sub-kegiatan.show', $selectedSubKegiatan) }}" class="hover:text-primary transition-colors truncate max-w-[200px]">
                    {{ $selectedSubKegiatan->nama_sub_kegiatan }}
                </a>
                
                @if(request('kode_rekening_id'))
                    <i class="fa-solid fa-chevron-right text-[8px] opacity-40"></i>
                    <a href="{{ route('sub-kegiatan.kode-rekenings.index', $selectedSubKegiatan) }}" class="hover:text-primary transition-colors">
                        Kode Rekening
                    </a>
                    <i class="fa-solid fa-chevron-right text-[8px] opacity-40"></i>
                    <span class="text-slate-900 font-black">Data Administrasi</span>
                @else
                    <i class="fa-solid fa-chevron-right text-[8px] opacity-40"></i>
                    <span class="text-slate-900 font-black">Kode Rekening</span>
                @endif
            </nav>
        @endif

        {{-- Header Section --}}
        <div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between animate-fade-up">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">Administrasi Belanja</h1>
                @if(isset($selectedSubKegiatan) && $selectedSubKegiatan)
                    <div class="mt-2 flex items-center gap-2 text-sm text-slate-500">
                        <i class="fa-solid fa-folder-tree text-slate-300"></i>
                        <span>Kegiatan: <span class="font-semibold text-slate-700">{{ $selectedSubKegiatan->nama_sub_kegiatan }}</span></span>
                    </div>
                @endif
            </div>
            
            <a href="{{ route('administrasi.create', request()->only('sub_kegiatan_id', 'year_id', 'kode_rekening_id')) }}" 
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-slate-800 transition-all active:scale-95">
                <i class="fa-solid fa-plus text-xs"></i>
                Tambah Rekaman
            </a>
        </div>

        {{-- Filter Section --}}
        <div class="mb-8 animate-fade-up" style="animation-delay: 100ms">
            <form method="GET" action="{{ route('administrasi.index') }}" 
                class="grid grid-cols-1 gap-4 rounded-xl border border-slate-200 bg-white/80 p-5 shadow-sm backdrop-blur-sm sm:grid-cols-2 lg:grid-cols-4 lg:items-end">
                
                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-400 ml-1">Tahun</label>
                    <select name="year_id" class="w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium focus:border-slate-900 focus:ring-0 transition-all cursor-pointer">
                        <option value="">-- Semua Tahun --</option>
                        @foreach($years as $y)
                            <option value="{{ $y->id }}" {{ request('year_id') == $y->id ? 'selected' : '' }}>{{ $y->tahun }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-400 ml-1">Sub Kegiatan</label>
                    <select name="sub_kegiatan_id" class="w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium focus:border-slate-900 focus:ring-0 transition-all cursor-pointer">
                        <option value="">-- Semua Kegiatan --</option>
                        @foreach($subKegiatans as $sk)
                            <option value="{{ $sk->id }}" {{ request('sub_kegiatan_id') == $sk->id ? 'selected' : '' }}>{{ $sk->nama_sub_kegiatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-wider text-slate-400 ml-1">Kode Rekening</label>
                    <select name="kode_rekening_id" class="w-full rounded-lg border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium focus:border-slate-900 focus:ring-0 transition-all cursor-pointer">
                        <option value="">-- Semua Rekening --</option>
                        @foreach($kodeRekenings as $kr)
                            <option value="{{ $kr->id }}" {{ request('kode_rekening_id') == $kr->id ? 'selected' : '' }}>{{ $kr->kode_rekening }} - {{ $kr->nama_rekening }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="h-10 flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-4 text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-all">
                    <i class="fa-solid fa-sliders text-xs opacity-50"></i>
                    Terapkan Filter
                </button>
            </form>
        </div>

        {{-- Table Section --}}
        <div class="animate-fade-up border border-slate-200 bg-white rounded-xl shadow-sm overflow-hidden" style="animation-delay: 200ms">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">No</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Uraian / Deskripsi</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Tgl. Nota</th>
                            <th class="px-6 py-4 text-right text-[10px] font-black uppercase tracking-widest text-slate-400 font-mono">Pajak</th>
                            <th class="px-6 py-4 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Tagihan</th>
                            <th class="px-6 py-4 text-right text-[10px] font-black uppercase tracking-widest text-slate-900">Total Bersih</th>
                            <th class="px-6 py-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($administrasis as $a)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-400">{{ $a->no }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-900 leading-snug">{{ $a->uraian_belanja }}</div>
                                    <div class="mt-1 flex items-center gap-1.5 text-[10px] font-mono font-medium text-slate-400 uppercase">
                                        {{ $a->kodeRekening?->kode_rekening ?? '-' }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                    {{ $a->tanggal_nota_persetujuan?->format('d/m/Y') ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-500 font-mono">
                                    {{ number_format(($a->ppn ?? 0) + ($a->pph23 ?? 0) + ($a->pph21 ?? 0), 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-500 font-mono">
                                    {{ number_format($a->tagihan, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <span class="text-sm font-black text-slate-900 tabular-nums">
                                        {{ number_format($a->total_bersih, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-4 text-slate-300">
                                        <a href="{{ route('administrasi.edit', $a) }}" class="hover:text-slate-900 transition-colors" title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="{{ route('administrasi.kwitansi', $a) }}" target="_blank" class="hover:text-emerald-600 transition-colors" title="Cetak Kwitansi">
                                            <i class="fa-solid fa-receipt"></i>
                                        </a>
                                        <a href="{{ route('administrasi.nota-persetujuan', $a) }}" target="_blank" class="hover:text-blue-600 transition-colors" title="Cetak Nota Persetujuan">
                                            <i class="fa-solid fa-file-signature"></i>
                                        </a>
                                        @can('delete', $a)
                                            <form action="{{ route('administrasi.destroy', $a) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="hover:text-red-500 transition-colors">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center text-slate-400">
                                    <p class="text-sm">Tidak ada data ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($administrasis->isNotEmpty())
                        <tfoot class="bg-slate-50/50 border-t border-slate-100">
                            <tr class="font-bold">
                                <td colspan="3" class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Rekapitulasi Total</td>
                                <td class="px-6 py-5 text-right text-sm text-slate-600 font-mono">{{ number_format($rekap['ppn'] + $rekap['pph23'] + $rekap['pph21'], 0, ',', '.') }}</td>
                                <td class="px-6 py-5 text-right text-sm text-slate-600 font-mono">{{ number_format($rekap['tagihan'], 0, ',', '.') }}</td>
                                <td class="px-6 py-5 text-right text-lg text-slate-900 tabular-nums font-black leading-none">
                                    <span class="text-xs font-bold text-slate-400 mr-1 italic">Rp</span>{{ number_format($rekap['total_bersih'], 0, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>

        @if($administrasis->hasPages())
            <div class="mt-6">
                {{ $administrasis->withQueryString()->links() }}
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
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
@endsection