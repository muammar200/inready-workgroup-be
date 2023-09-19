<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\MetaPaginateResource;
use App\Http\Resources\Public\WorksResource;
use App\Models\Concentration;
use App\Models\Work;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class WorksController extends Controller
{
    public function index(){

        $bestWorks = Arr::map(Concentration::get(['id', 'name'])->toArray(), function($concentration){
            return Work::join('members', 'members.id', '=', 'works.member_id')
            ->where('members.concentration_id', $concentration['id'])
            ->where('is_best', true)
            ->select(['works.title', 'members.name', DB::raw("CONCAT('{$concentration['name']}') as concentration")])
            ->first();
        });

        $concentration = request()->query('concentration');

        $works = Work::join('members',function($query) use ($concentration){
                $query->on('members.id', '=', 'works.member_id')
                ->when(!is_null($concentration), function($q) use ($concentration){
                    $q->where('concentration_id', $concentration);
                });
            })
            ->join('concentrations', 'concentrations.id', '=', 'members.concentration_id')
            ->select(['works.title', 'members.name as creator', 'concentrations.name as concentration'])
            ->paginate(9);

        return response()->json([
            'best_works' => $bestWorks,
            'works' => WorksResource::collection($works),
            'meta' => new MetaPaginateResource($works)
        ]);
    }
}
