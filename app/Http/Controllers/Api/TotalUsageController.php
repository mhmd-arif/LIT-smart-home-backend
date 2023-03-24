<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TotalUsage;
use Carbon\Carbon;

class TotalUsageController extends Controller
{
    public function getTotalUsage()
    {
        $total_usages = DB::table('total_usages')->paginate();
        return response()->json($total_usages);
    }

    public function getTotalUsageHourly()
    {
        $usage = DB::table('total_usages')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as hour'), 
                    DB::raw('SUM(total_kwh) as total_kwh'), 
                    DB::raw('MAX(total_watt) as peak_power'))
            ->groupBy('hour')
            ->get();        

        return response()->json($usage_hourly);
    }

    public function getTotalUsageDaily()
    {
        $usage = DB::table('total_usages')
            ->select(DB::raw('DATE(created_at) as date'), 
                    DB::raw('SUM(total_kwh) as total_kwh'), 
                    DB::raw('MAX(total_watt) as peak_power'))
            ->groupBy('date')
            ->get();        

        return response()->json($usage);
    }

    public function getTotalUsageWeekly()
    {
        $usage = DB::table('total_usages')
            ->select(DB::raw('YEARWEEK(created_at) as week'), 
                    DB::raw('SUM(total_kwh) as total_kwh'), 
                    DB::raw('MAX(total_watt) as peak_power'))
            ->groupBy('week')
            ->get();        

        return response()->json($usage);
    }

    public function getTotalUsageMonthly()
    {
        $usage = DB::table('total_usages')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), 
                    DB::raw('SUM(total_kwh) as total_kwh'), 
                    DB::raw('MAX(total_watt) as peak_power'))
            ->groupBy('month')
            ->get();        

        return response()->json($usage);
    }
}

