@extends('layouts.app')

@section('title', 'Admin - Kode Rekening & Etalase')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; Admin</a>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">Kode Rekening & Etalase</h1>
        </div>
        <a href="{{ route('admin.kode-rekenings.create') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Tambah Kode Rekening</a>
    </div>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">Kode</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">Nama Rekening</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">Jumlah Etalase</th>
                    <th class="px-4 py-3 text-right text-xs font-medium uppercase text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($kodeRekenings as $kr)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $kr->kode_rekening }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $kr->nama_rekening }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $kr->etalases_count }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.kode-rekenings.edit', $kr) }}" class="text-slate-600 hover:text-slate-900">Kelola / Edit</a>
                            <form action="{{ route('admin.kode-rekenings.destroy', $kr) }}" method="POST" class="ml-2 inline" onsubmit="return confirm('Hapus kode rekening dan semua etalasenya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">Belum ada kode rekening.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($kodeRekenings->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">{{ $kodeRekenings->links() }}</div>
        @endif
    </div>
</div>
@endsection
