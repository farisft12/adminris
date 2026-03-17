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

    public function subKegiatan(): BelongsTo
    {
        return $this->belongsTo(SubKegiatan::class, 'sub_kegiatan_id');
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

    public function getTotalAttribute(): float
    {
        $tagihan = (float) $this->tagihan;
        $ppn = (float) ($this->ppn ?? 0);
        $pph23 = (float) ($this->pph23 ?? 0);
        $pph21 = (float) ($this->pph21 ?? 0);
        return $tagihan + $ppn + $pph23 + $pph21;
    }

    /** Total setelah pajak dipotong: Tagihan - (PPN + PPH23 + PPH21) */
    public function getTotalBersihAttribute(): float
    {
        $tagihan = (float) $this->tagihan;
        $pajak = (float) ($this->ppn ?? 0) + (float) ($this->pph23 ?? 0) + (float) ($this->pph21 ?? 0);
        return $tagihan - $pajak;
    }
}
