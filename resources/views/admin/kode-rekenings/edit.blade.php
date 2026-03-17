@extends('layouts.app')

@section('title', 'Edit Kode Rekening & Etalase')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
    <a href="{{ route('admin.kode-rekenings.index') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; Kode Rekening</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900">Edit Kode Rekening & Etalase</h1>

    <form method="POST" action="{{ route('admin.kode-rekenings.update', $kodeRekening) }}" class="mt-6 rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        @method('PUT')
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="kode_rekening" class="mb-1 block text-sm font-medium text-slate-700">Kode Rekening</label>
                <input id="kode_rekening" type="text" name="kode_rekening" value="{{ old('kode_rekening', $kodeRekening->kode_rekening) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('kode_rekening')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="nama_rekening" class="mb-1 block text-sm font-medium text-slate-700">Nama Rekening</label>
                <input id="nama_rekening" type="text" name="nama_rekening" value="{{ old('nama_rekening', $kodeRekening->nama_rekening) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('nama_rekening')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="mt-4 flex gap-3">
            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan Kode Rekening</button>
            <a href="{{ route('admin.kode-rekenings.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
        </div>
    </form>

    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6">
        <h2 class="mb-4 font-semibold text-slate-900">Tambah Etalase</h2>
        <form method="POST" action="{{ route('admin.etalases.store', $kodeRekening) }}" class="mb-4 flex gap-2">
            @csrf
            <input type="text" name="nama_etalase" required placeholder="Nama etalase" class="block flex-1 rounded-lg border border-slate-300 px-3 py-2" />
            <div class="flex gap-2">
                <button type="submit" class="rounded-lg bg-slate-700 px-4 py-2 text-sm font-medium text-white hover:bg-slate-600">Simpan</button>
                <a href="{{ route('admin.kode-rekenings.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Simpan Semua</a>
            </div>
        </form>
        <p class="mb-4 text-sm text-slate-500">Simpan = simpan etalase ini dan tetap di halaman. Simpan Semua = selesai dan kembali ke daftar kode rekening.</p>
        <h3 class="mb-2 text-sm font-medium text-slate-700">Etalase yang sudah ditambah</h3>
        <ul class="divide-y divide-slate-200">
            @forelse($kodeRekening->etalases as $e)
                <li class="flex items-center justify-between py-3">
                    <span class="text-slate-900">{{ $e->nama_etalase }}</span>
                    <form action="{{ route('admin.etalases.destroy', $e) }}" method="POST" class="inline" onsubmit="return confirm('Hapus etalase ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">Hapus</button>
                    </form>
                </li>
            @empty
                <li class="py-4 text-center text-sm text-slate-500">Belum ada etalase. Tambah di atas.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
