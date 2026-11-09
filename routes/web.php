<?php

use App\Http\Controllers\AlumniProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->prefix('alumni')->name('alumni.')->group(function () {
    Route::get('/profile', [AlumniProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [AlumniProfileController::class, 'update'])->name('profile.update');
});
