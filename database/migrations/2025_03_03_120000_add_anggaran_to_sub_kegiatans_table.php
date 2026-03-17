<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sub_kegiatans', function (Blueprint $table) {
            $table->decimal('anggaran', 15, 2)->default(0)->after('kode_sub');
        });
    }

    public function down(): void
    {
        Schema::table('sub_kegiatans', function (Blueprint $table) {
            $table->dropColumn('anggaran');
        });
    }
};
