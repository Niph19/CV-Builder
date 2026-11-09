<?php

use App\Http\Controllers\AlumniProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    $user = auth()->user();

    return redirect()->route($user->isAdmin()
        ? 'admin.dashboard'
        : ($user->isAlumni() ? 'alumni.profile.edit' : 'profile.data.edit'));
})->middleware('auth')->name('home');

Route::middleware(['auth', 'password.confirm'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:siswa,alumni', 'password.confirm'])->group(function () {
    Route::get('/profile/data', [UserProfileController::class, 'edit'])->name('profile.data.edit');
    Route::put('/profile/data', [UserProfileController::class, 'update'])->name('profile.data.update');
});

Route::middleware(['auth', 'role:alumni', 'password.confirm'])
    ->prefix('alumni')
    ->name('alumni.')
    ->group(function () {
        Route::get('/profile', [AlumniProfileController::class, 'show'])->name('profile.edit');
        Route::put('/profile', [AlumniProfileController::class, 'update'])->name('profile.update');
    });

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(base_path('routes/admin.php'));

require __DIR__.'/auth.php';
