<?php

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

test('users can obtain an api token with role based abilities', function () {
    $siswa = User::factory()->create();

    $response = $this->postJson('/api/auth/token', [
        'email' => $siswa->email,
        'password' => 'password',
        'device_name' => 'android-app',
    ]);

    $response->assertCreated()
        ->assertJson(['abilities' => ['siswa']])
        ->assertJsonStructure(['token', 'abilities', 'expires_at']);

    expect($response->json('token'))->toMatch('/^\d+\|cvb_/');
    expect($siswa->tokens)->toHaveCount(1);
});

test('admin tokens receive the admin ability', function () {
    $admin = User::factory()->admin()->create();

    $this->postJson('/api/auth/token', [
        'email' => $admin->email,
        'password' => 'password',
        'device_name' => 'admin-cli',
    ])->assertCreated()->assertJson(['abilities' => ['admin']]);
});

test('tokens are not issued with wrong credentials', function () {
    $user = User::factory()->create();

    $this->postJson('/api/auth/token', [
        'email' => $user->email,
        'password' => 'wrong-password',
        'device_name' => 'attacker',
    ])->assertUnprocessable();

    expect($user->tokens)->toHaveCount(0);
});

test('token issuance is rate limited', function () {
    $user = User::factory()->create();

    foreach (range(1, 5) as $attempt) {
        $this->postJson('/api/auth/token', [
            'email' => $user->email,
            'password' => 'wrong-password',
            'device_name' => 'brute',
        ]);
    }

    $this->postJson('/api/auth/token', [
        'email' => $user->email,
        'password' => 'password',
        'device_name' => 'brute',
    ])->assertTooManyRequests();
});

test('the api requires a token', function () {
    $this->getJson('/api/me')->assertUnauthorized();
});

test('a valid token can access the api and returns the user role', function () {
    $user = User::factory()->create();
    $token = $user->createToken('app', ['siswa'])->plainTextToken;

    $this->withToken($token)
        ->getJson('/api/me')
        ->assertOk()
        ->assertJson([
            'id' => $user->id,
            'email' => $user->email,
            'role' => 'siswa',
        ]);
});

test('tokens can be revoked', function () {
    $user = User::factory()->create();
    $token = $user->createToken('app', ['siswa'])->plainTextToken;

    $this->withToken($token)->deleteJson('/api/auth/token')->assertOk();

    expect(PersonalAccessToken::count())->toBe(0);
});

test('tokens expire', function () {
    $user = User::factory()->create();
    $token = $user->createToken('app', ['siswa'], now()->addDay());

    expect($token->accessToken->expires_at->isFuture())->toBeTrue();
});

test('security headers are present on responses', function () {
    $this->get('/login')
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('X-Frame-Options', 'DENY')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
        ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

    expect($this->get('/login')->headers->get('Content-Security-Policy'))
        ->toContain("default-src 'self'")
        ->toContain("frame-ancestors 'none'")
        ->toContain("object-src 'none'");
});

test('changing the password revokes all api tokens', function () {
    $user = User::factory()->create();
    $user->createToken('app', ['siswa']);

    $this->actingAs($user)->put('/password', [
        'current_password' => 'password',
        'password' => 'N3w!Strong#Passw0rd',
        'password_confirmation' => 'N3w!Strong#Passw0rd',
    ]);

    expect($user->tokens()->count())->toBe(0);
});
