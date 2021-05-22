<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityRoom;
use App\Models\Resort;
use App\Models\RoomGallery;
use App\Models\Room;
use App\Models\RoomCategory;
use App\Models\RoomPrice;
use App\Services\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::paginate(10);

        /*if ($user->role()->name === 'super_admin') {
            $rooms = Room::paginate(10);
            $user_type = 'system_user';
        }else if ($user->role()->name === 'admin' || $user->role()->name === 'manager') {
            $rooms = Room::where('resort_id', $user->resort()->id)->paginate(10);
            $user_type = 'resort_user';
        }*/

        $data = [
            'page_title' => 'Room list',
            'rooms' => $rooms,
        ];

        return view('dashboard.room.index')->with(array_merge($this->data, $data));
    }

    public function create()
    {
        $categories = RoomCategory::get();
        $facilities = FacilityRoom::get();
        $resorts = Resort::get();

        $data = [
            'page_title' => 'Add Room',
            'resorts' => $resorts,
            'categories' => $categories,
            'facilities' => $facilities,
        ];

        return view('dashboard.room.create')->with(array_merge($this->data, $data));
    }

    /*
     * Store Rooms for the Resort*/
    public function store(Request $request)
    {
        $rules = [
            'resorts' => 'required',
            'name' => 'required',
            'category' => 'required',
            'regular_price' => 'required',
        ];

        $this->validate($request, $rules);

        try {
            DB::beginTransaction();

            $rooms = explode(',', $request->get('name'));

            foreach ($rooms as $room) {
                if (empty($room) || $room === null || $room === '') {
                    continue;
                }

                //check exists or not
                $exits = Room::where('resort_id', $request->get('resort'))->where('name', $room)->first();

                if ($exits) {
                    DB::rollBack();
                    return response()->json([
                        'type' => 'warning',
                        'title' => 'Already Exists',
                        'message' => $room . 'Room Already Exists'
                    ]);
                }

                //store room information
                $resort_room = new Room();
                $resort_room->resort_id = $request->get('resorts');
                $resort_room->room_category_id = $request->get('category');
                $resort_room->name = $room;
                $resort_room->size = $request->get('size');
                $resort_room->capacity = $request->get('capacity');
                $resort_room->regular_price = $request->get('regular_price');
                $resort_room->weekend_price = $request->get('weekend_price');
                $resort_room->holiday_price = $request->get('holiday_price');
                $resort_room->short_description = $request->get('short_description');
                $resort_room->description = $request->get('description');
                $resort_room->created_by = Auth::user()->id;

                if ($resort_room->save()) {
                    //store room facilities information
                    if ($request->get('facilities')) {
                        $resort_room->attachFacilities($request->get('facilities'));
                    }

                    //store room seasonal price information
                    if ($request->has('seasons')) {
                        foreach ($request->get('seasons') as $key => $season) {
                            $season_price = new RoomPrice();
                            $season_price->room_id = $resort_room->id;
                            $season_price->season_id = $season;
                            $season_price->price = $request->get('season_price')[$key];
                            $season_price->weekend_price = $request->get('season_weekend_price')[$key];
                            $season_price->holiday_price = $request->get('season_holiday_price')[$key];
                            $season_price->created_by = Auth::user()->id;
                            $season_price->save();
                        }
                    }
                } else {
                    throw new \Exception('Failed to store room');
                }
            }

            DB::commit();

            return response()->json([
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Resorts Rooms are Store Successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'title' => 'Something went wrong',
                'message' => 'An error occurred while creating Room' . $e->getMessage().$e->getLine()
            ]);
        }
    }

    public function show($id)
    {
        $data = [
            'page_title' => 'Room Details',
            'room' => Room::find($id),
        ];

        return view('dashboard.room.show')->with(array_merge($this->data, $data));
    }

    /*
     * Room Edit
     * */
    public function edit(Request $request, $id)
    {
        $categories = RoomCategory::get();
        $facilities = FacilityRoom::get();
        $resorts = Resort::get();
        $room = Room::find($id);

        $data = [
            'page_title' => 'Update Room',
            'resorts' => $resorts,
            'categories' => $categories,
            'facilities' => $facilities,
            'room' => $room
        ];

        return view('dashboard.room.edit')->with(array_merge($this->data, $data));
    }


    /*
     * Update Rooms for the Resort*/
    public function update(Request $request, $id)
    {
        $rules = [
            'resorts' => 'required',
            'name' => 'required',
            'category' => 'required',
            'regular_price' => 'required',
        ];

        $this->validate($request, $rules);

        try {
            DB::beginTransaction();

                //check exists or not
                $exits = Room::where('resort_id', $request->get('resort'))
                    ->where('name', $request->get('name'))
                    ->where('id', '!=', $id)
                    ->first();

                if ($exits) {
                    DB::rollBack();
                    return response()->json([
                        'type' => 'warning',
                        'title' => 'Already Exists',
                        'message' => $request->get('name') . ' Room Already Exists'
                    ]);
                }

                //store room information
                $resort_room = Room::find($id);
                $resort_room->resort_id = $request->get('resorts');
                $resort_room->room_category_id = $request->get('category');
                $resort_room->name = $request->get('name');
                $resort_room->size = $request->get('size');
                $resort_room->capacity = $request->get('capacity');
                $resort_room->regular_price = $request->get('regular_price');
                $resort_room->weekend_price = $request->get('weekend_price');
                $resort_room->holiday_price = $request->get('holiday_price');
                $resort_room->short_description = $request->get('short_description');
                $resort_room->description = $request->get('description');
                $resort_room->created_by = Auth::user()->id;

                if ($resort_room->save()) {
                    //store room facilities information
                    if ($request->get('facilities')) {
                        $resort_room->detachFacilities($resort_room->facilities);
                        $resort_room->attachFacilities($request->get('facilities'));
                    }

                    //store room seasonal price information
                    if ($request->has('seasons')) {
                        foreach ($request->get('seasons') as $key => $season) {
                            if ($request->get('season_price')[$key]) {
                                $season_price = RoomPrice::where('season_id', $season)->where('room_id', $resort_room->id)->first();

                                if (!$season_price) {
                                    $season_price = new RoomPrice();
                                    $season_price->room_id = $resort_room->id;
                                    $season_price->season_id = $season;
                                    $season_price->created_by = Auth::user()->id;
                                }

                                $season_price->price = $request->get('season_price')[$key];
                                $season_price->weekend_price = $request->get('season_weekend_price')[$key];
                                $season_price->holiday_price = $request->get('season_holiday_price')[$key];
                                $season_price->save();
                            } else {
                                RoomPrice::where('season_id', $season)->where('room_id', $resort_room->id)->delete();
                            }
                        }
                    }
                } else {
                    throw new \Exception('Failed to update room');
                }

            DB::commit();

            return response()->json([
                'type' => 'success',
                'title' => 'Updated',
                'message' => 'Resorts Room updated successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'title' => 'Something went wrong',
                'message' => 'An error occurred while updating Room' . $e->getMessage().$e->getLine()
            ]);
        }
    }

    /*
     * Room Delete
     * */
    public function destroy(Room $room, $id)
    {
        $room = $room->find($id);

        if ($room->delete())
        {
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Failed to delete Room'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to delete Room'
        ]);
    }

    public function gallery($id)
    {
        $data = [
            'page_title' => 'Photo Gallery',
            'room' => Room::find($id),
        ];

        return view('dashboard.room.photo-gallery')->with(array_merge($this->data, $data));
    }

    public function storePhoto(Request $request, $id)
    {
        $rules = [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ];

        $this->validate($request, $rules);

        $photo = new RoomGallery();
        $photo->room_id = $id;
        $photo->image = FileUpload::uploadWithResize($request, 'photo', 'galleries', 960, 720);
        $photo->caption = $request->get('caption');

        if ($request->has('thumbnail')) {
            $thumbnail_photo = RoomGallery::where('room_id', $id)->where('is_thumbnail', 1)->first();
            if ($thumbnail_photo) {
                $thumbnail_photo->is_thumbnail = 0;
                $thumbnail_photo->save();
            }

            $photo->is_thumbnail = 1;
        }

        if ($photo->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Uploaded',
                'message' => 'Photo uploaded successfully',
                'redirect' => route('room.photo.gallery', $id)
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to upload photo'
        ]);
    }

    public function deletePhoto($id, $photo_id)
    {
        $gallery = RoomGallery::find($photo_id);
        $image = $gallery->image;
        $is_thumbnail = false;

        if ($gallery->is_thumbnail) {
            $is_thumbnail = true;
        }

        if ($gallery->delete()) {
            // delete photo
            if ($image) {
                unlink($image);
            }

            // update delete photo is thumbnail for the resort
            if ($is_thumbnail) {
                $new_thumbnail = RoomGallery::latest()->first();

                if ($new_thumbnail) {
                    $new_thumbnail->is_thumbnail = true;
                    $new_thumbnail->save();
                }
            }

            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Gallery Deleted Successfully',
                'parent' => '.col-lg-3'
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed',
            'message' => 'Failed to Delete'
        ]);
    }
}
