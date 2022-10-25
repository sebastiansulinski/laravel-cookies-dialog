<?php

use Illuminate\Support\Facades\Route;
use SSD\CookiesDialog\Controllers\CookieController;

Route::post('/ssd/cookie', CookieController::class)
    ->middleware('web')
    ->name('ssd.cookie');