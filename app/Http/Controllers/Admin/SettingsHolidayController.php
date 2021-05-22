<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use App\Models\HolidayDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsHolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $data = [
            'page_title' => 'Holiday',
            'holidays' => Holiday::get(),
        ];

        return view('dashboard.settings.holiday.index')->with(array_merge($this->data, $data));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required'
        ];

        $this->validate($request, $rules);

        if (!$request->get('holiday_dates')) {
            return response()->json([
                'type' => 'warning',
                'title' => 'Warning',
                'message' => 'No Date Select',
            ]);
        }

        try {
            DB::beginTransaction();

            $holiday = new Holiday();
            $holiday->name = $request->get('name');
            $holiday->description = $request->get('description');

            if ($holiday->save()) {

                foreach ($request->get('holiday_dates') as $date) {
                    $holiday_date = new HolidayDate();
                    $holiday_date->holiday_id = $holiday->id;
                    $holiday_date->holiday_date = $date;
                    $holiday_date->save();
                }

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'title' => 'Congratulations',
                    'message' => 'Holiday Saved successfully',
                    'redirect' => route('holiday.list')
                ]);
            }

            return response()->json([
                'type' => 'warning',
                'title' => 'Failed to store holiday',
                'message' => 'Failed to store holiday',
            ]);

        }  catch(\Exception $e){
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'title' => 'An error occurred',
                'message' => 'an error occurred while create holiday. '.$e->getMessage(),
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        $data = [
            'page_title' => 'Edit holiday',
            'holidays' => Holiday::get(),
            'holiday' => Holiday::find($id)
        ];

        return view('dashboard.settings.holiday.edit')->with(array_merge($this->data, $data));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required'
        ];

        $this->validate($request, $rules);

        if (!$request->get('holiday_dates')) {
            return response()->json([
                'type' => 'warning',
                'title' => 'Warning',
                'message' => 'No Date Select',
            ]);
        }

        try {
            DB::beginTransaction();

            $holiday = Holiday::find($id);
            $holiday->name = $request->get('name');
            $holiday->description = $request->get('description');

            if ($holiday->save()) {

                //remove old_date
                $old_dates = $holiday->deleteHolidays($holiday->holidayDates);

                foreach ($request->get('holiday_dates') as $date) {
                    $holiday_date = new HolidayDate();
                    $holiday_date->holiday_id = $holiday->id;
                    $holiday_date->holiday_date = $date;
                    $holiday_date->save();
                }

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'title' => 'Congratulations',
                    'message' => 'Holiday Saved successfully',
                    'redirect' => route('holiday.list')
                ]);
            }

            return response()->json([
                'type' => 'warning',
                'title' => 'Failed to store holiday',
                'message' => 'Failed to store holiday',
            ]);

        }catch(\Exception $e){
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'title' => 'An error occurred',
                'message' => 'an error occurred while create holiday. '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $holiday = Holiday::find($id);

        if ($holiday->delete()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Holiday deleted successfully',
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to delete holiday',
        ]);
    }
}
