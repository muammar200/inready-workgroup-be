<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\MetaPaginateResource;
use App\Http\Resources\Public\PublicBlogDetailResource;
use App\Http\Resources\Public\PublicBlogResource;
use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        $data = Article::latest()->paginate(4);
        return response()->json([
            'data' => PublicBlogResource::collection($data),
            'meta' => new MetaPaginateResource($data)
        ]);
    }

    public function show(Article $article){
        return response()->json([
            'data' => new PublicBlogDetailResource($article),
        ]);
    }
}
