<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'booking_id'     => 'required|exists:bookings,id',
            'payment_method' => 'required|string|in:credit_card,paypal,stripe',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        if ($booking->status === 'paid') {
            return response()->json([
                'status'  => 'error',
                'message' => 'هذا الحجز مدفوع بالفعل.'
            ], 400);
        }

        $transactionId = 'TXN-' . strtoupper(bin2hex(random_bytes(6)));

        $payment = Payment::create([
            'booking_id'     => $booking->id,
            'amount'         => $booking->total_price,
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $transactionId,
            'status'         => 'completed',
        ]);

        $booking->update(['status' => 'paid']);

        return response()->json([
            'status'         => 'success',
            'message'        => 'تمت عملية الدفع بنجاح!',
            'hotel'          => tenant('hotel_name'),
            'transaction_id' => $transactionId,
            'payment'        => $payment,
            'booking'        => $booking
        ], 201);
    }
}
