@php
    /** @var \App\Models\Administrasi $administrasi */
    $administrasi->load(['subKegiatan.year', 'subKegiatan.pptk', 'kodeRekening']);
    $tahun = $administrasi->subKegiatan && $administrasi->subKegiatan->year
        ? $administrasi->subKegiatan->year->tahun
        : date('Y');
    $pptk = $administrasi->subKegiatan && $administrasi->subKegiatan->pptk
        ? $administrasi->subKegiatan->pptk
        : null;
    $namaPptk = $pptk ? $pptk->nama_pptk : 'Eldinar Raina Arijadi, A.Md';
    $nipPptk = $pptk ? $pptk->nip : '19780221 200901 2 001';
    $terbilangText = ucwords(strtolower(trim(\App\Services\TerbilangService::numberToWords($administrasi->total)))).' Rupiah';
    $logoPath = public_path('img/logo_bjm.png');
    $logoSrc = file_exists($logoPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
        : '';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Persetujuan - {{ $administrasi->no }}</title>
    <style>
        @page { size: A4; margin: 12mm; }
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; width: 100%; }
        body { font-family: Arial, sans-serif; background-color: #f0f0f0; font-size: 11pt; }
        .container {
            background-color: white;
            width: 100%;
            max-width: 186mm;
            margin: 0 auto;
            padding: 14px 24px 18px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            page-break-inside: avoid;
        }
        header {
            margin-bottom: 6px;
        }
        header .header-inner {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        header .header-inner .logo-cell {
            width: 60px;
            vertical-align: middle;
            padding-right: 14px;
        }
        header .header-inner .logo { width: 60px; height: auto; display: block; }
        header .text-cell { vertical-align: middle; text-align: center; }
        header h1 { margin: 0; font-size: 15pt; letter-spacing: 0.5px; }
        header h2 { margin: 3px 0 0 0; font-size: 10pt; font-weight: bold; }
        .double-line {
            border: none;
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            height: 4px;
            margin-top: 4px;
        }
        .title-doc { text-align: center; font-size: 14pt; margin: 14px 0 12px 0; }
        .intro-text { margin: 10px 0 6px 0; }
        .info-table { width: 100%; border-collapse: collapse; border: 1px solid black; }
        .info-table td { padding: 5px 8px; vertical-align: top; border: 1px solid black; }
        .detail-table { width: 100%; border-collapse: collapse; border: 1px solid black; }
        .detail-table th, .detail-table td { border: 1px solid black; padding: 6px 8px; text-align: left; }
        .header-row { background-color: white; text-align: center !important; }
        .center { text-align: center; }
        .italic { font-style: italic; }
        .border-top-none { border-top: none; }
        .description-box {
            border: 1px solid black;
            border-top: none;
            padding: 8px;
            min-height: 70px;
        }
        .description-box p { margin: 4px 0 0 0; }
        .closing { margin: 10px 0; }
        .footer-table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        .footer-table td { vertical-align: top; padding: 0 0 0 24px; }
        .footer-table td:first-child { padding-left: 0; width: 460px; }
        .disposition-box {
            border: 1px solid black;
            width: 460px;
            min-width: 260px;
            height: 150px;
            padding: 2px;
            font-size: 10pt;
        }
        .signature {
            text-align: center;
            width: 220px;
            min-width: 220px;
            height: 150px;
            margin-left: auto;
            font-size: 10pt;
        }
        .signature p { margin: 0; }
        @media print {
            html, body { background: none; padding: 0; margin: 0; width: 100%; }
            .container { box-shadow: none; margin: 0; padding: 0; width: 100%; max-width: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <table class="header-inner" cellpadding="0" cellspacing="0">
                <tr>
                    @if($logoSrc)
                        <td class="logo-cell">
                            <img src="{{ $logoSrc }}" alt="Logo Banjarmasin" class="logo">
                        </td>
                    @endif
                    <td class="text-cell">
                        <h1>PEMERINTAH KOTA BANJARMASIN</h1>
                        <h2>BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN SEKRETARIAT DAERAH KOTA BANJARMASIN</h2>
                    </td>
                </tr>
            </table>
        </header>
        <hr class="double-line">

        <main>
            <h2 class="title-doc"><u>NOTA PERSETUJUAN</u></h2>

            <table class="info-table">
                <tr>
                    <td width="20%"><strong>Kepada Yth</strong></td>
                    <td width="2%">:</td>
                    <td>Kuasa Pengguna Anggaran</td>
                </tr>
                <tr>
                    <td><strong>Dari PPTK Kegiatan</strong></td>
                    <td>:</td>
                    <td>{{ $namaPptk }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>:</td>
                    <td>{{ $administrasi->tanggal_nota_persetujuan ? $administrasi->tanggal_nota_persetujuan->format('Y') : $tahun }}</td>
                </tr>
                <tr>
                    <td><strong>Perihal</strong></td>
                    <td>:</td>
                    <td>Mohon Persetujuan Pencairan Dana</td>
                </tr>
            </table>

            <p class="intro-text">Bersama ini disampaikan Permohonan Persetujuan belanja dengan keterangan sebagai berikut :</p>

            <table class="detail-table">
                <tr class="header-row">
                    <th style="text-align: center;" width="70%">URAIAN REKENING</th>
                    <th style="text-align: center;">BEBAN REKENING</th>
                </tr>
                <tr>
                    <td>{{ $administrasi->kodeRekening ? $administrasi->kodeRekening->nama_rekening : $administrasi->uraian_belanja }}</td>
                    <td style="text-align: center;" class="center">{{ $administrasi->kodeRekening ? $administrasi->kodeRekening->kode_rekening : '-' }}</td>
                </tr>
            </table>

            <table class="detail-table border-top-none">
                <tr class="header-row">
                    <th style="text-align: center;" class="center" width="35%">NILAI (Rp.)</th>
                    <th>TERBILANG :</th>
                </tr>
                <tr>
                    <td style="text-align: center;" class="center">Rp. {{ number_format($administrasi->total, 0, ',', '.') }}</td>
                    <td style="text-align: center;" class="italic">{{ $terbilangText }}</td>
                </tr>
            </table>

            <section class="description-box">
                <strong>URAIAN :</strong>
                <p>{{ $administrasi->uraian_belanja }}</p>
                @if($administrasi->keterangan)
                    <p>{{ $administrasi->keterangan }}</p>
                @endif
            </section>

            <p class="closing">Demikian disampaikan dan mohon persetujuannya.</p>

            <table class="footer-table">
                <tr>
                    <td class="disposition-box">
                        <strong> DISPOSISI ( PERSETUJUAN )</strong><br>
                        <strong><u> PIMPINAN / KPA :</u></strong>
                    </td>
                    <td>
                        <div class="signature">
                            <p>PPTK KEGIATAN,</p>
                            <br><br>
                            <br><br>
                            <br><br>
                            <p><strong><u>{{ $namaPptk }}</u></strong><br>
                            NIP. {{ $nipPptk }}</p>
                        </div>
                    </td>
                </tr>
            </table>
        </main>
    </div>
</body>
</html>
