<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristSpot extends Model
{
    use HasFactory;

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class, 'upazila_id', 'id');
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

        $spot = TouristSpot::where('slug', $slug)->get();

        if (count($spot) > 0) {
            $slug = $slug.'-'.$spot->count();
        }

        return $slug;
    }

    public function galleries()
    {
        return $this->hasMany(TouristSpotGallery::class, 'tourist_spot_id', 'id');
    }

    public function instructions()
    {
        return $this->hasMany(TouristSpotInstruction::class, 'tourist_spot_id', 'id');
    }


    public function articles()
    {
        return $this->hasMany(TouristSpotArticle::class, 'tourist_spot_id', 'id');
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

    public function resorts()
    {
        return $this->belongsToMany(Resort::class, 'resort_tourist_spots', 'tourist_spot_id', 'resort_id');
    }
}
