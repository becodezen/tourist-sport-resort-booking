<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BookingRoom;
use App\Models\District;
use App\Models\Division;
use App\Models\Resort;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ResortsController extends Controller
{
    public function index()
    {
        $divisions = Division::orderBy('name', 'ASC')->get();
        $districts = District::orderBy('name', 'ASC')->get();
        $data = [
            'page_title' => 'Resorts',
            'resorts' => Resort::paginate(10),
            'divisions' => $divisions,
            'districts' => $districts,

        ];

        return view('frontend.resort.index')->with(array_merge($this->data, $data));
    }

    public function show($slug)
    {
        $resort = Resort::where('slug', $slug)->first();
        $guest_number = null;
        if (Session::has('check_in_date')) {
            $check_in = database_formatted_date(Session::get('check_in_date'));
            $check_out = database_formatted_date(Session::get('check_out_date'));
            $guest_number = Session::get('guest_number') ? Session::get('guest_number') : null;

            Session::forget('check_in_date');
            Session::forget('check_out_date');

            $booked_rooms = BookingRoom::whereHas('booking', function ($q) use ($resort) {
                        $q->where('resort_id', $resort->id)->whereIn('status', ['pending', 'approved']);
                    })
                    ->where([['check_in', '<=', database_formatted_date($check_in)], ['check_out', '>', database_formatted_date($check_in)]])
                    ->orWhere([['check_in', '<', database_formatted_date($check_out)], ['check_out', '>', database_formatted_date($check_out)]])
                ->get();

            $room_ids = [];

            if ($booked_rooms->isNotEmpty()) {
                $room_ids = $booked_rooms->pluck('room_id')->toArray();
            }

            if ($guest_number) {
                $rooms = Room::with('category', 'facilities', 'seasonPrices')
                ->where('resort_id', $resort->id)
                ->where('capacity', '>=', $guest_number)
                ->whereNotIn('id', $room_ids)
                ->get();
            } else {
                $rooms = Room::with('category', 'facilities', 'seasonPrices')
                ->where('resort_id', $resort->id)
                ->whereNotIn('id', $room_ids)
                ->get();
            }


        } else {
            $check_in = null;
            $check_out = null;
            $rooms = null;
        }

        $data = [
            'page_title' => 'View Details of '. $resort->name,
            'resort' => $resort,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'guest_number' => $guest_number,
            'rooms' => $rooms
        ];

        return view('frontend.resort.show')->with(array_merge($this->data, $data));
    }


}
