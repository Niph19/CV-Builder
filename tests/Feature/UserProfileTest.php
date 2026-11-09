<?php

use App\Models\User;

test('siswa can view the data diri form', function () {
    $siswa = User::factory()->create();

    actingAsConfirmed($this, $siswa)->get('/profile/data')->assertOk();
});

test('alumni can view the data diri form', function () {
    $alumni = User::factory()->alumni()->create();

    actingAsConfirmed($this, $alumni)->get('/profile/data')->assertOk();
});

test('admin cannot access the data diri form', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->get('/profile/data')->assertForbidden();
});

test('guests are redirected to login', function () {
    $this->get('/profile/data')->assertRedirect('/login');
});

test('siswa can save their profile data', function () {
    $siswa = User::factory()->create();

    actingAsConfirmed($this, $siswa)->put('/profile/data', [
        'school_major' => 'DKV',
        'phone' => '0812-3456-7890',
        'skills' => 'Photoshop, Illustrator',
        'experience' => 'PKL di studio desain',
    ])->assertRedirect();

    expect($siswa->profile()->first())
        ->school_major->toBe('DKV')
        ->skills->toBe('Photoshop, Illustrator');
});

test('saving twice updates the same profile row', function () {
    $siswa = User::factory()->create();

    actingAsConfirmed($this, $siswa)->put('/profile/data', ['school_major' => 'DKV', 'skills' => 'A']);
    actingAsConfirmed($this, $siswa)->put('/profile/data', ['school_major' => 'RPL', 'skills' => 'B']);

    expect($siswa->profile()->count())->toBe(1);
    expect($siswa->profile()->first()->school_major)->toBe('RPL');
});

test('skills and school major are required', function () {
    $siswa = User::factory()->create();

    actingAsConfirmed($this, $siswa)->put('/profile/data', ['phone' => '0812'])
        ->assertSessionHasErrors(['skills', 'school_major']);
});

test('graduation year must be in the past for alumni', function () {
    $alumni = User::factory()->alumni()->create();

    actingAsConfirmed($this, $alumni)->put('/profile/data', [
        'school_major' => 'DKV',
        'skills' => 'Design',
        'graduation_year' => (int) date('Y') + 3,
    ])->assertSessionHasErrors('graduation_year');
});

test('users cannot write profile data of another user', function () {
    $siswa = User::factory()->create();
    $other = User::factory()->create();

    actingAsConfirmed($this, $siswa)->put('/profile/data', [
        'school_major' => 'DKV',
        'skills' => 'Design',
        'user_id' => $other->id,
    ]);

    expect($other->profile()->exists())->toBeFalse();
    expect($siswa->profile()->exists())->toBeTrue();
});
