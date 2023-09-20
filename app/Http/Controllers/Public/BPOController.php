<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Public\BPOResource;
use App\Http\Resources\Public\PresidiumResource;
use App\Models\BPO;
use App\Models\Presidium;
use Illuminate\Http\Request;

class BPOController extends Controller
{
    public function index(){

        $presidium = BPO::whereNotNull('presidium_id')
                ->join('presidiums', 'presidiums.id', '=', 'bpo.presidium_id')
                ->orderBy('presidiums.level')
                ->get();
        

        $bpo = Presidium::where('level', '>', 3)
                ->orderBy('level', 'ASC')
                ->get();
        

        return response()->json([
            'presidium' => PresidiumResource::collection($presidium),
            'bpo' => BPOResource::collection($bpo)
        ]);
    }
}
