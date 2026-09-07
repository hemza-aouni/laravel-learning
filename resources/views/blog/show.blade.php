<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><title>{{ $article->title }}</title>
<meta name="keywords" content="{{ $article->meta_keywords }}">
<meta name="description" content="{{ $article->meta_description }}">
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100">
@include('partials.menu')
<article class="max-w-3xl mx-auto p-6 md:p-10 space-y-6">
    @if($article->image)<img src="{{ asset($article->image) }}" class="w-full rounded-2xl">@endif
    <h1 class="text-3xl font-black">{{ $article->title }}</h1>
    <div class="prose prose-invert max-w-none">{!! $article->content !!}</div>
</article>
@include('partials.footer')
</body>
</html>
