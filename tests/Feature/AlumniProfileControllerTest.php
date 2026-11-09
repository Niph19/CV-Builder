<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns 401 for unauthenticated profile requests', function () {
    $this->getJson('/alumni/profile')->assertUnauthorized();

    $this->putJson('/alumni/profile', [])->assertUnauthorized();
});

it('returns only the authenticated user profile', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();

    $profile = $owner->alumniProfile()->create([
        'nama_lengkap' => 'Hanif',
        'jurusan' => 'Rekayasa Perangkat Lunak',
        'tahun_lulus' => 2024,
        'status_saat_ini' => 'bekerja',
    ]);

    $this->actingAs($owner)
        ->getJson('/alumni/profile')
        ->assertOk()
        ->assertJsonPath('data.id', $profile->id)
        ->assertJsonMissingPath('data.user_id');

    $this->actingAs($otherUser)
        ->getJson('/alumni/profile')
        ->assertOk()
        ->assertJsonPath('data', null);
});

it('creates and updates the authenticated user profile', function () {
    $user = User::factory()->create();
    $profileData = [
        'nama_lengkap' => 'Hanif',
        'jurusan' => 'Rekayasa Perangkat Lunak',
        'tahun_lulus' => 2024,
        'status_saat_ini' => 'bekerja',
        'nama_instansi' => 'PT Pesat',
        'jabatan' => 'Junior Developer',
        'no_hp' => '081234567890',
        'alamat' => 'Bogor',
        'user_id' => 999,
    ];

    $this->actingAs($user)
        ->putJson('/alumni/profile', $profileData)
        ->assertCreated()
        ->assertJsonPath('data.nama_lengkap', 'Hanif')
        ->assertJsonMissingPath('data.user_id');

    $this->actingAs($user)
        ->putJson('/alumni/profile', [...$profileData, 'nama_lengkap' => 'Hanif Updated'])
        ->assertOk()
        ->assertJsonPath('data.nama_lengkap', 'Hanif Updated');

    $this->assertDatabaseCount('alumni_profiles', 1);
    $this->assertDatabaseHas('alumni_profiles', [
        'user_id' => $user->id,
        'nama_lengkap' => 'Hanif Updated',
        'tahun_lulus' => 2024,
    ]);
});

it('rejects invalid profile data without saving it', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->putJson('/alumni/profile', [
            'nama_lengkap' => '',
            'jurusan' => 'RPL',
            'tahun_lulus' => now()->year + 1,
            'status_saat_ini' => 'invalid',
        ])
        ->assertInvalid(['nama_lengkap', 'tahun_lulus', 'status_saat_ini']);

    $this->assertDatabaseCount('alumni_profiles', 0);
});
