<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LemonSqueezyWebhookController extends Controller
{
    public function __construct(private SubscriptionService $subscriptionService) {}

    public function handle(Request $request)
    {
        $gateway = PaymentGateway::where('slug', 'lemonsqueezy')->first();
        if (!$gateway || !$gateway->is_active) {
            return response('Gateway inactive', 400);
        }

        // التحقق من التوقيع (في الإنتاج)
        // $signature = $request->header('X-Signature');
        // hash_hmac('sha256', $request->getContent(), $gateway->webhook_secret)

        $payload = $request->all();
        $eventName = $payload['meta']['event_name'] ?? '';

        Log::info('LemonSqueezy Webhook', ['event' => $eventName]);

        try {
            match ($eventName) {
                'subscription_created',
                'subscription_payment_success',
                'order_created'                 => $this->handleSuccess($payload),
                'subscription_cancelled',
                'subscription_payment_failed'  => $this->handleFailed($payload),
                default                        => null,
            };
        } catch (\Throwable $e) {
            Log::error('LemonSqueezy Webhook error: ' . $e->getMessage());
            return response('Error', 500);
        }

        return response('OK', 200);
    }

    protected function handleSuccess(array $payload): void
    {
        $attrs = $payload['data']['attributes'] ?? [];
        $meta  = $payload['meta']['custom_data'] ?? [];

        $subscriptionId = $meta['subscription_id'] ?? null;
        $gatewaySubId   = $payload['data']['id'] ?? null;

        if (!$subscriptionId) return;

        $subscription = Subscription::find($subscriptionId);
        if ($subscription && $subscription->status !== 'active') {
            $this->subscriptionService->activateSubscription($subscription, $gatewaySubId);
        }
    }

    protected function handleFailed(array $payload): void
    {
        $meta = $payload['meta']['custom_data'] ?? [];
        $subscriptionId = $meta['subscription_id'] ?? null;
        if (!$subscriptionId) return;

        $subscription = Subscription::find($subscriptionId);
        if ($subscription) {
            $subscription->update(['status' => 'past_due']);
        }
    }
}
