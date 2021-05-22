<?php

namespace App\Http\Controllers;

use App\Models\BookingRoom;
use App\Models\Division;
use App\Models\District;
use App\Models\Guest;
use App\Models\Package;
use App\Models\PackageRoute;
use App\Models\Resort;
use App\Models\Room;
use App\Models\RoomPrice;
use App\Models\Season;
use App\Models\TouristSpot;
use App\Models\Upazila;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AjaxLoadController extends Controller
{
    public function getDistrict(Request $request)
    {
        $districts = District::select('id', 'name')->where('division_id', $request->get('division_id'))->get();

        if ($districts) {
            return response()->json([
                'status' => 'success',
                'data' => $districts,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'data' => null,
        ]);
    }

    public function getUpazila(Request $request)
    {
        $upazilas = Upazila::select('id', 'name')->where('district_id', $request->get('district_id'))->get();

        if ($upazilas) {
            return response()->json([
                'status' => 'success',
                'data' => $upazilas,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'data' => null,
        ]);
    }

    public function getSeason(Request $request)
    {
        $resort = Resort::find($request->get('resort_id'));
        $seasons = $resort->seasons;

        if ($seasons) {
            return response()->json([
                'status' => 'success',
                'data' => $seasons,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'data' => null,
        ]);
    }

    public function getSeasonWithRoom(Request $request)
    {
        $resort = Resort::find($request->get('resort_id'));
        $seasons = $resort->seasons;
        $room = Room::find($request->get('room_id'));
        $roomSeason = $room->seasonPrices;

        if ($seasons) {
            return response()->json([
                'status' => 'success',
                'data' => $seasons,
                'room' => $roomSeason
            ]);
        }

        return response()->json([
            'status' => 'error',
            'data' => null,
        ]);
    }

    public function getRooms(Request $request)
    {
        $check_in = $request->get('check_in');
        $check_out = $request->get('check_out');
        $resort = $request->get('resort_id');
        //existing room for the resort
        $booked_rooms = BookingRoom::whereHas('booking', function ($q) use ($resort) {
                    $q->where('resort_id', $resort)->whereIn('status', ['pending','approved']);
                })
                ->where([['check_in', '<=', database_formatted_date($check_in)], ['check_out', '>', database_formatted_date($check_in)]])
                ->orWhere([['check_in', '<', database_formatted_date($check_out)], ['check_out', '>', database_formatted_date($check_out)]])
                ->get();


        $room_ids = [];

        if ($booked_rooms->isNotEmpty()) {
            $room_ids = $booked_rooms->pluck('room_id')->toArray();
        }

        if ($request->get('resort_id') && $request->get('check_in') && !$request->has('category_id')) {
            $rooms = Room::with('category', 'facilities', 'seasonPrices')
                ->where('resort_id', $request->resort_id)
                ->whereNotIn('id', $room_ids)
                ->get();
        } else {
            $rooms = Room::with('category', 'facilities', 'seasonPrices')
                ->whereIn('room_category_id', $request->category_id)
                ->where('resort_id', $request->resort_id)
                ->whereNotIn('id', $room_ids)
                ->get();
        }

        $resort_id = $request->get('resort_id');

        $check_in_date = $request->get('check_in');

        $prices = RoomPrice::whereHas('room', function($q) use ($resort_id) {
                                $q->where('rooms.resort_id', $resort_id);
                            })
                            ->whereHas('season', function ($q) use ($check_in_date) {
                                $q->where('dates', 'like', '%'.$check_in_date.'%');
                            })
                        ->get();


        if ($rooms) {
            return response()->json([
                'status' => 'success',
                'data' => $rooms,
                'prices' => $prices
            ]);
        }

        return response()->json([
            'status' => 'error',
            'data' => null,
        ]);
    }

    public function getGuestList(Request $request)
    {
        $guests = Guest::where('resort_id', $request->get('resort_id'))
            ->where('phone', 'LIKE', $request->get('phone').'%')
            ->get();

        if ($guests->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'data' => $guests,
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => null,
        ]);
    }

    public function getSingleGuest(Request $request)
    {
        $guest = Guest::find($request->get('guest_id'));

        if ($guest) {
            return response()->json([
                'status' => true,
                'data' => $guest,
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => null,
        ]);
    }

    public function getQuickBookingRooms(Request $request)
    {
        $check_in = $request->get('check_in');
        $check_out = $request->get('check_out');
        $resort = $request->get('resort_id');
        //existing room for the resort
        $booked_rooms = BookingRoom::whereHas('booking', function ($q) use ($resort) {
            $q->where('resort_id', $resort)->whereIn('status', ['pending','approved']);
        })
        ->where([['check_in', '<=', database_formatted_date($check_in)], ['check_out', '>', database_formatted_date($check_in)]])
        ->orWhere([['check_in', '<', database_formatted_date($check_out)], ['check_out', '>', database_formatted_date($check_out)]])
        ->get();

        $room_ids = [];

        if ($booked_rooms->isNotEmpty()) {
            $room_ids = $booked_rooms->pluck('room_id')->toArray();
        }

        $rooms = Room::with('category', 'facilities', 'seasonPrices')
            ->where('resort_id', $request->resort_id)
            ->whereNotIn('id', $room_ids)
            ->get();

        $resort_id = $request->get('resort_id');

        $check_in_date = $request->get('check_in');

        $prices = RoomPrice::whereHas('room', function($q) use ($resort_id) {
                                $q->where('rooms.resort_id', $resort_id);
                            })
                            ->whereHas('season', function ($q) use ($check_in_date) {
                                $q->where('dates', 'like', '%'.$check_in_date.'%');
                            })
                        ->get();

        if ($rooms) {
            return response()->json([
                'status' => 'success',
                'data' => $rooms,
                'prices' => $prices
            ]);
        }

        return response()->json([
            'status' => 'error',
            'data' => null,
        ]);
    }

    public function getGuest(Request $request)
    {
        $guest = Guest::find($request->get('guest_id'));

        if ($guest) {
            return response()->json([
                'status' => 'success',
                'data' => $guest
            ]);
        }

        return response()->json([
            'status' => 'error',
            'data' => null,
        ]);
    }

    public function getRoomBookingCalendar(Request $request)
    {
        $month = Carbon::make($request->calendarDate);
        $next_month = Carbon::make($request->calendarDate)->addMonth();
        $prev_month = Carbon::make($request->calendarDate)->previous();

        $dayNameArr = [
            'Saturday' => 1,
            'Sunday' => 2,
            'Monday' => 3,
            'Tuesday' => 4,
            'Wednesday' => 5,
            'Thursday' => 6,
            'Friday' => 7
        ];

        $data = [
            'page_title' => 'Booking Calendar',
            'month' => $month->format('F'),
            'year' => $month->year,
            'days' => $month->daysInMonth,
            'start_day_name' => $month->firstOfMonth()->dayName,
            'prev_month' => $prev_month->format('F-Y'),
            'next_month' => $next_month->format('F-Y'),
            'day_name_arr' => $dayNameArr
        ];

        $output = '';

        for($i=1;$i<=$dayNameArr[$data['start_day_name']];$i++) {
            if ($i == $dayNameArr[$data['start_day_name']]) {
                for ($d=1;$d<=$data['days'];$d++) {
                    $output .= '<div class="date"  data-toggle="modal" data-target=".day-modal">
    <strong>'.$d.'</strong>
</div>';
                }
            } else {
                $output .= '<div class="date inactive"></div>';
            }
        }

        return response()->json([
            'status' => true,
            'data' => $data,
            'html' => $output,
        ]);
    }

    public function getDestination(Request $request)
    {
        $destinations = null;

        $touristSpot = TouristSpot::where('name', 'LIKE', $request->get('destination').'%')
            ->orderBy('name', 'ASC')
            ->get()->pluck('name')->toArray();

        $divisions = Division::where('name', 'LIKE', $request->get('destination').'%')
            ->orderBy('name', 'ASC')
            ->get()->pluck('name')->toArray();

        $districts = District::where('name', 'LIKE', $request->get('destination').'%')
            ->orderBy('name', 'ASC')
            ->get()->pluck('name')->toArray();

        $destinations = array_merge($touristSpot, array_merge($districts, $divisions));

        if ($destinations) {
            return response()->json([
                'status' => true,
                'data' => array_unique($destinations)
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'No match data found'
        ]);
    }

    public function getResorts(Request $request)
    {
        $resorts = null;

        $resorts = Resort::where('name', 'LIKE', '%'.$request->get('resort').'%')
            ->orderBy('name', 'ASC')
            ->get()->pluck('name')->toArray();

        if ($resorts) {
            return response()->json([
                'status' => true,
                'data' => array_unique($resorts)
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'No match data found'
        ]);
    }

    public function getPackage(Request $request)
    {
        $package = null;

        $package = Package::find($request->get('package_id'));

        if ($package) {
            return response()->json([
                'status' => true,
                'data' => $package->toArray()
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => null
        ]);
    }

}
