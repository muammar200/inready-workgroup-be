<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\IdNameResource;
use App\Http\Resources\MetaPaginateResource;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 10);
        $search = $request->input("search", "");

        $majors = Major::where("name", "LIKE", "%$search%")->orderBy("name", "asc")->paginate($perpage, ["*"], 'page', $page);
        return response()->base_response_with_meta(
            IdNameResource::collection($majors),
            new MetaPaginateResource($majors),
        200);
    }

    public function show(Major $major)
    {
        return response()->base_response(new IdNameResource($major), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
        ]);
        try {
            $major = Major::create($validated);
            return response()->base_response(new IdNameResource($major), 201, "Created", "Jurusan Berhasil Ditambahkan");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Major $major)
    {
        $validated = $request->validate([
            "name" => "required|string",
        ]);
        try {
            $major->update($validated);
            return response()->base_response(new IdNameResource($major), 200, "OK", "Jurusan Berhasil Diedit");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Major $major)
    {
        try {
            $major->delete();
            return response()->base_response([], 200, "OK", "Jurusan Berhasil Dihapus");
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }
}
