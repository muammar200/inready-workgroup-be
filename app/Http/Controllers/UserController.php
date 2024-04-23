<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\MetaPaginateResource;
use App\Http\Resources\UserDetailResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input('page', 1);
        $perpage = $request->input('perpage', 10);
        $search = $request->input('search', "");

        $users = User::where("username", "LIKE", "%$search%")->latest()->paginate($perpage, ["*"], 'page', $page);
        return response()->base_response_with_meta(
            UserResource::collection($users),
            new MetaPaginateResource($users),
        200);
    }

    public function show(User $user)
    {
        return response()->base_response(new UserDetailResource($user), 200);
    }

    public function store(Request $request)
    {
        $validated  = $request->validate([
            "username" => "required|unique:users,username",
            "password" => "required|min:8",
            "level" => "required|in:admin,user,editor",
            "member_id" => "required|exists:members,id",
        ]);
        $validated["password"] = Hash::make($validated["password"]);
        try {
            $user = User::create($validated);
            return response()->base_response(new UserDetailResource($user), 201, "Created", "User Berhasil Ditambahkan");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, User $user)
    {
        $validated  = $request->validate([
            "username" => "required|unique:users,username,$user->id",
            "password" => "nullable|min:8",
            "level" => "required|in:admin,user,editor",
            "member_id" => "required|exists:members,id",
        ]);
        if ($request->password) {
            $validated["password"] = Hash::make($validated["password"]);
        } else {
            unset($validated["password"]);
        }
        try {
            $user->update($validated);
            return response()->base_response(new UserDetailResource($user), 200, "OK", "User Berhasil Diedit");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->base_response([], 200, "OK", "User Berhasil Dihapus");
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
            ], 500);
        }
    }
}
