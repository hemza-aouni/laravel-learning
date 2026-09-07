<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><title>Edit Article</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({selector:'.rich-editor',plugins:'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table',toolbar:'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',skin:'oxide-dark',content_css:'dark',height:350});</script>
</head>
<body class="bg-slate-950 text-slate-100 p-6 md:p-10">
<div class="max-w-3xl mx-auto space-y-6">
    <a href="/admin/dashboard" class="text-indigo-400 text-sm">&larr; Back to Dashboard</a>
    <h1 class="text-2xl font-black">Edit Article</h1>
    <form action="/admin/blog/articles/{{ $article->id }}" method="POST" enctype="multipart/form-data" class="bg-slate-900 border border-slate-800 p-6 rounded-2xl space-y-6">
        @csrf @method('PUT')
        <div class="grid md:grid-cols-2 gap-4">
            <input type="text" name="title" value="{{ $article->title }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
            <select name="category_id" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
                <option value="">-- None --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected($article->category_id == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <input type="text" name="excerpt" value="{{ $article->excerpt }}" placeholder="Excerpt" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
        @if($article->image)
            <img src="{{ asset($article->image) }}" class="h-32 rounded-xl border border-slate-800">
        @endif
        <input type="file" name="image" accept="image/*" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
        <textarea class="rich-editor" name="content">{{ $article->content }}</textarea>
        <div class="grid md:grid-cols-2 gap-4">
            <input type="text" name="meta_keywords" value="{{ $article->meta_keywords }}" placeholder="Meta Keywords" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
            <input type="text" name="meta_description" value="{{ $article->meta_description }}" placeholder="Meta Description" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
        </div>
        <button class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-3 rounded-xl text-sm">Update Article</button>
    </form>
</div>
</body>
</html>
