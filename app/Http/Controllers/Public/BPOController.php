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
        

        $bpo = Presidium::where('level', '>', 5)
                ->orderBy('level', 'ASC')
                ->get();
        

        return response()->json([
            'pembina' => [
                [
                    "name" => 'Kak Farida',
                    "profession" => 'Dosen',
                    "photo" => url("storage/syahid.jpg")
                ]
            ],
            'dpo' => [
                [
                    "name" => "Ikrar Restu Gibrani",
                    "concentration" => "Mobile",
                    "photo" => url("storage/syahid.jpg")
                ],
                [
                    "name" => "Nur Halis",
                    "concentration" => "Mobile",
                    "photo" => url("storage/syahid.jpg")
                ],
                [
                    "name" => "Muammar",
                    "concentration" => "Website",
                    "photo" => url("storage/syahid.jpg")
                ]
            ],
            'presidium' => PresidiumResource::collection($presidium),
            'bpo' => BPOResource::collection($bpo)
        ]);
    }
}
