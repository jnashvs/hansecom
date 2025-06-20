<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('v1/auth')->controller(AuthController::class)->group(function () {
    Route::middleware('throttle:register')->post('/create', 'create');
    Route::middleware('throttle:login')->post('/login', 'login');

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', 'me');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
    });
});
