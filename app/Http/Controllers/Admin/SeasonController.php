<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\Resort;
use App\Models\RoomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SeasonController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Season Setup',
            'pricings' => Season::all()
        ];

        return view('dashboard.season.index')->with(array_merge($this->data, $data));
    }

    public function create()
    {
        $resorts = Resort::get();

        $data = [
            'page_title' => 'Create Season',
            'resorts' => $resorts,
        ];

        return view('dashboard.season.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:seasons,name',
        ];

        $this->validate($request, $rules);

        if (!$request->get('resort')) {
            return response()->json([
                'type' => 'warning',
                'title' => 'Warning',
                'message' => 'No Resort select'
            ]);
        }

        if (!$request->get('season_dates')) {
            return response()->json([
                'type' => 'warning',
                'title' => 'Warning',
                'message' => 'No Season Date select'
            ]);
        }

        try {
            DB::beginTransaction();

            $season = new Season();
            $season->name = $request->get('name');
            $season->dates = json_encode($request->get('season_dates'));
            $season->created_by = Auth::user()->id;

            if ($season->save()) {
                $season->assignResorts($request->get('resort'));

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'title' => 'Congratulation',
                    'message' => 'Seasons stored successfully'
                ]);
            }

            return response()->json([
                'type' => 'error',
                'title' => 'Failed to Deleted',
                'message' => 'Season failed to store'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'title' => 'Something went wrong',
                'message' => 'An error occurred while creating ' . $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $resorts = Resort::get();
        $season = Season::find($id);

        $data = [
            'page_title' => 'Update Season',
            'resorts' => $resorts,
            'season' => $season,
            'dates' => json_decode($season->dates),
        ];

        return view('dashboard.season.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:seasons,name,'.$id,
        ];

        $this->validate($request, $rules);

        if (!$request->get('resort')) {
            return response()->json([
                'type' => 'warning',
                'title' => 'Warning',
                'message' => 'No Resort select'
            ]);
        }

        if (!$request->get('season_dates')) {
            return response()->json([
                'type' => 'warning',
                'title' => 'Warning',
                'message' => 'No Season Date select'
            ]);
        }

        try {
            DB::beginTransaction();

            $season = Season::find($id);
            $season->name = $request->get('name');
            $season->dates = json_encode($request->get('season_dates'));
            $season->created_by = Auth::user()->id;

            if ($season->save()) {
                $season->removeResorts($season->resorts);
                $season->assignResorts($request->get('resort'));

                DB::commit();

                return response()->json([
                    'type' => 'success',
                    'title' => 'Congratulation',
                    'message' => 'Seasons updated successfully'
                ]);
            }

            return response()->json([
                'type' => 'error',
                'title' => 'Failed to Deleted',
                'message' => 'Season failed to update'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'title' => 'Something went wrong',
                'message' => 'An error occurred while creating ' . $e->getMessage()
            ]);
        }
    }
    

    
}
