<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'location' => 'required|in:header,footer',
            'link_type' => 'required|in:page,url',
            'page_id' => 'nullable|exists:pages,id',
            'url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        MenuItem::create([
            'label' => $request->label,
            'location' => $request->location,
            'page_id' => $request->link_type === 'page' ? $request->page_id : null,
            'url' => $request->link_type === 'url' ? $request->url : null,
            'order' => $request->order ?? 0,
        ]);

        return back()->with('success', 'تم إضافة عنصر القائمة.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return back()->with('success', 'تم حذف عنصر القائمة.');
    }
}
