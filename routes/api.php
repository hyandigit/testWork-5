<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Middleware\CookieMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([CookieMiddleware::class, \ProtoneMedia\LaravelXssProtection\Middleware\XssCleanInput::class])->group(function () {
    Route::apiResource('genre', GenreController::class);
    Route::apiResource('movie', MovieController::class);
    Route::put('/movie/{movie}/active', [MovieController::class, 'active']);
});
