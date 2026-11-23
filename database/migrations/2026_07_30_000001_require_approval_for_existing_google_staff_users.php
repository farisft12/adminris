<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Akun Google staf yang dibuat sebelum alur persetujuan diberlakukan
        // perlu disetujui admin terlebih dahulu.
        DB::table('users')
            ->where('role', User::ROLE_STAFF)
            ->whereNotNull('google_id')
            ->update(['is_approved' => false]);
    }

    public function down(): void
    {
        // Status persetujuan harus ditentukan admin, sehingga tidak dipulihkan otomatis.
    }
};
