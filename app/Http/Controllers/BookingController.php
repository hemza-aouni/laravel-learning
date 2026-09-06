<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * إنشاء حجز جديد مع منع الحجز المزدوج
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'room_id'        => 'required|exists:rooms,id',
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'check_in'       => 'required|date|after_or_equal:today',
            'check_out'      => 'required|date|after:check_in',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        // التحقق من أن الغرفة غير محجوزة في نفس الفترة (Prevent Overbooking)
        $hasOverlap = Booking::where('room_id', $room->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('check_in', [$validated['check_in'], $validated['check_out']])
                      ->orWhereBetween('check_out', [$validated['check_in'], $validated['check_out']])
                      ->orWhere(function ($q) use ($validated) {
                          $q->where('check_in', '<=', $validated['check_in'])
                            ->where('check_out', '>=', $validated['check_out']);
                      });
            })
            ->exists();

        if ($hasOverlap) {
            return response()->json([
                'status'  => 'error',
                'message' => 'الغرفة محجوزة بالفعل خلال هذه الفترة. يرجى اختيار تاريخ آخر.'
            ], 422);
        }

        // حساب عدد الليالي والسعر الإجمالي تلقائياً
        $checkIn  = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights   = $checkIn->diffInDays($checkOut);
        $totalPrice = $nights * $room->price_per_night;

        // إنشاء الحجز داخل قاعدة بيانات الفندق الحالي
        $booking = Booking::create([
            'room_id'        => $room->id,
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'check_in'       => $validated['check_in'],
            'check_out'      => $validated['check_out'],
            'total_price'    => $totalPrice,
            'status'         => 'confirmed',
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم الحجز بنجاح!',
            'hotel'   => tenant('hotel_name'),
            'booking' => $booking->load('room')
        ], 201);
    }

    /**
     * عرض جميع الحجوزات الخاصة بالفندق الحالي
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status'   => 'success',
            'hotel'    => tenant('hotel_name'),
            'bookings' => Booking::with('room')->get()
        ]);
    }
}
