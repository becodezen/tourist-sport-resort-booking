<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'resort_user', 'resort_id', 'user_id');
    }

    public function user()
    {
        return $this->users()->first();
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->slugify($value);
    }

    protected function slugify($name)
    {
        $slug = str_replace(' ', '-', strtolower($name));

        $slug = str_replace('.', '', $slug);

        $resort = Resort::where('slug', $slug)->get();

        if (count($resort) > 0) {
            $slug = $slug.'-'.$resort->count();
        }

        return $slug;
    }

    public function facilities()
    {
        return $this->belongsToMany(FacilityResort::class, 'resort_facilities', 'resort_id', 'facility_resort_id');
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

    public function families()
    {
        return $this->hasMany(ResortFamily::class, 'resort_id', 'id');
    }

    public function owner()
    {
        return $this->hasOne(ResortFamily::class, 'resort_id', 'id')->where('type', 'owner');
    }

    public function manager()
    {
        return $this->hasOne(ResortFamily::class, 'resort_id', 'id')->where('type', 'manager');
    }

    public function galleries()
    {
        return $this->hasMany(ResortGallery::class, 'resort_id', 'id')->latest();
    }

    public function thumbnail()
    {
        if ($this->galleries) {
            $thumbnail = $this->galleries->where('is_thumbnail', 1)->first();

            if (!$thumbnail) {
                return $this->galleries->first();
            }

            return $thumbnail;
        }

        return false;
    }

    public function touristSpots()
    {
        return $this->belongsToMany(TouristSpot::class, 'resort_tourist_spots', 'resort_id', 'tourist_spot_id');
    }

    public function touristSpot()
    {
        if ($this->touristSpots()->isNotEmpty()) {
            $this->touristSpots()->first();
        }
        return null;
    }

    public function attachTouristSpot($spot)
    {
        if (is_object($spot)) {
            $spot = $spot->getKey();
        } else if (is_array($spot)) {
            $spot = $spot['id'];
        }

        $this->touristSpots()->attach($spot);
    }

    public function attachTouristSpots($spots)
    {
        foreach ($spots as $spot) {
            $this->attachTouristSpot($spot);
        }
    }

    public function detachTouristSpot($spot)
    {
        if (is_object($spot)) {
            $spot = $spot->getKey();
        } else if (is_array($spot)) {
            $spot = $spot['id'];
        }

        $this->touristSpots()->detach($spot);
    }

    public function detachTouristSpots($spots)
    {
        if (!$spots) $spots = $this->touristSpots()->get();

        foreach ($spots as $spot) {
            $this->detachTouristSpot($spot);
        }
    }

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'season_resort', 'resort_id', 'season_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'resort_id', 'id');
    }

    public function minRoomPrice()
    {
        if ($this->rooms->isNotEmpty()) {
            return $this->rooms->min('regular_price');
        }

        return 0;
    }

    public function maxRoomPrice()
    {
        if ($this->rooms->isNotEmpty()) {
            return $this->rooms->max('regular_price');
        }

        return 0;
    }


}
