@extends('layouts.app')

@section('title', 'NPD ' . ($npd->nomor ?? $npd->id) . ' — ' . $subKegiatan->nama_sub_kegiatan)

@push('styles')
<style>
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area { position: absolute; left: 0; top: 0; width: 100%; }
        nav, .no-print { display: none !important; }
    }
</style>
@endpush

@section('content')
<div class="relative min-h-[60vh]">
    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        <nav class="no-print mb-6 flex items-center gap-2 text-sm text-slate-600">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-900">Dashboard</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('sub-kegiatan.show', $subKegiatan) }}" class="hover:text-slate-900">{{ $subKegiatan->nama_sub_kegiatan }}</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('sub-kegiatan.npd', $subKegiatan) }}" class="hover:text-slate-900">NPD</a>
            <span aria-hidden="true">/</span>
            <span class="font-medium text-slate-900">{{ $npd->nomor ?? 'NPD #' . $npd->id }}</span>
        </nav>

        <div class="print-area">
            <h1 class="mb-1 text-2xl font-bold tracking-tight text-slate-900">Nota Pencairan Dana (NPD)</h1>
            <p class="mb-1 text-slate-600">{{ $subKegiatan->nama_sub_kegiatan }}</p>
            <p class="mb-1 text-sm text-slate-500">Nomor: {{ $npd->nomor ?? 'NPD #' . $npd->id }} — Tanggal: {{ $npd->tanggal->format('d/m/Y') }}</p>
            <p class="mb-6 text-sm text-slate-500">Tahun {{ $subKegiatan->year?->tahun ?? date('Y') }}</p>

            @if($npdPerKodeRekening->isEmpty())
                <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center">
                    <p class="text-slate-600">Tidak ada detail kode rekening.</p>
                </div>
            @else
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Kode Rekening</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Nama Rekening</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">Anggaran</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">Akumulasi</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">Pencairan Saat Ini</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">Sisa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($npdPerKodeRekening as $row)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-900">{{ $row['kode_rekening'] }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $row['nama_rekening'] }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900">Rp {{ number_format($row['anggaran'], 0, ',', '.') }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900">Rp {{ number_format($row['akumulasi'], 0, ',', '.') }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900">Rp {{ number_format($row['pencairan_saat_ini'], 0, ',', '.') }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-right text-sm {{ $row['sisa'] >= 0 ? 'text-slate-900' : 'text-red-600' }}">Rp {{ number_format($row['sisa'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="no-print mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('sub-kegiatan.npd.edit', [$subKegiatan, $npd]) }}" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit NPD
                    </a>
                    <a href="{{ route('sub-kegiatan.npd.print', [$subKegiatan, $npd]) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Print NPD
                    </a>
                    <a href="{{ route('sub-kegiatan.npd', $subKegiatan) }}" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Buat NPD Baru</a>
                    <a href="{{ route('sub-kegiatan.show', $subKegiatan) }}" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali ke Sub Kegiatan</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
