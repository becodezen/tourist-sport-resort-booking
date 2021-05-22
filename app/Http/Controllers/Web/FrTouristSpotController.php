<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\TouristSpot;
use App\Models\TouristSpotArticle;
use Illuminate\Http\Request;

class FrTouristSpotController extends Controller
{
    public function index()
    {
        $tourist_spots = TouristSpot::paginate(12);
        $divisions = Division::orderBy('name', 'ASC')->get();
        $districts = District::orderBy('name', 'ASC')->get();

        $data = [
            'page_title' => 'Tourist spot',
            'spots' => $tourist_spots,
            'divisions' => $divisions,
            'districts' => $districts,
        ];

        return view('frontend.touristspots.index')->with(array_merge($this->data, $data));
    }

    /*
     * view details of tourist spot
     *
     * @params $slug
     * @return view/frontend/touristspot/show
     * */
    public function show($slug)
    {
        $tourist_spot = TouristSpot::where('slug', $slug)->first();
        $more_spots = TouristSpot::where('district_id', $tourist_spot->district_id)->where('id', '!=', $tourist_spot->id)->latest()->get();
        $data = [
            'page_title' => 'View Details of '. $tourist_spot->name,
            'spot' => $tourist_spot,
            'tourist_spots' => $more_spots
        ];

        return view('frontend.touristspots.show')->with(array_merge($this->data, $data));
    }

    /*
     * view details of article
     *
     * @params $slug
     * @return view/frontend/touristspot/article-show
     * */
    public function articleShow($slug)
    {
        $article = TouristSpotArticle::find($slug);

        $data = [
            'page_title' => 'Article '. $article->title,
            'article' => $article,
        ];

        return view('frontend.touristspots.showArticle')->with(array_merge($this->data, $data));
    }
}
