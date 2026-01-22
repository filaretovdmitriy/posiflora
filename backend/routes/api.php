<?php

use App\Http\Controllers\OrdersController;
use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/shops/{shopId}/telegram/connect', [TelegramController::class, 'connect']);

Route::get('/shops/{shopId}/telegram/status', [TelegramController::class, 'status']);

Route::post('/shops/{shopId}/orders', [OrdersController::class, 'store']);