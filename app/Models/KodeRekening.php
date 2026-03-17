<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KodeRekening extends Model
{
    protected $table = 'kode_rekenings';

    protected $fillable = ['kode_rekening', 'nama_rekening'];

    public function etalases(): HasMany
    {
        return $this->hasMany(Etalase::class, 'kode_rekening_id');
    }

    public function administrasis(): HasMany
    {
        return $this->hasMany(Administrasi::class, 'kode_rekening_id');
    }

    public function subKegiatans(): BelongsToMany
    {
        return $this->belongsToMany(SubKegiatan::class, 'kode_rekening_sub_kegiatan')->withPivot('anggaran');
    }
}
