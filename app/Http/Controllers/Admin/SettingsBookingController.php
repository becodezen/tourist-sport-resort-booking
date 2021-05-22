<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsBookingController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Booking Settings',
            'settings' => Settings::first()
        ];

        return view('dashboard.settings.booking.index')->with(array_merge($this->data, $data));
    }

    public function bookingSettings(Request $request)
    {
        $rules = [];

        if ($request->get('is_vat')) {
            $rules['vat_amount'] = 'required';
            $rules['vat_type'] = 'required';
        }


        $this->validate($request, $rules);

        $settings = Settings::first();

        if(!$settings) {
            $settings = new Settings();
        }

        if($request->get('weekend_price')) {
            $settings->is_weekend_price = 1;
        } else {
            $settings->is_weekend_price = 0;
        }

        if($request->get('holiday_price')) {
            $settings->is_holiday_price = 1;
        } else {
            $settings->is_holiday_price = 0;
        }

        if($request->get('is_vat')) {
            $settings->is_vat_active = 1;
            $settings->vat = $request->get('vat_amount');
            $settings->vat_type = $request->get('vat_type');
        } else {
            $settings->is_vat_active = 0;
            $settings->vat = 0;
            $settings->vat_type = null;
        }

        if ($settings->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Congratulations',
                'message' => 'Saved changes successfully',
                'redirect' => route('setting.booking.list')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to save the changes'
        ]);
    }

}
