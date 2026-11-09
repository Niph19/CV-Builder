<?php

use App\Http\Controllers\Api\AuthTokenController;
use App\Http\Controllers\Api\MeController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/token', [AuthTokenController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('api.auth.token');

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::get('/me', MeController::class)->name('api.me');
    Route::delete('/auth/token', [AuthTokenController::class, 'destroy'])->name('api.auth.token.revoke');
});
