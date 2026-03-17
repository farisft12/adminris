<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('npds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_kegiatan_id')->constrained('sub_kegiatans')->cascadeOnDelete();
            $table->string('nomor')->nullable();
            $table->date('tanggal');
            $table->timestamps();

            $table->index('sub_kegiatan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('npds');
    }
};
