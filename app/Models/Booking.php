<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public function resort()
    {
        return $this->belongsTo(Resort::class, 'resort_id', 'id');
    }

    public function bookingRooms()
    {
        return $this->hasMany(BookingRoom::class, 'booking_id', 'id');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_rooms', 'booking_id', 'room_id');
    }

    public function room()
    {
        if ($this->rooms()) {
            $room = $this->rooms()->pluck('name')->toArray();
            return implode(', ', $room);
        }

        return null;
    }

    public function diffInDays()
    {
        $check_in = new Carbon($this->attributes['check_in']);
        $check_out = new Carbon($this->attributes['check_out']);

        return $check_out->diffInDays($check_in);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id', 'id');
    }

    public static function generateInvoiceNumber()
    {
        return time();
    }

    public static function invoice()
    {
        $microtime = microtime();
        $comps = explode(' ', $microtime);

        return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
    }

    public function bookingStatus()
    {
        $status = $this->attributes['status'];

        switch ($status) {
            case 'pending':
                return '<span class="badge badge-primary">Pending</span>';
                break;

            case 'approved':
                return '<span class="badge badge-success">Approved</span>';
                break;

            default:
                return '<span class="badge badge-danger">Cancelled</span>';

        }
    }


}
