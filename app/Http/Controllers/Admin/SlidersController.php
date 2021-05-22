<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Services\FileUpload;
use Illuminate\Http\Request;

class SlidersController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => 'Slider Manage',
            'sliders' => Slider::all()
        ];

        return view('dashboard.sliders.index')->with(array_merge($this->data, $data));
    }

    public function create()
    {

        $data = [
            'page_title' => 'Add new slider',
        ];

        return view('dashboard.sliders.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request)
    {
        $rules = [
            'image' => 'required|mimes:jpg,jpeg,png',
        ];

        $this->validate($request, $rules);

        try {

            $slider= new Slider();
            $slider->title = $request->get('name');
            $slider->description = $request->get('description');

            if ($request->hasFile('image')) {
                $path = FileUpload::uploadWithResize($request, 'image', 'sliders', 1366, 768);
                $slider->image = $path;
            }

            if ($slider->save()) {
                return response()->json([
                    'type' => 'success',
                    'title' => 'Congratulation',
                    'message' => 'Slider published successfully'
                ]);
            }

            return response()->json([
                'type' => 'error',
                'title' => 'Failed to store',
                'message' => 'Slider failed to store'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'type' => 'error',
                'title' => 'Something went wrong',
                'message' => 'An error occurred while creating ' . $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $slider = Slider::find($id);

        $data = [
            'page_title' => 'Update Slider',
            'slider' => $slider,
        ];

        return view('dashboard.sliders.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'image' => 'mimes:jpg,jpeg,png',
        ];

        $this->validate($request, $rules);

        try {

            $slider= Slider::find($id);
            $slider->title = $request->get('name');
            $slider->description = $request->get('description');

            if ($request->hasFile('image')) {
                $old_img = $slider->image;
                $path = FileUpload::uploadWithResize($request, 'image', 'sliders', 1366, 768);
                $slider->image = $path;
                if($old_img) {
                    unlink($old_img);
                }
            }

            if ($slider->save()) {
                return response()->json([
                    'type' => 'success',
                    'title' => 'Congratulation',
                    'message' => 'Slider Update successfully'
                ]);
            }

            return response()->json([
                'type' => 'error',
                'title' => 'Failed to store',
                'message' => 'Slider failed to Update'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'type' => 'error',
                'title' => 'Something went wrong',
                'message' => 'An error occurred while updating ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(Slider $slider, $id)
    {
        $slider = $slider->find($id);
        $slider_img = $slider->image;

        if ($slider->delete()) {
            unlink($slider_img);

            return response()->json([
                'type' => 'success',
                'title' => 'Deleted',
                'message' => 'Slider Deleted Successfully'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed to delete',
            'message' => 'Slider failed to delete'
        ]);
    }
}
