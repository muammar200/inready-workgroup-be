<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\ArticleDetailResource;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\MetaSearchResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 10);
        $search = $request->input("search", "");

        $articles = Article::where("title", "LIKE", "%$search%")->paginate($perpage, ["*"], 'page', $page);
        return response()->json([
            "meta" => new MetaSearchResource($articles),
            "data" => ArticleResource::collection($articles),
        ]);
    }

    public function show(Article $article)
    {
        return response()->json([
            "data" => new ArticleDetailResource($article)
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required|string",
            "category_id" => "required|exists:categories,id",
            "image" => "required|image",
            "content" => "required|string",
        ]);
        $validated["image"] = $request->file("image")->storePublicly("article", "public");
        $validated["user_id"] = 1;
        try {
            $article = Article::create($validated);
            return response()->json(new ArticleDetailResource($article));
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 400);
        }
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            "title" => "required|string",
            "category_id" => "required|exists:categories,id",
            "image" => "nullable|image",
            "content" => "required|string",
        ]);
        if ($request->file("image")) {
            $validated["image"] = $request->file("image")->storePublicly("article", "public");
        } else {
            unset($validated["image"]);
        }
        try {
            $article->update($validated);
            return response()->json(new ArticleDetailResource($article));
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 400);
        }
        $article->update($validated);
    }

    public function destroy(Article $article)
    {
        if (Storage::exists($article->image)) {
            Storage::delete($article->image);
        }
        try {
            $article->delete();
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ]);
        }
    }
}
