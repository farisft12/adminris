<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = ['kode', 'nama', 'program'];

    /** Kode kegiatan dari kode sub kegiatan: 4.01.01.2.06.0009 -> 4.01.01.2.06 */
    public static function kodeFromSub(?string $kodeSub): string
    {
        $parts = explode('.', (string) $kodeSub);

        return count($parts) > 1 ? implode('.', array_slice($parts, 0, -1)) : (string) $kodeSub;
    }

    public static function forSub(?string $kodeSub): ?self
    {
        return static::where('kode', static::kodeFromSub($kodeSub))->first();
    }
}
