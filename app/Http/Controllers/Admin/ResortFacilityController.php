<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityResort;
use App\Models\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResortFacilityController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Resort Facility Manage',
            'facilities' => FacilityResort::get()
        ];

        return view('dashboard.resort.facility.index')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:facility_resorts,name',
            'facility_type' => 'required'
        ];

        $this->validate($request, $rules);

        $facility = new FacilityResort();
        $facility->name = $request->get('name');
        $facility->description = $request->get('description');
        $facility->facility_type = $request->get('facility_type');

        if ($facility->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Saved',
                'message' => 'Resort Facility Saved Successfully',
                'redirect' => route('resort.facilities')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Resort Facility Failed to Save'
        ]);
    }

    public function edit($id)
    {
        $data = [
            'page_title' => 'Resort Facility Manage',
            'facilities' => FacilityResort::get(),
            'facility' => FacilityResort::find($id)
        ];

        return view('dashboard.resort.facility.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:facility_resorts,name,'.$id,
            'facility_type' => 'required'
        ];

        $this->validate($request, $rules);

        $facility = FacilityResort::find($id);
        $facility->name = $request->get('name');
        $facility->description = $request->get('description');
        $facility->facility_type = $request->get('facility_type');

        if ($facility->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Updated',
                'message' => 'Resort Facility Updated Successfully',
                'redirect' => route('resort.facilities')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Resort Facility Failed to Update'
        ]);
    }

    public function destroy(FacilityResort $facility, $id)
    {
        $facility = $facility->find($id);

        if($facility->delete()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Resort Facility Deleted Successfully'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to Delete'
        ]);
    }
}
