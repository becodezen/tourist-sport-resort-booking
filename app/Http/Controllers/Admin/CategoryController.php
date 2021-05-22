<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityRoom;
use App\Models\Resort;
use App\Models\Room;
use App\Models\RoomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $resorts = null;

        $categories = RoomCategory::get();

        /*if ($user->role()->name === 'super_admin') {
            $resorts = Resort::get();
            $user_type = 'system_user';
            $categories = RoomCategory::get();
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $resorts = $user->resort()->id;
            $user_type = 'resort_user';
            $categories = RoomCategory::where('resort_id', $resorts)->get();
        }*/

        $data = [
            'page_title' => 'Room Category List',
            'categories' => $categories
        ];

        return view('dashboard.room.category.index')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
           /* 'resort' => 'required',*/
            'room_type' => 'required',
            'bed_size' => 'required'
        ]);

        //existing category
        $exist = RoomCategory::where('room_type', $request->get('room_type'))
            ->where('bed_size', $request->get('bed_size'))
            ->first();

        if ($exist) {
            return response()->json([
                'type' => 'error',
                'title' => 'Category Exists',
                'message' => 'Room Category Already Exists'
            ]);
        }

        //store room category
        $category = new RoomCategory();
        $category->room_type = $request->get('room_type');
        $category->bed_size = $request->get('bed_size');

        if ($category->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Saved',
                'message' => 'Room Category Saved Successfully',
                'redirect' => route('room.categories')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Room Category Failed to Save'
        ]);
    }

    public function edit($id)
    {
        $user = Auth::user();
        /*$resorts = null;

        if ($user->role()->name === 'super_admin') {
            $resorts = Resort::get();
            $user_type = 'system_user';
            $categories = RoomCategory::get();
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $resorts = $user->resort()->id;
            $user_type = 'resort_user';
            $categories = RoomCategory::where('resort_id', $resorts)->get();
        }*/
        $categories = RoomCategory::get();

        $category = RoomCategory::find($id);

        $data = [
            'page_title' => 'Category List',
            'categories' => $categories,
            'category' => $category,
        ];

        return view('dashboard.room.category.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            /*'resort' => 'required',*/
            'room_type' => 'required',
            'bed_size' => 'required'
        ]);

        //existing category
        $exist = RoomCategory::where('room_type', $request->get('room_type'))
            ->where('bed_size', $request->get('bed_size'))
            ->where('id', '!=', $id)
            ->first();

        if ($exist) {
            return response()->json([
                'type' => 'error',
                'title' => 'Already Exists',
                'message' => 'Room Category Already Exists'
            ]);
        }

        //store room category
        $category = RoomCategory::find($id);
        /*$category->resort_id = $request->get('resort');*/
        $category->room_type = $request->get('room_type');
        $category->bed_size = $request->get('bed_size');

        if ($category->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Updated',
                'message' => 'Room Category Updated Successfully',
                'redirect' => route('room.categories')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Room Category Failed to Update'
        ]);
    }

    public function destroy($id)
    {
        $facility = RoomCategory::find($id);

        if ($facility->delete()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Room Category Deleted Successfully'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Room Category Failed to Delete'
        ]);
    }
}
