<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hanya admin yang dapat langsung memakai sistem. Semua akun pengguna,
        // termasuk akun lama, harus melewati persetujuan admin.
        DB::table('users')
            ->where('role', '!=', User::ROLE_ADMIN)
            ->update(['is_approved' => false]);
    }

    public function down(): void
    {
        // Persetujuan akun tidak dipulihkan otomatis.
    }
};
