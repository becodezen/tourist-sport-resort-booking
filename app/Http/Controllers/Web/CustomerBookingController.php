<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\Guest;
use App\Models\Resort;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerBookingController extends Controller
{
    public function customerBooking(Request $request, $slug)
    {
        //validation
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
        ];

        $messages = [];

        if ($request->has('is_user')) {
            $rules['name'] = 'required';
            $rules['phone'] = 'required|unique:customers,phone';
            $rules['password'] = 'required|confirmed';
            $rules['password_confirmation'] = 'required';

            $messages = [
                'password_confirmation.required' => 'Confirm Password is required',
                'password.confirmed' => 'Confirm password does not match'
            ];
        }

        $this->validate($request, $rules, $messages);

        if (!$request->get('rooms')) {
            return response()->json([
                'type' => 'warning',
                'title' => 'Room Undefined',
                'message' => 'No booking room select yet'
            ]);
        }

        if ($request->get('check_in') >= $request->get('check_out')) {
            return response()->json([
                'type' => 'warning',
                'title' => 'Date not valid',
                'message' => 'Mismatch check in and out date'
            ]);
        }

        try{
            DB::beginTransaction();

            $resort = Resort::where('slug', $slug)->first();
            $customer_id = null;

            //store customer
            if ($request->has('is_user')) {
                $customer = new Customer();
                $customer->name = $request->get('name');
                $customer->phone = $request->get('phone');
                $customer->email = $request->get('email');
                $customer->otp = rand(111111, 999999);
                $customer->is_verified = 1;
                $customer->password = Hash::make($request->get('password'));
                $customer->otp_verified_at = Carbon::now();
                $customer->save();

                if ($request->get('address')) {
                    $profile = new CustomerProfile();
                    $profile->customer_id = $customer->id;
                    $profile->address = $request->get('address');
                    $profile->save();
                }

                $customer_id = $customer->id;
            }

            if (Auth::guard('customer')->user()) {
                $customer_id = Auth::guard('customer')->user()->id;
            }

            //store guest
            $guest = new Guest();
            $guest->customer_id = $customer_id;
            $guest->name = $request->get('name');
            $guest->phone = $request->get('phone');
            $guest->email = $request->get('email');
            $guest->address = $request->get('address');

            if ($guest->save()) {
                //store booking
                $booking = new Booking();
                $booking->guest_id = $guest->id;
                $booking->resort_id = $resort->id;
                $booking->customer_id = $customer_id;
                $booking->invoice_no = Booking::invoice();
                $booking->sub_total = $request->get('sub_total');
                $booking->grand_total = $request->get('grand_total');
                $booking->issue_date = Carbon::now();
                $booking->check_in = $request->get('check_in');
                $booking->check_out = $request->get('check_out');
                $booking->booked_by = $customer_id ? 'customer' : 'guest';
                $booking->status = 'pending';
                $booking->booking_type = $customer_id ? 'customer_booking' : 'guest_booking';

                if ($booking->save()) {
                    //store booking room information
                    foreach ($request->get('rooms') as $key => $room_id) {
                        $room = Room::find($room_id);
                        $book_room = new BookingRoom();
                        $book_room->booking_id = $booking->id;
                        $book_room->room_id = $room_id;
                        $book_room->room_rate = $room->regular_price;
                        $book_room->check_in = $request->get('check_in');
                        $book_room->check_out = $request->get('check_out');
                        $book_room->save();
                    }
                }

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'title' => 'Thank you',
                    'message' => 'Your booking request has been sent, Please wait for confirmation'
                ]);
            }

            return response()->json([
                'type' => 'warning',
                'title' => 'Failed',
                'message' => 'Failed to booking, please try again'
            ]);

        }catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'title' => 'Something went wrong',
                'message' => 'An error occurred while create customer booking. '.$e->getMessage()
            ]);
        }
    }
}
