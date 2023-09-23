<?php

namespace App\Http\Controllers;

use App\Http\Resources\NameCountResource;
use App\Http\Resources\Public\PublicAgendaResource;
use App\Models\Agenda;
use App\Models\Member;
use Carbon\Carbon;
use Generator;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function member_chart()
    {
        $member_count = Member::count();
        $desain_count = Member::whereHas('concentration', function ($query) {
            $query->where("name", 'Desain');
        })->count();
        $website_count = Member::whereHas('concentration', function ($query) {
            $query->where("name", 'Website');
        })->count();
        $mobile_count = Member::whereHas('concentration', function ($query) {
            $query->where("name", 'Mobile');
        })->count();
        return response()->json([
            "data" => [
                "member_count" => $member_count,
                "desain_count" => $desain_count,
                "website_count" => $website_count,
                "mobile_count" => $mobile_count,
                "desain_percent" => $member_count != 0 ? round(($desain_count / $member_count) * 100) : 0,
                "website_percent" => $member_count != 0 ? round(($website_count / $member_count) * 100) : 0,
                "mobile_percent" => $member_count != 0 ? round(($mobile_count / $member_count) * 100) : 0,
            ],
        ]);
    }

    public function member_column_chart()
    {
        $generations = Member::groupBy('generation')
            ->selectRaw('CAST(generation as UNSIGNED) as generation')
            ->orderByRaw('CAST(generation as UNSIGNED)')
            ->pluck('generation');
        $maleCounts = Member::where('gender', 'male')
            ->groupBy('generation')
            ->selectRaw('CAST(generation as UNSIGNED) as angkatan, COUNT(*) as count')
            ->orderByRaw('CAST(generation as UNSIGNED)')
            ->get();
        $femaleCounts = Member::where('gender', 'female')
            ->groupBy('generation')
            ->selectRaw('CAST(generation as UNSIGNED) as angkatan, COUNT(*) as count')
            ->orderByRaw('CAST(generation as UNSIGNED)')
            ->get();

        $maleResult = [];
        $femaleResult = [];

        foreach ($generations as $generation) {
            $maleResult[] = [
                'angkatan' => $generation,
                'count' => $maleCounts->where('angkatan', $generation)->first() ? $maleCounts->where('angkatan', $generation)->first()->count : 0
            ];

            $femaleResult[] = [
                'angkatan' => $generation,
                'count' => $femaleCounts->where('angkatan', $generation)->first() ? $femaleCounts->where('angkatan', $generation)->first()->count : 0
            ];
        }
        return response()->json([
            "data" => [
                "male" => $maleResult,
                "female" => $femaleResult,
            ],
        ], 200);
    }

    public function upcoming_agenda()
    {
        $agendas = Agenda::where("time", ">=", Carbon::now())
            ->orderBy("time")
            ->take(4)
            ->get();
        return response()->json([
            "data" => PublicAgendaResource::collection($agendas),
        ], 200);
    }
}
