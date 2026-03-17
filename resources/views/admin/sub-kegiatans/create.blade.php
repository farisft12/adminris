@extends('layouts.app')

@section('title', 'Tambah Sub Kegiatan')

@section('content')
<div class="mx-auto max-w-lg px-4 py-6 sm:px-6 lg:px-8">
    <a href="{{ route('admin.sub-kegiatans.index') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; Sub Kegiatan</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900">Tambah Sub Kegiatan</h1>
    <form method="POST" action="{{ route('admin.sub-kegiatans.store') }}" class="mt-6 rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="year_id" class="mb-1 block text-sm font-medium text-slate-700">Tahun</label>
                <select id="year_id" name="year_id" required class="block w-full rounded-lg border border-slate-300 px-3 py-2">
                    <option value="">-- Pilih Tahun --</option>
                    @foreach($years as $y)
                        <option value="{{ $y->id }}" {{ old('year_id') == $y->id ? 'selected' : '' }}>{{ $y->tahun }}</option>
                    @endforeach
                </select>
                @error('year_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="nama_sub_kegiatan" class="mb-1 block text-sm font-medium text-slate-700">Nama Sub Kegiatan</label>
                <input id="nama_sub_kegiatan" type="text" name="nama_sub_kegiatan" value="{{ old('nama_sub_kegiatan') }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('nama_sub_kegiatan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="kode_sub" class="mb-1 block text-sm font-medium text-slate-700">Kode Sub (opsional)</label>
                <input id="kode_sub" type="text" name="kode_sub" value="{{ old('kode_sub') }}" class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('kode_sub')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="anggaran" class="mb-1 block text-sm font-medium text-slate-700">Anggaran (Rp)</label>
                <input id="anggaran" type="number" name="anggaran" value="{{ old('anggaran', 0) }}" min="0" step="0.01" class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('anggaran')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan</button>
            <a href="{{ route('admin.sub-kegiatans.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection
