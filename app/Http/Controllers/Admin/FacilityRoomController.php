<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityRoom;
use App\Models\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacilityRoomController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        /*$resorts = null;

        if ($user->role()->name === 'super_admin') {
            $resorts = Resort::get();
            $user_type = 'system_user';
            $facilites = FacilityRoom::get();
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $resorts = $user->resort()->id;
            $user_type = 'resort_user';
            $facilites = FacilityRoom::where('resort_id', $resorts)->get();
        }*/

        $facilities = FacilityRoom::get();

        $data = [
            'page_title' => 'Room Facility Manage',
            'facilities' => $facilities,
        ];

        return view('dashboard.room.facility.index')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            /*'resort' => 'required',*/
            'name' => 'required|unique:facility_rooms,name',
            'facility_type' => 'required'
        ];

        $this->validate($request, $rules);

        $facility = new FacilityRoom();
        /*$facility->resort_id = $request->get('resort');*/
        $facility->name = $request->get('name');
        $facility->description = $request->get('description');
        $facility->facility_type = $request->get('facility_type');
        $facility->created_by = Auth::user()->id;

        if ($facility->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Saved',
                'message' => 'Room Facility Saved Successfully',
                'redirect' => route('room.facilities')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Room Facility Failed to Save'
        ]);
    }

    public function edit($id)
    {
        $data = [
            'page_title' => 'Room Facility Manage',
            'facilities' => FacilityRoom::get(),
            'facility' => FacilityRoom::find($id)
        ];

        return view('dashboard.room.facility.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:facility_rooms,name,'.$id,
            'facility_type' => 'required'
        ];

        $this->validate($request, $rules);

        $facility = FacilityRoom::find($id);
        $facility->name = $request->get('name');
        $facility->description = $request->get('description');
        $facility->facility_type = $request->get('facility_type');

        if ($facility->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Updated',
                'message' => 'Room Facility Updated Successfully',
                'redirect' => route('room.facilities')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Room Facility Failed to Update'
        ]);
    }

    public function destroy(FacilityRoom $facility, $id)
    {
        $facility = $facility->find($id);

        if($facility->delete()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Room Facility Deleted Successfully'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to Delete'
        ]);
    }
}
