<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Email dari Google sudah terverifikasi, tetapi dulu email_verified_at
        // tidak tersimpan karena kolom itu tidak ada di $fillable User.
        DB::table('users')
            ->whereNotNull('google_id')
            ->whereNull('email_verified_at')
            ->update(['email_verified_at' => now()]);
    }

    public function down(): void
    {
        // Tidak dipulihkan.
    }
};
