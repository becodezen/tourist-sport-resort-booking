<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->slugify($value);
    }

    protected function slugify($name)
    {
        $slug = str_replace(' ', '-', strtolower($name));

        $slug = str_replace('.', '', $slug);

        $resort = Package::where('slug', $slug)->get();

        if (count($resort) > 0) {
            $slug = $slug.'-'.$resort->count();
        }

        return $slug;
    }

    public function assignPackages()
    {
        return $this->hasMany(AssignPackage::class, 'package_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function packageRoutes()
    {
        return $this->hasMany(PackageRoute::class, 'package_id', 'id');
    }

    public function packagePrices()
    {
        return $this->hasMany(PackagePrice::class, 'package_id', 'id');
    }

}
