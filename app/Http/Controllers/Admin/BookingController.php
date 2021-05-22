<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Booking;
use App\Models\BookingPayment;
use App\Models\BookingRoom;
use App\Models\Guest;
use App\Models\Member;
use App\Models\Resort;
use App\Models\Room;
use App\Models\RoomCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role()->name === 'super_admin') {
            $bookings = Booking::latest()->paginate(15);
            $user_type = 'system_user';
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $resort = $user->resort();
            $bookings = Booking::where('resort_id', $resort->id)->latest()->paginate(15);
            $user_type = 'resort_user';
        }

        $data = [
            'page_title' => 'Booking List',
            'bookings' => $bookings,
            'user_type' => $user_type,
            'filter_by' => 'all'
        ];

        return view('dashboard.booking.index')->with(array_merge($this->data, $data));
    }

    public function guestBooking()
    {
        $user = Auth::user();

        if ($user->role()->name === 'super_admin') {
            $bookings = Booking::where('booked_by', 'guest')->latest()->paginate(15);
            $user_type = 'system_user';
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $resort = $user->resort();
            $bookings = Booking::where('resort_id', $resort->id)->where('booked_by', 'guest')->latest()->paginate(15);
            $user_type = 'resort_user';
        }

        $data = [
            'page_title' => 'Booking List',
            'bookings' => $bookings,
            'user_type' => $user_type,
            'filter_by' => 'guest'
        ];

        return view('dashboard.booking.index')->with(array_merge($this->data, $data));
    }

    public function customerBooking()
    {
        $user = Auth::user();

        if ($user->role()->name === 'super_admin') {
            $bookings = Booking::where('booked_by', 'customer')->latest()->paginate(15);
            $user_type = 'system_user';
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $resort = $user->resort();
            $bookings = Booking::where('resort_id', $resort->id)->where('booked_by', 'customer')->latest()->paginate(15);
            $user_type = 'resort_user';
        }

        $data = [
            'page_title' => 'Booking List',
            'bookings' => $bookings,
            'user_type' => $user_type,
            'filter_by' => 'customer'
        ];

        return view('dashboard.booking.index')->with(array_merge($this->data, $data));
    }

    public function resortBooking()
    {
        $user = Auth::user();

        if ($user->role()->name === 'super_admin') {
            $bookings = Booking::where('booked_by', 'resort')->latest()->paginate(15);
            $user_type = 'system_user';
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $resort = $user->resort();
            $bookings = Booking::where('resort_id', $resort->id)->where('booked_by', 'resort')->latest()->paginate(15);
            $user_type = 'resort_user';
        }

        $data = [
            'page_title' => 'Booking List',
            'bookings' => $bookings,
            'user_type' => $user_type,
            'filter_by' => 'resort'
        ];

        return view('dashboard.booking.index')->with(array_merge($this->data, $data));
    }

    public function adminBooking()
    {
        $user = Auth::user();

        if ($user->role()->name === 'super_admin') {
            $bookings = Booking::where('booked_by', 'admin')->latest()->paginate(15);
            $user_type = 'system_user';
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $resort = $user->resort();
            $bookings = Booking::where('resort_id', $resort->id)->where('booked_by', 'admin')->latest()->paginate(15);
            $user_type = 'resort_user';
        }

        $data = [
            'page_title' => 'Booking List',
            'bookings' => $bookings,
            'user_type' => $user_type,
            'filter_by' => 'customer'
        ];

        return view('dashboard.booking.index')->with(array_merge($this->data, $data));
    }

    public function show($id)
    {
        $booking = Booking::find($id);

        $data = [
            'page_title' => 'Details of Booking',
            'booking' => $booking
        ];

        return view('dashboard.booking.show')->with(array_merge($this->data, $data));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role()->name === 'super_admin') {
            $resorts = Resort::whereHas('rooms')->orderBy('name', 'ASC')->get();
            $user_type = 'system_user';
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $resorts = $user->resort();
            $user_type = 'resort_user';
        }
        $new_invoice_no = rand(111111111111, 999999999999);

        $data = [
            'page_title' => 'Create Booking',
            'categories' => RoomCategory::get(),
            'invoice' => $new_invoice_no,
            'guests' => Guest::all(),
            'resorts' => $resorts,
            'user_type' => $user_type
        ];

        return view('dashboard.booking.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            'resort' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
        ];

        $guest_rules = [
            'guest_name' => 'required',
            'guest_phone' => 'required'
        ];

        if ($request->get('paid_amount') > 0) {
            $rules['payment_method'] = 'required';
        }

        $rules = array_merge($rules, $guest_rules);

        $this->validate($request, $rules);

        try {
            DB::beginTransaction();
            //store guest information
            if ($request->get('guest_id')){
                $guest = Guest::find($request->get('guest'));

            } else {
                $guest = new Guest();
                $guest->resort_id = $request->get('resort');
                $guest->name = $request->get('guest_name');
                $guest->phone = $request->get('guest_phone');
                $guest->email = $request->get('guest_email');
                $guest->company = $request->get('company');
                $guest->address = $request->get('address');
                $guest->identity = $request->get('identity');
                $guest->save();
            }

            if ($guest) {
                $user = Auth::user();

                if ($user->role()->name === 'super_admin') {
                    $booked_by = 'admin';
                }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
                    $booked_by = 'resort';
                }

                //store booking information
                $booking = new Booking();
                $booking->guest_id = $guest->id;
                $booking->resort_id = $request->get('resort');
                $booking->invoice_no = Booking::invoice();
                $booking->sub_total = $request->get('sub_total');
                //$booking->vat = $request->get('tax');
                //$booking->vat_amount = $request->get('tax');
                $booking->discount = $request->get('discount') ? $request->get('discount') : 0;
                $booking->grand_total = $request->get('grand');
                $booking->adult = $request->get('adult_member');
                $booking->child = $request->get('child_member');
                $booking->issue_date = Carbon::now();
                $booking->check_in = $request->get('check_in');
                $booking->check_out = $request->get('check_out');
                $booking->booked_by = $booked_by;
                $booking->status = 'approved';
                $booking->created_by = Auth::user()->id;

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

                    //booking billing information
                    if ($request->get('bill_address') || $request->get('bill_city') || $request->get('bill_country') || $request->get('bill_postal_code')) {
                        $billing = new Billing();
                        $billing->booking_id = $booking->id;
                        $billing->address = $request->get('bill_address');
                        $billing->city = $request->get('bill_city');
                        $billing->country = $request->get('bill_country');
                        $billing->post_code = $request->get('bill_postal_code');
                        $billing->save();
                    }

                    //booking payment information
                    if ($request->get('paid_amount') > 0) {
                        $payment = new BookingPayment();
                        $payment->resort_id = $request->get('resort');
                        $payment->booking_id = $booking->id;
                        $payment->paid = $request->get('paid_amount');
                        $payment->payment_method = $request->get('payment_method');
                        $payment->payment_date = database_formatted_date(Carbon::now());
                        $payment->save();
                    }

                    //store member information
                    if ($request->has('member_adult')) {
                        foreach ($request->get('member_adult') as $key => $adult) {
                            if ($request->get('adult_name')[$key] != null) {
                                $member = new Member();
                                $member->booking_id = $booking->id;
                                $member->name = $request->get('adult_name')[$key];
                                $member->age  = $request->get('adult_age')[$key];
                                $member->member_type  = 'adult';
                                //add phone, email, identity
                                $member->save();
                            }
                        }
                    }

                    //store child member information
                    if ($request->has('member_child')) {
                        foreach ($request->get('member_child') as $key => $child) {
                            if ($request->get('child_name')[$key] != null) {
                                $member = new Member();
                                $member->booking_id = $booking->id;
                                $member->name = $request->get('child_name')[$key];
                                $member->age  = $request->get('child_age')[$key];
                                $member->member_type  = 'child';
                                //add phone, email, identity
                                $member->save();
                            }
                        }
                    }
                }

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'title' => 'Congratulations',
                    'message' => 'Booking Stored Successfully'
                ]);
            }

            return response()->json([
                'type' => 'warning',
                'title' => 'Failed',
                'message' => 'Failed to booking'
            ]);


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'title' => 'Something went wrong',
                'message' => 'An error occurred while creating ' . $e->getMessage()
            ]);
        }
    }

    public function bookingCalendarResort()
    {
        $user = Auth::user();

        if ($user->role()->name === 'super_admin') {
            $resorts = Resort::where('is_active', 1)->get();
        } else {
            abort(403, 'Unauthorized access');
        }

        $data = [
            'page_title' => 'Booking calendar',
            'resorts' => $resorts,
        ];

        return view('dashboard.calendar.index')->with(array_merge($this->data, $data));
    }

    public function bookingCalendarRoom(Request $request)
    {
        $month = Carbon::now();
        $next_month = Carbon::now()->addMonth();
        $prev_month = Carbon::now()->previous();
        $resort = Resort::find($request->get('resort'));

        $dayNameArr = [
            'Saturday' => 1,
            'Sunday' => 2,
            'Monday' => 3,
            'Tuesday' => 4,
            'Wednesday' => 5,
            'Thursday' => 6,
            'Friday' => 7
        ];

        $room = $resort->rooms->first();

        //booked for this month
        $booked_rooms = BookingRoom::where('room_id', $room->id)->whereMonth('check_in', $month->format('m'))->get()->pluck('check_in, check_out')->toArray();


        //pending for this month

        //hold for this month

        $data = [
            'page_title' => 'Booking Calendar',
            'resort' => $resort,
            'b_room' => $room,
            'month' => $month->format('F'),
            'year' => $month->year,
            'days' => $month->daysInMonth,
            'start_day_name' => $month->firstOfMonth()->dayName,
            'prev_month' => $prev_month->format('F-Y'),
            'next_month' => $next_month->format('F-Y'),
            'day_name_arr' => $dayNameArr
        ];

        return view('dashboard.calendar.calendar')->with(array_merge($this->data, $data));
    }

    public function bookingCalendar()
    {
        $user = Auth::user();
        $month = Carbon::now();
        $next_month = Carbon::now()->addMonth();
        $prev_month = Carbon::now()->previous();

        if ($user->role()->name == 'super_admin')
        {
            abort(403, 'Unauthorized');
        }

        $resort = $user->resort();

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
            'resort' => $resort,
            'month' => $month->format('F'),
            'year' => $month->year,
            'days' => $month->daysInMonth,
            'start_day_name' => $month->firstOfMonth()->dayName,
            'prev_month' => $prev_month->format('F-Y'),
            'next_month' => $next_month->format('F-Y'),
            'day_name_arr' => $dayNameArr
        ];

        return view('dashboard.calendar.calendar')->with(array_merge($this->data, $data));
    }

    public function invoice($id)
    {
        $booking = Booking::find($id);

        $data = [
            'page_title' => 'Details of Booking',
            'booking' => $booking
        ];

        return view('dashboard.booking.show')->with(array_merge($this->data, $data));
    }

    public function approveBooking(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->status = 'approved';

        if ($booking->save()) {
            //notification create

            return response()->json([
                'type' => 'success',
                'title' => 'Thank you',
                'message' => 'Booking approved successfully',
                'redirect' => route('booking.show', $id)
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to approve booking'
        ]);
    }

    public function cancelBooking(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->status = 'cancelled';

        if ($booking->save()) {
            //notification create

            return response()->json([
                'type' => 'success',
                'title' => 'Booking Cancelled',
                'message' => 'Booking cancelled successfully',
                'redirect' => route('booking.show', $id)
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to canceled booking'
        ]);
    }
}
