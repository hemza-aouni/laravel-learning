<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS Platform & Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Header Menu الديناميكي -->
    <header class="bg-slate-900 border-b border-slate-800 px-6 py-4 flex justify-between items-center">
        <div class="font-black text-lg text-rose-500">SaaSPlatform</div>
        <nav class="hidden md:flex space-x-6 text-sm font-semibold text-slate-300">
            @foreach($data['menu'] as $item)
                <a href="{{ $item['url'] }}" class="hover:text-white transition">{{ $item['name'] }}</a>
            @endforeach
        </nav>
        <a href="/admin/login" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-xl text-xs font-semibold">Admin Login</a>
    </header>

    <!-- Main Content & Latest Articles -->
    <main class="max-w-6xl w-full mx-auto p-6 md:p-10 space-y-12 my-auto">
        <div class="text-center space-y-4">
            <h1 class="text-4xl md:text-5xl font-black">Welcome to Our Modern Platform</h1>
            <p class="text-slate-400 max-w-xl mx-auto text-sm">Explore our latest articles, insights, and tools managed directly from the admin dashboard.</p>
        </div>

        <div class="space-y-6">
            <h2 class="text-2xl font-bold border-b border-slate-800 pb-3">Latest Articles</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($data['articles'] as $article)
                    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl flex flex-col">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="h-48 w-full object-cover">
                        <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="bg-indigo-500/10 text-indigo-400 text-xs px-2.5 py-1 rounded-full font-semibold">{{ $article['category'] }}</span>
                                <h3 class="font-bold text-lg mt-2 text-white">{{ $article['title'] }}</h3>
                                <p class="text-slate-400 text-xs mt-1">{{ Str::limit(strip_tags($article['content']), 80) }}</p>
                            </div>
                            <div class="text-xs text-slate-500 pt-4 border-t border-slate-800 flex justify-between">
                                <span>{{ $article['date'] }}</span>
                                <span class="text-emerald-400 font-semibold">SEO Optimized</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Footer والروابط المفيدة الديناميكية -->
    <footer class="bg-slate-900 border-t border-slate-800 py-8 px-6 text-center text-xs text-slate-400 space-y-4">
        <div class="flex flex-wrap justify-center gap-6 font-semibold">
            @foreach($data['footer_links'] as $link)
                <a href="{{ $link['url'] }}" class="hover:text-white transition">{{ $link['name'] }}</a>
            @endforeach
        </div>
        <div>{{ $data['copyright'] }}</div>
    </footer>

</body>
</html>
