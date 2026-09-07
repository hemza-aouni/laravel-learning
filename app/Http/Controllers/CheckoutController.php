<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Coupon;
use App\Models\PaymentGateway;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private SubscriptionService $subscriptionService) {}

    /**
     * صفحة اختيار الباقة (يمكن ربطها بـ /deploy لاحقاً)
     */
    public function show(Package $package)
    {
        $gateways = PaymentGateway::active()->get();
        return view('checkout.show', compact('package', 'gateways'));
    }

    /**
     * بدء عملية الدفع
     */
    public function process(Request $request)
    {
        $request->validate([
            'package_id'  => 'required|exists:packages,id',
            'tenant_id'   => 'required|string',
            'gateway'     => 'required|string',
            'coupon_code' => 'nullable|string',
        ]);

        $package = Package::findOrFail($request->package_id);
        $gateway = PaymentGateway::where('slug', $request->gateway)->where('is_active', true)->firstOrFail();

        $coupon = null;
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();
            if (!$coupon || !$coupon->isValid($package->price)) {
                return back()->withErrors(['coupon_code' => 'Invalid or expired coupon.']);
            }
        }

        // إنشاء اشتراك بحالة pending أو trialing
        $status = $package->trial_days > 0 ? 'trialing' : 'pending';

        $subscription = $this->subscriptionService->createSubscription(
            tenantId: $request->tenant_id,
            package: $package,
            coupon: $coupon,
            gateway: $gateway->slug,
            status: $status
        );

        // توجيه حسب بوابة الدفع
        return match ($gateway->slug) {
            'stripe'       => $this->redirectToStripe($subscription, $gateway, $package),
            'paypal'       => $this->redirectToPaypal($subscription, $gateway, $package),
            'lemonsqueezy' => $this->redirectToLemonSqueezy($subscription, $gateway, $package),
            'offline'      => $this->handleOffline($subscription),
            default        => back()->withErrors(['gateway' => 'Unsupported payment gateway.']),
        };
    }

    protected function redirectToStripe(Subscription $subscription, PaymentGateway $gateway, Package $package)
    {
        // في الإنتاج: استخدام Stripe SDK لإنشاء Checkout Session
        // هنا نضع placeholder مع بيانات للاختبار
        return redirect()->route('checkout.success', [
            'subscription' => $subscription->id,
            'gateway'      => 'stripe',
        ])->with('info', 'Stripe checkout would open here. (Configure Stripe keys first)');
    }

    protected function redirectToPaypal(Subscription $subscription, PaymentGateway $gateway, Package $package)
    {
        return redirect()->route('checkout.success', [
            'subscription' => $subscription->id,
            'gateway'      => 'paypal',
        ])->with('info', 'PayPal checkout would open here.');
    }

    protected function redirectToLemonSqueezy(Subscription $subscription, PaymentGateway $gateway, Package $package)
    {
        return redirect()->route('checkout.success', [
            'subscription' => $subscription->id,
            'gateway'      => 'lemonsqueezy',
        ])->with('info', 'Lemon Squeezy checkout would open here.');
    }

    protected function handleOffline(Subscription $subscription)
    {
        // الدفع اليدوي → يبقى في حالة trialing أو pending حتى يؤكد الأدمن
        return redirect()->route('checkout.success', [
            'subscription' => $subscription->id,
            'gateway'      => 'offline',
        ])->with('success', 'Subscription created. Please complete the offline payment.');
    }

    public function success(Request $request)
    {
        $subscription = Subscription::findOrFail($request->subscription);
        return view('checkout.success', compact('subscription'));
    }
}
