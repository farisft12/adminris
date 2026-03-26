@php
    /** @var \App\Models\Administrasi $administrasi */
    $administrasi->load(['subKegiatan.year', 'kodeRekening']);
    $totalBayar = (float) $administrasi->total;
    $terbilangText = ucwords(strtolower(trim(\App\Services\TerbilangService::numberToWords($totalBayar)))).' Rupiah';
    $tahun = $administrasi->subKegiatan && $administrasi->subKegiatan->year
        ? $administrasi->subKegiatan->year->tahun
        : date('Y');
    $kodeRekening = $administrasi->kodeRekening
        ? $administrasi->kodeRekening->kode_rekening
        : '5.1.02.04.01.0001';
    $namaKegiatan = $administrasi->subKegiatan
        ? $administrasi->subKegiatan->nama_sub_kegiatan
        : 'Belanja Perjalanan Dinas Biasa';
    $nomorKwitansi = $administrasi->subKegiatan
        ? ($administrasi->subKegiatan->kode_sub ?? '').'-'.$administrasi->no.'/'.($administrasi->subKegiatan->year->tahun ?? $tahun)
        : $administrasi->no;
    $ppn = (float) ($administrasi->ppn ?? 0);
    $pph = (float) ($administrasi->pph23 ?? 0) + (float) ($administrasi->pph21 ?? 0);
    $penerimaNama = $administrasi->penerima ? trim($administrasi->penerima) : '';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Kwitansi - {{ $nomorKwitansi }}</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }
        * { box-sizing: border-box; }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: 'Times New Roman', Times, serif;
            font-size: 9pt;
            line-height: 1.25;
        }
        body { background: #f0f0f0; }
        .container {
            border: 2px solid #000;
            width: 100%;
            max-width: 190mm;
            min-height: 0;
            margin: 0 auto;
            padding: 8px 12px;
            background: #fff;
        }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        td { padding: 1px 4px; vertical-align: top; word-wrap: break-word; overflow-wrap: break-word; }
        .fw-bold { font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .italic { font-style: italic; }
        .underline { text-decoration: underline; }
        .border-bottom-double { border-bottom: 3px double #000; }
        @media print {
            html, body { background: none; margin: 0; padding: 0; }
            .container { max-width: none; width: 100%; box-shadow: none; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <table style="margin-bottom: 4px;">
            <tr>
                <td style="width: 50%;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 35%;">Nama Kegiatan</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 60%;">{{ $namaKegiatan }}</td>
                        </tr>
                        <tr>
                            <td>Kode Rekening</td>
                            <td>:</td>
                            <td>{{ $kodeRekening }}</td>
                        </tr>
                        <tr>
                            <td>Tahun Anggaran</td>
                            <td>:</td>
                            <td>{{ $tahun }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; text-align: right; vertical-align: top;">
                    <table style="width: 100%; margin-left: auto;">
                        <tr>
                            <td style="width: 40%;">Dibayar Tanggal</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 55%;"></td>
                        </tr>
                        <tr>
                            <td>No Kwitansi</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No. BKU</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Paraf</td>
                            <td>:</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <h2 class="text-center fw-bold" style="margin: 6px 0; font-size: 12pt; letter-spacing: 2px;">K W I T A N S I</h2>

        <table style="margin-bottom: 5px;">
            <tr>
                <td style="width: 22%;" class="fw-bold">TERIMA DARI</td>
                <td style="width: 3%;">:</td>
                <td style="width: 75%;">Bendahara Pengeluaran Pembantu Bagian Protokol dan Komunikasi Pimpinan Sekretariat Daerah Kota Banjarmasin</td>
            </tr>
        </table>

        <table style="margin-bottom: 8px;">
            <tr>
                <td style="width: 22%;" class="fw-bold">TERBILANG</td>
                <td style="width: 3%;">:</td>
                <td style="width: 75%;" class="italic">{{ $terbilangText }}</td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%;" class="fw-bold">UANG SEJUMLAH</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 20%;">Rp</td>
                            <td style="width: 25%; text-align: right;">{{ number_format($administrasi->tagihan ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">PPN</td>
                            <td>:</td>
                            <td style="border-bottom: 1px solid #000;">Rp</td>
                            <td style="text-align: right; border-bottom: 1px solid #000;">{{ number_format($ppn, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">SISA</td>
                            <td>:</td>
                            <td>Rp</td>
                            <td class="text-right">-</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">PPh 22</td>
                            <td>:</td>
                            <td>Rp</td>
                            <td class="text-right">{{ number_format($pph, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">PPh 23</td>
                            <td>:</td>
                            <td>Rp</td>
                            <td class="text-right">{{ number_format($pph, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">JUMLAH YANG DIBAYAR</td>
                            <td>:</td>
                            <td colspan="2" class="text-right border-bottom-double" style="padding-bottom: 2px;">
                                <span class="fw-bold">Rp &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($totalBayar, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top; padding-left: 10px;">
                    <span class="fw-bold underline" style="display: block; margin-bottom: 5px;">Untuk Pembayaran :</span>
                    <span style="text-align: justify;">{{ $administrasi->uraian_belanja }}</span>
                </td>
            </tr>
        </table>

        <table style="height: 36px;"><tr><td></td></tr></table>

        <table>
            <tr>
                <td style="width: 50%;">&nbsp;</td>
                <td style="width: 50%; text-align: right;">Banjarmasin, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $tahun }}</td>
            </tr>
        </table>

        <table style="margin-top: 6px;">
            <tr>
                <td style="width: 25%; vertical-align: top; text-align: center; font-size: 8pt;">
                    Mengetahui/Menyetujui,<br>Kuasa Pengguna Anggaran
                    <br><br><br><br>
                    <span class="fw-bold underline" style="white-space: nowrap;">{{ \App\Models\Setting::get('kabag_nama', 'Noorfahmi Arif Ridha, S.STP, MM') }}</span><br>
                    <span style="font-size: 7pt;">NIP. {{ \App\Models\Setting::get('kabag_nip', '19871115 200602 1 001') }}</span>
                </td>
                <td style="width: 25%; vertical-align: top; text-align: center; font-size: 8pt;">
                    Pejabat Pelaksana<br>Teknis Kegiatan
                    <br><br><br><br>
                    <span class="fw-bold underline">Ahmad Hamidi, S.Kom</span><br>
                    <span style="font-size: 7pt;">NIP. 19871021 201001 1 002</span>
                </td>
                <td style="width: 25%; vertical-align: top; text-align: center; font-size: 8pt;">
                    Lunas dibayar,<br>Bendahara Pengeluaran Pembantu
                    <br><br><br><br>
                    <span class="fw-bold underline">{{ \App\Models\Setting::get('bendahara_nama', 'Ahmad Sofa Anwari, S.Ak') }}</span><br>
                    <span style="font-size: 7pt;">NIP. {{ \App\Models\Setting::get('bendahara_nip', '19870129 201001 1 002') }}</span>
                </td>
                <td style="width: 25%; vertical-align: top; text-align: center; font-size: 8pt;">
                    Yang menerima,
                    <br><br><br><br><br>
                    <span class="fw-bold underline">{{ $penerimaNama ?: '-' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="no-print" style="position: fixed; bottom: 20px; right: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #4caf50; color: white; border: none; border-radius: 5px; cursor: pointer;">Print</button>
        <a href="{{ route('administrasi.index') }}" style="padding: 10px 20px; background-color: #2196f3; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px; display: inline-block;">Kembali</a>
    </div>
</body>
</html>
