<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('api')->group(function () {

    // مسارات الغرف
    Route::get('/rooms', [RoomController::class, 'index']);

    // مسارات الحجوزات
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);

});
