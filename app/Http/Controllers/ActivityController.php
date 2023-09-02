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

        $activities = Activity::where("title", "LIKE", "%$search%")->paginate($perpage, ["*"], 'page', $page);
        return response()->json([
            "meta" => new MetaPaginateResource($activities),
            "data" => ActivityResource::collection($activities),
        ], 200);
    }

    public function show(Activity $activity)
    {
        return response()->json([
            "data" => new ActivityDetailResource($activity),
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required|string",
            "flayer_image" => "required|image",
            "location" => "required|string",
            "time" => "required|date",
            "description" => "required|string",
        ]);
        $validated["flayer_image"] = $request->file("flayer_image")->storePublicly("activity", "public");
        $validated["created_by "]  = 1;
        $validated["updated_by "]  = 1;
        try {
            $activity = Activity::create($validated);
            return response()->json(new ActivityDetailResource($activity), 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 400);
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
        ]);
        if ($request->file("flayer_image")) {
            Storage::delete($activity->flayer_image);
            $validated["flayer_image"] = $request->file("flayer_image")->storePublicly("activity", "public");
        } else {
            unset($validated["flayer_image"]);
        }
        $validated["updated_by "]  = 1;
        try {
            $activity->update($validated);
            return response(new ActivityDetailResource($activity), 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 400);
        }
    }

    public function destroy(Activity $activity)
    {
        try {
            if (Storage::exists($activity->flayer_image)) {
                Storage::delete($activity->flayer_image);
            }
            $activity->delete();
            return response()->json([
                "success" => true,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ], 400);
        }
    }
}
