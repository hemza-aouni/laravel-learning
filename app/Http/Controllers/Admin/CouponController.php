<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $data = $request->validate([
            'code'       => 'required|string|max:50|unique:coupons,code',
            'type'       => 'required|in:percent,fixed',
            'value'      => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'max_uses'   => 'nullable|integer|min:1',
            'starts_at'  => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active'  => 'nullable|boolean',
        ]);

        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->boolean('is_active', true);

        Coupon::create($data);

        return redirect('/admin/dashboard#section-packages')
            ->with('success', 'Coupon created successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $coupon->delete();

        return redirect('/admin/dashboard#section-packages')
            ->with('success', 'Coupon deleted successfully.');
    }
}
