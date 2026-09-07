<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-slate-900 border border-slate-800 rounded-3xl p-10 text-center space-y-6">
        <div class="w-20 h-20 bg-emerald-500/10 text-emerald-400 rounded-full flex items-center justify-center mx-auto text-3xl">
            <i class="fa-solid fa-check"></i>
        </div>
        <h1 class="text-2xl font-black">Subscription Created!</h1>
        <p class="text-slate-400 text-sm">
            Your subscription is now <span class="text-emerald-400 font-semibold">{{ $subscription->status }}</span>.
            @if($subscription->isOnTrial())
                Trial ends at {{ $subscription->trial_ends_at->format('Y-m-d') }}.
            @endif
        </p>
        <div class="bg-slate-950 rounded-2xl p-4 text-left text-sm space-y-2">
            <div class="flex justify-between"><span class="text-slate-500">Package</span><span>{{ $subscription->package->name ?? '-' }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Amount</span><span>${{ number_format($subscription->amount, 2) }}</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Gateway</span><span>{{ $subscription->payment_gateway }}</span></div>
        </div>
        <a href="/hotel/{{ $subscription->tenant_id }}" class="inline-block bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 py-3 rounded-2xl transition">
            Go to Dashboard
        </a>
    </div>
</body>
</html>
