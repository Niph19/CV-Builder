<?php

use App\Enums\UserRole;
use App\Models\User;

test('registration screen can be rendered', function () {
    $this->get('/register')->assertOk();
});

test('status selection only offers siswa and alumni', function () {
    $this->get('/register')
        ->assertSee('Siswa aktif')
        ->assertSee('Alumni')
        ->assertDontSee('value="admin"', false);
});

test('new siswa can register and is assigned the siswa role', function () {
    $response = $this->post('/register', [
        'name' => 'Siswa Baru',
        'email' => 'siswa@example.com',
        'role' => 'siswa',
        'password' => 'Str0ng!Password#2026',
        'password_confirmation' => 'Str0ng!Password#2026',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('profile.data.edit', absolute: false));

    expect(User::where('email', 'siswa@example.com')->first())
        ->role->toBe(UserRole::Siswa);
});

test('new alumni can register and is assigned the alumni role', function () {
    $response = $this->post('/register', [
        'name' => 'Alumni Baru',
        'email' => 'alumni@example.com',
        'role' => 'alumni',
        'password' => 'Str0ng!Password#2026',
        'password_confirmation' => 'Str0ng!Password#2026',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('profile.data.edit', absolute: false));

    $alumni = User::where('email', 'alumni@example.com')->first();

    expect($alumni->role)->toBe(UserRole::Alumni);

    actingAsConfirmed($this, $alumni)->get('/profile/data')->assertOk();
});

test('registration rejects weak passwords', function () {
    $response = $this->post('/register', [
        'name' => 'Siswa Lemah',
        'email' => 'lemah@example.com',
        'role' => 'siswa',
        'password' => 'pendek',
        'password_confirmation' => 'pendek',
    ]);

    $response->assertSessionHasErrors('password');
    $this->assertGuest();
});

test('registration accepts lowercase passwords without symbols', function () {
    $response = $this->post('/register', [
        'name' => 'Siswa Sederhana',
        'email' => 'sederhana@example.com',
        'role' => 'siswa',
        'password' => 'rahasia123',
        'password_confirmation' => 'rahasia123',
    ]);

    $this->assertAuthenticated();
    $response->assertSessionHasNoErrors();
    expect(User::where('email', 'sederhana@example.com')->exists())->toBeTrue();
});

test('registration cannot escalate to admin', function () {
    $response = $this->post('/register', [
        'name' => 'Penyusup',
        'email' => 'penyusup@example.com',
        'role' => 'admin',
        'password' => 'Str0ng!Password#2026',
        'password_confirmation' => 'Str0ng!Password#2026',
    ]);

    $response->assertSessionHasErrors('role');
    $this->assertGuest();
    expect(User::where('email', 'penyusup@example.com')->exists())->toBeFalse();
});
