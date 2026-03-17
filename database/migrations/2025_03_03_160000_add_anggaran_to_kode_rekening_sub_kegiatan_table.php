<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kode_rekening_sub_kegiatan', function (Blueprint $table) {
            $table->decimal('anggaran', 15, 2)->default(0)->after('kode_rekening_id');
        });
    }

    public function down(): void
    {
        Schema::table('kode_rekening_sub_kegiatan', function (Blueprint $table) {
            $table->dropColumn('anggaran');
        });
    }
};
