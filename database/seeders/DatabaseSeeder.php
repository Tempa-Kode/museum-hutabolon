<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Super Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'hak_akses' => 'admin',
        ]);

        User::create([
            'nama' => 'Pengelola Konten',
            'email' => 'contentadmin@mail.com',
            'password' => bcrypt('password'),
            'hak_akses' => 'pengelola-konten',
        ]);

        User::create([
            'nama' => 'Tamu Test',
            'email' => 'guest@mail.com',
            'password' => bcrypt('password'),
            'hak_akses' => 'tamu',
        ]);
    }
}
