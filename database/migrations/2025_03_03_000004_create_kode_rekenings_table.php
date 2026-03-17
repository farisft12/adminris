<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kode_rekenings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode_rekening')->index();
            $table->string('nama_rekening');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kode_rekenings');
    }
};
