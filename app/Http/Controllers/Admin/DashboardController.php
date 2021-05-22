<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Guest;
use App\Models\Resort;
use App\Models\TouristSpot;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Dashboard',
            'resorts' => Resort::get()->count(),
            'spots' => TouristSpot::get()->count(),
            'bookings' => Booking::get()->count(),
            'guests' => Guest::get()->count() + Customer::get()->count(),
        ];

        return view('dashboard.index')->with(array_merge($this->data, $data));
    }
}
