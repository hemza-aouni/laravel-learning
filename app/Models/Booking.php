<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'tenant_id', 'room_id', 'guest_name', 'guest_email', 'guest_phone',
        'check_in', 'check_out', 'guests_count', 'status', 'total_price', 'notes',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }

    /**
     * غرفة متاحة إذا ما فيه حجز نشط (pending/confirmed) يتقاطع مع الفترة المطلوبة.
     */
    public static function isRoomAvailable($roomId, $checkIn, $checkOut, $excludeBookingId = null)
    {
        $query = static::where('room_id', $roomId)
            ->active()
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn);

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return !$query->exists();
    }
}
