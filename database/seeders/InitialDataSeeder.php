<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InitialDataSeeder extends Seeder
{
    /**
     * Seeder ini akan memasukkan semua data awal ke database.
     * Setelah selesai dijalankan, file ini akan **menghapus dirinya sendiri** secara otomatis.
     */
    public function run(): void
    {
        // =============================================
        // 1. USERS
        // =============================================
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@example.com', 'email_verified_at' => now(), 'password' => '$2y$12$rjTFV6XAJd6HAAlv1lAxTuOL4qSKGIbqL5eO1WIEnV9CQkd.y66Jq', 'role' => 'admin', 'nip' => null, 'jabatan' => null, 'google_id' => null, 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 00:28:05'],
            ['id' => 2, 'name' => 'Staff', 'email' => 'staff@example.com', 'email_verified_at' => now(), 'password' => '$2y$12$5a5L.DcUe0zYOx4hmeiOSuDfld7i/Rx8dX18RVnFJFxqjn3oRUuqa', 'role' => 'staff', 'nip' => null, 'jabatan' => null, 'google_id' => null, 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 00:28:05'],
            ['id' => 3, 'name' => 'faris', 'email' => 'farisket@gmail.com', 'email_verified_at' => '2026-03-25 16:15:20', 'password' => '$2y$12$sO6A0erMDPMbGm7MQ/hh3.7yJg/Rjgd4LSWDj1pXZSsZkFH8VHgEu', 'role' => 'staff', 'nip' => null, 'jabatan' => null, 'google_id' => null, 'created_at' => '2026-03-03 00:36:53', 'updated_at' => '2026-03-25 16:15:20'],
        ]);

        // =============================================
        // 2. PPTKS
        // =============================================
        DB::table('pptks')->insert([
            ['id' => 1, 'nama_pptk' => 'Ahmad Hamidi, S. Kom', 'nip' => '19871021 201001 1 002', 'created_at' => '2026-03-03 05:23:31', 'updated_at' => '2026-03-03 05:23:31'],
            ['id' => 2, 'nama_pptk' => 'Eldinar Raina Arijadi, A.Md', 'nip' => '19780221 200901 2 001', 'created_at' => '2026-03-03 05:23:50', 'updated_at' => '2026-03-03 05:23:50'],
        ]);

        // =============================================
        // 3. YEARS
        // =============================================
        DB::table('years')->insert([
            ['id' => 1, 'tahun' => 2026, 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 05:18:16'],
            ['id' => 2, 'tahun' => 2025, 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 00:28:05'],
        ]);

        // =============================================
        // 4. SUB KEGIATANS
        // =============================================
        DB::table('sub_kegiatans')->insert([
            ['id' => 1, 'year_id' => 1, 'nama_sub_kegiatan' => 'Pelaksanaan Penatausahaan dan Pengujian/Verifikasi Keuangan SKPD', 'kode_sub' => '4.01.01.2.02.0003', 'pptk_id' => 1, 'anggaran' => 490000, 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 06:08:52'],
            ['id' => 2, 'year_id' => 1, 'nama_sub_kegiatan' => 'Penyediaan Bahan Logistik Kantor', 'kode_sub' => '4.01.01.2.06.0004', 'pptk_id' => 1, 'anggaran' => 114485200, 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 06:08:52'],
            ['id' => 3, 'year_id' => 1, 'nama_sub_kegiatan' => 'Pendidikan dan Pelatihan Pegawai Berdasarkan Tugas dan Fungsi', 'kode_sub' => '4.01.01.2.05.0009', 'pptk_id' => 1, 'anggaran' => 53995000, 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 06:08:52'],
            ['id' => 4, 'year_id' => 1, 'nama_sub_kegiatan' => 'Penyediaan Komponen Instalasi Listrik/Penerangan Bangunan Kantor', 'kode_sub' => '4.01.01.2.06.0001', 'pptk_id' => 1, 'anggaran' => 3500000, 'created_at' => '2026-03-03 05:57:30', 'updated_at' => '2026-03-03 06:08:52'],
            ['id' => 5, 'year_id' => 1, 'nama_sub_kegiatan' => 'Penyelenggaraan Rapat Koordinasi dan Konsultasi SKPD', 'kode_sub' => '4.01.01.2.06.0009', 'pptk_id' => 1, 'anggaran' => 3048440400, 'created_at' => '2026-03-03 06:03:37', 'updated_at' => '2026-03-03 06:08:52'],
            ['id' => 6, 'year_id' => 1, 'nama_sub_kegiatan' => 'Pengadaan Peralatan dan Mesin Lainnya', 'kode_sub' => '4.01.01.2.07.0006', 'pptk_id' => 2, 'anggaran' => 314227000, 'created_at' => '2026-03-03 06:04:24', 'updated_at' => '2026-03-03 06:08:52'],
            ['id' => 7, 'year_id' => 1, 'nama_sub_kegiatan' => 'Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan, dan Pajak Kendaraan Perorangan Dinas atau Kendaraan Dinas Jabatan', 'kode_sub' => '4.01.01.2.09.0001', 'pptk_id' => 2, 'anggaran' => 18720000, 'created_at' => '2026-03-03 06:05:02', 'updated_at' => '2026-03-03 06:08:52'],
            ['id' => 8, 'year_id' => 1, 'nama_sub_kegiatan' => 'Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan, Pajak dan Perizinan Kendaraan Dinas Operasional atau Lapangan', 'kode_sub' => '4.01.01.2.09.0002', 'pptk_id' => 2, 'anggaran' => 98760000, 'created_at' => '2026-03-03 06:05:38', 'updated_at' => '2026-03-03 06:08:52'],
            ['id' => 9, 'year_id' => 1, 'nama_sub_kegiatan' => 'Pemeliharaan Peralatan dan Mesin Lainnya', 'kode_sub' => '4.01.01.2.09.0006', 'pptk_id' => 2, 'anggaran' => 82920000, 'created_at' => '2026-03-03 06:06:25', 'updated_at' => '2026-03-03 06:08:52'],
            ['id' => 10, 'year_id' => 1, 'nama_sub_kegiatan' => 'Fasilitasi Keprotokolan', 'kode_sub' => '4.01.01.2.14.0001', 'pptk_id' => 1, 'anggaran' => 683309000, 'created_at' => '2026-03-03 06:06:52', 'updated_at' => '2026-03-03 06:08:52'],
            ['id' => 11, 'year_id' => 1, 'nama_sub_kegiatan' => 'Pendokumentasian Tugas Pimpinan', 'kode_sub' => '4.01.01.2.14.0003', 'pptk_id' => 2, 'anggaran' => 20518000, 'created_at' => '2026-03-03 06:07:16', 'updated_at' => '2026-03-03 06:08:52'],
        ]);

        // =============================================
        // 5. KODE REKENINGS
        // =============================================
        DB::table('kode_rekenings')->insert([
            ['id' => 1, 'kode_rekening' => '5.1.02.02.001.00042', 'nama_rekening' => 'Belanja Jasa Pelaksanaan Transaksi Keuangan', 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 06:11:01'],
            ['id' => 2, 'kode_rekening' => '5.1.02.02', 'nama_rekening' => 'Belanja Jasa', 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 00:28:05'],
            ['id' => 3, 'kode_rekening' => '5.1.02.01.001.00031', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Listrik', 'created_at' => '2026-03-03 06:12:46', 'updated_at' => '2026-03-03 06:12:46'],
            ['id' => 4, 'kode_rekening' => '5.1.02.01.001.00024', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Tulis Kantor', 'created_at' => '2026-03-03 06:17:40', 'updated_at' => '2026-03-03 06:17:40'],
            ['id' => 5, 'kode_rekening' => '5.1.02.01.001.00025', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover', 'created_at' => '2026-03-03 06:18:53', 'updated_at' => '2026-03-03 06:18:53'],
            ['id' => 6, 'kode_rekening' => '5.1.02.01.001.00027', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Benda Pos', 'created_at' => '2026-03-03 06:19:39', 'updated_at' => '2026-03-03 06:19:39'],
            ['id' => 7, 'kode_rekening' => '5.1.02.01.001.00029', 'nama_rekening' => 'Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer', 'created_at' => '2026-03-03 06:20:29', 'updated_at' => '2026-03-03 06:20:29'],
            ['id' => 8, 'kode_rekening' => '5.1.02.03.002.00133', 'nama_rekening' => 'Belanja Pemeliharaan Alat Studio, Komunikasi, dan Pemancar-Alat Studio-Peralatan Studio Video dan Film', 'created_at' => '2026-03-03 06:23:24', 'updated_at' => '2026-03-03 06:23:24'],
        ]);

        // =============================================
        // 6. ETALASES
        // =============================================
        DB::table('etalases')->insert([
            ['id' => 3, 'kode_rekening_id' => 2, 'nama_etalase' => 'Jasa Konsultan', 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 00:28:05'],
            ['id' => 4, 'kode_rekening_id' => 2, 'nama_etalase' => 'Jasa Lainnya', 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 00:28:05'],
            ['id' => 5, 'kode_rekening_id' => 1, 'nama_etalase' => 'Slip Setoran', 'created_at' => '2026-03-03 06:11:34', 'updated_at' => '2026-03-03 06:11:34'],
            ['id' => 6, 'kode_rekening_id' => 4, 'nama_etalase' => 'Alat tulis Kantor', 'created_at' => '2026-03-03 06:18:22', 'updated_at' => '2026-03-03 06:18:22'],
            ['id' => 7, 'kode_rekening_id' => 5, 'nama_etalase' => 'Kertas', 'created_at' => '2026-03-03 06:19:01', 'updated_at' => '2026-03-03 06:19:01'],
            ['id' => 8, 'kode_rekening_id' => 6, 'nama_etalase' => 'Materai', 'created_at' => '2026-03-03 06:21:17', 'updated_at' => '2026-03-03 06:21:17'],
            ['id' => 9, 'kode_rekening_id' => 7, 'nama_etalase' => 'Tinta', 'created_at' => '2026-03-03 06:21:31', 'updated_at' => '2026-03-03 06:21:31'],
            ['id' => 10, 'kode_rekening_id' => 3, 'nama_etalase' => 'Alat Listrik', 'created_at' => '2026-03-03 06:21:47', 'updated_at' => '2026-03-03 06:21:47'],
            ['id' => 11, 'kode_rekening_id' => 8, 'nama_etalase' => 'Pemeliharaan Kamera', 'created_at' => '2026-03-03 06:23:31', 'updated_at' => '2026-03-03 06:23:31'],
        ]);

        // =============================================
        // 7. KODE REKENING - SUB KEGIATAN (PIVOT)
        // =============================================
        DB::table('kode_rekening_sub_kegiatan')->insert([
            ['sub_kegiatan_id' => 2, 'kode_rekening_id' => 4, 'anggaran' => 16485200],
            ['sub_kegiatan_id' => 2, 'kode_rekening_id' => 5, 'anggaran' => 59120000],
            ['sub_kegiatan_id' => 2, 'kode_rekening_id' => 6, 'anggaran' => 4000000],
            ['sub_kegiatan_id' => 2, 'kode_rekening_id' => 7, 'anggaran' => 34880000],
        ]);

        // =============================================
        // 8. ADMINISTRASIS
        // =============================================
        DB::table('administrasis')->insert([
            ['id' => 3, 'sub_kegiatan_id' => 2, 'no' => 1, 'uraian_belanja' => 'atk', 'tagihan' => 0, 'tanggal_nota_persetujuan' => '2026-03-03', 'kode_rekening_id' => 4, 'etalase_id' => 6, 'ppn' => 0, 'pph23' => 0, 'pph21' => 0, 'keterangan' => null, 'created_by' => 3, 'penerima' => null, 'created_at' => '2026-03-03 07:21:46', 'updated_at' => '2026-03-16 08:17:15'],
            ['id' => 4, 'sub_kegiatan_id' => 2, 'no' => 2, 'uraian_belanja' => 'Belanja Materai 400 Buah', 'tagihan' => 4000000, 'tanggal_nota_persetujuan' => '2026-03-16', 'kode_rekening_id' => 6, 'etalase_id' => 8, 'ppn' => 0, 'pph23' => 0, 'pph21' => 0, 'keterangan' => null, 'created_by' => 3, 'penerima' => null, 'created_at' => '2026-03-16 08:28:29', 'updated_at' => '2026-03-16 08:28:48'],
        ]);

        // =============================================
        // 9. NPDS
        // =============================================
        DB::table('npds')->insert([
            ['id' => 1, 'sub_kegiatan_id' => 2, 'nomor' => '4.01.01.2.06.0004-2026-001', 'tanggal' => '2026-03-16', 'created_at' => '2026-03-16 07:45:57', 'updated_at' => '2026-03-16 07:45:57'],
        ]);

        // =============================================
        // 10. NPD DETAILS
        // =============================================
        DB::table('npd_details')->insert([
            ['id' => 6, 'npd_id' => 1, 'kode_rekening_id' => 6, 'jumlah' => 4000000, 'created_at' => '2026-03-25 13:47:23', 'updated_at' => '2026-03-25 13:47:23'],
        ]);

        // =============================================
        // 11. PERPAJAKAN
        // =============================================
        DB::table('perpajakan')->insert([
            ['id' => 1, 'ppn_rate' => 0.1100, 'pph23_rate' => 0.0200, 'pph21_rate' => 0.0500, 'created_at' => '2026-03-03 04:55:19', 'updated_at' => '2026-03-03 04:55:19'],
        ]);

        // =============================================
        // RESET SEQUENCES (PostgreSQL Auto-Increment)
        // =============================================
        $sequences = [
            'users' => 10,
            'pptks' => 10,
            'years' => 10,
            'sub_kegiatans' => 20,
            'kode_rekenings' => 20,
            'etalases' => 20,
            'administrasis' => 10,
            'npds' => 10,
            'npd_details' => 10,
            'perpajakan' => 10,
        ];

        foreach ($sequences as $table => $val) {
            DB::statement("SELECT setval(pg_get_serial_sequence('{$table}', 'id'), {$val}, true)");
        }

        $this->command->info('✅ Semua data awal berhasil di-seed!');

        // =============================================
        // AUTO-CLEANUP: Hapus file ini setelah selesai
        // =============================================
        $thisFile = __FILE__;
        $this->command->warn("🗑️  Auto-cleanup: Menghapus file seeder '{$thisFile}'...");
        File::delete($thisFile);
        $this->command->info('✅ File seeder berhasil dihapus secara otomatis.');
    }
}
