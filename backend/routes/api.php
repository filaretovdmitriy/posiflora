<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/shops/{shopId}/telegram/connect', [TelegramController::class, 'connect']);

Route::post('/shops/{shopId}/telegram/status', [TelegramController::class, 'status']);

Route::post('/shops/{shopId}/orders', [TelegramController::class, 'connect']);