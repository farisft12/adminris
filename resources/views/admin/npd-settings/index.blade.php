@extends('layouts.app')

@section('title', 'Pengaturan NPD')

@section('content')
<div class="relative min-h-screen bg-slate-50/50 pb-12 font-sans">
    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8">
            <nav class="mb-3 flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-500 transition-colors">Admin</a>
                <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                <span class="text-indigo-500">Pengaturan NPD</span>
            </nav>
            <div class="flex items-center gap-4">
                <div class="bg-white text-blue-600 p-3.5 rounded-2xl shadow-sm border border-slate-100">
                    <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan NPD</h1>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Dipakai saat mencetak NPD, SPTJB, dan Nota Dinas.</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-emerald-50 p-4 border border-emerald-100 text-sm font-bold text-emerald-700">
                <i class="fa-solid fa-check mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 rounded-2xl bg-rose-50 p-4 border border-rose-100 text-sm font-medium text-rose-700">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        {{-- Teks per tahun --}}
        <section class="mb-10 rounded-3xl border border-slate-100 bg-white p-8 shadow-sm">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-black text-slate-900">Teks per Tahun Anggaran</h2>
                    <p class="text-sm text-slate-500">Kosongkan isian untuk memakai teks bawaan.</p>
                </div>
                <form method="GET" action="{{ route('admin.npd-settings.index') }}">
                    <select name="tahun" onchange="this.form.submit()" class="rounded-xl border-slate-200 text-sm font-bold">
                        @foreach($years as $y)
                            <option value="{{ $y }}" @selected($y == $tahun)>Tahun {{ $y }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <form method="POST" action="{{ route('admin.npd-settings.texts.update') }}" class="space-y-5">
                @csrf @method('PUT')
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                @foreach($fields as $field => $label)
                    <div>
                        <label for="{{ $field }}" class="mb-1 block text-xs font-black uppercase tracking-widest text-slate-500">{{ $label }}</label>
                        @if($field === 'nomor_dpa')
                            <input id="{{ $field }}" type="text" name="{{ $field }}" value="{{ old($field, $texts[$field]) }}"
                                class="block w-full rounded-xl border-slate-200 px-4 py-3 font-mono text-sm">
                        @else
                            <textarea id="{{ $field }}" name="{{ $field }}" rows="{{ str_starts_with($field, 'sptjb') ? 5 : 3 }}"
                                class="block w-full rounded-xl border-slate-200 px-4 py-3 text-sm leading-relaxed">{{ old($field, $texts[$field]) }}</textarea>
                        @endif
                    </div>
                @endforeach
                <button type="submit" class="rounded-xl bg-slate-900 px-8 py-3 text-sm font-black uppercase tracking-widest text-white hover:bg-emerald-600">
                    Simpan Teks {{ $tahun }}
                </button>
            </form>
        </section>

        {{-- Kegiatan --}}
        <section class="rounded-3xl border border-slate-100 bg-white p-8 shadow-sm">
            <h2 class="text-xl font-black text-slate-900">Kode Kegiatan</h2>
            <p class="mb-6 text-sm text-slate-500">Nama Program & Kegiatan pada NPD dan Nota Dinas diambil dari sini berdasarkan kode sub kegiatan (mis. 4.01.01.2.06.0009 → 4.01.01.2.06).</p>

            <div class="space-y-3">
                @foreach($kegiatans as $kegiatan)
                    <form method="POST" action="{{ route('admin.npd-settings.kegiatans.update', $kegiatan) }}" class="grid gap-3 rounded-2xl border border-slate-100 p-4 sm:grid-cols-[9rem_1fr_1fr_auto] sm:items-center">
                        @csrf @method('PUT')
                        <span class="font-mono text-sm font-bold text-slate-700">{{ $kegiatan->kode }}</span>
                        <input type="text" name="nama" value="{{ $kegiatan->nama }}" required class="rounded-xl border-slate-200 px-3 py-2 text-sm" aria-label="Nama kegiatan {{ $kegiatan->kode }}">
                        <input type="text" name="program" value="{{ $kegiatan->program }}" required class="rounded-xl border-slate-200 px-3 py-2 text-sm" aria-label="Program {{ $kegiatan->kode }}">
                        <button type="submit" class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-black uppercase tracking-widest text-slate-600 hover:bg-slate-900 hover:text-white">Simpan</button>
                    </form>
                @endforeach
            </div>

            <form method="POST" action="{{ route('admin.npd-settings.kegiatans.store') }}" class="mt-6 grid gap-3 rounded-2xl border border-dashed border-slate-300 p-4 sm:grid-cols-[9rem_1fr_1fr_auto] sm:items-center">
                @csrf
                <input type="text" name="kode" value="{{ old('kode') }}" placeholder="4.01.01.2.xx" required class="rounded-xl border-slate-200 px-3 py-2 font-mono text-sm" aria-label="Kode kegiatan baru">
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama kegiatan" required class="rounded-xl border-slate-200 px-3 py-2 text-sm" aria-label="Nama kegiatan baru">
                <input type="text" name="program" value="{{ old('program', 'Program Penunjang Urusan Pemerintahan Daerah Kabupaten/Kota') }}" required class="rounded-xl border-slate-200 px-3 py-2 text-sm" aria-label="Program kegiatan baru">
                <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2 text-xs font-black uppercase tracking-widest text-white hover:bg-indigo-700">Tambah</button>
            </form>
        </section>
    </div>
</div>
@endsection
