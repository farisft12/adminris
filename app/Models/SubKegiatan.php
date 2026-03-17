<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubKegiatan extends Model
{
    protected $fillable = ['year_id', 'nama_sub_kegiatan', 'kode_sub', 'anggaran', 'pptk_id'];

    protected $casts = [
        'anggaran' => 'decimal:2',
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function pptk(): BelongsTo
    {
        return $this->belongsTo(Pptk::class, 'pptk_id');
    }

    public function administrasis(): HasMany
    {
        return $this->hasMany(Administrasi::class, 'sub_kegiatan_id');
    }

    public function kodeRekenings(): BelongsToMany
    {
        return $this->belongsToMany(KodeRekening::class, 'kode_rekening_sub_kegiatan')
            ->withPivot('anggaran');
    }

    public function npds(): HasMany
    {
        return $this->hasMany(Npd::class, 'sub_kegiatan_id');
    }
}
