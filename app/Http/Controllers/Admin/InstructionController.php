<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TouristSpot;
use App\Models\TouristSpotInstruction;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    public function index($tourist_spot_id)
    {
        $data = [
            'page_title' => 'Route Instruction',
            'spot' => TouristSpot::find($tourist_spot_id),
            'instructions' => TouristSpotInstruction::find($tourist_spot_id),
        ];

        return view('dashboard.touristspot.instruction.index')->with(array_merge($this->data, $data));
    }

    public function create($tourist_spot_id)
    {
        $data = [
            'page_title' => 'Add Route Instruction',
            'spot' => TouristSpot::find($tourist_spot_id),
        ];

        return view('dashboard.touristspot.instruction.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request, $tourist_spot_id)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required'
        ];

        $message = [
            'title.required' => 'Please Enter Instruction Title',
            'description.required' => 'Please enter instruction content'
        ];

        $this->validate($request, $rules, $message);

        try {
            $ins = new TouristSpotInstruction();
            $ins->tourist_spot_id = $tourist_spot_id;
            $ins->title = $request->get('title');
            $ins->description = $request->get('description');

            if ($ins->save()) {
                return response()->json([
                    'type' => 'success',
                    'title' => 'Saved',
                    'message' => 'Instruction Route Saved Successfully'
                ]);
            }

            return response()->json([
                'type' => 'warning',
                'title' => 'Failed',
                'message' => 'Failed to save'
            ]);

        }catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Something went wrong '.$e->getMessage()
            ]);
        }
    }

    public function edit($tourist_spot_id, $id)
    {
        $data = [
            'page_title' => 'Update Route Instruction',
            'spot' => TouristSpot::find($tourist_spot_id),
            'ins' => TouristSpotInstruction::find($id)
        ];

        return view('dashboard.touristspot.instruction.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $tourist_spot_id, $id)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required'
        ];

        $message = [
            'title.required' => 'Please Enter Instruction Title',
            'description.required' => 'Please enter instruction content'
        ];

        $this->validate($request, $rules, $message);

        try {
            $ins = TouristSpotInstruction::find($id);
            $ins->title = $request->get('title');
            $ins->description = $request->get('description');

            if ($ins->save()) {
                return response()->json([
                    'type' => 'success',
                    'title' => 'Saved',
                    'message' => 'Instruction Route Update Successfully'
                ]);
            }

            return response()->json([
                'type' => 'warning',
                'title' => 'Failed',
                'message' => 'Failed to update'
            ]);

        }catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Something went wrong '.$e->getMessage()
            ]);
        }
    }

    public function destroy($tourist_spot_id, $id)
    {
        $ins = TouristSpotInstruction::find($id);

        if ($ins->delete()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Instruction Route Deleted Successfully'
            ]);
        }

        return response()->json([
            'type' => 'warning',
            'title' => 'Failed',
            'message' => 'Failed to delete'
        ]);
    }
}
