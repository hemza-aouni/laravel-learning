<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    /**
     * لوحة تحكم صاحب الفندق
     */
    public function dashboard($id)
    {
        $tenant = Tenant::findOrFail($id);
        $rooms = Room::forTenant($id)->orderBy('sort_order')->orderBy('name')->get();

        return view('tenant.dashboard', compact('tenant', 'rooms'));
    }

    /**
     * الموقع العام للضيوف
     */
    public function preview($id)
    {
        $tenant = Tenant::findOrFail($id);
        $rooms = Room::forTenant($id)->active()->orderBy('sort_order')->orderBy('price')->get();

        return view('tenant.front-user', compact('tenant', 'rooms'));
    }

    /**
     * إضافة غرفة جديدة
     */
    public function storeRoom(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'capacity'    => 'nullable|integer|min:1',
            'image'       => 'nullable|image|max:4096',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['tenant_id'] = $tenant->id;
        $data['capacity']  = $data['capacity'] ?? 2;
        $data['is_active'] = $request->boolean('is_active', true);
        $data['currency']  = 'USD';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'room_' . $tenant->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads'), $filename);
            $data['image'] = 'assets/uploads/' . $filename;
        }

        Room::create($data);

        return redirect('/hotel/' . $id . '#rooms')
            ->with('success', 'Room added successfully.');
    }

    /**
     * تحديث غرفة
     */
    public function updateRoom(Request $request, $id, $roomId)
    {
        $tenant = Tenant::findOrFail($id);
        $room = Room::forTenant($id)->findOrFail($roomId);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'capacity'    => 'nullable|integer|min:1',
            'image'       => 'nullable|image|max:4096',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'room_' . $tenant->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads'), $filename);
            $data['image'] = 'assets/uploads/' . $filename;
        }

        $room->update($data);

        return redirect('/hotel/' . $id . '#rooms')
            ->with('success', 'Room updated successfully.');
    }

    /**
     * حذف غرفة
     */
    public function destroyRoom($id, $roomId)
    {
        $room = Room::forTenant($id)->findOrFail($roomId);
        $room->delete();

        return redirect('/hotel/' . $id . '#rooms')
            ->with('success', 'Room deleted successfully.');
    }
}
