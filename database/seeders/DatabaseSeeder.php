<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Administrator',
            'email' => 'admin@peminjaman.test',
            'password' => Hash::make('password'),
        ]);

        User::factory()->petugas()->create([
            'name' => 'Petugas Gudang',
            'email' => 'petugas@peminjaman.test',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Peminjam Umum',
            'email' => 'peminjam@peminjaman.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Peminjam,
        ]);
    }
}
