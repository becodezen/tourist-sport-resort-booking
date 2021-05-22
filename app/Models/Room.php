<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public $appends = ['room_price'];

    public function resort()
    {
        return $this->belongsTo(Resort::class, 'resort_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(RoomCategory::class, 'room_category_id', 'id');
    }

    public function seasonPrices()
    {
        return $this->hasMany(RoomPrice::class, 'room_id', 'id');
    }


    public function getRoomPriceAttribute()
    {
        $today = database_formatted_date(Carbon::now());

        $season = $this->seasonPrices()->whereHas('season', function ($q) use ($today){
                    $q->where('dates', 'like', '%'.$today.'%');
                })->first();

        if ($season) {
            return $season->price;
        }

        return $this->attributes['regular_price'];
    }

    public function facilities()
    {
        return $this->belongsToMany(FacilityRoom::class, 'room_facilities', 'room_id', 'facility_room_id');
    }

    public function attachFacility($facility)
    {
        if (is_object($facility)) {
            $facility = $facility->getKey();
        } else if (is_array($facility)) {
            $facility = $facility['id'];
        }

        $this->facilities()->attach($facility);
    }

    public function attachFacilities($facilities)
    {
        foreach ($facilities as $facility) {
            $this->attachFacility($facility);
        }
    }

    public function detachFacility($facility)
    {
        if (is_object($facility)) {
            $facility = $facility->getKey();
        } else if (is_array($facility)) {
            $facility = $facility['id'];
        }

        $this->facilities()->detach($facility);
    }

    public function detachFacilities($facilities)
    {
        if (!$facilities) $facilities = $this->facilities()->get();

        foreach ($facilities as $facility) {
            $this->detachFacility($facility);
        }
    }

    public function hasFacility($facility)
    {
        if (is_object($facility)) {
            $facility = $facility->name;
        }
        if (is_array($facility)) {
            $facility = $facility['name'];
        }

        if ($this->facilities()->where('name', $facility)->first()) {
            return true;
        }

        return false;
    }

    public function galleries()
    {
        return $this->hasMany(RoomGallery::class, 'room_id', 'id');
    }

    public function bookingRooms()
    {
        $bookedRooms = $this->bookedRooms->toArray();
        $quickBookedRooms = $this->quickBookedRooms->toArray();

        return array_merge($bookedRooms, $quickBookedRooms);
    }

    public function bookedRooms()
    {
        return $this->hasMany(BookedRoom::class, 'room_id', 'id');
    }

    public function quickBookedRooms()
    {
        return $this->hasMany(QuickBookingRoom::class, 'room_id', 'id');
    }

    public function price()
    {
        return $this->attributes['regular_price'];
    }

    public function facilityList()
    {
        $facilities = $this->facilities->pluck('name')->toArray();


        if ($facilities) {
            $merge = implode(', ', $facilities);

            return 'Facilities: '.$merge;
        }

        return false;
    }

    public function thumbnail()
    {
        if ($this->galleries->isNotEmpty()) {
            return asset($this->galleries->first()->image);
        }

        return asset('frontend/assets/img/room-dummy.png');
    }


}
