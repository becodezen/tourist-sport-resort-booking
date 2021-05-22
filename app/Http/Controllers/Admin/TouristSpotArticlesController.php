<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TouristSpot;
use App\Models\TouristSpotArticle;
use App\Services\FileUpload;
use Illuminate\Http\Request;

class TouristSpotArticlesController extends Controller
{
    public function index($tourist_spot_id)
    {
        $data = [
            'page_title' => 'Articles',
            'spot' => TouristSpot::find($tourist_spot_id),
        ];

        return view('dashboard.touristspot.articles.index')->with(array_merge($this->data, $data));
    }

    public function show($tourist_spot_id, $id)
    {
        $article = TouristSpotArticle::find($id);
        $data = [
            'page_title' => 'Details to Article',
            'article' => $article
        ];

        return view('dashboard.touristspot.articles.show')->with(array_merge($this->data, $data));
    }

    public function create($tourist_spot_id)
    {
        $data = [
            'page_title' => 'Articles',
            'spot' => TouristSpot::find($tourist_spot_id),
        ];

        return view('dashboard.touristspot.articles.create')->with(array_merge($this->data, $data));
    }

    public function store(Request $request, $tourist_spot_id)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png,gif|max:1024'
        ];

        $message = [
            'title.required' => 'Please Enter Article Title',
            'description.required' => 'Please enter article content'
        ];

        $this->validate($request, $rules, $message);

        try {
            $article = new TouristSpotArticle();
            $article->tourist_spot_id = $tourist_spot_id;
            $article->title = $request->get('title');
            $article->description = $request->get('description');

            if ($request->has('thumbnail')) {
                $article->thumbnail = FileUpload::uploadWithResize($request, 'thumbnail', 'articles', 960, 720);
            }

            if ($article->save()) {
                return response()->json([
                    'type' => 'success',
                    'title' => 'Congratulations',
                    'message' => 'Article Published Successfully'
                ]);
            }

            return response()->json([
                'type' => 'warning',
                'title' => 'Failed',
                'message' => 'Failed to publish'
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
        $article = TouristSpotArticle::find($id);

        $data = [
            'page_title' => 'Update Article',
            'article' => $article
        ];

        return view('dashboard.touristspot.articles.edit')->with(array_merge($this->data, $data));
    }

    public function update(Request $request, $tourist_spot_id, $id)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png,gif|max:1024'
        ];

        $message = [
            'title.required' => 'Please Enter Article Title',
            'description.required' => 'Please enter article content'
        ];

        $this->validate($request, $rules, $message);

        try {
            $article = TouristSpotArticle::find($id);
            $article->title = $request->get('title');
            $article->description = $request->get('description');

            if ($request->has('thumbnail')) {
                //delete old thumbnail
                if ($article->thumbnail) {
                    unlink($article->thumbnail);
                }

                $article->thumbnail = FileUpload::uploadWithResize($request, 'thumbnail', 'articles', 960, 720);
            }

            if ($article->save()) {
                return response()->json([
                    'type' => 'success',
                    'title' => 'Congratulations',
                    'message' => 'Article Updated Successfully'
                ]);
            }

            return response()->json([
                'type' => 'warning',
                'title' => 'Failed',
                'message' => 'Failed to Update'
            ]);

        }catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => 'Error',
                'message' => 'Something went wrong '.$e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request, $tourist_spot_id, $id)
    {
        $article = TouristSpotArticle::find($id);

        //delete Thumbnail
        if ($article->thumbnail)
        {
            unlink($article->thumbnail);
        }

        if ($article->delete()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Article Deleted',
                'message' => 'Article Deleted Successfully'
            ]);
        }

        return response()->json([
            'type' => 'failed',
            'title' => 'Failed',
            'messagte' => 'Article failed to delete successfully'
        ]);
    }




}
