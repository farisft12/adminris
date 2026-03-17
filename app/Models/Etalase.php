<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etalase extends Model
{
    protected $fillable = ['kode_rekening_id', 'nama_etalase'];

    public function kodeRekening(): BelongsTo
    {
        return $this->belongsTo(KodeRekening::class, 'kode_rekening_id');
    }

    public function administrasis(): HasMany
    {
        return $this->hasMany(Administrasi::class, 'etalase_id');
    }
}
