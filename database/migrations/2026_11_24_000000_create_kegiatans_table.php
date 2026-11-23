<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // mis. 4.01.01.2.06
            $table->string('nama');
            $table->string('program');
            $table->timestamps();
        });

        // Nomenklatur default (Permendagri) untuk kode kegiatan yang dipakai.
        // Admin dapat mengoreksi lewat halaman Pengaturan NPD.
        $program = 'Program Penunjang Urusan Pemerintahan Daerah Kabupaten/Kota';
        $defaults = [
            '4.01.01.2.01' => 'Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah',
            '4.01.01.2.02' => 'Administrasi Keuangan Perangkat Daerah',
            '4.01.01.2.03' => 'Administrasi Barang Milik Daerah pada Perangkat Daerah',
            '4.01.01.2.05' => 'Administrasi Kepegawaian Perangkat Daerah',
            '4.01.01.2.06' => 'Administrasi Umum Perangkat Daerah',
            '4.01.01.2.07' => 'Pengadaan Barang Milik Daerah Penunjang Urusan Pemerintah Daerah',
            '4.01.01.2.08' => 'Penyediaan Jasa Penunjang Urusan Pemerintahan Daerah',
            '4.01.01.2.09' => 'Pemeliharaan Barang Milik Daerah Penunjang Urusan Pemerintahan Daerah',
            '4.01.01.2.11' => 'Fasilitasi Kerumahtanggaan Sekretariat Daerah',
            '4.01.01.2.14' => 'Pelaksanaan Protokol dan Komunikasi Pimpinan',
        ];

        DB::table('kegiatans')->insert(array_map(fn ($kode, $nama) => [
            'kode' => $kode,
            'nama' => $nama,
            'program' => $program,
            'created_at' => now(),
            'updated_at' => now(),
        ], array_keys($defaults), $defaults));
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
