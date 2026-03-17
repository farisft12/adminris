<?php

namespace Database\Seeders;

use App\Models\Etalase;
use App\Models\KodeRekening;
use App\Models\SubKegiatan;
use App\Models\User;
use App\Models\Year;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);
        User::create([
            'name' => 'Staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STAFF,
        ]);

        $y2024 = Year::create(['tahun' => 2024]);
        $y2025 = Year::create(['tahun' => 2025]);

        SubKegiatan::create(['year_id' => $y2024->id, 'nama_sub_kegiatan' => 'Sub Kegiatan A 2024', 'kode_sub' => 'SK-A']);
        SubKegiatan::create(['year_id' => $y2024->id, 'nama_sub_kegiatan' => 'Sub Kegiatan B 2024', 'kode_sub' => 'SK-B']);
        SubKegiatan::create(['year_id' => $y2025->id, 'nama_sub_kegiatan' => 'Sub Kegiatan A 2025', 'kode_sub' => 'SK-A']);

        $kr1 = KodeRekening::create(['kode_rekening' => '5.1.02.01', 'nama_rekening' => 'Belanja Barang']);
        $kr2 = KodeRekening::create(['kode_rekening' => '5.1.02.02', 'nama_rekening' => 'Belanja Jasa']);

        Etalase::create(['kode_rekening_id' => $kr1->id, 'nama_etalase' => 'Alat Tulis Kantor']);
        Etalase::create(['kode_rekening_id' => $kr1->id, 'nama_etalase' => 'Peralatan']);
        Etalase::create(['kode_rekening_id' => $kr2->id, 'nama_etalase' => 'Jasa Konsultan']);
        Etalase::create(['kode_rekening_id' => $kr2->id, 'nama_etalase' => 'Jasa Lainnya']);
    }
}
