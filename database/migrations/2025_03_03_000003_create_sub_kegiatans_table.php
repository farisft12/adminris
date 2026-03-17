<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_kegiatans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('year_id');
            $table->string('nama_sub_kegiatan');
            $table->string('kode_sub');
            $table->timestamps();

            $table->foreign('year_id')
                ->references('id')
                ->on('years')
                ->onDelete('cascade');
            $table->index('year_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_kegiatans');
    }
};
