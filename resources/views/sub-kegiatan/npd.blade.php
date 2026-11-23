@extends('layouts.app')

@section('title', 'NPD — ' . $subKegiatan->nama_sub_kegiatan)

@section('content')
<div class="relative min-h-[60vh]">
    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        <nav class="mb-6 flex items-center gap-2 text-sm text-slate-600">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-900">Dashboard</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('sub-kegiatan.show', $subKegiatan) }}" class="hover:text-slate-900">{{ $subKegiatan->nama_sub_kegiatan }}</a>
            <span aria-hidden="true">/</span>
            <span class="font-medium text-slate-900">NPD</span>
        </nav>

        <h1 class="mb-1 text-2xl font-bold tracking-tight text-slate-900">Nota Pencairan Dana (NPD) — Baru</h1>
        <p class="mb-1 text-slate-600">{{ $subKegiatan->nama_sub_kegiatan }}</p>
        <p class="mb-6 text-sm text-slate-500">Tahun {{ $subKegiatan->year?->tahun ?? date('Y') }}</p>

        @if($npds->isNotEmpty())
            <div class="mb-6">
                <h2 class="mb-2 text-sm font-semibold text-slate-700">NPD terdahulu</h2>
                <ul class="flex flex-wrap gap-2">
                    @foreach($npds as $n)
                        <li class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white shadow-sm">
                            <a href="{{ route('sub-kegiatan.npd.show', [$subKegiatan, $n]) }}" class="rounded-l-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                {{ $n->nomor ?? 'NPD #' . $n->id }} — {{ $n->tanggal->format('d/m/Y') }}
                            </a>
                            <a href="{{ route('sub-kegiatan.npd.edit', [$subKegiatan, $n]) }}" class="rounded-r-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700" title="Edit NPD">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($npdPerKodeRekening->isEmpty())
            <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center">
                <p class="text-slate-600">Belum ada kode rekening untuk sub kegiatan ini.</p>
                <a href="{{ route('sub-kegiatan.show', $subKegiatan) }}" class="mt-4 inline-block rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
            </div>
        @else
            <form action="{{ route('sub-kegiatan.npd.store', $subKegiatan) }}" method="POST" class="space-y-6">
                @csrf
                @include('sub-kegiatan._npd-form-fields', ['tanggal' => old('tanggal', date('Y-m-d'))])

                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="inline-flex items-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700" @disabled($administrasis->isEmpty())>Simpan NPD</button>
                    <a href="{{ route('sub-kegiatan.show', $subKegiatan) }}" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali ke Sub Kegiatan</a>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
