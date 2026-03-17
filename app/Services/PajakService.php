<?php

namespace App\Services;

use App\Models\Perpajakan;

class PajakService
{
    public const PPN_RATE = 0.11;
    public const PPH23_RATE = 0.02;
    public const PPH21_RATE = 0.05;

    protected function getRates(): array
    {
        try {
            $s = Perpajakan::settings();
            return [
                'ppn' => (float) $s->ppn_rate,
                'pph23' => (float) $s->pph23_rate,
                'pph21' => (float) $s->pph21_rate,
            ];
        } catch (\Throwable) {
            return [
                'ppn' => self::PPN_RATE,
                'pph23' => self::PPH23_RATE,
                'pph21' => self::PPH21_RATE,
            ];
        }
    }

    public function calculatePpn(float $tagihan): float
    {
        $rates = $this->getRates();
        return round($tagihan * $rates['ppn'], 2);
    }

    public function calculatePph23(float $tagihan): float
    {
        $rates = $this->getRates();
        return round($tagihan * $rates['pph23'], 2);
    }

    public function calculatePph21(float $tagihan): float
    {
        $rates = $this->getRates();
        return round($tagihan * $rates['pph21'], 2);
    }

    public function calculateAll(float $tagihan): array
    {
        return [
            'ppn' => $this->calculatePpn($tagihan),
            'pph23' => $this->calculatePph23($tagihan),
            'pph21' => $this->calculatePph21($tagihan),
            'total' => round(
                $tagihan
                + $this->calculatePpn($tagihan)
                + $this->calculatePph23($tagihan)
                + $this->calculatePph21($tagihan),
                2
            ),
        ];
    }
}
