<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pencairan Dana (NPD)</title>
    <style>
        @page {
            size: 210mm 330mm;
            margin: 10mm;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 2mm;
                page-break-after: avoid;
            }
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
            line-height: 1.3;
        }
        .container {
            border: 2px solid black;
            padding: 2mm;
            max-width: 190mm;
            margin: auto;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 10px;
            position: relative;
        }
        .header img {
            position: absolute;
            left: 10px;
            top: 5px;
            width: 80px;
            height: auto;
        }
        .header h3, .header h4 {
            margin: 2px 0;
            text-transform: uppercase;
        }
        .info-table {
            width: 100%;
            margin-bottom: 8px;
        }
        .info-table td {
            vertical-align: top;
            padding: 1px 2px;
            border: none;
        }
        .info-table td:first-child { width: 5%; }
        .info-table td:nth-child(2) { width: 25%; }
        .info-table td:nth-child(3) { width: 2%; }

        table.main-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 10px;
        }
        table.main-data th, table.main-data td {
            border: 1px solid black;
            padding: 3px;
            text-align: left;
        }
        table.main-data th {
            text-align: center;
            background-color: #f2f2f2;
            font-size: 10px;
        }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .font-bold { font-weight: bold; }

        .footer-section {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            text-align: center;
        }
        .signature-box {
            width: 40%;
        }
        .signature-box p {
            margin: 0;
            line-height: 1.2;
            font-size: 10px;
        }
        .space-signature {
            height: 50px;
        }
        .signature-box .font-bold {
            margin-bottom: 0;
        }
        .signature-box .font-bold + p {
            margin-top: 0;
        }
    </style>
</head>
<body>

@php
    $grandTotalAnggaran = $npdPerKodeRekening->sum('anggaran');
    $grandTotalAkumulasi = $npdPerKodeRekening->sum('akumulasi');
    $grandTotalPencairan = $npdPerKodeRekening->sum('pencairan_saat_ini');
    $grandTotalSisa = $npdPerKodeRekening->sum('sisa');
    $terbilangGrandTotal = $grandTotalPencairan > 0
        ? ucfirst(trim(\App\Services\TerbilangService::numberToWords($grandTotalPencairan))) . ' Rupiah'
        : 'Nol Rupiah';
    $tahun = $subKegiatan->year?->tahun ?? date('Y');
    $pptk = $subKegiatan->pptk;
@endphp

<div class="no-print" style="margin-bottom: 20px; text-align: center;">
    <button onclick="window.print()" style="padding: 10px 20px; background: #3c50e0; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
        Print
    </button>
    <a href="{{ route('sub-kegiatan.npd.show', [$subKegiatan, $npd]) }}" style="padding: 10px 20px; background: #6b7280; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px; display: inline-block;">
        Kembali
    </a>
</div>

<div class="container">
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
        <tbody>
            <tr style="text-align: center; height: 25px;">
                <td style="width: 80px; height: 25px; vertical-align: top; text-align: left; padding: 0;">
                    @if(file_exists(public_path('img/logo_bjm.png')))
                        <img src="{{ asset('img/logo_bjm.png') }}" alt="Logo" style="width: auto; height: 50px; display: block;">
                    @else
                        <span style="font-size: 10px;">LOGO</span>
                    @endif
                </td>
                <td style="height: 25px; vertical-align: middle; text-align: center; font-size: 11px; padding: 0 5px;">
                    <strong>NOTA &nbsp;&nbsp; PENCAIRAN &nbsp;&nbsp; DANA &nbsp;&nbsp; (NPD)</strong><br />
                    Nomor : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/NPD/{{ $subKegiatan->kode_sub}}/{{ $tahun }}
                </td>
                <td style="width: 80px; height: 25px;"></td>
            </tr>
            <tr style="text-align: center; height: 40px;">
                <td colspan="3" style="height: 40px; vertical-align: middle; text-align: center; border-top: 1px solid black; border-bottom: 1px solid black; padding: 2px 0; font-size: 10px;">
                    <strong>BENDAHARA PENGELUARAN</strong><br />
                    <strong>SKPD : (4.01.0.00.0.00.01.0001)  BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN SEKRETARIAT DAERAH KOTA BANJARMASIN</strong>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="margin: 5px 0 3px 0; font-size: 11px;">Supaya mencairkan dana kepada :</p>
    <table class="info-table">
        <tr><td>1</td><td>Pejabat Pelaksana Teknis Kegiatan</td><td>:</td><td>{{ $pptk ? $pptk->nama_pptk : '-' }}</td></tr>
        <tr><td>2</td><td>Sub Kegiatan</td><td>:</td><td>{{ $subKegiatan->nama_sub_kegiatan }}</td></tr>
        <tr><td>3</td><td>Kode Kegiatan</td><td>:</td><td>{{ $subKegiatan->kode_sub ?: '-' }}</td></tr>
        <tr><td>4</td><td>Tahun Anggaran</td><td>:</td><td>{{ $tahun }}</td></tr>
        <tr><td>5</td><td>Jumlah dana yang diminta</td><td>:</td><td>Rp {{ number_format($grandTotalPencairan, 0, ',', '.') }}</td></tr>
        <tr><td>6</td><td>Terbilang</td><td>:</td><td>{{ $terbilangGrandTotal }}</td></tr>
    </table>

    <table class="main-data">
        <thead>
            <tr>
                <th colspan="7">Pembebanan pada kode rekening :</th>
            </tr>
            <tr>
                <th style="width: 40px;">No. Urut</th>
                <th style="width: 100px;">Kode Rekening</th>
                <th>Uraian</th>
                <th>Anggaran</th>
                <th>Akumulasi</th>
                <th>Pencairan saat ini</th>
                <th>Sisa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($npdPerKodeRekening as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $row['kode_rekening'] }}</td>
                <td class="font-bold">{{ $row['nama_rekening'] }}</td>
                <td class="text-right">{{ number_format($row['anggaran'], 0, ',', '.') }}</td>
                <td class="text-right">{{ $row['akumulasi'] > 0 ? number_format($row['akumulasi'], 0, ',', '.') : '-' }}</td>
                <td class="text-right">{{ $row['pencairan_saat_ini'] > 0 ? number_format($row['pencairan_saat_ini'], 0, ',', '.') : '-' }}</td>
                <td class="text-right">{{ $row['sisa'] > 0 ? number_format($row['sisa'], 0, ',', '.') : ($row['sisa'] < 0 ? number_format($row['sisa'], 0, ',', '.') : '-') }}</td>
            </tr>
            @endforeach
            <tr class="font-bold">
                <td colspan="3" class="text-center">JUMLAH</td>
                <td class="text-right">{{ number_format($grandTotalAnggaran, 0, ',', '.') }}</td>
                <td class="text-right">{{ $grandTotalAkumulasi > 0 ? number_format($grandTotalAkumulasi, 0, ',', '.') : '-' }}</td>
                <td class="text-right">{{ $grandTotalPencairan > 0 ? number_format($grandTotalPencairan, 0, ',', '.') : '-' }}</td>
                <td class="text-right">{{ $grandTotalSisa != 0 ? number_format($grandTotalSisa, 0, ',', '.') : '-' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="main-data">
        <tr><th colspan="2">Potongan-potongan :</th></tr>
        <tr><td style="width: 80%;">PPN</td><td style="text-align: center;">-</td></tr>
        <tr><td>PPH 21</td><td style="text-align: center;">-</td></tr>
        <tr><td>PPH 22</td><td style="text-align: center;">-</td></tr>
        <tr><td>PPH 23</td><td style="text-align: center;">-</td></tr>
        <tr><td>PPH Pasal 4 (2)</td><td style="text-align: center;">-</td></tr>
    </table>

    <div style="margin-top: 3px; padding: 3px;">
        <table style="width: 100%; font-size: 10px;">
            <tr>
                <td style="width: 30%;">Jumlah yang diminta</td>
                <td style="width: 2%;">:</td>
                <td style="width: 20%">Rp {{ number_format($grandTotalPencairan, 0, ',', '.') }}</td>
                <td style="width: 48%">&nbsp;</td>
            </tr>
            <tr>
                <td>Potongan</td>
                <td>:</td>
                <td>Rp -</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Jumlah yang dibayarkan</td>
                <td>:</td>
                <td>Rp {{ number_format($grandTotalPencairan, 0, ',', '.') }}</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Terbilang</td>
                <td>:</td>
                <td colspan="2">{{ $terbilangGrandTotal }}</td>
            </tr>
        </table>
    </div>

    <div class="footer-section">
        <div class="signature-box">
            <p>Menyetujui,</p>
            <p>Kuasa Pengguna Anggaran</p>
            <div class="space-signature"></div>
            <p class="font-bold" style="text-decoration: underline;">Noorfahmi Arif Ridha, S.STP, MM</p>
            <p>NIP. 19871115 200602 1 001</p>
        </div>
        <div class="signature-box">
            <p>Banjarmasin, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $npd->tanggal->format('Y') }}</p>
            <p>Pejabat Pelaksana Teknis Kegiatan,</p>
            <div class="space-signature"></div>
            <p class="font-bold" style="text-decoration: underline;">{{ $pptk ? $pptk->nama_pptk : '-' }}</p>
            <p>NIP. {{ $pptk ? $pptk->nip : '-' }}</p>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>
</body>
</html>
