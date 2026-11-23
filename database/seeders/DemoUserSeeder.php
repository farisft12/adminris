<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Akun demo untuk pengujian lokal. Jalankan:
 *   php artisan db:seed --class=DemoUserSeeder
 *
 * Login:
 *   Admin : admin.demo@adminris.test / demo12345
 *   Staf  : staf.demo@adminris.test  / demo12345
 *
 * Password dapat diganti lewat DEMO_USER_PASSWORD di .env.
 * Tidak dijalankan di production karena passwordnya tercatat di repo.
 */
class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isProduction()) {
            $this->command->error('Akun demo tidak boleh dibuat di production.');

            return;
        }

        $password = env('DEMO_USER_PASSWORD', 'demo12345');

        $accounts = [
            ['email' => 'admin.demo@adminris.test', 'name' => 'Admin Demo', 'role' => User::ROLE_ADMIN, 'jabatan' => 'Administrator'],
            ['email' => 'staf.demo@adminris.test', 'name' => 'Staf Demo', 'role' => User::ROLE_STAFF, 'jabatan' => 'Staf'],
        ];

        foreach ($accounts as $account) {
            $user = User::firstOrNew(['email' => $account['email']]);

            // forceFill: email_verified_at tidak ada di $fillable User.
            $user->forceFill([
                'name' => $account['name'],
                'role' => $account['role'],
                'jabatan' => $account['jabatan'],
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'is_active' => true,
                'is_approved' => true,
            ])->save();

            $this->command->info("Akun demo siap: {$account['email']} ({$account['role']})");
        }
    }
}
