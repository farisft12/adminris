<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pptk extends Model
{
    protected $table = 'pptks';

    protected $fillable = ['nama_pptk', 'nip'];

    public function subKegiatans(): HasMany
    {
        return $this->hasMany(SubKegiatan::class, 'pptk_id');
    }
}
