<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perpajakan', function (Blueprint $table) {
            $table->id();
            $table->decimal('ppn_rate', 5, 4)->default(0.11)->comment('Contoh: 0.11 = 11%');
            $table->decimal('pph23_rate', 5, 4)->default(0.02);
            $table->decimal('pph21_rate', 5, 4)->default(0.05);
            $table->timestamps();
        });

        DB::table('perpajakan')->insert([
            'ppn_rate' => 0.11,
            'pph23_rate' => 0.02,
            'pph21_rate' => 0.05,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('perpajakan');
    }
};
