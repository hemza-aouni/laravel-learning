<?php

namespace App\Http\Controllers;

use App\Models\Tenant;

class TenantFrontController extends Controller
{
    public function show($id)
    {
        $tenant = Tenant::findOrFail($id);

        // يمكن لاحقاً جلب الغرف والمحتوى من قاعدة البيانات
        // $rooms = $tenant->rooms()->where('is_active', true)->get();

        return view('tenant.front-user', compact('tenant'));
    }
}
