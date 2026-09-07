<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Coupon;
use App\Models\Subscription;
use App\Models\Tenant;
use Carbon\Carbon;

class SubscriptionService
{
    /**
     * إنشاء اشتراك جديد (تجريبي أو مدفوع)
     */
    public function createSubscription(
        string $tenantId,
        Package $package,
        ?Coupon $coupon = null,
        string $gateway = 'offline',
        ?string $gatewaySubscriptionId = null,
        string $status = 'trialing'
    ): Subscription {
        $amount = $package->price;

        if ($coupon && $coupon->isValid($amount)) {
            $discount = $coupon->calculateDiscount($amount);
            $amount = max(0, $amount - $discount);
            $coupon->increment('used_count');
        }

        $trialEndsAt = null;
        $startsAt = now();
        $endsAt = null;

        if ($package->trial_days > 0 && $status === 'trialing') {
            $trialEndsAt = now()->addDays($package->trial_days);
        }

        if ($status === 'active') {
            $startsAt = now();
            if ($package->type === 'monthly') {
                $endsAt = now()->addMonth();
            } elseif ($package->type === 'yearly') {
                $endsAt = now()->addYear();
            } else {
                $endsAt = null; // lifetime
            }
        }

        return Subscription::create([
            'tenant_id'               => $tenantId,
            'package_id'              => $package->id,
            'coupon_id'               => $coupon?->id,
            'status'                  => $status,
            'payment_gateway'         => $gateway,
            'gateway_subscription_id' => $gatewaySubscriptionId,
            'amount'                  => $amount,
            'currency'                => $package->currency,
            'trial_ends_at'           => $trialEndsAt,
            'starts_at'               => $startsAt,
            'ends_at'                 => $endsAt,
        ]);
    }

    /**
     * تفعيل الاشتراك بعد نجاح الدفع
     */
    public function activateSubscription(Subscription $subscription, ?string $gatewaySubscriptionId = null): void
    {
        $package = $subscription->package;

        $endsAt = null;
        if ($package->type === 'monthly') {
            $endsAt = now()->addMonth();
        } elseif ($package->type === 'yearly') {
            $endsAt = now()->addYear();
        }

        $subscription->update([
            'status'                  => 'active',
            'gateway_subscription_id' => $gatewaySubscriptionId ?? $subscription->gateway_subscription_id,
            'starts_at'               => now(),
            'ends_at'                 => $endsAt,
            'trial_ends_at'           => null,
        ]);

        // تحديث حالة المستأجر إن أمكن
        try {
            $tenant = Tenant::find($subscription->tenant_id);
            if ($tenant) {
                $tenant->update([
                    'subscription_status' => 'active',
                    'trial_ends_at'       => null,
                ]);
            }
        } catch (\Throwable $e) {
            // تجاهل إذا لم يكن الحقل موجوداً
        }
    }

    /**
     * إلغاء الاشتراك
     */
    public function cancelSubscription(Subscription $subscription): void
    {
        $subscription->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }
}
