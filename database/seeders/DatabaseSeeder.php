<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * PERINGATAN: menghapus seluruh data master & transaksi (kecuali users).
     */
    public function run(): void
    {
        if (app()->isProduction()) {
            $this->command->error('Seeder ini menghapus data dan tidak boleh dijalankan di production.');

            return;
        }

        if (DB::table('sub_kegiatans')->exists()
            && ! $this->command->confirm('Database sudah berisi data. Hapus semua data (kecuali users) dan isi ulang?', false)) {
            $this->command->warn('Seeder dibatalkan.');

            return;
        }

        // =============================================
        // 0. TRUNCATE ALL TABLES (WIPE DATA)
        // =============================================
        $this->command->info('🧹 Menghapus data lama...');

        // Disable foreign key checks for PostgreSQL (session level)
        DB::statement("SET session_replication_role = 'replica';");

        $tables = [
            'npd_details',
            'npds',
            'administrasis',
            'kode_rekening_sub_kegiatan',
            'etalases',
            'kode_rekenings',
            'sub_kegiatans',
            'years',
            'pptks',
            'perpajakan',
            'settings',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        // Re-enable foreign key checks
        DB::statement("SET session_replication_role = 'origin';");


        // =============================================
        // 2. PPTKS
        // =============================================
        $this->command->info('👔 Seeding PPTKs...');
        DB::table('pptks')->insert([
            ['id' => 1, 'nama_pptk' => 'Ahmad Hamidi, S. Kom', 'nip' => '19871021 201001 1 002', 'created_at' => '2026-03-03 05:23:31', 'updated_at' => '2026-03-03 05:23:31'],
            ['id' => 2, 'nama_pptk' => 'Eldinar Raina Arijadi, A.Md', 'nip' => '19780221 200901 2 001', 'created_at' => '2026-03-03 05:23:50', 'updated_at' => '2026-03-03 05:23:50'],
        ]);

        // =============================================
        // 3. YEARS
        // =============================================
        $this->command->info('🗓️ Seeding Years...');
        DB::table('years')->insert([
            ['id' => 1, 'tahun' => 2026, 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 05:18:16'],
            ['id' => 2, 'tahun' => 2025, 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 00:28:05'],
        ]);

        // =============================================
        // 4. SUB KEGIATANS
        // =============================================
        $this->command->info('📂 Seeding Sub Kegiatans...');
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
        $this->command->info('💳 Seeding Kode Rekenings...');
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
        $this->command->info('🏪 Seeding Etalases...');
        DB::table('etalases')->insert([
            ['id' => 1, 'kode_rekening_id' => 2, 'nama_etalase' => 'Jasa Konsultan', 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 00:28:05'],
            ['id' => 2, 'kode_rekening_id' => 2, 'nama_etalase' => 'Jasa Lainnya', 'created_at' => '2026-03-03 00:28:05', 'updated_at' => '2026-03-03 00:28:05'],
            ['id' => 3, 'kode_rekening_id' => 1, 'nama_etalase' => 'Slip Setoran', 'created_at' => '2026-03-03 06:11:34', 'updated_at' => '2026-03-03 06:11:34'],
            ['id' => 4, 'kode_rekening_id' => 4, 'nama_etalase' => 'Alat tulis Kantor', 'created_at' => '2026-03-03 06:18:22', 'updated_at' => '2026-03-03 06:18:22'],
            ['id' => 5, 'kode_rekening_id' => 5, 'nama_etalase' => 'Kertas', 'created_at' => '2026-03-03 06:19:01', 'updated_at' => '2026-03-03 06:19:01'],
            ['id' => 6, 'kode_rekening_id' => 6, 'nama_etalase' => 'Materai', 'created_at' => '2026-03-03 06:21:17', 'updated_at' => '2026-03-03 06:21:17'],
            ['id' => 7, 'kode_rekening_id' => 7, 'nama_etalase' => 'Tinta', 'created_at' => '2026-03-03 06:21:31', 'updated_at' => '2026-03-03 06:21:31'],
            ['id' => 8, 'kode_rekening_id' => 3, 'nama_etalase' => 'Alat Listrik', 'created_at' => '2026-03-03 06:21:47', 'updated_at' => '2026-03-03 06:21:47'],
            ['id' => 9, 'kode_rekening_id' => 8, 'nama_etalase' => 'Pemeliharaan Kamera', 'created_at' => '2026-03-03 06:23:31', 'updated_at' => '2026-03-03 06:23:31'],
        ]);

        // =============================================
        // 7. KODE REKENING - SUB KEGIATAN (PIVOT)
        // =============================================
        $this->command->info('🖇️ Seeding Pivot Table Budget...');
        DB::table('kode_rekening_sub_kegiatan')->insert([
            ['sub_kegiatan_id' => 2, 'kode_rekening_id' => 4, 'anggaran' => 16485200],
            ['sub_kegiatan_id' => 2, 'kode_rekening_id' => 5, 'anggaran' => 59120000],
            ['sub_kegiatan_id' => 2, 'kode_rekening_id' => 6, 'anggaran' => 4000000],
            ['sub_kegiatan_id' => 2, 'kode_rekening_id' => 7, 'anggaran' => 34880000],
        ]);



        // =============================================
        // 10. PERPAJAKAN
        // =============================================
        $this->command->info('💸 Seeding Perpajakan...');
        DB::table('perpajakan')->insert([
            ['id' => 1, 'ppn_rate' => 0.1100, 'pph23_rate' => 0.0200, 'pph21_rate' => 0.0500, 'created_at' => '2026-03-03 04:55:19', 'updated_at' => '2026-03-03 04:55:19'],
        ]);

        // =============================================
        // 11. SETTINGS
        // =============================================
        $this->command->info('⚙️ Seeding Settings...');
        DB::table('settings')->insert([
            ['id' => 1, 'key' => 'bendahara_nama', 'value' => 'Ahmad Sofa Anwari, S.Ak', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'key' => 'bendahara_nip', 'value' => '19870129 201001 1 002', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'key' => 'kabag_nama', 'value' => 'Noorfahmi Arif Ridha, S.STP, MM', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'key' => 'kabag_nip', 'value' => '19871115 200602 1 001', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =============================================
        // RESET SEQUENCES (PostgreSQL Auto-Increment)
        // =============================================
        $this->command->info('🔄 Resetting Sequences (PostgreSQL)...');
        $sequences = [

            'pptks' => 10,
            'years' => 10,
            'sub_kegiatans' => 20,
            'kode_rekenings' => 20,
            'etalases' => 20,

            'perpajakan' => 10,
            'settings' => 10,
        ];

        foreach ($sequences as $table => $val) {
            DB::statement("SELECT setval(pg_get_serial_sequence('{$table}', 'id'), {$val}, true)");
        }

        $this->ensureAdminExists();

        $this->command->info('✅ Database Seeding Completed!');
    }

    private function ensureAdminExists(): void
    {
        if (User::where('role', User::ROLE_ADMIN)->exists()) {
            return;
        }

        $email = env('SEED_ADMIN_EMAIL', 'admin@example.com');
        $password = env('SEED_ADMIN_PASSWORD') ?: Str::random(16);

        User::forceCreate([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
            'is_active' => true,
            'is_approved' => true,
        ]);

        $this->command->warn("👤 Admin dibuat: {$email} / {$password} (segera ganti password).");
    }
}
