<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Models\Room;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
| هذه المسارات تعمل فقط داخل الساب دومين الخاص بكل فندق
| وتقوم المكتبة بتوجيه الاستعلامات تلقائياً لقاعدة بيانات الفندق الحالي
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', function () {
        return response()->json([
            'hotel' => tenant('hotel_name'),
            'email' => tenant('email'),
            'message' => 'Welcome to ' . tenant('hotel_name') . ' API Portal'
        ]);
    });

    // جلب قائمة الغرف الخاصة بالفندق الحالي فقط
    Route::get('/rooms', function () {
        return response()->json([
            'hotel' => tenant('hotel_name'),
            'rooms' => Room::all()
        ]);
    });

});
