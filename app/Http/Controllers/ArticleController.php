<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\MetaPaginateResource;
use App\Http\Resources\ArticleDetailResource;

class ArticleController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 10);
        $search = $request->input("search", "");

        $articles = Article::where("title", "LIKE", "%$search%")->latest()->paginate($perpage, ["*"], 'page', $page);
        return response()->base_response_with_meta(
            ArticleResource::collection($articles),
            new MetaPaginateResource($articles),
        200);
    }

    public function show(Article $article)
    {
        return response()->base_response(new ArticleDetailResource($article),200);
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
        try {
            $article = Article::create($validated);
            return response()->base_response(new ArticleDetailResource($article), 201, "Created", "Blog Berhasil Ditambahkan");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            "title" => "required|string",
            "category_id" => "required|exists:categories,id",
            "image" => "nullable",
            "content" => "required|string",
        ]);
        if ($request->file("image")) {
            if ($article->image && Storage::exists($article->image)) {
                Storage::delete($article->image);
            }
            $validated["image"] = $request->file("image")->storePublicly("article", "public");
        } else {
            unset($validated["image"]);
        }
        try {
            $article->update($validated);
            return response()->base_response(new ArticleDetailResource($article), 200, "OK", "Blog Berhasil Diedit");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Article $article)
    {
        try {
            if ($article->image && Storage::exists($article->image)) {
                Storage::delete($article->image);
            }
            $article->delete();
            return response()->base_response([], 200, "OK", "Blog Berhasil Dihapus");
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage()
            ], 400);
        }
    }
}
