<?php

namespace App\Http\Controllers;

use App\Models\Tenant;

/**
 * @deprecated استخدم TenantController@preview بدلاً منه
 * تم الإبقاء عليه مؤقتاً للتوافق مع أي روابط قديمة
 */
class TenantFrontController extends Controller
{
    public function show($id)
    {
        // توجيه لنفس المنطق الجديد
        return app(TenantController::class)->preview($id);
    }
}
