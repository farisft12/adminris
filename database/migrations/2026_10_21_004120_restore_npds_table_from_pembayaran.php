
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Sama dengan migration 2026_10_21_002607: lewati jika tidak ada yang dipulihkan.
        if (Schema::hasTable('npds') || ! Schema::hasTable('pembayaran')) {
            return;
        }

        foreach (['id', 'sub_kegiatan_id', 'nomor', 'tanggal'] as $column) {
            if (!Schema::hasColumn('pembayaran', $column)) {
                throw new \RuntimeException(
                    "Kolom pembayaran.$column tidak ditemukan."
                );
            }
        }

        DB::transaction(function () {
            Schema::create('npds', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sub_kegiatan_id')
                    ->constrained('sub_kegiatans')
                    ->cascadeOnDelete();
                $table->string('nomor')->nullable();
                $table->date('tanggal');
                $table->timestamps();
                $table->index('sub_kegiatan_id', 'npds_sub_kegiatan_id_restore_index');
            });

            // Pertahankan ID agar npd_details tetap terhubung.
            DB::statement("
                INSERT INTO npds
                    (id, sub_kegiatan_id, nomor, tanggal,
                     created_at, updated_at)
                SELECT
                    id, sub_kegiatan_id, nomor, tanggal,
                    NULL, NULL
                FROM pembayaran
                ORDER BY id
            ");

            $orphanCount = DB::table('npd_details as d')
                ->leftJoin('npds as n', 'n.id', '=', 'd.npd_id')
                ->whereNull('n.id')
                ->count();

            if ($orphanCount > 0) {
                throw new \RuntimeException(
                    "Ditemukan {$orphanCount} detail tanpa induk NPD."
                );
            }

            DB::statement("
                SELECT setval(
                    pg_get_serial_sequence('public.npds', 'id'),
                    COALESCE((SELECT MAX(id) FROM npds), 1),
                    EXISTS (SELECT 1 FROM npds)
                )
            ");

            Schema::table('npd_details', function (Blueprint $table) {
                $table->dropForeign('npd_details_npd_id_foreign');

                $table->foreign('npd_id')
                    ->references('id')
                    ->on('npds')
                    ->cascadeOnDelete();
            });
        });
    }

    public function down(): void
    {
        // Pada database hasil pemulihan, rollback diblokir agar npds tidak terhapus.
        if (Schema::hasTable('pembayaran')) {
            throw new \RuntimeException(
                'Pemulihan npds tidak dibatalkan otomatis demi keamanan data.'
            );
        }
    }
};

