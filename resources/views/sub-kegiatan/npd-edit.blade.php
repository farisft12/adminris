@extends('layouts.app')

@section('title', 'Edit NPD ' . ($npd->nomor ?? $npd->id) . ' — ' . $subKegiatan->nama_sub_kegiatan)

@section('content')
<div class="relative min-h-[60vh]">
    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        <nav class="mb-6 flex items-center gap-2 text-sm text-slate-600">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-900">Dashboard</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('sub-kegiatan.show', $subKegiatan) }}" class="hover:text-slate-900">{{ $subKegiatan->nama_sub_kegiatan }}</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('sub-kegiatan.npd', $subKegiatan) }}" class="hover:text-slate-900">NPD</a>
            <span aria-hidden="true">/</span>
            <span class="font-medium text-slate-900">Edit {{ $npd->nomor ?? 'NPD #' . $npd->id }}</span>
        </nav>

        <h1 class="mb-1 text-2xl font-bold tracking-tight text-slate-900">Edit Nota Pencairan Dana (NPD)</h1>
        <p class="mb-1 text-slate-600">{{ $subKegiatan->nama_sub_kegiatan }}</p>
        <p class="mb-6 text-sm text-slate-500">Nomor: {{ $npd->nomor ?? 'NPD #' . $npd->id }} — Tanggal: {{ $npd->tanggal->format('d/m/Y') }}</p>

        @if($npdPerKodeRekening->isEmpty())
            <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center">
                <p class="text-slate-600">Tidak ada kode rekening.</p>
                <a href="{{ route('sub-kegiatan.npd.show', [$subKegiatan, $npd]) }}" class="mt-4 inline-block rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
            </div>
        @else
            <form action="{{ route('sub-kegiatan.npd.update', [$subKegiatan, $npd]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                @include('sub-kegiatan._npd-form-fields', ['tanggal' => old('tanggal', $npd->tanggal->format('Y-m-d'))])

                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="inline-flex items-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan Perubahan</button>
                    <a href="{{ route('sub-kegiatan.npd.print', [$subKegiatan, $npd]) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Print NPD</a>
                    <a href="{{ route('sub-kegiatan.npd.show', [$subKegiatan, $npd]) }}" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal / Lihat NPD</a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
