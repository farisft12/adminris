@extends('layouts.app')

@section('title', 'Tambah Kode Rekening')

@section('content')
<div class="mx-auto max-w-lg px-4 py-6 sm:px-6 lg:px-8">
    <a href="{{ route('admin.kode-rekenings.index') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; Kode Rekening</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900">Tambah Kode Rekening</h1>
    <form method="POST" action="{{ route('admin.kode-rekenings.store') }}" class="mt-6 rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="kode_rekening" class="mb-1 block text-sm font-medium text-slate-700">Kode Rekening</label>
                <input id="kode_rekening" type="text" name="kode_rekening" value="{{ old('kode_rekening') }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('kode_rekening')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="nama_rekening" class="mb-1 block text-sm font-medium text-slate-700">Nama Rekening</label>
                <input id="nama_rekening" type="text" name="nama_rekening" value="{{ old('nama_rekening') }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('nama_rekening')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan</button>
            <a href="{{ route('admin.kode-rekenings.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection
