<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\MetaPaginateResource;
use App\Http\Resources\Public\NextBlogResource;
use App\Http\Resources\Public\PublicBlogDetailResource;
use App\Http\Resources\Public\PublicBlogResource;
use App\Models\Article;

class BlogController extends Controller
{
    public function index(){
        $category = request()->query('category');
        $data = Article::
                when(!is_null($category), function ($q) use ($category) {
                    $q->where('category_id', $category);
                })
                ->latest()->paginate(4);
        return response()->json([
            'data' => PublicBlogResource::collection($data),
            'meta' => new MetaPaginateResource($data)
        ]);
    }

    public function show(Article $article){

        $data = Article::whereDate('created_at', '>',$article->created_at)->limit(3)->get();

        return response()->json([
            'data' => new PublicBlogDetailResource($article),
            'next_article' => NextBlogResource::collection($data)
        ]);
    }
}
