<?php

use App\Http\Middleware\CookieMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(CookieMiddleware::class)->group(function () {

});
