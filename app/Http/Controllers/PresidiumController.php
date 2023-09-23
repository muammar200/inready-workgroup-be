<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\MetaPaginateResource;
use App\Http\Resources\PresidiumResource;
use App\Models\Presidium;
use Illuminate\Http\Request;

class PresidiumController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 100);
        $search = $request->input("search", "");

        $presidiums = Presidium::select()->where("name", "LIKE", "%$search%")->orderBy("level", "asc")->paginate($perpage, ["*"], 'page', $page);
        return response()->json([
            "meta" => new MetaPaginateResource($presidiums),
            "data" => PresidiumResource::collection($presidiums),
        ], 200);
    }

    public function show(Presidium $presidium)
    {
        return response()->json([
            "data" => new PresidiumResource($presidium),
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "level" => "required|integer",
        ]);

        try {
            $presidium = Presidium::create($validated);
            return response()->json(new PresidiumResource($presidium), 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Presidium $presidium)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "level" => "required|integer",
        ]);

        try {
            $presidium->update($validated);
            return response()->json(new PresidiumResource($presidium), 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Presidium $presidium)
    {
        try {
            $presidium->delete();
            return response()->json([
                "success" => true,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }
}
