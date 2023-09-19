<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\IdNameResource;
use App\Http\Resources\MetaPaginateResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 10);
        $search = $request->input("search", "");

        $categories = Category::where("name", "LIKE", "%$search%")->orderBy("name", "asc")->paginate($perpage, ["*"], 'page', $page);
        return response()->json([
            "meta" => new MetaPaginateResource($categories),
            "data" => IdNameResource::collection($categories),
        ], 200);
    }

    public function show(Category $category)
    {
        return response()->json(new IdNameResource($category), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
        ]);
        try {
            $category = Category::create($validated);
            return response()->json(new IdNameResource($category), 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            "name" => "required|string",
        ]);
        try {
            $category->update($validated);
            return response()->json(new IdNameResource($category), 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return response()->json([
                "success" => true,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }
}
