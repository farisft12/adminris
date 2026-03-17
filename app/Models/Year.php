<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Year extends Model
{
    protected $fillable = ['tahun'];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
        ];
    }

    public function subKegiatans(): HasMany
    {
        return $this->hasMany(SubKegiatan::class, 'year_id');
    }
}
