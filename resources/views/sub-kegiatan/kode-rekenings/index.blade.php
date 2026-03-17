@extends('layouts.app')

@section('title', 'Kode Rekening — ' . $subKegiatan->nama_sub_kegiatan)

@section('content')
<div class="relative min-h-[60vh]">
    <div class="pointer-events-none absolute inset-0 -top-8 -z-10 overflow-hidden">
        <div class="absolute -left-40 -top-40 h-80 w-80 rounded-full bg-indigo-100/40 blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 h-80 w-80 rounded-full bg-slate-200/30 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        <nav class="mb-6 flex flex-wrap items-center gap-2 text-sm text-slate-600">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-900">Dashboard</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('sub-kegiatan.show', $subKegiatan) }}" class="hover:text-slate-900">{{ $subKegiatan->nama_sub_kegiatan }}</a>
            <span aria-hidden="true">/</span>
            <span class="font-medium text-slate-900">Kode Rekening</span>
        </nav>

        <h1 class="mb-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Kode Rekening</h1>
        <p class="mb-10 text-slate-600">{{ $subKegiatan->nama_sub_kegiatan }}</p>

        @if($kodeRekenings->isEmpty())
            <div class="rounded-2xl border border-slate-200/80 bg-white/80 px-8 py-14 text-center backdrop-blur-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <p class="mt-5 text-base font-medium text-slate-600">Belum ada kode rekening untuk sub kegiatan ini.</p>
                <p class="mt-1 text-sm text-slate-500">Hubungi administrator untuk mengatur kode rekening di halaman admin.</p>
                <a href="{{ route('sub-kegiatan.show', $subKegiatan) }}" class="mt-6 inline-block rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
            </div>
        @else
            <ul class="flex flex-col gap-4" role="list">
                @foreach($kodeRekenings as $kr)
                    <li>
                        <a href="{{ route('administrasi.index', ['sub_kegiatan_id' => $subKegiatan->id, 'year_id' => $subKegiatan->year_id, 'kode_rekening_id' => $kr->id]) }}"
                            class="group flex min-h-[72px] w-full items-center gap-4 rounded-xl border border-slate-200/80 bg-white/80 px-6 py-4 shadow-sm backdrop-blur-sm transition-all duration-300 hover:border-indigo-200 hover:bg-white hover:shadow-md hover:shadow-indigo-500/10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:min-h-[80px] sm:px-8 sm:py-5">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-50 to-slate-100 text-indigo-600 transition-all duration-300 group-hover:from-indigo-600 group-hover:to-indigo-700 group-hover:text-white sm:h-12 sm:w-12">
                                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </span>
                            <div class="min-w-0 flex-1">
                                <span class="block font-semibold text-slate-900 transition-colors group-hover:text-indigo-700">{{ $kr->kode_rekening }}</span>
                                <span class="mt-0.5 block text-sm text-slate-500">{{ $kr->nama_rekening }}</span>
                                <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-600">
                                    <span><strong>Anggaran:</strong> Rp {{ number_format($kr->anggaran ?? 0, 0, ',', '.') }} &nbsp;&nbsp;</span>
                                    <span><strong>Total input:</strong> Rp {{ number_format($kr->total_input ?? 0, 0, ',', '.') }} &nbsp;&nbsp;</span>
                                    <span><strong>Selisih:</strong> <span class="{{ ($kr->selisih ?? 0) >= 0 ? 'text-emerald-600' : 'text-red-600' }}">Rp {{ number_format($kr->selisih ?? 0, 0, ',', '.') }} &nbsp;&nbsp;</span></span>
                                </div>
                            </div>
                            <span class="shrink-0 text-slate-400 transition-all duration-300 group-hover:translate-x-0.5 group-hover:text-indigo-500">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
