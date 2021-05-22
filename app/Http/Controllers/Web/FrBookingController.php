<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PackageBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrBookingController extends Controller
{
    public function recentBookingHistory()
    {
        $user = Auth::guard('customer')->user();
        $bookings = Booking::where('customer_id', $user->id)->latest()->take(5)->get();

        $data = [
            'page_title' => 'Recent Booking History',
            'bookings' => $bookings
        ];

        return view('frontend.customer.recent-booking')->with(array_merge($this->data, $data));
    }

    public function bookingHistory()
    {
        $user = Auth::guard('customer')->user();
        $bookings = Booking::where('customer_id', $user->id)->latest()->paginate(10);

        $data = [
            'page_title' => 'Booking History',
            'bookings' => $bookings
        ];

        return view('frontend.customer.booking')->with(array_merge($this->data, $data));
    }

    public function packageBookingHistory()
    {
        $user = Auth::guard('customer')->user();
        $bookings = PackageBooking::where('customer_id', $user->id)->latest()->paginate(10);

        $data = [
            'page_title' => 'Package Booking History',
            'bookings' => $bookings
        ];

        return view('frontend.customer.package-booking')->with(array_merge($this->data, $data));
    }
}
