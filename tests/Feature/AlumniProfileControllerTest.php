<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns 401 for unauthenticated profile requests', function () {
    $this->getJson('/alumni/profile')->assertUnauthorized();

    $this->putJson('/alumni/profile', [])->assertUnauthorized();
});

it('returns only the authenticated user profile', function () {
    $owner = User::factory()->alumni()->create();
    $otherUser = User::factory()->alumni()->create();

    $profile = $owner->alumniProfile()->create([
        'nama_lengkap' => 'Hanif',
        'jurusan' => 'Rekayasa Perangkat Lunak',
        'tahun_lulus' => 2024,
        'status_saat_ini' => 'bekerja',
    ]);

    actingAsConfirmed($this, $owner)
        ->getJson('/alumni/profile')
        ->assertOk()
        ->assertJsonPath('data.id', $profile->id)
        ->assertJsonMissingPath('data.user_id');

    actingAsConfirmed($this, $otherUser)
        ->getJson('/alumni/profile')
        ->assertOk()
        ->assertJsonPath('data', null);
});

it('creates and updates the authenticated user profile', function () {
    $user = User::factory()->alumni()->create();
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

    actingAsConfirmed($this, $user)
        ->putJson('/alumni/profile', $profileData)
        ->assertCreated()
        ->assertJsonPath('data.nama_lengkap', 'Hanif')
        ->assertJsonMissingPath('data.user_id');

    actingAsConfirmed($this, $user)
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
    $user = User::factory()->alumni()->create();

    actingAsConfirmed($this, $user)
        ->putJson('/alumni/profile', [
            'nama_lengkap' => '',
            'jurusan' => 'RPL',
            'tahun_lulus' => now()->year + 1,
            'status_saat_ini' => 'invalid',
        ])
        ->assertInvalid(['nama_lengkap', 'tahun_lulus', 'status_saat_ini']);

    $this->assertDatabaseCount('alumni_profiles', 0);
});

it('renders the alumni form and saves submitted profile data', function () {
    $user = User::factory()->alumni()->create();
    $profileData = [
        'nama_lengkap' => $user->name,
        'jurusan' => 'Rekayasa Perangkat Lunak',
        'tahun_lulus' => 2024,
        'status_saat_ini' => 'bekerja',
    ];

    actingAsConfirmed($this, $user)
        ->get('/alumni/profile')
        ->assertOk()
        ->assertSee('Data alumni')
        ->assertSee('Nama lengkap')
        ->assertSee('Status saat ini');

    actingAsConfirmed($this, $user)
        ->put('/alumni/profile', $profileData)
        ->assertRedirect(route('alumni.profile.edit'))
        ->assertSessionHas('status', 'alumni-profile-updated');

    $this->assertDatabaseHas('alumni_profiles', [
        'user_id' => $user->id,
        'nama_lengkap' => $user->name,
        'status_saat_ini' => 'bekerja',
    ]);
});

it('returns validation errors for an incomplete alumni form', function () {
    $user = User::factory()->alumni()->create();

    actingAsConfirmed($this, $user)
        ->from(route('alumni.profile.edit'))
        ->put('/alumni/profile', ['nama_lengkap' => $user->name])
        ->assertRedirect(route('alumni.profile.edit'))
        ->assertSessionHasErrors(['jurusan', 'tahun_lulus', 'status_saat_ini']);

    $this->assertDatabaseCount('alumni_profiles', 0);
});

it('forbids students from accessing the alumni form', function () {
    $student = User::factory()->create();

    actingAsConfirmed($this, $student)
        ->get('/alumni/profile')
        ->assertForbidden();
});
