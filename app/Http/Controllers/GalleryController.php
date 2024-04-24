<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\MetaPaginateResource;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 10);

        $galleries = Gallery::latest()->paginate($perpage, ["*"], 'page', $page);
        return response()->base_response_with_meta(
            GalleryResource::collection($galleries),
            new MetaPaginateResource($galleries),
        200);
    }

    public function show(Gallery $gallery)
    {
        return response()->base_response(new GalleryResource($gallery), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "image" => "required|image",
            "is_active" => "nullable|boolean",
        ]);
        $validated["image"] = $request->file("image")->storePublicly("gallery", "public");
        try {
            $gallery = Gallery::create($validated);
            return response()->base_response(new GalleryResource($gallery), 201, "Created", "Gambar Berhasil Ditambahkan");
        } catch (\Throwable $th) {
            return response()->json([
                "massage" => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            "image" => "nullable",
            "is_active" => "required|boolean",
        ]);
        if ($request->file("image")) {
            if ($gallery->image && Storage::exists($gallery->image)) {
                Storage::delete($gallery->image);
            }
            $validated["image"] = $request->file("image")->storePublicly("slider", "public");
        } else {
            unset($validated["image"]);
        }
        try {
            $gallery->update($validated);
            return response()->base_response(new GalleryResource($gallery), 200, "OK", "Gambar Berhasil Diedit");
        } catch (\Throwable $th) {
            return response()->json([
                "massage" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Gallery $gallery)
    {
        try {
            if ($gallery->image && Storage::exists($gallery->image)) {
                Storage::delete($gallery->image);
            }
            $gallery->delete();
            return response()->base_response([], 200, "OK", "Gambar Berhasil Dihapus");
        } catch (\Throwable $th) {
            return response()->json([
                "success" => "false",
                "massage" => $th->getMessage(),
            ], 500);
        }
    }
}
