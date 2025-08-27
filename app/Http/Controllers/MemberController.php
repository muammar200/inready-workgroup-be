<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MemberResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\AngkatanResource;
use App\Http\Resources\MetaSearchResource;
use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\MemberDetailResource;
use App\Http\Resources\MetaPaginateResource;

class MemberController extends Controller
{

    public function getAllMember(){
        return response()->json([
            'data' => Member::latest()->get(['id', 'name'])
        ],200);
    }

    public function getMembersByGeneration($generation)
    {
        return response()->json([
            'data' => DB::table('members')->where('generation', $generation)->latest()->get(['name'])
        ], 200);
    }

    public function getGenerations()
    {
        $data = DB::table('members')
            ->select('generation')
            ->distinct()
            ->orderByRaw('CAST(generation AS UNSIGNED)')
            ->get();

        return response()->json([
            'data' => AngkatanResource::collection($data),
        ]);
    }

    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 10);
        $search = $request->input("search", "");

        $members = Member::where("name", "LIKE", "%$search%")->latest()->paginate($perpage, ["*"], 'page', $page);
        return response()->base_response_with_meta(
            MemberResource::collection($members),
            new MetaPaginateResource($members),
            200
        );
    }

    public function show(Member $member)
    {
        return response()->base_response(new MemberDetailResource($member), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "nri" => "required|unique:members,nri",
            "name" => "required|string",
            "photo" => "nullable|image",
            "address" => "nullable|string",
            "pob" => "nullable|string",
            "dob" => "nullable|date",
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
        try {
            $member = Member::create($validated);
            return response()->base_response(new MemberDetailResource($member), 201, "Create", "Anggota Berhasil Ditambahkan");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
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
            "dob" => "nullable|date",
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
            if ($member->photo && Storage::exists($member->photo)) {
                Storage::delete($member->photo);
            }
            $validated["photo"] = $request->file("photo")->storePublicly("member_photo", "public");
        } else {
            unset($validated["photo"]);
        }
        try {
            $member->update($validated);
            return response()->base_response(new MemberDetailResource($member), 200, "OK", "Anggota Berhasil Diedit");
        } catch (\Throwable $th) {
            return response()->json([
                "massage" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Member $member)
    {
        try {
            if ($member->photo && Storage::exists($member->photo)) {
                Storage::delete($member->photo);
            }
            $member->delete();
            return response()->base_response([], 200, "OK", "Anggota Berhasil Dihapus");
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }
}
