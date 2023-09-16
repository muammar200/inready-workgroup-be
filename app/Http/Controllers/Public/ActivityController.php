<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\MetaPaginateResource;
use App\Http\Resources\Public\DetailActivityResource;
use App\Http\Resources\Public\PublicActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(){
        $data = Activity::latest()->paginate(9);
        return response()->json([
            'data' => PublicActivityResource::collection($data),
            'meta' => new MetaPaginateResource($data)
        ]);
    }

    public function show(Activity $activity){
        return response()->json([
            'data' => new DetailActivityResource($activity),
        ]);
    }
}
