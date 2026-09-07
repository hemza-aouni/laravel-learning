<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><title>Edit Page</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({selector:'.rich-editor',plugins:'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table',toolbar:'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',skin:'oxide-dark',content_css:'dark',height:350});</script>
</head>
<body class="bg-slate-950 text-slate-100 p-6 md:p-10">
<div class="max-w-3xl mx-auto space-y-6">
    <a href="/admin/dashboard" class="text-indigo-400 text-sm">&larr; Back to Dashboard</a>
    <h1 class="text-2xl font-black">Edit Page: {{ $page->title }}</h1>
    <form action="/admin/pages/{{ $page->id }}" method="POST" class="bg-slate-900 border border-slate-800 p-6 rounded-2xl space-y-6">
        @csrf @method('PUT')
        <input type="text" name="title" value="{{ $page->title }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-white text-sm">
        <textarea class="rich-editor" name="content">{{ $page->content }}</textarea>
        <button class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-3 rounded-xl text-sm">Update Page</button>
    </form>
</div>
</body>
</html>
