<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AssignPackage;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Models\Guest;
use App\Models\PackageBooking;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PackagesController extends Controller
{
    public function index()
    {
        $assigns = AssignPackage::whereDate('check_in', '>=', database_formatted_date(Carbon::now()))->paginate(10);

        $data = [
            'page_title' => 'Packages',
            'page_header' => 'Packages',
            'assigns' => $assigns
        ];

        return view('frontend.package.index')->with(array_merge($this->data, $data));
    }

    public function packageDetails($slug, $assign_id)
    {
        $assign = AssignPackage::find($assign_id);

        $data = [
            'page_title' => 'View Details of Package',
            'page_header' => 'View Details of Pakcage',
            'assign' => $assign
        ];

        return view('frontend.package.show')->with(array_merge($this->data, $data));
    }

    public function packageBooking(Request $request, $assign_id)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'member' => 'required',
            'package_route' => 'required',
            'boarding_point' => 'required'
        ];

        if ($request->get('boarding_point') == 'Other') {
            $rules['custom_boarding_point'] = 'required';
        }

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

        try {
            DB::beginTransaction();

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

            //store guest information
            $guest = new Guest();

            $guest->customer_id  = $customer_id;
            $guest->name = $request->get('name');
            $guest->phone = $request->get('phone');
            $guest->email = $request->get('email');
            $guest->address = $request->get('address');

            if ($guest->save()) {
                //store package
                $apb = new PackageBooking();
                $apb->booking_no = PackageBooking::bookingNo();
                $apb->assign_package_id = $assign_id;
                $apb->package_route_id = $request->get('package_route');
                $apb->guest_id = $guest->id;
                $apb->member = $request->get('member');
                $apb->customer_id = $guest->customer_id;
                if ($request->get('custom_boarding_point')) {
                    $apb->boarding_point = $request->get('custom_boarding_point');
                } else {
                    $apb->boarding_point = $request->get('boarding_point');
                }
                $apb->note = $request->get('note');
                $apb->price = $request->get('package_price');
                $apb->total_price = $request->has('total_price') ? $request->get('total_price') : 0;
                $apb->save();

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'title' => 'Thank you',
                    'message' => 'Please wait for confirmation, Your package request has been sent.',
                    'redirect' => route('fr.package.booking.pending.invoice', $apb->booking_no)
                ]);
            }

        }catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'warning',
                'title' => 'Something went wrong',
                'message' => 'Package booking request did not sent, try again '.$e->getMessage()
            ]);
        }

    }


    public function pendingInvoice($booking_no)
    {
        $data = [
            'page_title' => 'View Details of Package',
            'page_header' => 'View Details of Pakcage',
            'booking' => PackageBooking::where('booking_no', $booking_no)->first()
        ];

        $pdf = PDF::loadView('frontend.package.pending-invoice', $data)->setPaper('a5')->setWarnings(false);

        return $pdf->stream('pkg-'.time().'-'.$booking_no.'.pdf');
    }

    public function invoice($booking_no)
    {
        $data = [
            'page_title' => 'View Details of Package',
            'page_header' => 'View Details of Pakcage',
            'booking' => PackageBooking::where('booking_no', $booking_no)->first()
        ];

        return view('frontend.package.invoice')->with(array_merge($this->data, $data));
    }
}
