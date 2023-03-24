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
        $usage_hourly = DB::table('total_usages')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as hour'), DB::raw('SUM(total_kwh) as hourly_kwh'), DB::raw('MAX(total_watt) as hourly_watt'))
            ->groupBy('hour')
            ->get();        

        return response()->json($usage_hourly);
    }

    public function getTotalUsageDaily()
    {
        $usage_daily = DB::table('total_usages')
            ->select(DB::raw('DATE(created_at) as date'), 
                    DB::raw('SUM(total_kwh) as daily_kwh'), 
                    DB::raw('MAX(total_watt) as daily_watt'))
            ->groupBy('date')
            ->get();        

        return response()->json($usage_daily);
    }

    public function getTotalUsageWeekly()
    {
        $usage_weekly = DB::table('total_usages')
            ->select(DB::raw('YEARWEEK(created_at) as week'), 
                    DB::raw('SUM(total_kwh) as weekly_kwh'), 
                    DB::raw('MAX(total_watt) as weekly_watt'))
            ->groupBy('week')
            ->get();        

        return response()->json($usage_weekly);
    }

    public function getTotalUsageMonthly()
    {
        $usage_monthly = DB::table('total_usages')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), 
                    DB::raw('SUM(total_kwh) as monthly_kwh'), 
                    DB::raw('MAX(total_watt) as monthly_watt'))
            ->groupBy('month')
            ->get();        

        return response()->json($usage_monthly);
    }
}

