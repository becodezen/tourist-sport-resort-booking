<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristSpotArticle extends Model
{
    use HasFactory;

    public function touristSpot()
    {
        return $this->belongsTo(TouristSpot::class, 'tourist_spot_id', 'id');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $this->slugify($value);
    }

    protected function slugify($name)
    {
        $slug = str_replace(' ', '-', strtolower($name));

        $slug = str_replace('.', '', $slug);

        $user = TouristSpotArticle::where('slug', $slug)->get();

        if (count($user) > 0) {
            $slug = $slug.'-'.$user->count();
        }

        return $slug;
    }
}
