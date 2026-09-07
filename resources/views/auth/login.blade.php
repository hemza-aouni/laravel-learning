<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | StayCloud</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-slate-900 border border-slate-800 p-8 rounded-2xl shadow-2xl">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center space-x-3 mb-4">
                <div class="bg-gradient-to-tr from-indigo-600 to-violet-500 p-2.5 rounded-xl shadow-lg shadow-indigo-500/30">
                    <i class="fa-solid fa-hotel text-white text-xl"></i>
                </div>
            </a>
            <h1 class="text-2xl font-black">Welcome Back</h1>
            <p class="text-slate-400 text-sm mt-1">Sign in to manage your hotel infrastructure</p>
        </div>

        <form action="/login" method="POST" class="space-y-6">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                <input type="email" name="email" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                <input type="password" name="password" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition">
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3.5 rounded-xl shadow-lg shadow-indigo-600/30 transition cursor-pointer">
                Sign In to Dashboard
            </button>
        </form>
        <div class="text-center mt-6">
            <a href="/" class="text-sm text-slate-400 hover:text-indigo-400 transition"><i class="fa-solid fa-arrow-left mr-2"></i>Back to Home</a>
        </div>
    </div>
</body>
</html>
