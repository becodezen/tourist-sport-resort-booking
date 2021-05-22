<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    use HasFactory;

    public $appends = ['full_name'];

//    public function resort()
//    {
//        return $this->belongsTo(Resort::class, 'resort_id', 'id');
//    }

    public function getFullNameAttribute()
    {
        return $this->attributes['room_type'].' ('.$this->attributes['bed_size'].')';
    }
}
