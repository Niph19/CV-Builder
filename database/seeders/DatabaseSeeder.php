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
            'name' => 'Admin Pesat',
            'email' => 'admin@pesat.sch.id',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
        ]);

        User::factory()->create([
            'name' => 'Siswa Demo',
            'email' => 'siswa@pesat.sch.id',
            'password' => Hash::make('password'),
            'role' => UserRole::Siswa,
        ]);
    }
}
