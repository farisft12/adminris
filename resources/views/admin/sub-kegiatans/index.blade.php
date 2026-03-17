@extends('layouts.app')

@section('title', 'Admin - Sub Kegiatan')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; Admin</a>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">Sub Kegiatan</h1>
        </div>
        <a href="{{ route('admin.sub-kegiatans.create') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Tambah Sub Kegiatan</a>
    </div>
    <form method="GET" class="mb-4 flex gap-2">
        <select name="year_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option value="">Semua Tahun</option>
            @foreach($years as $y)
                <option value="{{ $y->id }}" {{ request('year_id') == $y->id ? 'selected' : '' }}>{{ $y->tahun }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">Filter</button>
    </form>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="w-10 px-2 py-3"></th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">Tahun</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">Nama Sub Kegiatan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">Kode</th>
                    <th class="px-4 py-3 text-right text-xs font-medium uppercase text-slate-600">Anggaran</th>
                    <th class="px-4 py-3 text-right text-xs font-medium uppercase text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($subKegiatans as $sk)
                    <tr class="hover:bg-slate-50 align-top">
                        <td colspan="6" class="p-0">
                            <div x-data="{ open: false }" class="border-b border-slate-100">
                                <div class="grid grid-cols-[2.5rem_4rem_1fr_6rem_7rem_8rem] items-center gap-0 border-b border-slate-100 md:grid-cols-[2.5rem_5rem_1fr_7rem_8rem_9rem]">
                                    <div class="flex justify-center py-3">
                                        @if($sk->kodeRekenings->isNotEmpty())
                                            <button type="button" @click="open = !open" class="rounded p-1 text-slate-500 hover:bg-slate-200" :class="{ 'rotate-90': open }" title="Tampilkan kode rekening">
                                                <svg class="h-5 w-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="px-2 py-3 text-slate-900">{{ $sk->year->tahun ?? '-' }}</div>
                                    <div class="min-w-0 px-2 py-3 font-medium text-slate-900">{{ $sk->nama_sub_kegiatan }}</div>
                                    <div class="px-2 py-3 text-slate-600">{{ $sk->kode_sub ?: '-' }}</div>
                                    <div class="px-2 py-3 text-right tabular-nums text-slate-700">{{ number_format($sk->anggaran ?? 0, 0, ',', '.') }}</div>
                                    <div class="flex items-center justify-end gap-1 px-2 py-3">
                                        <a href="{{ route('admin.sub-kegiatans.edit', $sk) }}" class="rounded p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900" title="Edit">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        <form action="{{ route('admin.sub-kegiatans.destroy', $sk) }}" method="POST" class="inline" onsubmit="return confirm('Hapus sub kegiatan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600" title="Hapus">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @if($sk->kodeRekenings->isNotEmpty())
                                    <div x-show="open" x-transition class="border-t border-slate-100 bg-slate-50/80 px-4 py-4" style="display: none;">
                                        <div class="rounded-lg border border-slate-200 bg-white p-4">
                                            <h4 class="mb-3 text-sm font-semibold text-slate-700">Kode Rekening & Anggaran</h4>
                                            <form method="POST" action="{{ route('admin.sub-kegiatans.anggaran-kode-rekening.update', $sk) }}" class="space-y-3">
                                                @csrf
                                                @method('PUT')
                                                @if(request('year_id'))<input type="hidden" name="year_id" value="{{ request('year_id') }}" />@endif
                                                <div class="overflow-x-auto">
                                                    <table class="min-w-full text-sm">
                                                        <thead>
                                                            <tr class="border-b border-slate-200">
                                                                <th class="py-2 text-left font-medium text-slate-600">Kode Rekening</th>
                                                                <th class="py-2 text-left font-medium text-slate-600">Nama Rekening</th>
                                                                <th class="py-2 text-right font-medium text-slate-600">Anggaran (Rp)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($sk->kodeRekenings as $kr)
                                                                <tr class="border-b border-slate-100">
                                                                    <td class="py-2 text-slate-800">{{ $kr->kode_rekening }}</td>
                                                                    <td class="py-2 text-slate-700">{{ $kr->nama_rekening }}</td>
                                                                    <td class="py-2 text-right">
                                                                        <input type="number" name="anggaran[{{ $kr->id }}]" value="{{ old('anggaran.'.$kr->id, $kr->pivot->anggaran ?? 0) }}" min="0" step="0.01" class="w-36 rounded border border-slate-300 px-2 py-1.5 text-right tabular-nums" />
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
                                                <div class="flex flex-wrap items-center gap-4 border-t border-slate-200 pt-3">
                                                    <span class="text-slate-600">Anggaran Sub Kegiatan: <strong class="tabular-nums">{{ number_format($anggaranSk, 0, ',', '.') }}</strong></span>
                                                    <span class="text-slate-600">Total Kode Rekening: <strong class="tabular-nums">{{ number_format($totalKodeRek, 0, ',', '.') }}</strong></span>
                                                    @if($selisih != 0)
                                                        <span class="rounded-md bg-amber-100 px-2 py-1 text-sm font-medium text-amber-800">Selisih:  {{ $selisih > 0 ? '+' : '' }}{{ number_format($selisih, 0, ',', '.') }}</span>
                                                    @else
                                                        <span class="rounded-md bg-emerald-100 px-2 py-1 text-sm font-medium text-emerald-800">Selisih: 0 (sesuai)</span>
                                                    @endif
                                                    <button type="submit" class="ml-auto rounded-lg bg-slate-700 px-3 py-1.5 text-sm font-medium text-white hover:bg-slate-600">Simpan Anggaran</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada sub kegiatan.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($subKegiatans->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">{{ $subKegiatans->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
@endsection
