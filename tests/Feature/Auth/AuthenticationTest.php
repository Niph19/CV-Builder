<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $this->get('/login')->assertOk();
});

test('siswa is redirected to profile data after login', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('profile.data.edit', absolute: false));
});

test('admin is redirected to admin dashboard after login', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->post('/login', [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($admin);
    $response->assertRedirect(route('admin.dashboard', absolute: false));
});

test('users cannot authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('session id is regenerated after login', function () {
    $user = User::factory()->create();

    $this->get('/login');
    $before = session()->getId();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    expect(session()->getId())->not->toBe($before);
});

test('login is rate limited after five failed attempts', function () {
    $user = User::factory()->create();

    foreach (range(1, 5) as $attempt) {
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
    }

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('guests are redirected to login when accessing protected pages', function () {
    $this->get('/profile/data')->assertRedirect('/login');
    $this->get('/admin')->assertRedirect('/login');
    $this->get('/profile')->assertRedirect('/login');
});

test('siswa and alumni cannot access the admin area', function () {
    $admin = User::factory()->admin()->create();
    $siswa = User::factory()->create();
    $alumni = User::factory()->alumni()->create();

    $this->actingAs($siswa)->get('/admin')->assertForbidden();
    $this->actingAs($alumni)->get('/admin')->assertForbidden();
    $this->actingAs($admin)->get('/admin')->assertOk();
});

test('logout invalidates the session', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/logout');

    $this->assertGuest();
});
