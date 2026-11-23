{{-- Satu halaman NPD. $withParaf = tampilkan kotak paraf di bawah bingkai. --}}
@php
    $rp = fn ($n) => number_format($n, 0, ',', '.');
    $rpOrDash = fn ($n) => round($n) == 0 ? '-' : $rp($n);
@endphp
<section class="page npd-page">
    <div class="npd-box">
        <table class="npd-head">
            <tr>
                <td class="npd-logo">
                    @if(file_exists(public_path('img/logo_bjm.png')))
                        <img src="{{ asset('img/logo_bjm.png') }}" alt="Logo Kota Banjarmasin">
                    @endif
                </td>
                <td class="center">
                    <strong class="npd-title">NOTA &nbsp; PENCAIRAN &nbsp; DANA &nbsp; (NPD)</strong><br>
                    Nomor : <span class="blank-sm"></span>/NPD/{{ $kodeNomor }}/{{ $tahun }}
                </td>
                <td class="npd-logo"></td>
            </tr>
        </table>

        <div class="npd-skpd">
            <strong>BENDAHARA PENGELUARAN PEMBANTU</strong><br>
            SKPD : (4.01.0.00.0.00.01.0001) BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN SEKRETARIAT DAERAH KOTA BANJARMASIN
        </div>

        <p class="npd-intro">Supaya mencairkan dana kepada :</p>
        <table class="npd-info">
            @foreach([
                ['Pejabat Pelaksana Teknis Kegiatan', $pptk?->nama_pptk ?? '-'],
                ['Program', $program],
                ['Kegiatan', $kegiatan],
                ['Sub Kegiatan', $subKegiatan->nama_sub_kegiatan],
                ['Kode Kegiatan', $kodeKegiatan],
                ['Nomor DPA SKPD', $texts['nomor_dpa']],
                ['Tahun Anggaran', $tahun],
                ['Jumlah dana yang diminta', 'Rp ' . $rp($diminta)],
                ['Terbilang', \App\Services\NpdService::terbilang($diminta)],
            ] as $i => [$label, $value])
                <tr><td class="no">{{ $i + 1 }}</td><td class="label">{{ $label }}</td><td class="colon">:</td><td>{{ $value }}</td></tr>
            @endforeach
        </table>

        <table class="grid npd-rek">
            <tr><th colspan="7">Pembebanan pada kode rekening :</th></tr>
            <tr>
                <th style="width:7%">No. Urut</th>
                <th style="width:16%">Kode Rekening</th>
                <th>Uraian</th>
                <th style="width:11%">Anggaran</th>
                <th style="width:11%">Akumulasi</th>
                <th style="width:11%">Pencairan saat ini</th>
                <th style="width:11%">Sisa</th>
            </tr>
            @foreach($rows as $i => $row)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ $row['kode_rekening'] }}</td>
                    <td><strong>{{ $row['nama_rekening'] }}</strong></td>
                    <td class="right">{{ $rp($row['anggaran']) }}</td>
                    <td class="right">{{ $rp($row['akumulasi']) }}</td>
                    <td class="right">{{ $rp($row['pencairan']) }}</td>
                    <td class="right">{{ $rp($row['sisa']) }}</td>
                </tr>
            @endforeach
            <tr class="bold">
                <td></td><td></td>
                <td>JUMLAH</td>
                <td class="right">{{ $rp($totals['anggaran']) }}</td>
                <td class="right">{{ $rp($totals['akumulasi']) }}</td>
                <td class="right">{{ $rp($totals['pencairan']) }}</td>
                <td class="right">{{ $rp($totals['sisa']) }}</td>
            </tr>
        </table>

        <table class="grid npd-potongan">
            <tr><th colspan="2">Potongan-potongan :</th></tr>
            @foreach($potongan as $label => $nilai)
                <tr><td>{{ $label }}</td><td class="right" style="width:19%">{{ $rpOrDash($nilai) }}</td></tr>
            @endforeach
        </table>

        <table class="npd-info npd-summary">
            <tr><td class="label">Jumlah yang diminta</td><td class="colon">:</td><td>Rp {{ $rp($diminta) }}</td></tr>
            <tr><td class="label">Potongan</td><td class="colon">:</td><td>Rp {{ $rpOrDash($totalPotongan) }}</td></tr>
            <tr><td class="label">Jumlah yang dibayarkan</td><td class="colon">:</td><td>Rp {{ $rp($dibayarkan) }}</td></tr>
            <tr><td class="label">Terbilang</td><td class="colon">:</td><td>{{ \App\Services\NpdService::terbilang($dibayarkan) }}</td></tr>
        </table>

        <table class="sign">
            <tr>
                <td>Menyetujui,<br>Kuasa Pengguna Anggaran</td>
                <td>Banjarmasin, <span class="blank-md"></span>{{ $tahun }}<br>Pejabat Pelaksana Teknis Kegiatan,</td>
            </tr>
            <tr class="sign-space"><td></td><td></td></tr>
            <tr>
                <td><strong class="u">{{ $kpa['nama'] }}</strong><br>NIP. {{ $kpa['nip'] }}</td>
                <td><strong class="u">{{ $pptk?->nama_pptk ?? '-' }}</strong><br>NIP. {{ $pptk?->nip ?? '-' }}</td>
            </tr>
        </table>
    </div>

    @if($withParaf)
        <table class="paraf">
            <tr><th colspan="2">Paraf</th></tr>
            <tr><td>Kepala Sub Bagian Protokol</td><td class="paraf-cell"></td></tr>
            <tr><td>Staf admin</td><td class="paraf-cell"></td></tr>
        </table>
    @endif
</section>
