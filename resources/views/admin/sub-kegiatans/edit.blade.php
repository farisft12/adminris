@extends('layouts.app')

@section('title', 'Edit Sub Kegiatan')

@section('content')
<div class="mx-auto max-w-lg px-4 py-6 sm:px-6 lg:px-8">
    <a href="{{ route('admin.sub-kegiatans.index') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; Sub Kegiatan</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900">Edit Sub Kegiatan</h1>
    <form method="POST" action="{{ route('admin.sub-kegiatans.update', $subKegiatan) }}" class="mt-6 rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label for="year_id" class="mb-1 block text-sm font-medium text-slate-700">Tahun</label>
                <select id="year_id" name="year_id" required class="block w-full rounded-lg border border-slate-300 px-3 py-2">
                    @foreach($years as $y)
                        <option value="{{ $y->id }}" {{ old('year_id', $subKegiatan->year_id) == $y->id ? 'selected' : '' }}>{{ $y->tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="nama_sub_kegiatan" class="mb-1 block text-sm font-medium text-slate-700">Nama Sub Kegiatan</label>
                <input id="nama_sub_kegiatan" type="text" name="nama_sub_kegiatan" value="{{ old('nama_sub_kegiatan', $subKegiatan->nama_sub_kegiatan) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('nama_sub_kegiatan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="kode_sub" class="mb-1 block text-sm font-medium text-slate-700">Kode Sub (opsional)</label>
                <input id="kode_sub" type="text" name="kode_sub" value="{{ old('kode_sub', $subKegiatan->kode_sub) }}" class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('kode_sub')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="anggaran" class="mb-1 block text-sm font-medium text-slate-700">Anggaran (Rp)</label>
                <input id="anggaran" type="number" name="anggaran" value="{{ old('anggaran', $subKegiatan->anggaran) }}" min="0" step="0.01" class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('anggaran')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <span class="mb-2 block text-sm font-medium text-slate-700">Kode Rekening untuk Sub Kegiatan ini</span>
                <p class="mb-3 text-xs text-slate-500">Centang kode rekening yang boleh dipakai staff di halaman "Masuk Ke Data" untuk sub kegiatan ini.</p>
                <div class="max-h-48 space-y-2 overflow-y-auto rounded-lg border border-slate-200 bg-slate-50/50 p-3">
                    @foreach($kodeRekenings as $kr)
                        <label class="flex cursor-pointer items-center gap-2">
                            <input type="checkbox" name="kode_rekening_ids[]" value="{{ $kr->id }}" {{ in_array($kr->id, old('kode_rekening_ids', $subKegiatan->kodeRekenings->pluck('id')->toArray())) ? 'checked' : '' }} class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" />
                            <span class="text-sm text-slate-800">{{ $kr->kode_rekening }} — {{ $kr->nama_rekening }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan</button>
            <a href="{{ route('admin.sub-kegiatans.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection
