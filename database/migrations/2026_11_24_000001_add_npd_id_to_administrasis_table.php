<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Satu administrasi hanya boleh dicairkan oleh satu NPD.
        Schema::table('administrasis', function (Blueprint $table) {
            $table->foreignId('npd_id')->nullable()->after('sub_kegiatan_id')
                ->constrained('npds')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('administrasis', function (Blueprint $table) {
            $table->dropConstrainedForeignId('npd_id');
        });
    }
};
