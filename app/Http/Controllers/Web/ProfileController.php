<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerProfile;
use App\Services\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function editProfile()
    {
        $data = [
            'customer' => Auth::user(),
            'page_title' => 'Update Profile'
        ];

        return view('frontend.customer.edit-profile')->with(array_merge($this->data, $data));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'gender' => 'required',
            'photo' => 'mimes:jpg,jpeg,png'
        ]);

        $customer = Auth::user();

        $customer_photo = false;

        if ($customer->profile) {
            $profile  = $customer->profile;
            if ($profile->photo) {
                $customer_photo = true;
            }
        } else {
            $profile = new CustomerProfile();
            $profile->customer_id = $customer->id;
        }

        if ($request->hasFile('photo')) {
            $path = FileUpload::uploadWithResize($request, 'photo', 'customers', 180, 180);

            if ($customer_photo) {
                unlink($profile->photo);
            }

            $profile->photo = $path;
        }

        $profile->gender = $request->get('gender');
        $profile->address = $request->get('address');
        $profile->identity = $request->get('identity');
        $profile->birthdate = $request->birthdate ? database_formatted_date($request->get('birthdate')) : null;

        if ($profile->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Profile Updated',
                'message' => 'Profile has been updated successfully',
                'redirect' => route('fr.update.profile')
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Something went wrong',
            'message' => 'Failed to update profile'
        ]);

    }

    public function changePassword()
    {
        $data = [
            'customer' => Auth::user(),
            'page_title' => 'Change Password'
        ];

        return view('frontend.customer.change-password')->with(array_merge($this->data, $data));
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ], [
            'password.required' => 'New password required',
            'password.confirmed' => 'Confirm password doesn\'t match'
        ]);

        $customer = Auth::user();

        //check current password matched or not
        if (!Hash::check($request->get('current_password'), $customer->password)) {
            return response()->json([
                'type' => 'warning',
                'title' => 'Password mismatch',
                'message' => 'Entered current password is wrong'
            ]);
        }

        $customer->password = Hash::make($request->password);

        if ($customer->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Updated',
                'message' => 'Password Updated Successfully',
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed',
            'message' => 'Password failed to update'
        ]);

    }



}
