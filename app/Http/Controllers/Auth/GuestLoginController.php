<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class GuestLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customer')->except('fr.customer.logout');
    }

    public function showLoginForm()
    {
        $data = [
            'page_title' => 'Login',
            'page_header' => 'Guest Login'
        ];

        return view('frontend.customer.auth.login')->with(array_merge($this->data, $data));
    }

    /**
     * find username or email
     *
     * @return string
     */
    public function username()
    {
        if (filter_var(request()->email, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        } else {
            return 'phone';
        }
    }

    /**
     * login validtion
     *
     * @return string
     */
    public function loginValidation(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Please enter email or phone'
        ]);
    }

    /**
     * attempt login with username or email
     *
     * @return void
     */
    public function login(Request $request)
    {
        $this->loginValidation($request);

        //attempt login with usename or email
        Auth::guard('customer')->attempt([$this->username() => $request->email, 'password' => $request->password]);

        //was any of those correct ?
        if (Auth::guard('customer')->check()) {
            return redirect()->route('fr.dashboard');
        }

        //Nope, something wrong during authentication
        return redirect()->back()->withErrors([
            'email' => 'Invalid Email/Phone or Password'
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }

}
