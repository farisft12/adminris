<?php

namespace App\Services;

use App\Models\Administrasi;
use App\Models\Kegiatan;
use App\Models\Npd;
use App\Models\NpdDetail;
use App\Models\Setting;
use App\Models\SubKegiatan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class NpdService
{
    /** Administrasi yang boleh dipilih: belum masuk NPD lain. */
    public function availableAdministrasis(SubKegiatan $subKegiatan, ?Npd $npd = null): Collection
    {
        return Administrasi::with('kodeRekening')
            ->where('sub_kegiatan_id', $subKegiatan->id)
            ->where(fn ($q) => $q->whereNull('npd_id')->when($npd, fn ($q) => $q->orWhere('npd_id', $npd->id)))
            ->orderBy('tanggal_nota_persetujuan')
            ->orderBy('id')
            ->get();
    }

    /** Hubungkan administrasi terpilih ke NPD lalu hitung ulang pencairan per kode rekening. */
    public function sync(Npd $npd, array $administrasiIds): void
    {
        $ids = array_values(array_unique(array_map('intval', $administrasiIds)));

        $valid = Administrasi::whereIn('id', $ids)
            ->where('sub_kegiatan_id', $npd->sub_kegiatan_id)
            ->where(fn ($q) => $q->whereNull('npd_id')->orWhere('npd_id', $npd->id))
            ->pluck('id');

        if ($ids === [] || $valid->count() !== count($ids)) {
            throw ValidationException::withMessages([
                'administrasi_ids' => 'Pilih minimal satu administrasi yang belum masuk NPD lain.',
            ]);
        }

        DB::transaction(function () use ($npd, $ids) {
            Administrasi::where('npd_id', $npd->id)->whereNotIn('id', $ids)->update(['npd_id' => null]);
            Administrasi::whereIn('id', $ids)->update(['npd_id' => $npd->id]);
            $npd->recalculateDetails();
        });
    }

    /** Semua data untuk cetak NPD, NPD + paraf, SPTJB, dan Nota Dinas. */
    public function document(Npd $npd): array
    {
        $npd->load(['details', 'administrasis.kodeRekening', 'subKegiatan.year', 'subKegiatan.pptk']);
        $subKegiatan = $npd->subKegiatan;
        $tahun = (int) ($subKegiatan->year?->tahun ?? $npd->tanggal->year);
        $kodeRekenings = $subKegiatan->kodeRekenings()->orderBy('kode_rekening')->get();

        // Akumulasi = NPD sebelumnya saja (bukan NPD yang dibuat sesudahnya).
        $akumulasi = NpdDetail::query()
            ->whereHas('npd', fn ($q) => $q->where('sub_kegiatan_id', $subKegiatan->id)
                ->where(fn ($w) => $w->where('tanggal', '<', $npd->tanggal)
                    ->orWhere(fn ($s) => $s->where('tanggal', $npd->tanggal)->where('id', '<', $npd->id))))
            ->selectRaw('kode_rekening_id, SUM(jumlah) as total')
            ->groupBy('kode_rekening_id')
            ->pluck('total', 'kode_rekening_id');

        $pencairan = $npd->details->pluck('jumlah', 'kode_rekening_id');

        $rows = $kodeRekenings->map(function ($kr) use ($akumulasi, $pencairan) {
            $anggaran = (float) ($kr->pivot->anggaran ?? 0);
            $sebelum = (float) $akumulasi->get($kr->id, 0);
            $saatIni = (float) $pencairan->get($kr->id, 0);

            return [
                'kode_rekening' => $kr->kode_rekening,
                'nama_rekening' => $kr->nama_rekening,
                'anggaran' => $anggaran,
                'akumulasi' => $sebelum,
                'pencairan' => $saatIni,
                'sisa' => $anggaran - $sebelum - $saatIni,
            ];
        });

        $administrasis = $npd->administrasis->sortBy([['tanggal_nota_persetujuan', 'asc'], ['id', 'asc']]);
        $potongan = [
            'PPN' => (float) $administrasis->sum('ppn'),
            'PPH 21' => (float) $administrasis->sum('pph21'),
            'PPH 22' => 0.0,
            'PPH 23' => (float) $administrasis->sum('pph23'),
            'PPH Pasal 4 (2)' => 0.0,
        ];
        $diminta = (float) $rows->sum('pencairan');
        $totalPotongan = array_sum($potongan);

        $kegiatan = Kegiatan::forSub($subKegiatan->kode_sub);

        return [
            'npd' => $npd,
            'subKegiatan' => $subKegiatan,
            'tahun' => $tahun,
            'kodeKegiatan' => Kegiatan::kodeFromSub($subKegiatan->kode_sub),
            'kodeNomor' => $this->shortKode($subKegiatan->kode_sub),
            'kegiatan' => $kegiatan?->nama ?? '-',
            'program' => $kegiatan?->program ?? 'Program Penunjang Urusan Pemerintahan Daerah Kabupaten/Kota',
            'rows' => $rows,
            'totals' => [
                'anggaran' => (float) $rows->sum('anggaran'),
                'akumulasi' => (float) $rows->sum('akumulasi'),
                'pencairan' => $diminta,
                'sisa' => (float) $rows->sum('sisa'),
            ],
            'potongan' => $potongan,
            'diminta' => $diminta,
            'totalPotongan' => $totalPotongan,
            'dibayarkan' => $diminta - $totalPotongan,
            'sptjbItems' => $administrasis->values(),
            'texts' => NpdTemplate::forYear($tahun),
            'pptk' => $subKegiatan->pptk,
            'kpa' => [
                'nama' => Setting::get('kabag_nama', '-'),
                'nip' => Setting::get('kabag_nip', '-'),
            ],
        ];
    }

    /** 4.01.01.2.06.0009 -> 4.01.01.2.06.09 (segmen terakhir 2 digit). */
    public function shortKode(?string $kodeSub): string
    {
        $parts = explode('.', (string) $kodeSub);
        $last = array_pop($parts);

        if ($parts === [] || ! ctype_digit((string) $last)) {
            return (string) $kodeSub;
        }

        $parts[] = str_pad(ltrim($last, '0') ?: '0', 2, '0', STR_PAD_LEFT);

        return implode('.', $parts);
    }

    public static function terbilang(float $angka, bool $titleCase = false): string
    {
        $kata = trim(TerbilangService::numberToWords($angka));

        return ($titleCase ? ucwords($kata) : ucfirst($kata)) . ' Rupiah';
    }
}
