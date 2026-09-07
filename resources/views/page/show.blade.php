<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>{{ $page->title }}</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-950 text-slate-100">
@include('partials.menu')
<div class="max-w-3xl mx-auto p-6 md:p-10 space-y-6">
    <h1 class="text-3xl font-black">{{ $page->title }}</h1>
    <div class="prose prose-invert max-w-none">{!! $page->content !!}</div>
</div>
@include('partials.footer')
</body>
</html>
