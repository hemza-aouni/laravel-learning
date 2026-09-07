<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();

        return response()->json([
            'status' => 'success',
            'data' => $rooms
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms',
            'type' => 'required|string',
            'price_per_night' => 'required|numeric',
        ]);

        $room = Room::create([
            'room_number' => $validated['room_number'],
            'type' => $validated['type'],
            'price_per_night' => $validated['price_per_night'],
            'status' => 'available',
        ]);

        return response()->json([
            'message' => 'تم إنشاء الغرفة بنجاح',
            'data' => $room
        ], 201);
    }
}
