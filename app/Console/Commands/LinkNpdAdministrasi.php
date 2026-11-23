<?php

namespace App\Console\Commands;

use App\Models\Administrasi;
use App\Models\Npd;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Menghubungkan NPD lama (diisi angka manual) ke data administrasinya.
 * Cocok jika, untuk setiap kode rekening di NPD, ada administrasi yang belum
 * terhubung dengan total tagihan persis sama dengan pencairannya.
 */
class LinkNpdAdministrasi extends Command
{
    protected $signature = 'npd:link-administrasi {--force : Simpan hasil pencocokan (tanpa ini hanya laporan)}';

    protected $description = 'Hubungkan NPD lama ke administrasi berdasarkan nominal yang cocok persis.';

    private const MAX_CANDIDATES = 16;

    public function handle(): int
    {
        $linkedNpdIds = Administrasi::whereNotNull('npd_id')->distinct()->pluck('npd_id');
        $npds = Npd::with('details')->whereNotIn('id', $linkedNpdIds)->orderBy('tanggal')->orderBy('id')->get();

        $claimed = [];
        $plan = [];
        $failed = [];

        foreach ($npds as $npd) {
            $picked = $this->matchNpd($npd, $claimed);

            if ($picked === null) {
                $failed[] = $npd;
                continue;
            }

            $plan[$npd->id] = $picked;
            array_push($claimed, ...$picked);
        }

        $this->info('NPD belum terhubung: ' . $npds->count());
        $this->info('Cocok otomatis: ' . count($plan) . ' NPD (' . count($claimed) . ' administrasi)');

        if ($failed !== []) {
            $this->warn('Tidak cocok (hubungkan manual lewat Edit NPD): ' . count($failed));
            $this->table(['npd id', 'nomor', 'tanggal', 'sub kegiatan id', 'total'], collect($failed)->map(fn (Npd $n) => [
                $n->id, $n->nomor, $n->tanggal->toDateString(), $n->sub_kegiatan_id, number_format($n->details->sum('jumlah'), 0, ',', '.'),
            ]));
        }

        if (! $this->option('force')) {
            $this->warn('Mode laporan saja. Jalankan ulang dengan --force untuk menyimpan.');

            return self::SUCCESS;
        }

        DB::transaction(function () use ($plan) {
            foreach ($plan as $npdId => $administrasiIds) {
                Administrasi::whereIn('id', $administrasiIds)->whereNull('npd_id')->update(['npd_id' => $npdId]);
            }
        });

        $this->info('Tersimpan.');

        return self::SUCCESS;
    }

    /** @return int[]|null id administrasi, atau null jika ada kode rekening yang tidak cocok */
    private function matchNpd(Npd $npd, array $claimed): ?array
    {
        if ($npd->details->isEmpty()) {
            return null;
        }

        $picked = [];

        foreach ($npd->details as $detail) {
            $candidates = Administrasi::query()
                ->where('sub_kegiatan_id', $npd->sub_kegiatan_id)
                ->where('kode_rekening_id', $detail->kode_rekening_id)
                ->whereNull('npd_id')
                ->whereNotIn('id', array_merge($claimed, $picked))
                ->get(['id', 'tagihan', 'tanggal_nota_persetujuan'])
                // Yang tanggalnya paling dekat dengan tanggal NPD dicoba lebih dulu.
                ->sortBy(fn ($a) => abs($a->tanggal_nota_persetujuan?->diffInDays($npd->tanggal, false) ?? 9999))
                ->take(self::MAX_CANDIDATES)
                ->values();

            $subset = $this->findSubset($candidates, (int) round($detail->jumlah));

            if ($subset === null) {
                return null;
            }

            array_push($picked, ...$subset);
        }

        return $picked;
    }

    /**
     * Subset terkecil yang totalnya = target, dibandingkan dalam rupiah bulat
     * (beberapa tagihan tersimpan dengan selisih sen, mis. 11.799.999,98).
     */
    private function findSubset(Collection $candidates, int $target): ?array
    {
        $values = $candidates->map(fn ($a) => (int) round($a->tagihan))->all();
        $ids = $candidates->pluck('id')->all();
        $n = count($values);

        for ($size = 1; $size <= $n; $size++) {
            $found = $this->combination($values, $ids, $target, $size, 0, []);
            if ($found !== null) {
                return $found;
            }
        }

        return null;
    }

    private function combination(array $values, array $ids, int $remaining, int $size, int $start, array $chosen): ?array
    {
        if (count($chosen) === $size) {
            return $remaining === 0 ? $chosen : null;
        }

        for ($i = $start; $i < count($values); $i++) {
            if ($values[$i] > $remaining) {
                continue;
            }
            $result = $this->combination($values, $ids, $remaining - $values[$i], $size, $i + 1, [...$chosen, $ids[$i]]);
            if ($result !== null) {
                return $result;
            }
        }

        return null;
    }
}
