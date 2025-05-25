<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;

Route::prefix('v1/stocks')
    ->controller(StockController::class)
    ->middleware('auth:api')
    ->group(function () {
        Route::post('/quote', 'quote');
        Route::get('/history', 'history');
});
