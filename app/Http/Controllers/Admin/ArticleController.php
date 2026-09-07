<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    private function validated(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|max:4096',
            'meta_keywords' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);
    }

    private function handleImage(Request $request, ?string $oldImage = null): ?string
    {
        if (!$request->hasFile('image')) {
            return $oldImage;
        }

        if ($oldImage && file_exists(public_path($oldImage))) {
            @unlink(public_path($oldImage));
        }

        $file = $request->file('image');
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/uploads/articles'), $filename);

        return 'assets/uploads/articles/' . $filename;
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
        $data['image'] = $this->handleImage($request);
        $data['published_at'] = now();

        Article::create($data);

        return back()->with('success', 'تم نشر المقالة بنجاح.');
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.articles-edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validated($request);
        $data['image'] = $this->handleImage($request, $article->image);

        $article->update($data);

        return redirect('/admin/dashboard')->with('success', 'تم تعديل المقالة بنجاح.');
    }

    public function destroy(Article $article)
    {
        if ($article->image && file_exists(public_path($article->image))) {
            @unlink(public_path($article->image));
        }
        $article->delete();
        return back()->with('success', 'تم حذف المقالة.');
    }
}
