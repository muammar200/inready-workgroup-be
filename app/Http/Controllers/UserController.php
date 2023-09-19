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
        return response()->json([
            "meta" => new MetaPaginateResource($users),
            "data" => UserResource::collection($users),
        ], 200);
    }

    public function show(User $user)
    {
        return response()->json([
            "data" => new UserDetailResource($user),
        ], 200);
    }

    public function store(Request $request)
    {
        $validated  = $request->validate([
            "username" => "required|unique:users,username",
            "password" => "required|min:8",
            "member_id" => "required|exists:members,id",
        ]);
        $validated["password"] = Hash::make($validated["password"]);
        // $validated["created_by"]  = 1;
        // $validated["updated_by"]  = 1;
        try {
            $user = User::create($validated);
            return response()->json(new UserDetailResource($user));
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 400);
        }
    }

    public function update(Request $request, User $user)
    {
        $validated  = $request->validate([
            "username" => "required|unique:users,username,$user->id",
            "password" => "nullable|min:8",
            "member_id" => "required|exists:members,id",
        ]);
        if ($request->password) {
            $validated["password"] = Hash::make($validated["password"]);
        } else {
            unset($validated["password"]);
        }
        // $validated["updated_by"]  = 1;
        try {
            $user->update($validated);
            return response()->json(new UserDetailResource($user));
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 400);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([
                "success" => true,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
            ], 400);
        }
    }
}
