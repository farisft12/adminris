@extends('layouts.app')

@section('title', 'Edit NPD ' . ($npd->nomor ?? $npd->id) . ' — ' . $subKegiatan->nama_sub_kegiatan)

@push('styles')
<style>
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area { position: absolute; left: 0; top: 0; width: 100%; }
        nav, .no-print { display: none !important; }
    }
</style>
@endpush

@section('content')
<div class="relative min-h-[60vh]">
    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
        <nav class="no-print mb-6 flex items-center gap-2 text-sm text-slate-600">
            <a href="{{ route('dashboard') }}" class="hover:text-slate-900">Dashboard</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('sub-kegiatan.show', $subKegiatan) }}" class="hover:text-slate-900">{{ $subKegiatan->nama_sub_kegiatan }}</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('sub-kegiatan.npd', $subKegiatan) }}" class="hover:text-slate-900">NPD</a>
            <span aria-hidden="true">/</span>
            <span class="font-medium text-slate-900">Edit {{ $npd->nomor ?? 'NPD #' . $npd->id }}</span>
        </nav>

        <div class="print-area">
            <h1 class="mb-1 text-2xl font-bold tracking-tight text-slate-900">Edit Nota Pencairan Dana (NPD)</h1>
            <p class="mb-1 text-slate-600">{{ $subKegiatan->nama_sub_kegiatan }}</p>
            <p class="mb-6 text-sm text-slate-500">Nomor: {{ $npd->nomor ?? 'NPD #' . $npd->id }} — Tanggal: {{ $npd->tanggal->format('d/m/Y') }}</p>

            @if($npdPerKodeRekening->isEmpty())
                <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center">
                    <p class="text-slate-600">Tidak ada kode rekening.</p>
                    <a href="{{ route('sub-kegiatan.npd.show', [$subKegiatan, $npd]) }}" class="no-print mt-4 inline-block rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
                </div>
            @else
                <form action="{{ route('sub-kegiatan.npd.update', [$subKegiatan, $npd]) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="no-print">
                        <label for="tanggal" class="block text-sm font-medium text-slate-700">Tanggal NPD</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $npd->tanggal->format('Y-m-d')) }}" class="mt-1 rounded-lg border border-slate-300 px-3 py-2 text-sm">
                        @error('tanggal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Kode Rekening</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Nama Rekening</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">Anggaran</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">Akumulasi</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">Pencairan Saat Ini</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">Sisa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach($npdPerKodeRekening as $row)
                                    <tr class="npd-row" data-anggaran="{{ $row['anggaran'] }}" data-akumulasi="{{ $row['akumulasi'] }}" data-max-pencairan="{{ $row['max_pencairan'] }}" data-kr-id="{{ $row['kode_rekening_id'] }}">
                                        <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-900">{{ $row['kode_rekening'] }}</td>
                                        <td class="px-4 py-3 text-sm text-slate-600">{{ $row['nama_rekening'] }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900 npd-anggaran">Rp {{ number_format($row['anggaran'], 0, ',', '.') }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm text-slate-900 npd-akumulasi">Rp {{ number_format($row['akumulasi'], 0, ',', '.') }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right">
                                            <input type="number" name="pencairan[{{ $row['kode_rekening_id'] }}]" value="{{ old('pencairan.'.$row['kode_rekening_id'], $row['pencairan_saat_ini']) }}" min="0" max="{{ $row['max_pencairan'] }}" step="0.01" class="npd-pencairan w-28 rounded border border-slate-300 px-2 py-1.5 text-right text-sm {{ $errors->has('pencairan.'.$row['kode_rekening_id']) ? 'border-red-500' : '' }}" title="Maks. Rp {{ number_format($row['max_pencairan'], 0, ',', '.') }} (total realisasi administrasi)">
                                            @error('pencairan.'.$row['kode_rekening_id'])
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right text-sm npd-sisa" data-sisa="{{ $row['sisa'] }}">Rp {{ number_format($row['sisa'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="no-print flex flex-wrap gap-3">
                        <button type="submit" class="inline-flex items-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">Simpan Perubahan</button>
                        <a href="{{ route('sub-kegiatan.npd.print', [$subKegiatan, $npd]) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Print NPD
                        </a>
                        <a href="{{ route('sub-kegiatan.npd.show', [$subKegiatan, $npd]) }}" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal / Lihat NPD</a>
                        <a href="{{ route('sub-kegiatan.npd', $subKegiatan) }}" class="inline-flex items-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali ke Daftar NPD</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

@if(!$npdPerKodeRekening->isEmpty())
<script>
document.addEventListener('DOMContentLoaded', function() {
    function formatRp(n) {
        return 'Rp ' + Math.round(n).toLocaleString('id-ID');
    }
    function updateSisa(row) {
        var anggaran = parseFloat(row.dataset.anggaran) || 0;
        var akumulasi = parseFloat(row.dataset.akumulasi) || 0;
        var maxPencairan = parseFloat(row.dataset.maxPencairan) || 0;
        var input = row.querySelector('.npd-pencairan');
        var sisaCell = row.querySelector('.npd-sisa');
        var pencairan = parseFloat(input.value) || 0;
        if (maxPencairan >= 0 && pencairan > maxPencairan) {
            pencairan = maxPencairan;
            input.value = maxPencairan;
        }
        var sisa = anggaran - akumulasi - pencairan;
        sisaCell.textContent = formatRp(sisa);
        sisaCell.dataset.sisa = sisa;
        sisaCell.classList.toggle('text-red-600', sisa < 0);
        sisaCell.classList.toggle('text-slate-900', sisa >= 0);
    }
    document.querySelectorAll('.npd-row').forEach(function(row) {
        var input = row.querySelector('.npd-pencairan');
        if (input) {
            input.addEventListener('input', function() { updateSisa(row); });
            input.addEventListener('change', function() { updateSisa(row); });
        }
    });
});
</script>
@endif
@endsection
