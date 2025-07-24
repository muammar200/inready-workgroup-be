<?php

namespace App\Http\Controllers\Public;

use Carbon\Carbon;
use App\Models\Work;
use App\Models\Agenda;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\Activity;

use App\Http\Controllers\Controller;
use App\Http\Resources\MetaPaginateResource;
use App\Http\Resources\Public\PublicWorkResourece;

use App\Http\Resources\Public\PublicAgendaResource;
use App\Http\Resources\Public\PublicSliderResource;
use App\Http\Resources\Public\PublicArticleResource;
use App\Http\Resources\Public\DetailActivityResource;
use App\Http\Resources\Public\PublicActivityResource;
use App\Http\Resources\Public\SliderActivityResource;

class HomeController extends Controller
{
    public function slider()
    {
        $sliders = Activity::latest()->limit(3)->get();
        return response()->json([
            'data' => SliderActivityResource::collection($sliders),
        ]);
    }

    public function showSlider(Activity $activity)
    {
        return response()->json([
            'data' => new DetailActivityResource($activity),
        ]);
    }

    public function work()
    {
        $works = Work::where("is_active", 1)->get();
        return response()->json([
            "data" => PublicWorkResourece::collection($works),
        ], 200);
    }

    public function article()
    {
        $articles = Article::latest()->limit(4)->get();
        return response()->json([
            "data" => PublicArticleResource::collection($articles),
        ], 200);
    }

    public function gallery()
    {
        $galleries = Gallery::select("id", "image")->where("is_active", 1)->get();
        $galleries = $galleries->map(function ($gallery) {
            return [
                "id" => $gallery->id,
                "image" => url("storage/$gallery->image"),
            ];
        });
        return response()->json([
            "data" => $galleries,
        ], 200);
    }

    public function agenda()
    {
        $agendas = Agenda::where("time", ">=", Carbon::now())
            ->orderBy("time")
            ->take(6)
            ->get();
        return response()->json([
            "data" => PublicAgendaResource::collection($agendas),
        ], 200);
    }
}
