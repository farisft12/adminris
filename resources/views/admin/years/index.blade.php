@extends('layouts.app')

@section('title', 'Admin - Tahun')

@section('content')
<div class="mx-auto max-w-4xl px-4 py-6 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; Admin</a>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">Tahun</h1>
        </div>
        <a href="{{ route('admin.years.create') }}" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Tambah Tahun</a>
    </div>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">Tahun</th>
                    <th class="px-4 py-3 text-right text-xs font-medium uppercase text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($years as $y)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $y->tahun }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.years.edit', $y) }}" class="text-slate-600 hover:text-slate-900">Edit</a>
                            <form action="{{ route('admin.years.destroy', $y) }}" method="POST" class="ml-2 inline" onsubmit="return confirm('Hapus tahun ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="px-4 py-8 text-center text-slate-500">Belum ada tahun.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($years->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">{{ $years->links() }}</div>
        @endif
    </div>
</div>
@endsection
