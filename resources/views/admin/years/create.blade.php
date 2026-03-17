@extends('layouts.app')

@section('title', 'Tambah Tahun')

@section('content')
<div class="mx-auto max-w-md px-4 py-6 sm:px-6 lg:px-8">
    <a href="{{ route('admin.years.index') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; Tahun</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900">Tambah Tahun</h1>
    <form method="POST" action="{{ route('admin.years.store') }}" class="mt-6 rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        <div>
            <label for="tahun" class="mb-1 block text-sm font-medium text-slate-700">Tahun</label>
            <input id="tahun" type="number" name="tahun" min="2000" max="2100" value="{{ old('tahun') }}" required
                class="block w-full rounded-lg border border-slate-300 px-3 py-2" placeholder="2026" />
            @error('tahun')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="mt-4 flex gap-3">
            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan</button>
            <a href="{{ route('admin.years.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection
