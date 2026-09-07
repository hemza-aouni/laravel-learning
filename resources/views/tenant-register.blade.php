<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deploy Your Hotel | SaaS Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-slate-900 border border-slate-800 p-8 rounded-2xl shadow-2xl">
        <div class="text-center mb-8">
            <div class="inline-flex bg-indigo-600 p-3 rounded-2xl text-white mb-3 shadow-lg shadow-indigo-600/30">
                <i class="fa-solid fa-hotel text-2xl"></i>
            </div>
            <h1 class="text-2xl font-black">Launch Your Hotel</h1>
            <p class="text-slate-400 text-xs mt-1">Deploy your isolated multi-tenant hotel system instantly.</p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 p-4 rounded-xl mb-6 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <p><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="/register-hotel" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">Hotel Name</label>
                <input type="text" name="hotel_name" required placeholder="e.g. Grand Plaza Hotel" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">Subdomain Identifier</label>
                <div class="flex items-center bg-slate-950 border border-slate-800 rounded-xl overflow-hidden focus-within:border-indigo-500 transition">
                    <input type="text" name="subdomain" required placeholder="grand-plaza" class="w-full bg-transparent px-4 py-3 text-white text-sm focus:outline-none">
                    <span class="bg-slate-900 px-3 py-3 text-xs text-slate-500 border-l border-slate-800">.hotel.local</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">Manager Email</label>
                <input type="email" name="email" required placeholder="admin@grandplaza.com" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">Secure PIN (4 Digits)</label>
                <input type="password" name="password" required maxlength="4" placeholder="••••" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-indigo-500 transition tracking-widest">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3.5 rounded-xl text-sm shadow-lg shadow-indigo-600/30 transition mt-2">
                Deploy Hotel Now
            </button>
        </form>
    </div>

</body>
</html>
