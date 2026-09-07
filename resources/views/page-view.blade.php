<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page['title'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col justify-between">

    <header class="bg-slate-900 border-b border-slate-800 px-6 py-4 flex justify-between items-center">
        <a href="/" class="font-black text-lg text-rose-500">SaaSPlatform</a>
        <a href="/" class="text-xs text-slate-400 hover:text-white">← Back to Home</a>
    </header>

    <main class="max-w-4xl w-full mx-auto p-6 md:p-10 space-y-6 my-auto bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl">
        <h1 class="text-3xl font-black text-indigo-400 border-b border-slate-800 pb-4">{{ $page['title'] }}</h1>
        <div class="prose prose-invert text-slate-300 text-sm leading-relaxed">
            {!! $page['content'] !!}
        </div>
    </main>

    <footer class="bg-slate-900 border-t border-slate-800 py-6 text-center text-xs text-slate-400">
        {{ $data['copyright'] }}
    </footer>

</body>
</html>
