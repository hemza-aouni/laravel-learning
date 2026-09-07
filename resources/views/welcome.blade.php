<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS Platform & Hotel Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col justify-between">

@include('partials.menu')

<main class="max-w-6xl w-full mx-auto p-6 md:p-10 space-y-16 my-auto">
    <div class="text-center space-y-4">
        <h1 class="text-4xl md:text-5xl font-black">Multi-Tenant SaaS & Hotel Ecosystem</h1>
        <p class="text-slate-400 max-w-xl mx-auto text-sm">Manage your platform, deploy instant hotels, and publish professional articles linked directly from the super admin dashboard.</p>
    </div>

    <div class="space-y-6">
        <h2 class="text-2xl font-bold border-b border-slate-800 pb-3 flex justify-between items-center">
            <span>Latest Articles & News</span>
            <a href="/blog" class="text-xs text-indigo-400 hover:underline">View All Blog &rarr;</a>
        </h2>
        <div class="grid md:grid-cols-3 gap-6">
            @forelse($latestArticles as $article)
                <a href="/blog/{{ $article->slug }}" class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl flex flex-col hover:border-indigo-500 transition">
                    @if($article->image)
                        <img src="{{ asset($article->image) }}" alt="{{ $article->title }}" class="h-48 w-full object-cover">
                    @endif
                    <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                        <div>
                            @if($article->category)
                                <span class="bg-indigo-500/10 text-indigo-400 text-xs px-2.5 py-1 rounded-full font-semibold">{{ $article->category->name }}</span>
                            @endif
                            <h3 class="font-bold text-lg mt-2 text-white">{{ $article->title }}</h3>
                            <p class="text-slate-400 text-xs mt-1">{{ $article->excerpt ?? Str::limit(strip_tags($article->content), 80) }}</p>
                        </div>
                        <div class="text-xs text-slate-500 pt-4 border-t border-slate-800 flex justify-between">
                            <span>{{ optional($article->published_at)->format('Y-m-d') }}</span>
                            <span class="text-emerald-400 font-semibold">Live & Active</span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-slate-500 text-sm col-span-3 text-center py-10">No articles published yet.</p>
            @endforelse
        </div>
    </div>
</main>

@include('partials.footer')

</body>
</html>
