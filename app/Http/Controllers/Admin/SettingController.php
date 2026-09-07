<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function updateFooter(Request $request)
    {
        $request->validate([
            'footer_copyright' => 'nullable|string|max:255',
        ]);

        Setting::set('footer_copyright', $request->footer_copyright);

        return back()->with('success', 'تم تحديث إعدادات الفوتر.');
    }
}
