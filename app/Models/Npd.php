<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Npd extends Model
{
    protected $table = 'npds';

    protected $fillable = ['sub_kegiatan_id', 'nomor', 'tanggal'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function subKegiatan(): BelongsTo
    {
        return $this->belongsTo(SubKegiatan::class, 'sub_kegiatan_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(NpdDetail::class, 'npd_id');
    }

    /** Administrasi yang dicairkan oleh NPD ini (dasar SPTJB & potongan). */
    public function administrasis(): HasMany
    {
        return $this->hasMany(Administrasi::class, 'npd_id');
    }

    /**
     * Pencairan per kode rekening = total tagihan administrasi yang terhubung.
     * Hanya dipanggil untuk NPD yang (pernah) terhubung ke administrasi, sehingga
     * NPD lama yang diisi manual tidak tersentuh.
     */
    public function recalculateDetails(): void
    {
        $totals = $this->administrasis()
            ->selectRaw('kode_rekening_id, SUM(tagihan) as total')
            ->groupBy('kode_rekening_id')
            ->pluck('total', 'kode_rekening_id');

        $this->details()->delete();

        foreach ($totals as $kodeRekeningId => $total) {
            $this->details()->create(['kode_rekening_id' => $kodeRekeningId, 'jumlah' => $total]);
        }
    }
}
