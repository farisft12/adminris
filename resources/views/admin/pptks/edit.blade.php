@extends('layouts.app')

@section('title', 'Edit PPTK')

@section('content')
<div class="mx-auto max-w-lg px-4 py-6 sm:px-6 lg:px-8">
    <a href="{{ route('admin.pptks.index') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; PPTK</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900">Edit PPTK</h1>
    <form method="POST" action="{{ route('admin.pptks.update', $pptk) }}" class="mt-6 rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label for="nama_pptk" class="mb-1 block text-sm font-medium text-slate-700">Nama PPTK</label>
                <input id="nama_pptk" type="text" name="nama_pptk" value="{{ old('nama_pptk', $pptk->nama_pptk) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('nama_pptk')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="nip" class="mb-1 block text-sm font-medium text-slate-700">NIP (opsional)</label>
                <input id="nip" type="text" name="nip" value="{{ old('nip', $pptk->nip) }}" class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan</button>
            <a href="{{ route('admin.pptks.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection
