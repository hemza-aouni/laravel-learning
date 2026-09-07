<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'content' => $request->content,
        ]);

        return redirect('/admin/dashboard')->with('success', 'تم إنشاء الصفحة بنجاح.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages-edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $page->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect('/admin/dashboard')->with('success', 'تم تعديل الصفحة بنجاح.');
    }

    public function destroy(Page $page)
    {
        if ($page->is_default) {
            return back()->withErrors(['page' => 'لا يمكن حذف صفحة افتراضية، يمكنك فقط تعديل محتواها.']);
        }
        $page->delete();
        return back()->with('success', 'تم حذف الصفحة.');
    }
}
