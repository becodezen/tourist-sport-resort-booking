<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BookingRoom;
use App\Models\Customer;
use App\Models\OtpGenerate;
use App\Models\PackageRoute;
use App\Models\Room;
use Illuminate\Http\Request;

class FrontendAjaxLoadController extends Controller
{
    public function otpGenerate(Request $request)
    {
        //check if the number is alreay customer or not
        $customer = Customer::where('phone', $request->phone)->first();
        if ($customer) {
            return response()->json([
                'status' => false,
                'message' => 'You\'re already an guest, Please sign in'
            ]);
        }

        $otp = new OtpGenerate();
        $otp->phone = $request->get('phone');
        $otp->otp = rand(111111, 999999);

        if ($otp->save()) {
            return response()->json([
                'status' => true,
                'otp' => $otp,
                'message' => "OTP has been sent"
            ]);
        }

        return response()->json([
            'status' => false,
            'otp' => null
        ]);
    }

    public function guestOtpVerify(Request $request)
    {
        $otp = OtpGenerate::where('phone', $request->get('phone'))
                            ->where('is_verified', 0)
                            ->latest()
                            ->first();

        if ($otp) {
            if ($otp->otp == $request->get('otp')) {
                $otp->is_verified = 1;
                if ($otp->save()) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Congaratulation! verified successfully'
                    ]);
                }
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to verify'
        ]);
    }

    public function getResortRoom(Request $request)
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


        if ($request->get('guest_capacity')) {
            $rooms = Room::with('category', 'facilities', 'seasonPrices')
                ->where('resort_id', $resort)
                ->where('capacity', '>=', $request->get('guest_capacity'))
                ->whereNotIn('id', $room_ids,)
                ->get();
        } else {
            $rooms = Room::with('category', 'facilities', 'seasonPrices')
                ->where('resort_id', $resort)
                ->whereNotIn('id', $room_ids)
                ->get();
        }

        if ($rooms->isNotEmpty()) {
            $output = '';
            foreach($rooms as $room) {
                $output .= '<div class="room">
                                <label class="room-label">
                                    <div>
                                        <input type="checkbox" name="rooms[]" class="room_id" value="'.$room->id.'">
                                        <span>'.$room->name.' ('.$room->capacity.')</span>
                                    </div>
                                    <span class="room_price">'.$room->price().'</span>
                                </label>
                            </div>';
            }

            return response()->json([
                'status' => true,
                'rooms' => $output
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'No room avaiable'
        ]);
    }

    public function getPackageBoardingPoint(Request $request)
    {
        $package_routes = PackageRoute::find($request->get('package_route_id'));

        if ($package_routes) {
            $boarding_points = $package_routes->boarding_points;
            $b_points = explode(', ', $boarding_points);
            $b_points = array_merge($b_points, ['Other']);

            return response()->json([
                'status' => true,
                'boarding_points' => $b_points
            ]);
        }

        return response()->json([
            'status' => false,
            'boarding_points' => null
        ]);
    }
}
