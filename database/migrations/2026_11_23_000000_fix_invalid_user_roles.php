<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Dropdown role lama menyimpan nilai 'user' yang tidak dikenal sistem.
        DB::table('users')
            ->whereNotIn('role', [User::ROLE_ADMIN, User::ROLE_STAFF])
            ->update(['role' => User::ROLE_STAFF]);
    }

    public function down(): void
    {
        // Nilai role yang tidak valid tidak dipulihkan.
    }
};
