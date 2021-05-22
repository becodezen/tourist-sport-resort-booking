<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageBooking extends Model
{
    use HasFactory;

    public static function bookingNo()
    {
        return 'PB'.time();
    }

    public function assignPackage()
    {
        return $this->belongsTo(AssignPackage::class, 'assign_package_id', 'id');
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function package()
    {
        $assign_package = $this->assignPackage;

        if ($assign_package) {
            $package = Package::find($assign_package->package_id)->first();

            return $package;
        }

        return null;
    }
}
