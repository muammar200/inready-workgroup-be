<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function member_chart()
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
}
