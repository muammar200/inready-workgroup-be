<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            "username" => "required",
            "password" => "required|min:8",
        ]);

        if (Auth::attempt($validated)) {
            $user = Auth::user();
            $data = [
                "status" => true,
                "data" => [
                    "token" => $user->createToken('token')->plainTextToken,
                    "user" => [
                        "username" => $user->username,
                        "name" => $user->member->name,
                        "level" => $user->level,
                    ],
                ],
                "message" => "Login Berhasil",
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                "status" => false,
                "message" => "Username / Password Salah"
            ];
            return response()->json($data, 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "Logout Success",
        ], 200);
    }
}
