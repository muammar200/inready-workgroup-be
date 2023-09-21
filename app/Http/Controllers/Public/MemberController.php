<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\MetaPaginateResource;
use App\Http\Resources\Public\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(){

        $angkatan = request()->query('angkatan') ?? 1;

        $data = Member::whereGeneration($angkatan)->orderBy('name')->paginate();

        return response()->json([
            'data' => MemberResource::collection($data),
            'meta' => new MetaPaginateResource($data),
        ]);

    }
}
