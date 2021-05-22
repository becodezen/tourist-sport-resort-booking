<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Weekend;
use Illuminate\Http\Request;

class SettingsWeekendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $data = [
            'page_title' => 'Weekend',
            'weekends' => Weekend::get(),
        ];

        return view('dashboard.settings.weekend.index')->with(array_merge($this->data, $data));
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
            'name' => 'required|unique:weekends,name'
        ];

        $this->validate($request, $rules);

        $weekend = new Weekend();
        $weekend->name = $request->get('name');

        if ($weekend->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Congratulations',
                'message' => 'Weekend Saved successfully',
                'redirect' => route('weekend.list')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Error',
            'message' => 'Failed to store error',
        ]);

        
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
            'page_title' => 'Edit weekend',
            'weekends' => Weekend::get(),
            'weekend' => Weekend::find($id)
        ];

        return view('dashboard.settings.weekend.edit')->with(array_merge($this->data, $data));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:weekends,name,'.$id
        ];

        $this->validate($request, $rules);

        $weekend = Weekend::find($id);
        $weekend->name = $request->get('name');

        if ($weekend->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Congratulations',
                'message' => 'Weekend Updated successfully',
                'redirect' => route('weekend.list')
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Error',
            'message' => 'Failed to update weekend',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $weekend = Weekend::find($id);

        if ($weekend->delete()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Weekend deleted successfully',
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed',
            'message' => 'Failed to delete weeekend',
        ]);
    }
}
