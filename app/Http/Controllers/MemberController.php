<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Resources\MemberResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MetaSearchResource;
use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\MemberDetailResource;
use App\Http\Resources\MetaPaginateResource;

class MemberController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 10);
        $search = $request->input("search", "");

        $members = Member::where("name", "LIKE", "%$search%")->paginate($perpage, ["*"], 'page', $page);
        return response()->json([
            "meta" => new MetaPaginateResource($members),
            "data" => MemberResource::collection($members),
        ], 200);
    }

    public function show(Member $member)
    {
        return response()->json([
            "data" => new MemberDetailResource($member),
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "nri" => "required|unique:members,nri",
            "name" => "required|string",
            "photo" => "nullable|image",
            "address" => "nullable|string",
            "pob" => "nullable|string",
            "gender" => "required|in:male,female",
            "generation" => "required",
            "major_id" => "required|exists:majors,id",
            "concentration_id" => "required|exists:concentrations,id",
            "position" => "required",
            "phone" => "nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:9",
            "email" => "nullable|email",
            "instagram" => "nullable|string",
            "facebook" => "nullable|string",
        ]);
        if ($request->file("photo")) {
            $validated["photo"] = $request->file("photo")->storePublicly("member_photo", "public");
        } else {
            unset($validated["photo"]);
        }
        $validated["created_by "]  = 1;
        $validated["updated_by "]  = 1;
        try {
            $member = Member::create($validated);
            return response()->json(new MemberDetailResource($member), 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 400);
        }
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            "nri" => "required|unique:members,nri,$member->id",
            "name" => "required|string",
            "photo" => "nullable",
            "address" => "nullable|string",
            "pob" => "nullable|string",
            "gender" => "required|in:male,female",
            "generation" => "required",
            "major_id" => "required|exists:majors,id",
            "concentration_id" => "required|exists:concentrations,id",
            "position" => "required",
            "phone" => "nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:9",
            "email" => "nullable|email",
            "instagram" => "nullable|string",
            "facebook" => "nullable|string",
        ]);
        if ($request->file("photo")) {
            if (Storage::exists($member->photo)) {
                Storage::delete($member->photo);
            }
            $validated["photo"] = $request->file("photo")->storePublicly("member_photo", "public");
        } else {
            unset($validated["photo"]);
        }
        $validated["updated_by "]  = 1;
        try {
            $member->update($validated);
            return response()->json(new MemberDetailResource($member), 200);
        } catch (\Throwable $th) {
            return response()->json([
                "massage" => $th->getMessage(),
            ], 400);
        }
    }

    public function destroy(Member $member)
    {
        try {
            if (Storage::exists($member->photo)) {
                Storage::delete($member->photo);
            }
            $member->delete();
            return response()->json([
                "success" => true,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ], 400);
        }
    }
}
