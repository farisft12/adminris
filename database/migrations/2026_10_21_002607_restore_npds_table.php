
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hanya dijalankan pada database yang tabel npds-nya hilang (diganti
        // pembayaran). Database baru sudah punya npds, jadi tidak ada yang dipulihkan.
        if (Schema::hasTable('npds') || ! Schema::hasTable('pembayaran')) {
            return;
        }

        DB::transaction(function () {
            // Buat kembali tabel NPD sesuai struktur awal.
            Schema::create('npds', function (Blueprint $table) {
                $table->id();

                $table->foreignId('sub_kegiatan_id')
                    ->constrained('sub_kegiatans')
                    ->cascadeOnDelete();

                $table->string('nomor')->nullable();
                $table->date('tanggal');
                $table->timestamps();

                $table->index('sub_kegiatan_id');
            });

            // Salin data induk, pertahankan ID asli.
            $data = DB::table('pembayaran')
                ->select(
                    'id',
                    'sub_kegiatan_id',
                    'nomor',
                    'tanggal'
                )
                ->orderBy('id')
                ->get()
                ->map(fn ($row) => [
                    'id' => $row->id,
                    'sub_kegiatan_id' => $row->sub_kegiatan_id,
                    'nomor' => $row->nomor,
                    'tanggal' => $row->tanggal,
                    'created_at' => null,
                    'updated_at' => null,
                ])
                ->all();

            foreach (array_chunk($data, 500) as $chunk) {
                DB::table('npds')->insert($chunk);
            }

            // Sinkronkan sequence ID PostgreSQL.
            DB::statement("
                SELECT setval(
                    pg_get_serial_sequence('public.npds', 'id'),
                    COALESCE((SELECT MAX(id) FROM public.npds), 1),
                    EXISTS (SELECT 1 FROM public.npds)
                )
            ");

            // Pastikan seluruh detail memiliki induk.
            $orphanCount = DB::table('npd_details as d')
                ->leftJoin('npds as n', 'n.id', '=', 'd.npd_id')
                ->whereNull('n.id')
                ->count();

            if ($orphanCount > 0) {
                throw new RuntimeException(
                    "Ditemukan {$orphanCount} detail tanpa induk NPD."
                );
            }

            // Alihkan foreign key dari pembayaran ke npds.
            Schema::table('npd_details', function (Blueprint $table) {
                $table->dropForeign(
                    'npd_details_npd_id_foreign'
                );

                $table->foreign('npd_id')
                    ->references('id')
                    ->on('npds')
                    ->cascadeOnDelete();
            });
        });
    }

    public function down(): void
    {
        // Tanpa tabel pembayaran, up() tidak mengubah apa pun; jangan hapus npds asli.
        if (! Schema::hasTable('pembayaran')) {
            return;
        }

        DB::transaction(function () {
            // Kembalikan relasi ke pembayaran jika rollback.
            Schema::table('npd_details', function (Blueprint $table) {
                $table->dropForeign(
                    'npd_details_npd_id_foreign'
                );

                $table->foreign('npd_id')
                    ->references('id')
                    ->on('pembayaran')
                    ->cascadeOnDelete();
            });

            Schema::dropIfExists('npds');
        });
    }
};

