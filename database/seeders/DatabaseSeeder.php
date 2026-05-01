<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat akun Bidan Utama
        User::create([
            'name'     => 'Bidan Siti',
            'email'    => 'bidan@klinik.com',
            'password' => Hash::make('password123'), // Ini akan di-encrypt
            'role'     => 'bidan', // Sesuai enum role yang Anda buat
        ]);

        // Opsional: Buat akun Admin
        User::create([
            'name'     => 'Admin Sistem',
            'email'    => 'admin@klinik.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);
    }
}
