<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin Pesat', 'email' => 'admin@pesat.sch.id', 'role' => UserRole::Admin],
            ['name' => 'Siswa Demo', 'email' => 'siswa@pesat.sch.id', 'role' => UserRole::Siswa],
            ['name' => 'Alumni Demo', 'email' => 'alumni@pesat.sch.id', 'role' => UserRole::Alumni],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => Hash::make('password'),
                ],
            );
        }
    }
}
