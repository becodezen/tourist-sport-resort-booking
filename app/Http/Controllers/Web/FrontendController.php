<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AssignPackage;
use App\Models\Booking;
use App\Models\District;
use App\Models\Division;
use App\Models\Resort;
use App\Models\Slider;
use App\Models\TouristSpot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function index()
    {
        $resorts = Resort::orderBy('name', 'ASC')
        ->get()->pluck('name')->toArray();

        $touristSpot = TouristSpot::orderBy('name', 'ASC')
            ->get()->pluck('name')->toArray();

        $divisions = Division::orderBy('name', 'ASC')
            ->get()->pluck('name')->toArray();

        $districts = District::orderBy('name', 'ASC')
            ->get()->pluck('name')->toArray();

        $destinations = array_merge($resorts, array_merge($touristSpot, array_merge($districts, $divisions)));

        $keywords = array_unique($destinations);

        $packages = AssignPackage::orderBy('created_at', 'DESC')->whereDate('check_in', '>=', database_formatted_date(Carbon::now()))->get();

        $data = [
            'tourist_spots' => TouristSpot::take(6)->get(),
            'resorts' => Resort::take(15)->get(),
            'divisions' => Division::get(),
            'testimonials' => null,
            'blogs' => null,
            'packages' => $packages,
            'sliders' => Slider::latest()->get(),
            'keywords' => $keywords
        ];


        return view('frontend.index')->with(array_merge($this->data, $data));
    }

    public function underConstruction()
    {
        $data = [
            'page_title' => 'Under Construction',
            'page_header' => 'Under Construction',
        ];

        return view('frontend.uc')->with(array_merge($this->data, $data));
    }

    public function dashboard()
    {
        $user = Auth::guard('customer')->user();
        $bookings = Booking::where('customer_id', $user->id)->latest()->take(5)->get();

        $data = [
            'customer' => $user ,
            'page_title' => 'Dashboard',
            'bookings' => $bookings
        ];

        return view('frontend.customer.index')->with(array_merge($this->data, $data));
    }

    public function logout()
    {
        Auth::guard('customer')->logout();

        return redirect()->route('fr.home');
    }

    public function searchResult(Request $request)
    {
        $search_key = $request->get('destination');
        $check_in = database_formatted_date($request->get('check_in'));
        $check_out = database_formatted_date($request->get('check_out'));
        $guest_number = null;
        if ($request->has('guest_number') && $request->get('guest_number')) {
            $guest_number = $request->get('guest_number');
        } else if ($request->get('guest_number_input')) {
            $guest_number = $request->get('guest_number_input');
        }

        //search resorts
        $resorts = Resort::whereHas('rooms')
            ->whereHas('touristSpots', function($q) use($search_key) {
                $q->where('name', 'LIKE', '%'.$search_key.'%')
                ->orWhereHas('division', function($trq) use ($search_key) {
                    $trq->where('name', 'LIKE', '%'.$search_key.'%');
                })
                ->orWhereHas('district', function($trq) use ($search_key) {
                    $trq->where('name', 'LIKE', '%'.$search_key.'%');
            });
        })
        ->orWhere('name', 'LIKE', '%'.$search_key.'%')
        ->take(10)->get();

        //create session for check in and checkout
        Session::put('check_in_date', $request->get('check_in'));
        Session::put('check_out_date', $request->get('check_out'));
        Session::put('guest_number', $guest_number);

        $data = [
            'page_title' => 'Search Result',
            'resorts' => $resorts,
            'search_data' => $request->all(),
        ];

        return view('frontend.search.index')->with(array_merge($this->data, $data));
    }

}
