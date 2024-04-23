<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\IdNameResource;
use App\Http\Resources\MetaPaginateResource;
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
        return response()->base_response_with_meta(
            IdNameResource::collection($concentrations),
            new MetaPaginateResource($concentrations),
        200);
    }

    public function show(Concentration $concentration)
    {
        return response()->base_response(new IdNameResource($concentration), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
        ]);
        try {
            $concentration = Concentration::create($validated);
            return response()->base_response(new IdNameResource($concentration), 201, "Created", "Konsentrasi Berhasil Ditambahakan");
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
            return response()->base_response(new IdNameResource($concentration), 200, "OK", "Konsentrasi Berhasil Diedit");
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
            return response()->base_response([], 200, "OK", "Konsentrasi Berhasil Dihapus");
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }
}
