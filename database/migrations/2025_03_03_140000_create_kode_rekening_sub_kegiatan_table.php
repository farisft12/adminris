<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kode_rekening_sub_kegiatan', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_kegiatan_id');
            $table->unsignedBigInteger('kode_rekening_id');
            $table->primary(['sub_kegiatan_id', 'kode_rekening_id']);
            $table->foreign('sub_kegiatan_id')->references('id')->on('sub_kegiatans')->onDelete('cascade');
            $table->foreign('kode_rekening_id')->references('id')->on('kode_rekenings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kode_rekening_sub_kegiatan');
    }
};
