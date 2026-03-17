<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NpdDetail extends Model
{
    protected $table = 'npd_details';

    protected $fillable = ['npd_id', 'kode_rekening_id', 'jumlah'];

    protected $casts = [
        'jumlah' => 'decimal:2',
    ];

    public function npd(): BelongsTo
    {
        return $this->belongsTo(Npd::class, 'npd_id');
    }

    public function kodeRekening(): BelongsTo
    {
        return $this->belongsTo(KodeRekening::class, 'kode_rekening_id');
    }
}
