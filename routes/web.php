<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'role:siswa,alumni'])->name('dashboard');

Route::get('/home', function () {
    return redirect()->route(auth()->user()->isAdmin() ? 'admin.dashboard' : 'dashboard');
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

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(base_path('routes/admin.php'));

require __DIR__.'/auth.php';
