@extends('layouts.app')

@section('title', 'Admin - Perpajakan')

@section('content')
<div class="mx-auto max-w-lg px-4 py-6 sm:px-6 lg:px-8">
    <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; Admin</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900">Perpajakan</h1>
    <p class="mt-1 text-sm text-slate-500">Pengaturan tarif PPN, PPH 23, dan PPH 21 (nilai 0–1, contoh: 0.11 = 11%).</p>

    <form method="POST" action="{{ route('admin.perpajakan.update') }}" class="mt-6 rounded-xl border border-slate-200 bg-white p-6">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label for="ppn_rate" class="mb-1 block text-sm font-medium text-slate-700">Tarif PPN (contoh: 0.11 = 11%)</label>
                <input id="ppn_rate" type="number" name="ppn_rate" step="0.0001" min="0" max="1" value="{{ old('ppn_rate', $perpajakan->ppn_rate) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('ppn_rate')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="pph23_rate" class="mb-1 block text-sm font-medium text-slate-700">Tarif PPH 23 (contoh: 0.02 = 2%)</label>
                <input id="pph23_rate" type="number" name="pph23_rate" step="0.0001" min="0" max="1" value="{{ old('pph23_rate', $perpajakan->pph23_rate) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('pph23_rate')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="pph21_rate" class="mb-1 block text-sm font-medium text-slate-700">Tarif PPH 21 (contoh: 0.05 = 5%)</label>
                <input id="pph21_rate" type="number" name="pph21_rate" step="0.0001" min="0" max="1" value="{{ old('pph21_rate', $perpajakan->pph21_rate) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2" />
                @error('pph21_rate')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan</button>
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
        </div>
    </form>
</div>
@endsection
