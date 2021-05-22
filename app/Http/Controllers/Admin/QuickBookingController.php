<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\Guest;
use App\Models\Resort;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuickBookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role()->name === 'super_admin') {
            $bookings = Booking::where('booking_type', 'quick_booking')->latest()->paginate(10);
            $user_type = 'system_user';
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $resort = $user->resort();
            $bookings = Booking::where('resort_id', $resort->id)->where('booking_type', 'quick_booking')->paginate(10);
            $user_type = 'resort_user';
        }

        $data = [
            'page_title' => 'Booking List',
            'bookings' => $bookings,
            'user_type' => $user_type
        ];

        return view('dashboard.quick-booking.index')->with(array_merge($this->data, $data));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role()->name === 'super_admin') {
            $resorts = Resort::get();
            $user_type = 'system_user';
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $resorts = $user->resort();
            $user_type = 'resort_user';
        }

        $data = [
            'page_title' => 'Quick Booking',
            'resorts' => $resorts,
            'user_type' => $user_type
        ];

        return view('dashboard.quick-booking.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            'resort' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'guest_phone' => 'required',
        ];

        $this->validate($request, $rules);

        try {
            DB::beginTransaction();

            $user = Auth::user();

            if ($user->role()->name === 'super_admin') {
                $booked_by = 'admin';
            }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
                $booked_by = 'resort';
            }

            //store guest information
            $guest = new Guest();
            $guest->resort_id = $request->get('resort');
            $guest->name = $request->get('guest_name');
            $guest->phone = $request->get('guest_phone');
            $guest->address = $request->get('guest_address');

            if ($guest->save()) {
                //store booking
                $booking = new Booking();
                $booking->guest_id = $guest->id;
                $booking->resort_id = $request->get('resort');
                $booking->invoice_no = Booking::invoice();
                $booking->issue_date = Carbon::now();
                $booking->check_in = $request->get('check_in');
                $booking->check_out = $request->get('check_out');
                $booking->booked_by = $booked_by;
                $booking->status = 'approved';
                $booking->booking_type = 'quick_booking';

                if ($booking->save()) {
                    //store room
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
                    'title' => 'Congratulations!',
                    'message' => 'Quick Booking Approved'
                ]);
            }

            return response()->json([
                'type' => 'warning',
                'title' => 'Failed',
                'message' => 'Failed to booking'
            ]);


        }
        catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'title' => 'Something went wrong',
                'message' => 'An error occurred while creating ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $booking = Booking::find($id);

        $data = [
            'page_title' => 'Details of Quick Booking',
            'booking' => $booking
        ];

        return view('dashboard.quick-booking.show')->with(array_merge($this->data, $data));
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
