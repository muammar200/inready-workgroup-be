<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\IdNameResource;
use App\Models\Concentration;
use Illuminate\Http\Request;

class ConcentrationController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 10);
        $search = $request->input("search", "");

        $concentrations = Concentration::where("name", "LIKE", "%$search%")->orderBy("name", "asc")->paginate($perpage, ["*"], 'page', $page);
        return response()->json([
            "data" => IdNameResource::collection($concentrations),
        ], 200);
    }

    public function show(Concentration $concentration)
    {
        return response()->json(new IdNameResource($concentration), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
        ]);
        try {
            $concentration = Concentration::create($validated);
            return response()->json(new IdNameResource($concentration), 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Concentration $concentration)
    {
        $validated = $request->validate([
            "name" => "required|string",
        ]);
        try {
            $concentration->update($validated);
            return response()->json(new IdNameResource($concentration), 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Concentration $concentration)
    {
        try {
            $concentration->delete();
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
