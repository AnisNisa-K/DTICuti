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
        // User::factory(10)->create();

        User::create([
            'gambar' => 'user.png',
            'name' => 'Rika Rianti',
            'username' => 'Rika Rianti',
            'email' => 'rriantisari31@gmail.com',
            'password' => bcrypt('Dwimetal2019'),
            'posisi' => 'HRGA',
        ]);
    }
}
