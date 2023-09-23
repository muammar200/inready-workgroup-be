<?php

namespace App\Http\Controllers;

use App\Http\Resources\BPOResource;
use App\Models\BPO;
use Illuminate\Http\Request;

class BPOController extends Controller
{

    public function index()
    {
        $data = BPO::orderBy('presidium_id', 'DESC')->latest()->get();
        return response()->json([
            'data' => BPOResource::collection($data)
        ]);
    }

    public function show(BPO $bpo)
    {
        return response()->json([
            "data" => new BPOResource($bpo),
        ], 200);
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
            return response()->json($bpo);
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
            return response()->json([
                'message' => 'data berhasil di update',
                'data' => $bpo
            ]);
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
            return response()->json(['message' => 'data berhasil di hapus']);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }
    }
}
