<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomFacility extends Model
{
    use HasFactory;

    public function resort()
    {
        return $this->belongsTo(Resort::class, 'resort_id', 'id');
    }
}
