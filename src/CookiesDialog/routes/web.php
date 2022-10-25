<?php

use Illuminate\Support\Facades\Route;
use SSD\CookiesDialog\Controllers\CookieController;

Route::post('/cookie', CookieController::class);