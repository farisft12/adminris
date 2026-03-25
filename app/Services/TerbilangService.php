<?php

namespace App\Services;

class TerbilangService
{
    protected static array $satuan = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
    protected static array $belasan = ['sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
    protected static array $puluhan = ['', '', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];

    public static function numberToWords(float $number): string
    {
        $n = (int) round($number);
        if ($n === 0) {
            return 'nol';
        }
        if ($n < 0) {
            return 'minus ' . self::numberToWords(-$n);
        }
        return self::convert($n);
    }

    private static function convert(int $n): string
    {
        if ($n === 0) {
            return '';
        }
        if ($n < 10) {
            return self::$satuan[$n];
        }
        if ($n < 20) {
            return self::$belasan[$n - 10];
        }
        if ($n < 100) {
            $puluh = (int) floor($n / 10);
            $sisa = $n % 10;
            return trim(self::$puluhan[$puluh] . ' ' . self::convert($sisa));
        }
        if ($n < 200) {
            return trim('seratus ' . self::convert($n - 100));
        }
        if ($n < 1000) {
            $ratus = (int) floor($n / 100);
            $sisa = $n % 100;
            return trim(self::convert($ratus) . ' ratus ' . self::convert($sisa));
        }
        if ($n < 2000) {
            return trim('seribu ' . self::convert($n - 1000));
        }
        if ($n < 1000000) {
            $ribu = (int) floor($n / 1000);
            $sisa = $n % 1000;
            return trim(self::convert($ribu) . ' ribu ' . self::convert($sisa));
        }
        if ($n < 1000000000) {
            $juta = (int) floor($n / 1000000);
            $sisa = $n % 1000000;
            return trim(self::convert($juta) . ' juta ' . self::convert($sisa));
        }
        if ($n < 1000000000000) {
            $miliar = (int) floor($n / 1000000000);
            $sisa = $n % 1000000000;
            return trim(self::convert($miliar) . ' miliar ' . self::convert($sisa));
        }
        return (string) $n;
    }
}
