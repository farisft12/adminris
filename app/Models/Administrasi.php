<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Administrasi extends Model
{
    protected $fillable = [
        'sub_kegiatan_id',
        'no',
        'uraian_belanja',
        'tagihan',
        'tanggal_nota_persetujuan',
        'kode_rekening_id',
        'etalase_id',
        'ppn',
        'pph23',
        'pph21',
        'keterangan',
        'penerima',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tagihan' => 'decimal:2',
            'ppn' => 'decimal:2',
            'pph23' => 'decimal:2',
            'pph21' => 'decimal:2',
            'tanggal_nota_persetujuan' => 'date',
        ];
    }

    protected static function booted(): void
    {
        // Pindah sub kegiatan = keluar dari NPD lamanya (NPD per sub kegiatan).
        static::updating(function (self $administrasi) {
            if ($administrasi->npd_id && $administrasi->isDirty('sub_kegiatan_id')) {
                $administrasi->npd_id = null;
            }
        });

        // Jaga total NPD tetap sama dengan tagihan administrasi yang terhubung.
        static::saved(function (self $administrasi) {
            if (! $administrasi->wasChanged(['tagihan', 'kode_rekening_id', 'npd_id', 'sub_kegiatan_id'])) {
                return;
            }

            $npdIds = array_filter([$administrasi->npd_id, $administrasi->getOriginal('npd_id')]);
            Npd::whereIn('id', array_unique($npdIds))->get()->each->recalculateDetails();
        });

        static::deleted(function (self $administrasi) {
            if ($administrasi->npd_id) {
                Npd::find($administrasi->npd_id)?->recalculateDetails();
            }
        });
    }

    public function subKegiatan(): BelongsTo
    {
        return $this->belongsTo(SubKegiatan::class, 'sub_kegiatan_id');
    }

    public function npd(): BelongsTo
    {
        return $this->belongsTo(Npd::class, 'npd_id');
    }

    public function kodeRekening(): BelongsTo
    {
        return $this->belongsTo(KodeRekening::class, 'kode_rekening_id');
    }

    public function etalase(): BelongsTo
    {
        return $this->belongsTo(Etalase::class, 'etalase_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** Total setelah pajak dipotong: Tagihan - (PPN + PPH23 + PPH21) */
    public function getTotalBersihAttribute(): float
    {
        $tagihan = (float) $this->tagihan;
        $pajak = (float) ($this->ppn ?? 0) + (float) ($this->pph23 ?? 0) + (float) ($this->pph21 ?? 0);
        return $tagihan - $pajak;
    }
}
