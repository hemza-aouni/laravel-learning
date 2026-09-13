<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TenantController extends Controller
{
    public function dashboard($id)
    {
        $tenant = Tenant::findOrFail($id);
        $rooms = Room::forTenant($id)->orderBy('sort_order')->orderBy('name')->get();
        $bookings = Booking::forTenant($id)->with('room')->latest()->get();

        return view('tenant.admin.dashboard', compact('tenant', 'rooms', 'bookings'));
    }

    public function preview($id, Request $request)
    {
        $tenant = Tenant::findOrFail($id);
        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');
        $guests = $request->query('guests');

        $rooms = Room::forTenant($id)->active()->orderBy('sort_order')->orderBy('price')->get();

        if ($checkIn && $checkOut) {
            $rooms = $rooms->filter(function ($room) use ($checkIn, $checkOut) {
                return Booking::isRoomAvailable($room->id, $checkIn, $checkOut);
            })->values();
        }

        if (view()->exists('tenant.front.home')) {
            return view('tenant.front.home', compact('tenant', 'rooms', 'checkIn', 'checkOut', 'guests'));
        }
        return view('tenant.front-user', compact('tenant', 'rooms', 'checkIn', 'checkOut', 'guests'));
    }

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

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = 'room_' . $tenant->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads'), $filename);
            $data['image'] = 'assets/uploads/' . $filename;
        }

        Room::create($data);

        return redirect('/hotel/' . $id . '#section-rooms')
            ->with('success', 'Room added successfully. It is now visible on your website.');
    }

    public function destroyRoom($id, $roomId)
    {
        $room = Room::forTenant($id)->findOrFail($roomId);
        $room->delete();

        return redirect('/hotel/' . $id . '#section-rooms')
            ->with('success', 'Room deleted.');
    }

    public function updateSettings(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $data = $request->validate([
            'hotel_name'  => 'required|string|max:255',
            'email'       => 'nullable|email',
            'phone'       => 'nullable|string|max:50',
            'address'     => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'hero_image'  => 'nullable|image|max:4096',
        ]);

        $update = ['hotel_name' => $data['hotel_name']];
        if (isset($data['email'])) $update['email'] = $data['email'];

        try {
            if (Schema::hasColumn('tenants', 'phone')) {
                $update['phone'] = $data['phone'] ?? null;
            }
            if (Schema::hasColumn('tenants', 'description')) {
                $update['description'] = $data['description'] ?? null;
            }
            if (Schema::hasColumn('tenants', 'address')) {
                $update['address'] = $data['address'] ?? null;
            }
            if (Schema::hasColumn('tenants', 'hero_image') && $request->hasFile('hero_image')) {
                if ($tenant->hero_image && file_exists(public_path($tenant->hero_image))) {
                    @unlink(public_path($tenant->hero_image));
                }
                $file = $request->file('hero_image');
                $filename = 'hero_' . $tenant->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/uploads'), $filename);
                $update['hero_image'] = 'assets/uploads/' . $filename;
            }
        } catch (\Throwable $e) {}

        $tenant->update($update);

        return redirect('/hotel/' . $id . '#section-settings')
            ->with('success', 'Website settings updated. Changes appear on your public site.');
    }

    /**
     * حجز جديد من الضيف (الواجهة العامة).
     */
    public function storeBooking(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $data = $request->validate([
            'room_id'      => 'required|exists:rooms,id',
            'guest_name'   => 'required|string|max:255',
            'guest_email'  => 'nullable|email|max:255',
            'guest_phone'  => 'nullable|string|max:50',
            'check_in'     => 'required|date|after_or_equal:today',
            'check_out'    => 'required|date|after:check_in',
            'guests_count' => 'nullable|integer|min:1',
        ]);

        $room = Room::forTenant($id)->findOrFail($data['room_id']);

        if (!Booking::isRoomAvailable($room->id, $data['check_in'], $data['check_out'])) {
            return back()->withErrors(['room_id' => 'عذرًا، هذه الغرفة غير متاحة في التواريخ المختارة.'])->withInput();
        }

        $nights = max(1, (new \DateTime($data['check_in']))->diff(new \DateTime($data['check_out']))->days);

        Booking::create([
            'tenant_id'    => $tenant->id,
            'room_id'      => $room->id,
            'guest_name'   => $data['guest_name'],
            'guest_email'  => $data['guest_email'] ?? null,
            'guest_phone'  => $data['guest_phone'] ?? null,
            'check_in'     => $data['check_in'],
            'check_out'    => $data['check_out'],
            'guests_count' => $data['guests_count'] ?? 2,
            'status'       => 'pending',
            'total_price'  => $room->price * $nights,
        ]);

        return redirect('/hotel/' . $id . '/preview')
            ->with('booking_success', 'تم إرسال طلب الحجز بنجاح! سيتواصل معك الفندق قريبًا لتأكيد الحجز.');
    }

    /**
     * تحديث حالة الحجز (تأكيد/إلغاء) من لوحة التينانت.
     */
    public function updateBookingStatus(Request $request, $id, $bookingId)
    {
        $request->validate(['status' => 'required|in:confirmed,cancelled,pending']);

        $booking = Booking::forTenant($id)->findOrFail($bookingId);
        $booking->update(['status' => $request->status]);

        return redirect('/hotel/' . $id . '#section-bookings')->with('success', 'تم تحديث حالة الحجز.');
    }

    /**
     * حذف حجز نهائيًا.
     */
    public function destroyBooking($id, $bookingId)
    {
        Booking::forTenant($id)->findOrFail($bookingId)->delete();

        return redirect('/hotel/' . $id . '#section-bookings')->with('success', 'تم حذف الحجز.');
    }
}
