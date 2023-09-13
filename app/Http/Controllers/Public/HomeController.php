<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Public\PublicAgendaResource;
use App\Http\Resources\Public\PublicArticleResource;
use App\Http\Resources\Public\PublicSliderResource;
use App\Http\Resources\Public\PublicWorkResourece;
use App\Models\Agenda;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\Slider;
use App\Models\Work;
use Carbon\Carbon;

use function PHPSTORM_META\map;

class HomeController extends Controller
{
    public function slider()
    {
        $sliders = Slider::where("is_active", 1)->latest()->get();
        return response()->json([
            "data" => PublicSliderResource::collection($sliders)
        ], 200);
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
