<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\MetaPaginateResource;
use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 10);
        $search = $request->input("search", "");

        $sliders = Slider::where("title", "LIKE", "%$search%")->latest()->paginate($perpage, ["*"], 'page', $page);
        return response()->base_response_with_meta(
            SliderResource::collection($sliders),
            new MetaPaginateResource($sliders),
        200);
    }

    public function show(Slider $slider)
    {
        return response()->base_response(
            new SliderResource($slider),
        200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required",
            "description" => "required",
            "image" => "required|image",
            "is_active" => "boolean",
        ]);
        $validated["image"] = $request->file("image")->storePublicly("slider", "public");
        try {
            $slider = Slider::create($validated);
            return response()->base_response(new SliderResource($slider), 201, "Created", "Slider Berhasil Ditambahkan");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            "title" => "required",
            "description" => "required",
            "image" => "nullable",
            "is_active" => "required|boolean",
        ]);
        if ($request->file("image")) {
            if ($slider->image && Storage::exists($slider->image)) {
                Storage::delete($slider->image);
            }
            $validated["image"] = $request->file("image")->storePublicly("slider", "public");
        } else {
            unset($validated["image"]);
        }
        try {
            $slider->update($validated);
            return response()->base_response(new SliderResource($slider), 200, "OK", "Slider Berhasil Diedit");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Slider $slider)
    {
        try {
            if ($slider->image && Storage::exists($slider->image)) {
                Storage::delete($slider->image);
            }
            $slider->delete();
            return response()->base_response([], 200, "OK", "Slider Berhasil Dihapus");
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }
}
