<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etalases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kode_rekening_id');
            $table->string('nama_etalase');
            $table->timestamps();

            $table->foreign('kode_rekening_id')
                ->references('id')
                ->on('kode_rekenings')
                ->onDelete('cascade');
            $table->index('kode_rekening_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etalases');
    }
};
