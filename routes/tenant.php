<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the routes for your tenants.
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    
    // مسار لوحة التحكم الرئيسية للفندق
    Route::get('/', function () {
        $tenant = tenant(); // الحصول على بيانات الفندق الحالي تلقائياً من قاعدة بياناته العزل
        return view('tenant.dashboard', compact('tenant'));
    });

    // مسار لتسجيل الخروج أو التوجيه
    Route::get('/logout', function () {
        return redirect('http://185.252.232.60:8000/');
    });

});
