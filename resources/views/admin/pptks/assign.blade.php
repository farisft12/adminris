@extends('layouts.app')

@section('title', 'Admin - Penugasan PPTK')

@section('content')
<div class="mx-auto max-w-4xl px-4 py-6 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-600 hover:text-slate-900">&larr; Admin</a>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">PPTK — Sub Kegiatan mana saja, siapa PPTK-nya</h1>
            <p class="mt-1 text-sm text-slate-500">Pilih PPTK untuk setiap sub kegiatan.</p>
        </div>
        <a href="{{ route('admin.pptks.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Data PPTK</a>
    </div>

    <form method="POST" action="{{ route('admin.pptk.assign.store') }}" class="rounded-xl border border-slate-200 bg-white">
        @csrf
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">Tahun</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">Sub Kegiatan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-600">PPTK</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($subKegiatans as $sk)
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-3 text-slate-700">{{ $sk->year->tahun ?? '-' }}</td>
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $sk->nama_sub_kegiatan }}</td>
                            <td class="px-4 py-3">
                                <input type="hidden" name="assignments[{{ $loop->index }}][sub_kegiatan_id]" value="{{ $sk->id }}" />
                                <select name="assignments[{{ $loop->index }}][pptk_id]" class="block w-full min-w-[200px] rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                    <option value="">-- Tidak ada --</option>
                                    @foreach($pptks as $pptk)
                                        <option value="{{ $pptk->id }}" {{ (int) old('assignments.'.$loop->index.'.pptk_id', $sk->pptk_id) === (int) $pptk->id ? 'selected' : '' }}>{{ $pptk->nama_pptk }}{{ $pptk->nip ? ' ('.$pptk->nip.')' : '' }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($subKegiatans->isEmpty())
            <p class="px-4 py-8 text-center text-slate-500">Belum ada sub kegiatan. Tambah dulu di Admin → Sub Kegiatan.</p>
        @else
            <div class="border-t border-slate-200 px-4 py-4">
                <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan Penugasan</button>
            </div>
        @endif
    </form>
</div>
@endsection
