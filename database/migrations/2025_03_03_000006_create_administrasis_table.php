<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administrasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sub_kegiatan_id');
            $table->integer('no');
            $table->text('uraian_belanja');
            $table->decimal('tagihan', 15, 2);
            $table->date('tanggal_nota_persetujuan');
            $table->unsignedBigInteger('kode_rekening_id');
            $table->unsignedBigInteger('etalase_id');
            $table->decimal('ppn', 15, 2)->nullable();
            $table->decimal('pph23', 15, 2)->nullable();
            $table->decimal('pph21', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('sub_kegiatan_id')
                ->references('id')
                ->on('sub_kegiatans')
                ->onDelete('cascade');
            $table->foreign('kode_rekening_id')
                ->references('id')
                ->on('kode_rekenings')
                ->onDelete('cascade');
            $table->foreign('etalase_id')
                ->references('id')
                ->on('etalases')
                ->onDelete('cascade');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->index('sub_kegiatan_id');
            $table->index('kode_rekening_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administrasis');
    }
};
