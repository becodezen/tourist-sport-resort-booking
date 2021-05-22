<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class GuestRegisterController extends Controller
{
        /*
         * Create Account
         * */
        public function createAccount()
        {
            $data = [
                'page_title' => 'Create Account',
                'page_header' => 'Create Account'
            ];

            return view('frontend.customer.auth.register')->with(array_merge($this->data, $data));
        }

    /*
     * Store Register
     * */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required|unique:customers,phone',
            'email' => 'email|unique:customers,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];

        $messages = [
            'password.confirmed' => 'Confirm password does\' not matched',
            'password_confirmation.required' => 'Confirm password required'
        ];

        $this->validate($request, $rules, $messages);

        $guest = new Customer();
        $guest->name = $request->get('name');
        $guest->phone = $request->get('phone');
        $guest->email = $request->get('email');
        $guest->otp = rand(111111, 999999);
        $guest->password = Hash::make($request->get('password'));

        if ($guest->save()) {
            return redirect()->route('fr.otp', $guest->slug);
        }

        return redirect()->back()->with('failed', 'Failed to Register');
    }

    public function otpForm($slug)
    {
        $customer = Customer::where('slug', $slug)->first();
        $resend = false;

        return view('frontend.customer.auth.otp', compact('customer', 'resend'));
    }

    public function otpSubmit(Request $request, $slug)
    {
        $this->validate($request, [
            'otp' => 'required'
        ], [
            'otp.required' => 'Verification code is required'
        ]);

        $customer = Customer::where('slug', $slug)->first();

        //check OTP
        if ($customer->otp != $request->otp) {
            return response()->json([
                'type' => 'warning',
                'title' => 'Mismatch Code',
                'message' => ''
            ]);
        }

        $customer->otp_verified_at = Carbon::now();

        if ($customer->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Congratulation!',
                'message' => 'Verified Successfully | Please Login now',
                'redirect' => route('fr.login')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Opps! Failed',
            'message' => 'An error occurred while verify'
        ]);
    }

    public function otpResend($slug)
    {
        $resend = true;
        $customer = Customer::where('slug', $slug)->first();

        $customer->otp = rand(11111, 99999);
        $customer->otp_verified_at = null;

        if ($customer->save()) {
            return view('frontend.customer.auth.otp', compact('customer', 'resend'));
        }

        abort(403);
    }
}
