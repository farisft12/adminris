<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sub_kegiatans', function (Blueprint $table) {
            $table->unsignedBigInteger('pptk_id')->nullable()->after('kode_sub');
            $table->foreign('pptk_id')->references('id')->on('pptks')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('sub_kegiatans', function (Blueprint $table) {
            $table->dropForeign(['pptk_id']);
            $table->dropColumn('pptk_id');
        });
    }
};
