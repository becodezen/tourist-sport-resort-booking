<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityResort;
use App\Models\Resort;
use App\Models\ResortFamily;
use App\Models\ResortGallery;
use App\Models\Role;
use App\Models\TouristSpot;
use App\Models\User;
use App\Services\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResortController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Resort List',
            'resorts' => Resort::paginate(10)
        ];

        return view('dashboard.resort.index')->with(array_merge($this->data, $data));
    }

    public function show($id)
    {
        $data = [
            'page_title' => 'Resort View Details',
            'resort' => Resort::find($id)
        ];

        return view('dashboard.resort.show')->with(array_merge($this->data, $data));
    }

    public function create()
    {
        $data = [
            'page_title' => 'Create Resort',
             'inside_facilities' => FacilityResort::where('facility_type', 'inside')->get(),
            'outside_facilities' => FacilityResort::where('facility_type', 'outside')->get(),
            'tourist_spots' => TouristSpot::get()
        ];

        return view('dashboard.resort.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ];

        $this->validate($request, $rules);

        try {
            DB::beginTransaction();
            //store resort
            $resort = new Resort();
            $resort->name = $request->get('name');
            $resort->phone = $request->get('phone');
            $resort->address = $request->get('address');
            $resort->email = $request->get('email');
            $resort->lat = $request->get('lat');
            $resort->lon = $request->get('lon');
            $resort->short_description = $request->get('short_description');
            $resort->description = $request->get('resort_description');
            $resort->instruction = $request->get('resort_instruction');
            $resort->video_link = $request->get('video_link');
            $resort->video_link_3d = $request->get('video_link_3d');

            if ($resort->save()) {
                //store resort facility
                if ($request->has('facilities')) {
                    foreach ($request->get('facilities') as $facility) {
                        $resort->attachFacility($facility);
                    }
                }

                //store nearest tourist spot
                if ($request->get('tourist_spots')) {
                    $resort->attachTouristSpots($request->get('tourist_spots'));
                }

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'title' => 'Success',
                    'message' => 'Resort Stored Successfully',
                    'redirect' => route('resort.photo.gallery', $resort->id)
                ]);

            }

            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'Failed to store resort'
            ]);

        }catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'title' => 'Warning',
                'message' => 'An error occurred while create resort '. $e->getMessage()
            ]);

        }
    }

    public function edit($id)
    {
        $data = [
            'page_title' => 'Update Resort',
            'resort' => Resort::find($id),
            'inside_facilities' => FacilityResort::where('facility_type', 'inside')->get(),
            'outside_facilities' => FacilityResort::where('facility_type', 'outside')->get(),
            'tourist_spots' => TouristSpot::get()
        ];

        return view('dashboard.resort.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ];

        $this->validate($request, $rules);

        try {
            DB::beginTransaction();
            //store resort
            $resort = Resort::find($id);
            $resort->name = $request->get('name');
            $resort->phone = $request->get('phone');
            $resort->address = $request->get('address');
            $resort->email = $request->get('email');
            $resort->lat = $request->get('lat');
            $resort->lon = $request->get('lon');
            $resort->short_description = $request->get('short_description');
            $resort->description = $request->get('resort_description');
            $resort->instruction = $request->get('resort_instruction');
            $resort->video_link = $request->get('video_link');
            $resort->video_link_3d = $request->get('video_link_3d');

            if ($resort->save()) {
                //store resort facility
                if ($request->has('facilities')) {
                    //first detach all current facilities
                    $resort->detachFacilities($resort->facilities);
                    //add new facilities
                    foreach ($request->get('facilities') as $facility) {
                        $resort->attachFacility($facility);
                    }
                }

                //store nearest tourist spot
                if ($request->get('tourist_spots')) {
                    $resort->detachTouristSpots($resort->touristSpots);
                    $resort->attachTouristSpots($request->get('tourist_spots'));
                }

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'title' => 'Success',
                    'message' => 'Resort Updated Successfully'
                ]);

            }

            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'Failed to update resort'
            ]);

        }catch(\Exception $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'title' => 'Warning',
                'message' => 'An error occurred while update resort '. $e->getMessage()
            ]);

        }
    }

    public function gallery($id)
    {
        $data = [
            'page_title' => 'Photo Gallery',
            'resort' => Resort::find($id),
        ];

        return view('dashboard.resort.photo-gallery')->with(array_merge($this->data, $data));
    }

    public function storePhoto(Request $request, $id)
    {
        $rules = [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ];

        $this->validate($request, $rules);

        try {
            $photo = new ResortGallery();
            $photo->resort_id = $id;
            $photo->image = FileUpload::uploadWithResize($request, 'photo', 'galleries', 960, 720);
            $photo->caption = $request->get('caption');

            if ($request->has('thumbnail')) {
                $thumbnail_photo = ResortGallery::where('resort_id', $id)->where('is_thumbnail', 1)->first();
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
                    'redirect' => route('resort.photo.gallery', $id)
                ]);
            }

            return response()->json([
                'type' => 'warning',
                'title' => 'Failed',
                'message' => 'Failed to upload photo'
            ]);
        }catch(\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'An error occurred while store photo in galery. '.$e->getMessage()
            ]);
        }
    }

    public function deletePhoto($id, $photo_id)
    {
        $gallery = ResortGallery::find($photo_id);
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
                $new_thumbnail = ResortGallery::latest()->first();

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


    public function destroy(Resort $resort, $id)
    {
        $resort = $resort->find($id);

        //delete owner photo
        if ($resort->owner->photo) {
            unlink($resort->owner->photo);
        }
        //delete manager photo
        if ($resort->manager->photo) {
            unlink($resort->manager->photo);
        }

        if ($resort->delete) {
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Resort deleted successfully'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to delete Resort'
        ]);
    }

    /*
     * Resort User Create
     * */
    public function createResortUser($resort_id)
    {
        $data = [
            'page_title' => 'Create Resort User',
            'resort' => Resort::find($resort_id)
        ];

        return view('dashboard.resort.family.create')->with(array_merge($this->data, $data));
    }


    /*
     * Resort User Store
     * */
    public function storeResortUser(Request $request, $resort_id)
    {
        $rules = [
            'name' => 'required',
            'user_type' => 'required',
            'phone' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'photo' => 'mimes:jpg,jpeg,png|max:1024'
        ];

        //validation
        $this->validate($request, $rules);

        try {
            DB::beginTransaction();
            //store resort owner as user
            $user = new User();
            $user->name = $request->get('name');
            $user->username = $request->get('phone');
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));

            if ($user->save()) {
                $role = Role::where('name', $request->get('user_type'))->first();
                $user->attachRole($role->id);
                $user->attachResort($resort_id);

                $family = new ResortFamily();
                $family->resort_id = $resort_id;
                $family->user_id = $user->id;
                $family->name = $request->get('name');
                $family->phone = $request->get('phone');
                $family->email = $request->get('email');
                if ($request->get('user_type') == 'admin') {
                    $family->type = 'owner';
                } else {
                    $family->type = 'manager';
                }

                //store owner photo
                if ($request->hasFile('photo')) {
                    $path = FileUpload::uploadWithResize($request, 'photo', 'resort-users', 150, 150);
                    $family->photo = $path;
                }

                if ($family->save()) {

                    DB::commit();

                    return response()->json([
                        'type' => 'success',
                        'title' => 'Congratulation',
                        'message' => 'Resort User Saved Successfully'
                    ]);
                } else {
                    throw  new \Exception('Something went wrong');
                }

            } else {
                throw  new \Exception('Something went wrong');
            }

        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'An error occurred while add new user '. $e->getMessage()
            ]);
        }
    }

    /*
     * Resort User Create
     * */
    public function editResortUser($resort_id, $id)
    {
        $family = ResortFamily::find($id);
        if ($family->type == 'owner') {
            $user_type = 'admin';
        } else {
            $user_type = 'manager';
        }

        $data = [
            'page_title' => 'Update Resort User',
            'resort' => Resort::find($resort_id),
            'family' => $family,
            'user_type' => $user_type
        ];

        return view('dashboard.resort.family.edit')->with(array_merge($this->data, $data));
    }


    /*
     * Resort User Store
     * */
    public function updateResortUser(Request $request, $resort_id, $id)
    {
        return response()->json([
            'type' => 'warning',
            'title' => 'Progressing',
            'message' => 'Update is on progress'
        ]);

        $rules = [
            'name' => 'required',
            'user_type' => 'required',
            'phone' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'photo' => 'mimes:jpg,jpeg,png|max:1024'
        ];

        //validation
        $this->validate($request, $rules);

        try {
            DB::beginTransaction();
            //store resort owner as user
            $user = new User();
            $user->name = $request->get('name');
            $user->username = $request->get('phone');
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));

            if ($user->save()) {
                $role = Role::where('name', $request->get('user_type'))->first();
                $user->attachRole($role->id);
                $user->attachResort($resort_id);

                $family = new ResortFamily();
                $family->resort_id = $resort_id;
                $family->user_id = $user->id;
                $family->name = $request->get('name');
                $family->phone = $request->get('phone');
                $family->email = $request->get('email');
                if ($request->get('user_type') == 'admin') {
                    $family->type = 'owner';
                } else {
                    $family->type = 'manager';
                }

                //store owner photo
                if ($request->hasFile('photo')) {
                    $path = FileUpload::uploadWithResize($request, 'photo', 'resort-users', 150, 150);
                    $family->photo = $path;
                }

                if ($family->save()) {

                    DB::commit();

                    return response()->json([
                        'type' => 'success',
                        'title' => 'Congratulation',
                        'message' => 'Resort User Saved Successfully'
                    ]);
                } else {
                    throw  new \Exception('Something went wrong');
                }

            } else {
                throw  new \Exception('Something went wrong');
            }

        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'success',
                'title' => 'Congratulation',
                'message' => 'An error occurred while add new user '. $e->getMessage()
            ]);
        }
    }

    public function destroyResortUser($resort_id, $id)
    {
        $family = ResortFamily::find($id);
        $image = $family->photo ? $family->photo : null;
        if ($family->delete()) {
            if ($image) {
                unlink($image);
            }

            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Deleted Successfully'
            ]);
        }
        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to delete'
        ]);
    }




}
