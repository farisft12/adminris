<?php

namespace App\Services;

use App\Models\Setting;

/**
 * Teks NPD/SPTJB/Nota Dinas yang berubah tiap tahun anggaran.
 * Disimpan di tabel settings dengan key "npd.{tahun}.{field}".
 */
class NpdTemplate
{
    public const FIELDS = [
        'nomor_dpa' => 'Nomor DPA SKPD',
        'nodin_dasar' => 'Nota Dinas — A. Dasar',
        'nodin_saran' => 'Nota Dinas — C. Saran Tindak',
        'sptjb_pembuka' => 'SPTJB — Paragraf pembuka',
        'sptjb_penutup' => 'SPTJB — Paragraf penutup',
    ];

    public static function defaults(int $tahun): array
    {
        return [
            'nomor_dpa' => "DPPA/A.3/4.01.0.00.0.00.01.0000/002/{$tahun}",
            'nodin_dasar' => "Peraturan Daerah Kota Banjarmasin tentang Anggaran Pendapatan dan Belanja Daerah (APBD) Tahun Anggaran {$tahun}",
            'nodin_saran' => 'Mohon ditindaklanjuti dan pelaksana kegiatan bertanggung jawab penuh terhadap penggunaan dana sesuai dengan peruntukannya',
            'sptjb_pembuka' => 'Yang bertanda tangan dibawah ini Kuasa Pengguna Anggaran SKPD Bagian Protokol dan Komunikasi Pimpinan Sekretariat Daerah Kota Banjarmasin, menyatakan bertanggungjawab penuh atas kebenaran material, sesuai substansi dan uraian dalam Dokumen Pelaksanaan Anggaran (DPA) serta akibat yang timbul dari segala pengeluaran yang dibayar lunas oleh Bendahara Pengeluaran Pembantu kepada yang berhak menerima dengan perincian sebagai berikut:',
            'sptjb_penutup' => 'Surat bukti asli yang menjadi dasar pengeluaran atas beban APBD tersebut diatas disimpan sesuai dengan ketentuan yang berlaku pada Bagian Protokol dan Komunikasi Pimpinan Sekretariat Daerah Kota Banjarmasin, untuk kelengkapan administrasi dan keperluan pemeriksaan aparat fungsional (post audit).',
        ];
    }

    public static function forYear(int $tahun): array
    {
        $saved = Setting::where('key', 'like', "npd.{$tahun}.%")->pluck('value', 'key');
        $texts = [];

        foreach (static::defaults($tahun) as $field => $default) {
            $value = $saved->get("npd.{$tahun}.{$field}");
            $texts[$field] = filled($value) ? $value : $default;
        }

        return $texts;
    }

    public static function save(int $tahun, array $values): void
    {
        foreach (array_keys(static::FIELDS) as $field) {
            Setting::set("npd.{$tahun}.{$field}", $values[$field] ?? null);
        }
    }
}
