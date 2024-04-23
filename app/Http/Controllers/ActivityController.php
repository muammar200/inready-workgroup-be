<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\ActivityDetailResource;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\MetaPaginateResource;
use Illuminate\Support\Facades\Storage;
use Psy\CodeCleaner\ReturnTypePass;

class ActivityController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input('page', 1);
        $perpage = $request->input('perpage', 10);
        $search = $request->input("search", "");

        $activities = Activity::where("title", "LIKE", "%$search%")->latest()->paginate($perpage, ["*"], 'page', $page);
        return response()->base_response_with_meta(
            ActivityResource::collection($activities),
            new MetaPaginateResource($activities),
        200);
    }

    public function show(Activity $activity)
    {
        return response()->base_response(new ActivityDetailResource($activity), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required|string",
            "registration_link" => "nullable",
            "flayer_image" => "required|image",
            "location" => "required|string",
            "time" => "required|date",
            "description" => "required|string",
        ]);
        $validated["flayer_image"] = $request->file("flayer_image")->storePublicly("activity", "public");
        try {
            $activity = Activity::create($validated);
            return response()->base_response(new ActivityDetailResource($activity), 201, "Created", "Kegiatan Berhasil Ditambahkan");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            "title" => "required|string",
            "flayer_image" => "nullable",
            "location" => "required|string",
            "time" => "required|date",
            "description" => "required|string",
            "registration_link" => "nullable",
        ]);
        if ($request->file("flayer_image")) {
            if ($activity->flayer_image && Storage::exists($activity->flayer_image)) {
                Storage::delete($activity->flayer_image);
            }
            $validated["flayer_image"] = $request->file("flayer_image")->storePublicly("activity", "public");
        } else {
            unset($validated["flayer_image"]);
        }
        try {
            $activity->update($validated);
            return response()->base_response(new ActivityDetailResource($activity), 200, "OK", "Kegiatan Berhasil Diedit");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Activity $activity)
    {
        try {
            if ($activity->flayer_image && Storage::exists($activity->flayer_image)) {
                Storage::delete($activity->flayer_image);
            }
            $activity->delete();
            return response()->base_response([], 200, "OK", "Kegiatan Berhasil Dihapus");
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }
}
