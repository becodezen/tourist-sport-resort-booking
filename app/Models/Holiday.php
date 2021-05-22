<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    public function holidayDates()
    {
        return $this->hasMany(HolidayDate::class, 'holiday_id', 'id');
    }

    public function getHolidayDateAttribute()
    {
        return user_formatted_date($this->attributes['holiday_date']);
    }

    public function dates()
    {
        $output = '';
        $dates = $this->holidayDates;

        foreach($dates as $date) {
            $output .= user_formatted_date($date->holiday_date) . '<br>';
        }

        return $output;

    }

    public function deleteHolidays($dates)
    {
        foreach($dates as $date)
        {
            $date->delete();
        }
    }

}
