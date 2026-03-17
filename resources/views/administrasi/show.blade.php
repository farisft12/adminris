@extends('layouts.app')

@section('title', 'Detail Administrasi')

@section('content')
<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('administrasi.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">&larr; Kembali</a>
    </div>
    <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="mb-6 text-xl font-semibold text-slate-800">Detail Administrasi #{{ $administrasi->no }}</h2>
        <dl class="grid gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-slate-500">Sub Kegiatan</dt>
                <dd class="mt-1 text-slate-900">{{ $administrasi->subKegiatan->nama_sub_kegiatan ?? '-' }} ({{ $administrasi->subKegiatan->year->tahun ?? '' }})</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">Uraian Belanja</dt>
                <dd class="mt-1 text-slate-900">{{ $administrasi->uraian_belanja }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">Tagihan</dt>
                <dd class="mt-1 text-slate-900">{{ number_format($administrasi->tagihan, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">Tanggal Nota</dt>
                <dd class="mt-1 text-slate-900">{{ $administrasi->tanggal_nota_persetujuan?->format('d/m/Y') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">Kode Rekening</dt>
                <dd class="mt-1 text-slate-900">{{ $administrasi->kodeRekening->kode_rekening ?? '-' }} - {{ $administrasi->kodeRekening->nama_rekening ?? '' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">Etalase</dt>
                <dd class="mt-1 text-slate-900">{{ $administrasi->etalase->nama_etalase ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">PPN / PPH 23 / PPH 21</dt>
                <dd class="mt-1 text-slate-900">{{ number_format($administrasi->ppn ?? 0, 0, ',', '.') }} / {{ number_format($administrasi->pph23 ?? 0, 0, ',', '.') }} / {{ number_format($administrasi->pph21 ?? 0, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">Total</dt>
                <dd class="mt-1 font-medium text-slate-900">{{ number_format($administrasi->total, 0, ',', '.') }}</dd>
            </div>
            @if($administrasi->keterangan)
            <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-slate-500">Keterangan</dt>
                <dd class="mt-1 text-slate-900">{{ $administrasi->keterangan }}</dd>
            </div>
            @endif
            <div>
                <dt class="text-sm font-medium text-slate-500">Penerima (di kwitansi)</dt>
                <dd class="mt-1 text-slate-900">{{ $administrasi->penerima ?: '-' }}</dd>
            </div>
        </dl>
        <div class="mt-6 flex gap-3">
            <a href="{{ route('administrasi.kwitansi', $administrasi) }}" target="_blank" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Print Kwitansi</a>
            <a href="{{ route('administrasi.nota-persetujuan', $administrasi) }}" target="_blank" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Print Nota Persetujuan</a>
            <a href="{{ route('administrasi.edit', $administrasi) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Edit</a>
        </div>
    </div>
</div>
@endsection
