<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $package->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-lg w-full bg-slate-900 border border-slate-800 rounded-3xl p-8 space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-black">{{ $package->name }}</h1>
            <p class="text-slate-400 text-sm mt-1">{{ $package->description }}</p>
            <div class="text-4xl font-black text-rose-400 mt-4">
                ${{ number_format($package->price, 2) }}
                <span class="text-sm text-slate-500 font-normal">/ {{ $package->type }}</span>
            </div>
            @if($package->trial_days > 0)
                <p class="text-emerald-400 text-sm mt-2">{{ $package->trial_days }} days free trial</p>
            @endif
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="package_id" value="{{ $package->id }}">
            <input type="hidden" name="tenant_id" value="{{ request('tenant_id', 'demo') }}">

            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">Coupon Code (optional)</label>
                <input type="text" name="coupon_code" placeholder="SAVE20" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm uppercase">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-2">Payment Method</label>
                <div class="space-y-2">
                    @foreach($gateways as $gateway)
                        <label class="flex items-center space-x-3 bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 cursor-pointer hover:border-indigo-500 transition">
                            <input type="radio" name="gateway" value="{{ $gateway->slug }}" {{ $loop->first ? 'checked' : '' }} class="text-indigo-500">
                            <span class="font-semibold text-sm">{{ $gateway->name }}</span>
                            <span class="text-xs text-slate-500 ml-auto">{{ $gateway->type }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full bg-rose-600 hover:bg-rose-500 text-white font-bold py-4 rounded-2xl transition">
                Continue to Payment
            </button>
        </form>

        <a href="/" class="block text-center text-sm text-slate-500 hover:text-white">← Back to Home</a>
    </div>
</body>
</html>
