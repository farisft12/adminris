<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPD {{ $subKegiatan->nama_sub_kegiatan }}</title>
    <style>
        @page { size: 210mm 330mm; margin: 10mm; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #e5e7eb; color: #000; font-size: 10.5px; line-height: 1.3; }
        .toolbar { padding: 12px; text-align: center; }
        .toolbar button, .toolbar a { display: inline-block; margin: 0 4px; padding: 9px 18px; border: 0; border-radius: 6px; font: 600 14px Arial, sans-serif; text-decoration: none; cursor: pointer; }
        .toolbar button { background: #1e293b; color: #fff; }
        .toolbar a { background: #fff; color: #334155; border: 1px solid #cbd5e1; }

        .page { width: 190mm; min-height: 310mm; margin: 0 auto 12px; padding: 6mm 0; background: #fff; page-break-after: always; break-after: page; }
        .page:last-of-type { page-break-after: auto; break-after: auto; }
        table { border-collapse: collapse; width: 100%; }
        td, th { vertical-align: top; padding: 1px 3px; }
        .center { text-align: center; }
        .right { text-align: right; }
        .bold, .bold td { font-weight: bold; }
        .u { text-decoration: underline; }
        .blank-sm { display: inline-block; width: 22mm; }
        .blank-md { display: inline-block; width: 28mm; }
        table.grid th, table.grid td { border: 1px solid #000; padding: 2px 3px; }
        table.grid th { font-weight: bold; text-align: center; vertical-align: middle; }

        /* ---- NPD ---- */
        .npd-page { font-family: Arial, Helvetica, sans-serif; }
        .npd-box { border: 1.5px solid #000; padding: 3mm 3mm 5mm; }
        .npd-head td { vertical-align: middle; font-size: 11px; }
        .npd-logo { width: 22mm; }
        .npd-logo img { height: 15mm; display: block; }
        .npd-title { font-size: 11.5px; }
        .npd-skpd { margin: 2mm 0 0; padding: 2mm 0; border-top: 1.5px solid #000; border-bottom: 1.5px solid #000; text-align: center; font-size: 9.5px; }
        .npd-intro { margin: 2mm 0 1mm; }
        .npd-info td.no { width: 5%; }
        .npd-info td.label { width: 27%; }
        .npd-info td.colon { width: 2%; }
        .npd-rek, .npd-potongan { margin-top: 3mm; font-size: 10px; }
        .npd-potongan th { text-align: center; }
        .npd-summary { margin-top: 4mm; }
        .npd-summary td.label { width: 32%; padding-left: 4mm; }
        table.sign { margin-top: 5mm; text-align: center; }
        table.sign td { width: 50%; text-align: center; }
        .sign-space td { height: 18mm; }
        .paraf { width: 70mm; margin-top: 2mm; font-family: Calibri, Arial, sans-serif; font-size: 11px; }
        .paraf th, .paraf td { border: 1px solid #000; padding: 2px 4px; font-weight: normal; }
        .paraf td:first-child { width: 60%; height: 11mm; }

        /* ---- SPTJB & Nota Dinas ---- */
        .doc { font-family: "Bookman Old Style", "Book Antiqua", Georgia, serif; font-size: 10.5px; }
        .doc h2 { margin: 0 0 5mm; font-size: 12px; text-align: center; }
        .doc p { margin: 0 0 3mm; text-align: justify; }
        .kv td.label { width: 27%; white-space: nowrap; }
        .kv td.colon { width: 2%; }
        .sptjb-table { margin: 2mm 0 4mm; }
        .sptjb-table td { vertical-align: top; }
        .money { display: flex; justify-content: space-between; gap: 4px; }
        .sign-doc td { width: 50%; }
        .sign-doc .sign-space td { height: 20mm; }

        .kop { display: flex; align-items: center; gap: 6mm; padding-bottom: 2mm; border-bottom: 4px double #000; }
        .kop img { height: 24mm; }
        .kop-text { flex: 1; text-align: center; padding-right: 20mm; }
        .kop-text strong { display: block; font-size: 14px; line-height: 1.25; }
        .kop-text small { display: block; font-size: 8px; }
        .nodin-meta { margin: 2mm 0 0; }
        .nodin-meta td.label { width: 17%; }
        .rule { border-bottom: 2.5px solid #000; margin: 2mm 0 4mm; }
        .section { margin: 0 0 4mm; }
        .section .body { padding-left: 5mm; }
        .nodin-table { margin: 2mm 0 2mm 5mm; width: calc(100% - 5mm); }
        .pptk-sign { width: 60mm; margin: 8mm 0 0 auto; text-align: center; }
        .pptk-sign .space { height: 22mm; }
        .disposisi { width: 82mm; margin-top: 8mm; border: 1px solid #000; text-align: center; }
        .disposisi td { border-bottom: 1px solid #000; padding: 2px; }
        .disposisi .space { height: 20mm; border-bottom: 0; }

        @media print {
            body { background: #fff; }
            .toolbar { display: none; }
            .page { margin: 0; padding: 0; min-height: 0; }
        }
    </style>
</head>
<body>
@php
    $rp = fn ($n) => number_format($n, 0, ',', '.');
    $kodeSkpd = '4.01.0.00.0.00.01.0001';
@endphp

<div class="toolbar">
    <button type="button" onclick="window.print()">Print</button>
    <a href="{{ route('sub-kegiatan.npd.show', [$subKegiatan, $npd]) }}">Kembali</a>
</div>

{{-- Halaman 1 & 2: NPD, lalu salinan dengan kotak paraf --}}
@include('sub-kegiatan._npd-page', ['withParaf' => false])
@include('sub-kegiatan._npd-page', ['withParaf' => true])

{{-- Halaman 3: SPTJB --}}
<section class="page doc">
    <h2>SURAT PERNYATAAN TANGGUNG JAWAB BELANJA</h2>

    <table class="kv">
        <tr><td class="label">1. NAMA SKPD</td><td class="colon">:</td><td>Bendahara Pengeluaran Pembantu Bagian Protokol dan Komunikasi Pimpinan Sekretariat Daerah Kota Banjarmasin</td></tr>
        <tr><td class="label">2. KODE SKPD</td><td class="colon">:</td><td>{{ $kodeSkpd }}</td></tr>
        <tr><td class="label">3. PROGRAM</td><td class="colon">:</td><td>{{ $program }}</td></tr>
        <tr><td class="label">4. NAMA KEGIATAN</td><td class="colon">:</td><td>{{ $kegiatan }}</td></tr>
        <tr><td class="label">5. NAMA SUB KEGIATAN</td><td class="colon">:</td><td>{{ $subKegiatan->nama_sub_kegiatan }}</td></tr>
        <tr><td class="label">6. TANGGAL/NO.DPPA SKPD</td><td class="colon">:</td><td>{{ $texts['nomor_dpa'] }}</td></tr>
    </table>

    <p style="margin-top:4mm">{{ $texts['sptjb_pembuka'] }}</p>

    <table class="grid sptjb-table">
        <tr>
            <th rowspan="2" style="width:5%">NO</th>
            <th rowspan="2" style="width:19%">PENERIMA</th>
            <th rowspan="2">URAIAN</th>
            <th colspan="2">BUKTI</th>
            <th rowspan="2" style="width:20%">JUMLAH</th>
        </tr>
        <tr><th style="width:6%">TGL</th><th style="width:9%">NOMOR</th></tr>
        @forelse($sptjbItems as $a)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $a->penerima ?: '-' }}</td>
                <td>{{ $a->uraian_belanja }}</td>
                <td></td>
                <td></td>
                <td><div class="money"><span>Rp</span><span>{{ number_format($a->tagihan, 2, ',', '.') }}</span></div></td>
            </tr>
        @empty
            <tr><td colspan="6" class="center" style="padding:4mm">Belum ada administrasi yang terhubung ke NPD ini.</td></tr>
        @endforelse
        <tr>
            <td></td><td></td>
            <td class="center">Jumlah</td>
            <td colspan="2"></td>
            <td><div class="money"><span>Rp</span><span>{{ number_format($diminta, 2, ',', '.') }}</span></div></td>
        </tr>
    </table>

    <p>{{ $texts['sptjb_penutup'] }}</p>
    <p>Demikian surat pernyataan ini dibuat dengan sebenarnya.</p>

    <table class="sign-doc" style="margin-top:6mm">
        <tr>
            <td><br>Mengetahui :<br>Kuasa Pengguna Anggaran</td>
            <td>Banjarmasin, <span class="blank-md"></span>{{ $tahun }}<br>Dibuat oleh :<br>Pejabat Pelaksana Teknis Kegiatan</td>
        </tr>
        <tr class="sign-space"><td></td><td></td></tr>
        <tr>
            <td><span class="u">{{ mb_strtoupper($kpa['nama']) }}</span><br>NIP. {{ $kpa['nip'] }}</td>
            <td><span class="u">{{ mb_strtoupper($pptk?->nama_pptk ?? '-') }}</span><br>NIP. {{ $pptk?->nip ?? '-' }}</td>
        </tr>
    </table>
</section>

{{-- Halaman 4: Nota Dinas --}}
<section class="page doc">
    <div class="kop">
        @if(file_exists(public_path('img/logo_bjm.png')))
            <img src="{{ asset('img/logo_bjm.png') }}" alt="Logo Kota Banjarmasin">
        @endif
        <div class="kop-text">
            <strong>PEMERINTAH KOTA BANJARMASIN</strong>
            <strong>SEKRETARIAT DAERAH</strong>
            <strong>BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN</strong>
            <small>JL. RE Martadinata No.1 Banjarmasin TELP. 0511 3364857 KODE POS 70111 Banjarmasin 70111</small>
            <small><a href="https://www.banjarmasinkota.go.id">www.banjarmasinkota.go.id</a></small>
        </div>
    </div>

    <h2 style="margin-top:5mm">NOTA DINAS</h2>

    <table class="kv nodin-meta">
        <tr><td class="label">Kepada</td><td class="colon">:</td><td>Kepala Bagian Protokol dan Komunikasi Pimpinan Sekretariat Daerah Kota Banjarmasin</td></tr>
        <tr><td class="label">Dari</td><td class="colon">:</td><td>PPTK Sub Kegiatan {{ $subKegiatan->nama_sub_kegiatan }}</td></tr>
        <tr><td class="label" style="padding-top:2mm">Tanggal</td><td class="colon" style="padding-top:2mm">:</td><td style="padding-top:2mm"><span class="blank-md"></span>{{ $tahun }}</td></tr>
        <tr><td class="label">Nomor</td><td class="colon">:</td><td>&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/KEU/BAG.PROKOM/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/{{ $tahun }}</td></tr>
        <tr><td class="label">Sifat</td><td class="colon">:</td><td>Penting</td></tr>
        <tr><td class="label">Lampiran</td><td class="colon">:</td><td>1 (satu) lembar</td></tr>
        <tr><td class="label">Hal</td><td class="colon">:</td><td>Permintaan Dana Kegiatan {{ $kegiatan }} Sub Kegiatan {{ $subKegiatan->nama_sub_kegiatan }}</td></tr>
    </table>
    <div class="rule"></div>

    <div class="section">
        A.&nbsp; Dasar :
        <p class="body">{{ $texts['nodin_dasar'] }}</p>
    </div>

    <div class="section">
        B.&nbsp; Uraian
        <div class="body">Permintaan dana sebesar Rp. <strong>{{ number_format($diminta, 2, ',', '.') }}</strong> , terdiri dari :</div>
        <table class="grid nodin-table">
            <tr>
                <th style="width:21%; font-weight:normal">KODE REKENING</th>
                <th style="font-weight:normal">URAIAN KEGIATAN</th>
                <th colspan="2" style="width:24%; font-weight:normal">PERMINTAAN</th>
            </tr>
            @foreach($rows as $row)
                <tr>
                    <td>{{ $row['kode_rekening'] }}</td>
                    <td>{{ $row['nama_rekening'] }}</td>
                    <td style="width:5%; border-right:0">Rp</td>
                    <td class="right" style="border-left:0">{{ $rp($row['pencairan']) }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="right">JUMLAH</td>
                <td></td>
                <td style="border-right:0">Rp</td>
                <td class="right" style="border-left:0">{{ $rp($diminta) }}</td>
            </tr>
        </table>
        <div class="body">Terbilang : &nbsp; {{ \App\Services\NpdService::terbilang($diminta, true) }}.</div>
    </div>

    <div class="section">
        C.&nbsp; Saran Tindak :
        <p class="body">{{ $texts['nodin_saran'] }}</p>
    </div>

    <div class="pptk-sign">
        PPTK
        <div class="space"></div>
        <span class="u">{{ $pptk?->nama_pptk ?? '-' }}</span><br>
        NIP. {{ $pptk?->nip ?? '-' }}
    </div>

    <table class="disposisi">
        <tr><td>DISPOSISI</td></tr>
        <tr><td>KEPALA BAGIAN/KUASA PENGGUNA ANGGARAN</td></tr>
        <tr><td class="space"></td></tr>
        <tr><td style="border-bottom:0"><strong class="u">{{ mb_strtoupper($kpa['nama']) }}</strong><br>NIP. {{ $kpa['nip'] }}</td></tr>
    </table>
</section>
@unless(request()->boolean('preview'))
<script>
    // Sama seperti sebelumnya: dialog print langsung terbuka (?preview=1 untuk melihat saja).
    window.addEventListener('load', function () { window.print(); });
</script>
@endunless
</body>
</html>
