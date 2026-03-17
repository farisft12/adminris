<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('npd_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('npd_id')->constrained('npds')->cascadeOnDelete();
            $table->unsignedBigInteger('kode_rekening_id');
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('kode_rekening_id')
                ->references('id')
                ->on('kode_rekenings')
                ->onDelete('cascade');
            $table->unique(['npd_id', 'kode_rekening_id']);
            $table->index('npd_id');
            $table->index('kode_rekening_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('npd_details');
    }
};
