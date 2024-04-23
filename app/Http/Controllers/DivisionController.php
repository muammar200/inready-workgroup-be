<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\MetaPaginateResource;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 100);
        $search = $request->input("search", "");

        $divisions = Division::select()->where("name", "LIKE", "%$search%")->latest()->paginate($perpage, ["*"], 'page', $page);
        return response()->base_response_with_meta(
            DivisionResource::collection($divisions),
            new MetaPaginateResource($divisions),
        200);
    }

    public function show(Division $division)
    {
        return response()->base_response(new DivisionResource($division), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "presidium_id" => "required|exists:presidiums,id",
        ]);

        try {
            $division = Division::create($validated);
            return response()->base_response(new DivisionResource($division), 201, "Created", "Divisi Berhasil Ditambahkan");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Division $division)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "presidium_id" => "required|exists:presidiums,id",
        ]);

        try {
            $division->update($validated);
            return response()->base_response(new DivisionResource($division), 200, "OK", "Divisi Berhasil Diedit");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Division $division)
    {
        try {
            $division->delete();
            return response()->base_response([], 200, "OK", "Divisi Berhasil Dihapus");
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ]);
        }
    }
}
