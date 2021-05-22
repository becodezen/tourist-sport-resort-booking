<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\TouristSportGallery;
use App\Models\TouristSpot;
use App\Models\TouristSpotGallery;
use App\Models\Upazila;
use App\Services\FileUpload;
use Illuminate\Http\Request;

class TouristSpotController extends Controller
{
    public function index()
    {
        $spots = TouristSpot::where('is_active', 1)->get();

        $data = [
            'page_title' => 'Tourist Spots',
            'spots' => $spots,
        ];

        return view('dashboard.touristspot.index')->with(array_merge($this->data, $data));
    }

    public function show($id)
    {
        $spot = TouristSpot::find($id);

        $data = [
            'page_title' => 'View Details',
            'spot' => $spot,
        ];

        return view('dashboard.touristspot.show')->with(array_merge($this->data, $data));
    }


    public function create()
    {
        $divisions = Division::all();
        $data = [
            'page_title' => 'Create New Tourist Spot',
            'divisions' => $divisions
        ];

        return view('dashboard.touristspot.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:tourist_spots,name',
        ];

        $this->validate($request, $rules);

        $spot  = new TouristSpot();
        $spot->name = $request->get('name');
        $spot->division_id = $request->get('division');
        $spot->district_id = $request->get('district');
        $spot->upazila_id = $request->get('upazila');
        $spot->lat = $request->get('lat');
        $spot->lon = $request->get('lon');
        $spot->short_description = $request->get('short_description');
        $spot->description = $request->get('description');
        $spot->route_plan = $request->get('route_plan');
        $spot->instruction = $request->get('instruction');
        $spot->travel_cost = $request->get('travel_cost');
        $spot->warning = $request->get('warning');

        if ($request->get('tags')) {
            $exp = explode(',', $request->get('tags'));
            $spot->tags = json_encode($exp);
        }

        $spot->video_link = $request->get('video_link');

        if ($spot->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Success',
                'message' => 'Tourist spot stored successfully',
                'redirect' => route('tourist.spot.gallery', $spot->id)
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to store tourist spot'
        ]);
    }

    public function edit($id)
    {
        $spot = TouristSpot::find($id);
        $divisions = Division::all();
        $districts = District::where('division_id', $spot->division_id)->get();
        $upazilas = Upazila::where('district_id', $spot->district_id)->get();

        $data = [
            'page_title' => 'Update Tourist Spot',
            'spot' => $spot,
            'divisions' => $divisions,
            'districts' => $districts,
            'upazilas' => $upazilas,
        ];

        return view('dashboard.touristspot.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:tourist_spots,name,'.$id,
        ];

        $this->validate($request, $rules);

        $spot  = TouristSpot::find($id);
        $spot->division_id = $request->get('division');
        $spot->district_id = $request->get('district');
        $spot->upazila_id = $request->get('upazila');
        $spot->name = $request->get('name');
        $spot->lat = $request->get('lat');
        $spot->lon = $request->get('lon');
        $spot->short_description = $request->get('short_description');
        $spot->description = $request->get('description');
        $spot->route_plan = $request->get('route_plan');
        $spot->instruction = $request->get('instruction');
        $spot->travel_cost = $request->get('travel_cost');
        $spot->warning = $request->get('warning');

        if ($request->get('tags')) {
            $exp = explode(',', $request->get('tags'));
            $spot->tags = json_encode($exp);
        }

        $spot->video_link = $request->get('video_link');


        if ($spot->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Updated',
                'message' => 'Tourist spot has been updated successfully'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to update tourist spot'
        ]);
    }

    public function destroy(TouristSpot $spot, $id)
    {
        $spot = $spot->find($id);
        //unlink photo
        if ($spot) {

            if ($spot->delete()) {
                return response()->json([
                    'type' => 'success',
                    'title' => 'Deleted',
                    'message' => 'The Tourist spot deleted successfully'
                ]);
            }

            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => 'Failed to delete Tourist spot'
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Invalid',
            'message' => 'No Tourist Spot Found'
        ]);
    }

    /*
     * Create Tourist Gallery
     * */
    public function gallery($tourist_spot_id)
    {
        $data = [
            'page_title' => 'Galleries',
            'page_header' => 'Gallery',
            'galleries' => TouristSpotGallery::where('tourist_spot_id', $tourist_spot_id)->get(),
            'tourist_spot' => TouristSpot::find($tourist_spot_id),
        ];

        return view('dashboard.touristspot.gallery')->with(array_merge($this->data, $data));
    }

    /*
     * Store Gallery of Tourist Spot
     * */
    public function storeGallery(Request $request, $tourist_spot_id)
    {
        $rules = [
            'photo' => 'required|mimes:jpg,jpeg,png'
        ];

        $this->validate($request, $rules);

        $photo = new TouristSpotGallery();
        $photo->tourist_spot_id = $tourist_spot_id;
        $photo->image = FileUpload::uploadWithResize($request, 'photo', 'galleries', 960, 720);
        $photo->caption = $request->get('caption');

        if ($request->has('thumbnail')) {
            $default_photo = TouristSpotGallery::where('tourist_spot_id', $tourist_spot_id)->where('is_thumbnail', 1)->first();
            if ($default_photo) {
                $default_photo->is_thumbnail = 0;
                $default_photo->save();
            }

            $photo->is_thumbnail = 1;
        }

        if ($photo->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Congrats',
                'message' => 'Photo has been uploaded successfully',
                'redirect' => route('tourist.spot.gallery', $tourist_spot_id)
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to upload photo'
        ]);
    }

    public function deleteGallery($tourist_spot_id, $gallery_id)
    {
        $gallery = TouristSportGallery::find($gallery_id);
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
                $new_thumbnail = TouristSportGallery::latest()->first();

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
