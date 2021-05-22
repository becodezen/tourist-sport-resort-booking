<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageRoute extends Model
{
    use HasFactory;

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }



    public function boardingPoints()
    {
        $output = '';

        $points = $this->attributes['boarding_points'];
        if ($points) {
            $points = explode(',', $points);

            $output .= '<ol class="boarding-points">';

            foreach($points as $point)
            {
                $output .= '<li>'.ucfirst($point).'</li>';
            }

            $output .= '</ol>';
        }

        return $output;
    }

    public function boardingPointsInArray()
    {

        $packages = $this->attributes['boarding_points'];

        $explodes = explode(',', $packages);

        return $explodes;
    }
}
