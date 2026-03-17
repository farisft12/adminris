@extends('layouts.app')

@section('title', 'Admin - Data PPTK')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; Admin</a>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">Data PPTK</h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.pptk.assign') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Penugasan Sub Kegiatan</a>
            <a href="{{ route('admin.pptks.create') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Tambah PPTK</a>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">Nama PPTK</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">NIP</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">Sub Kegiatan</th>
                    <th class="px-4 py-3 text-right text-xs font-medium uppercase text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($pptks as $pptk)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $pptk->nama_pptk }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $pptk->nip ?: '-' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $pptk->sub_kegiatans_count }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.pptks.edit', $pptk) }}" class="text-slate-600 hover:text-slate-900">Edit</a>
                            <form action="{{ route('admin.pptks.destroy', $pptk) }}" method="POST" class="ml-2 inline" onsubmit="return confirm('Hapus PPTK ini? Penugasan sub kegiatan akan dikosongkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">Belum ada PPTK.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($pptks->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">{{ $pptks->links() }}</div>
        @endif
    </div>
</div>
@endsection
