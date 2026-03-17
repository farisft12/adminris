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
}
