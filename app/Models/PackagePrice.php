<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagePrice extends Model
{
    use HasFactory;

    protected $appends = ['price_unit'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getPriceUnitAttribute()
    {
        $price = $this->attributes['price'];
        $unit = $this->attributes['unit'];

        if ($unit) {
            return $price .' ('. $unit . ' Per Unit)';
        }

        return $price;
    }
}
