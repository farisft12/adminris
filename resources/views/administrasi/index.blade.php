@extends('layouts.app')

@section('title', 'Data Administrasi')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    @if(isset($selectedSubKegiatan) && $selectedSubKegiatan && request('kode_rekening_id'))
        <nav class="mb-4 flex items-center gap-2 text-sm text-slate-600">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-900">Dashboard</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('sub-kegiatan.show', $selectedSubKegiatan) }}" class="hover:text-slate-900">{{ $selectedSubKegiatan->nama_sub_kegiatan }}</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('sub-kegiatan.kode-rekenings.index', $selectedSubKegiatan) }}" class="hover:text-slate-900">Kode Rekening</a>
            <span aria-hidden="true">/</span>
            <span class="font-medium text-slate-900">Data Administrasi</span>
        </nav>
    @endif
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Data Administrasi</h1>
            @if(isset($selectedSubKegiatan) && $selectedSubKegiatan)
                <p class="mt-1 text-sm text-slate-600">Khusus sub kegiatan: <span class="font-medium text-slate-800">{{ $selectedSubKegiatan->nama_sub_kegiatan }}</span></p>
            @endif
        </div>
        <a href="{{ route('administrasi.create', request()->only('sub_kegiatan_id', 'year_id', 'kode_rekening_id')) }}" class="inline-flex justify-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700 transition">Tambah Data</a>
    </div>

    <form method="GET" action="{{ route('administrasi.index') }}" class="mb-6 flex flex-wrap items-end gap-4 rounded-lg border border-slate-200 bg-white p-4">
        <div>
            <label for="year_id" class="mb-1 block text-sm font-medium text-slate-700">Tahun</label>
            <select id="year_id" name="year_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                <option value="">-- Semua Tahun --</option>
                @foreach($years as $y)
                    <option value="{{ $y->id }}" {{ request('year_id') == $y->id ? 'selected' : '' }}>{{ $y->tahun }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="sub_kegiatan_id" class="mb-1 block text-sm font-medium text-slate-700">Sub Kegiatan</label>
            <select id="sub_kegiatan_id" name="sub_kegiatan_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm min-w-[200px]">
                <option value="">-- Semua Sub Kegiatan --</option>
                @foreach($subKegiatans as $sk)
                    <option value="{{ $sk->id }}" {{ request('sub_kegiatan_id') == $sk->id ? 'selected' : '' }}>{{ $sk->nama_sub_kegiatan }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="kode_rekening_id" class="mb-1 block text-sm font-medium text-slate-700">Kode Rekening</label>
            <select id="kode_rekening_id" name="kode_rekening_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm min-w-[220px]">
                <option value="">-- Semua Kode Rekening --</option>
                @foreach($kodeRekenings as $kr)
                    <option value="{{ $kr->id }}" {{ request('kode_rekening_id') == $kr->id ? 'selected' : '' }}>{{ $kr->kode_rekening }} - {{ $kr->nama_rekening }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="rounded-lg bg-slate-700 px-4 py-2 text-sm font-medium text-white hover:bg-slate-600">Filter</button>
    </form>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-600">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-600">Uraian Belanja</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-600">Tanggal Nota Setuju</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-600">Kode Rekening</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-600">Etalase</th>
                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-600">PPN</th>
                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-600">PPH 23</th>
                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-600">PPH 21</th>
                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-600">Tagihan</th>
                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-600">Total</th>
                        <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($administrasis as $a)
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-900">{{ $a->no }}</td>
                            <td class="px-4 py-3 text-sm text-slate-900 max-w-xs truncate" title="{{ $a->uraian_belanja }}">{{ $a->uraian_belanja }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-900">{{ $a->tanggal_nota_persetujuan?->format('d/m/Y') ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-900">{{ $a->kodeRekening ? $a->kodeRekening->kode_rekening . ' - ' . $a->kodeRekening->nama_rekening : '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-900">{{ $a->etalase?->nama_etalase ?? '-' }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900">{{ number_format($a->ppn ?? 0, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900">{{ number_format($a->pph23 ?? 0, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900">{{ number_format($a->pph21 ?? 0, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900">{{ number_format($a->tagihan, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right text-sm font-medium text-slate-900 tabular-nums">{{ number_format($a->total_bersih, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('administrasi.edit', $a) }}" class="rounded p-1.5 text-slate-600 hover:bg-slate-100 hover:text-slate-900" title="Edit">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    @can('delete', $a)
                                        <form action="{{ route('administrasi.destroy', $a) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded p-1.5 text-slate-600 hover:bg-red-50 hover:text-red-600" title="Hapus">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endcan
                                    <a href="{{ route('administrasi.kwitansi', $a) }}" target="_blank" class="rounded p-1.5 text-slate-600 hover:bg-slate-100 hover:text-slate-900" title="Print Kwitansi">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    </a>
                                    <a href="{{ route('administrasi.nota-persetujuan', $a) }}" target="_blank" class="rounded p-1.5 text-slate-600 hover:bg-slate-100 hover:text-slate-900" title="Print Nota Persetujuan">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($administrasis->isNotEmpty())
                <tfoot class="bg-slate-100 font-medium">
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-sm text-slate-700">Rekap Total (filter)</td>
                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900">{{ number_format($rekap['ppn'], 0, ',', '.') }}</td>
                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900">{{ number_format($rekap['pph23'], 0, ',', '.') }}</td>
                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900">{{ number_format($rekap['pph21'], 0, ',', '.') }}</td>
                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900">{{ number_format($rekap['tagihan'], 0, ',', '.') }}</td>
                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900 font-medium tabular-nums">{{ number_format($rekap['total_bersih'], 0, ',', '.') }}</td>
                        <td class="whitespace-nowrap px-4 py-3"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        @if($administrasis->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">
                {{ $administrasis->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
