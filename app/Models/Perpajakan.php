<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perpajakan extends Model
{
    protected $table = 'perpajakan';

    protected $fillable = ['ppn_rate', 'pph23_rate', 'pph21_rate'];

    protected function casts(): array
    {
        return [
            'ppn_rate' => 'float',
            'pph23_rate' => 'float',
            'pph21_rate' => 'float',
        ];
    }

    public static function settings(): self
    {
        $row = self::first();
        if ($row) {
            return $row;
        }
        return self::create([
            'ppn_rate' => 0.11,
            'pph23_rate' => 0.02,
            'pph21_rate' => 0.05,
        ]);
    }
}
