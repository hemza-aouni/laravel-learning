<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    public function update(Request $request, PaymentGateway $gateway)
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }

        $data = $request->validate([
            'public_key'     => 'nullable|string',
            'secret_key'     => 'nullable|string',
            'webhook_secret' => 'nullable|string',
            'mode'           => 'nullable|in:sandbox,live',
            'is_active'      => 'nullable|boolean',
            'official_url'   => 'nullable|url',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        // لا نحذف المفاتيح إذا تركها فارغة
        if (empty($data['secret_key'])) {
            unset($data['secret_key']);
        }
        if (empty($data['public_key'])) {
            unset($data['public_key']);
        }
        if (empty($data['webhook_secret'])) {
            unset($data['webhook_secret']);
        }

        $gateway->update($data);

        return redirect('/admin/dashboard#section-payments')
            ->with('success', $gateway->name . ' settings updated successfully.');
    }
}
