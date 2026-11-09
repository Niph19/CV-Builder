<?php

use App\Enums\UserRole;
use App\Models\User;

test('registration screen can be rendered', function () {
    $this->get('/register')->assertOk();
});

test('new users can register and are assigned the siswa role', function () {
    $response = $this->post('/register', [
        'name' => 'Siswa Baru',
        'email' => 'siswa@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    expect(User::where('email', 'siswa@example.com')->first())
        ->role->toBe(UserRole::Siswa);
});

test('registration cannot set role to admin', function () {
    $this->post('/register', [
        'name' => 'Penyusup',
        'email' => 'penyusup@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'admin',
    ]);

    expect(User::where('email', 'penyusup@example.com')->first())
        ->role->toBe(UserRole::Siswa);
});
