<?php

namespace App\Repositories;

use App\Models\Administrasi;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AdministrasiRepository
{
    public function __construct(
        protected Administrasi $model
    ) {}

    public function paginateWithFilters(?int $yearId = null, ?int $subKegiatanId = null, ?int $kodeRekeningId = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Administrasi::query()
            ->with(['subKegiatan.year', 'kodeRekening', 'etalase', 'createdBy']);

        if ($yearId) {
            $query->whereHas('subKegiatan', fn ($q) => $q->where('year_id', $yearId));
        }
        if ($subKegiatanId) {
            $query->where('sub_kegiatan_id', $subKegiatanId);
        }
        if ($kodeRekeningId) {
            $query->where('kode_rekening_id', $kodeRekeningId);
        }

        return $query->orderByDesc('created_at')->paginate($perPage);
    }

    public function getNextNoForSubKegiatan(int $subKegiatanId): int
    {
        $max = Administrasi::where('sub_kegiatan_id', $subKegiatanId)->max('no');
        return (int) $max + 1;
    }

    public function find(int $id): ?Administrasi
    {
        return Administrasi::with(['subKegiatan.year', 'kodeRekening', 'etalase', 'createdBy'])->find($id);
    }

    public function getRekapTotal(?\Illuminate\Database\Eloquent\Builder $query = null): array
    {
        $q = $query ?? Administrasi::query();
        return [
            'tagihan' => (float) $q->clone()->sum('tagihan'),
            'ppn' => (float) $q->clone()->sum('ppn'),
            'pph23' => (float) $q->clone()->sum('pph23'),
            'pph21' => (float) $q->clone()->sum('pph21'),
        ];
    }

    public function getRekapForPaginator(LengthAwarePaginator $paginator): array
    {
        $baseQuery = Administrasi::query();
        if ($paginator->getOptions()['path']) {
            $yearId = request('year_id');
            $subKegiatanId = request('sub_kegiatan_id');
            $kodeRekeningId = request('kode_rekening_id');
            if ($yearId) {
                $baseQuery->whereHas('subKegiatan', fn ($q) => $q->where('year_id', $yearId));
            }
            if ($subKegiatanId) {
                $baseQuery->where('sub_kegiatan_id', $subKegiatanId);
            }
            if ($kodeRekeningId) {
                $baseQuery->where('kode_rekening_id', $kodeRekeningId);
            }
        }
        $sums = $this->getRekapTotal($baseQuery);
        $sums['total'] = $sums['tagihan'] + $sums['ppn'] + $sums['pph23'] + $sums['pph21'];
        $sums['total_bersih'] = $sums['tagihan'] - $sums['ppn'] - $sums['pph23'] - $sums['pph21'];
        return $sums;
    }
}
