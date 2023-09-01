<?php

namespace App\Http\Controllers;

use App\Http\Resources\IdNameResource;
use App\Models\Concentration;
use Illuminate\Http\Request;

class ConcentrationController extends Controller
{
    public function index() {
        $concentrations = Concentration::orderBy("name", "asc")->get();
        return response()->json([
            "data" => IdNameResource::collection($concentrations),
        ], 200);
    }
}
