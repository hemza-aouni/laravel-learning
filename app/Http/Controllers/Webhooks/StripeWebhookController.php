<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function __construct(private SubscriptionService $subscriptionService) {}

    public function handle(Request $request)
    {
        $gateway = PaymentGateway::where('slug', 'stripe')->first();
        if (!$gateway || !$gateway->is_active) {
            return response('Gateway inactive', 400);
        }

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        // في الإنتاج: التحقق من التوقيع باستخدام webhook_secret
        // \Stripe\Webhook::constructEvent($payload, $sigHeader, $gateway->webhook_secret);

        $event = json_decode($payload, true);
        if (!$event) {
            return response('Invalid payload', 400);
        }

        Log::info('Stripe Webhook received', ['type' => $event['type'] ?? 'unknown']);

        try {
            match ($event['type'] ?? '') {
                'checkout.session.completed',
                'invoice.paid',
                'customer.subscription.created' => $this->handlePaymentSuccess($event),
                'customer.subscription.deleted',
                'invoice.payment_failed'        => $this->handlePaymentFailed($event),
                default                        => null,
            };
        } catch (\Throwable $e) {
            Log::error('Stripe Webhook error: ' . $e->getMessage());
            return response('Webhook handler error', 500);
        }

        return response('OK', 200);
    }

    protected function handlePaymentSuccess(array $event): void
    {
        $object = $event['data']['object'] ?? [];
        $subscriptionId = $object['client_reference_id'] 
            ?? $object['metadata']['subscription_id'] 
            ?? null;

        if (!$subscriptionId) return;

        $subscription = Subscription::find($subscriptionId);
        if ($subscription && $subscription->status !== 'active') {
            $this->subscriptionService->activateSubscription(
                $subscription,
                $object['subscription'] ?? $object['id'] ?? null
            );
        }
    }

    protected function handlePaymentFailed(array $event): void
    {
        $object = $event['data']['object'] ?? [];
        $subscriptionId = $object['client_reference_id'] 
            ?? $object['metadata']['subscription_id'] 
            ?? null;

        if (!$subscriptionId) return;

        $subscription = Subscription::find($subscriptionId);
        if ($subscription) {
            $subscription->update(['status' => 'past_due']);
        }
    }
}
