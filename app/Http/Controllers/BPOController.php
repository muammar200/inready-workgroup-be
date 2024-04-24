<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateSearchRequest;
use App\Http\Resources\BPOResource;
use App\Http\Resources\MetaPaginateResource;
use App\Models\BPO;
use Illuminate\Http\Request;

class BPOController extends Controller
{

    public function index(PaginateSearchRequest $request)
    {
        $page = $request->input("page", 1);
        $perpage = $request->input("perpage", 10);
        $search = $request->input("search", "");

        $bpos = BPO::select('bpo.*')->join("members", "bpo.member_id", "=", "members.id")
            ->where('members.name', 'LIKE', "%$search%")
            ->orderBy('bpo.presidium_id', 'DESC')
            ->latest()
            ->paginate($perpage, ["*"], 'page', $page);
        return response()->base_response_with_meta(
            BPOResource::collection($bpos),
            new MetaPaginateResource($bpos),
        200);
    }

    public function show(BPO $bpo)
    {
        return response()->base_response(new BPOResource($bpo), 200);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'member_id' => 'required',
            'presidium_id' => 'nullable',
            'division_id' => 'nullable',
            'is_division_head' => 'nullable',
        ]);

        try {
            $bpo = BPO::create($validated);
            return response()->base_response(new BPOResource($bpo), 201, "Create", "BPO Berhasil Ditambahkan");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, BPO $bpo)
    {

        try {
            $bpo->update($request->all());
            return response()->base_response(new BPOResource($bpo), 200, "OK", "BPO Berhasil Diedit");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(BPO $bpo)
    {

        try {
            $bpo->delete();
            return response()->base_response([], 200, "OK", "BPO Berhasil Dihapus");
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }
}
