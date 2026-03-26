<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default officials data
        DB::table('settings')->insert([
            ['key' => 'bendahara_nama', 'value' => 'Ahmad Sofa Anwari, S.Ak', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'bendahara_nip', 'value' => '19870129 201001 1 002', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'kabag_nama', 'value' => 'Noorfahmi Arif Ridha, S.STP, MM', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'kabag_nip', 'value' => '19871115 200602 1 001', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
