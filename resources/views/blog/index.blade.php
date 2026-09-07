<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Blog</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-950 text-slate-100">
@include('partials.menu')
<div class="max-w-5xl mx-auto p-6 md:p-10 grid md:grid-cols-3 gap-6">
    @foreach($articles as $article)
        <a href="/blog/{{ $article->slug }}" class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden hover:border-indigo-500 transition">
            @if($article->image)<img src="{{ asset($article->image) }}" class="w-full h-40 object-cover">@endif
            <div class="p-5 space-y-2">
                @if($article->category)<span class="text-xs text-indigo-400 font-semibold">{{ $article->category->name }}</span>@endif
                <h2 class="font-bold text-white">{{ $article->title }}</h2>
                <p class="text-xs text-slate-400">{{ $article->excerpt }}</p>
            </div>
        </a>
    @endforeach
</div>
<div class="max-w-5xl mx-auto px-6 pb-10">{{ $articles->links() }}</div>
@include('partials.footer')
</body>
</html>
