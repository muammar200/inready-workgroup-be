<?php

namespace App\Http\Controllers;

use App\Http\Resources\BPOResource;
use App\Models\BPO;
use Illuminate\Http\Request;

class BPOController extends Controller
{

    public function index(){
        $data = BPO::orderBy('presidium_id', 'DESC')->latest()->get();
        return response()->json([
            'data' => BPOResource::collection($data)
        ]);
    }

    public function store(Request $request){

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

    public function update(Request $request, BPO $bPO){

        try {
            $bPO->update($request->all());
            return response()->json([
                'message' => 'data berhasil di update',
                'data' => $bPO
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }

    }

    public function destroy(BPO $bPO){

        try {
            $bPO->delete();
            return response()->json([ 'message' => 'data berhasil di hapus' ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
            ], 500);
        }

    }

}
