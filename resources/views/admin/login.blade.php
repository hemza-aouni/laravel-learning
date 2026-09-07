<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | SaaS Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-slate-900 border border-slate-800 p-8 rounded-2xl shadow-2xl">
        <div class="text-center mb-8">
            <div class="inline-flex bg-rose-600 p-3 rounded-2xl text-white mb-3 shadow-lg shadow-rose-600/30">
                <i class="fa-solid fa-shield-halved text-2xl"></i>
            </div>
            <h1 class="text-2xl font-black">Super Admin Portal</h1>
            <p class="text-slate-400 text-xs mt-1">Enter your master PIN to access the global infrastructure.</p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 p-4 rounded-xl mb-6 text-xs text-rose-400">
                <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/login" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1">Master Password / PIN</label>
                <input type="password" name="password" required maxlength="4" placeholder="••••" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-rose-500 transition tracking-widest text-center text-xl">
            </div>

            <button type="submit" class="w-full bg-rose-600 hover:bg-rose-500 text-white font-semibold py-3.5 rounded-xl text-sm shadow-lg shadow-rose-600/30 transition mt-2">
                Access Admin Dashboard
            </button>
        </form>
    </div>

</body>
</html>
