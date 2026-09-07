<?php

namespace App\Http\Controllers;

use App\Models\Tenant;

class TenantFrontController extends Controller
{
    public function show($id)
    {
        $tenant = Tenant::findOrFail($id);
        return view('tenant.front-user', compact('tenant'));
    }
}
