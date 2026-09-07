<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalWebhookController extends Controller
{
    public function __construct(private SubscriptionService $subscriptionService) {}

    public function handle(Request $request)
    {
        $gateway = PaymentGateway::where('slug', 'paypal')->first();
        if (!$gateway || !$gateway->is_active) {
            return response('Gateway inactive', 400);
        }

        $event = $request->all();
        Log::info('PayPal Webhook received', ['type' => $event['event_type'] ?? 'unknown']);

        try {
            match ($event['event_type'] ?? '') {
                'PAYMENT.CAPTURE.COMPLETED',
                'CHECKOUT.ORDER.APPROVED',
                'BILLING.SUBSCRIPTION.ACTIVATED' => $this->handleSuccess($event),
                'BILLING.SUBSCRIPTION.CANCELLED',
                'PAYMENT.CAPTURE.DENIED'         => $this->handleFailed($event),
                default                         => null,
            };
        } catch (\Throwable $e) {
            Log::error('PayPal Webhook error: ' . $e->getMessage());
            return response('Error', 500);
        }

        return response('OK', 200);
    }

    protected function handleSuccess(array $event): void
    {
        $resource = $event['resource'] ?? [];
        $customId = $resource['custom_id'] ?? $resource['id'] ?? null;

        if (!$customId) return;

        $subscription = Subscription::where('gateway_subscription_id', $customId)
            ->orWhere('id', $customId)
            ->first();

        if ($subscription && $subscription->status !== 'active') {
            $this->subscriptionService->activateSubscription($subscription, $customId);
        }
    }

    protected function handleFailed(array $event): void
    {
        $resource = $event['resource'] ?? [];
        $customId = $resource['custom_id'] ?? null;
        if (!$customId) return;

        $subscription = Subscription::where('gateway_subscription_id', $customId)->first();
        if ($subscription) {
            $subscription->update(['status' => 'past_due']);
        }
    }
}
