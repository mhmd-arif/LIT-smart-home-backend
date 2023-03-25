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
        $total_usages = DB::table('total_usages')->get();
        return response()->json([
            'success' => true,
            'message'=>'Device usages created successfully',
            'data' => $total_usages
        ], 200);
    }

    public function getTotalUsageHourly()
    {
        $usage = DB::table('total_usages')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as hour'), 
                    DB::raw('SUM(kwh) as kwh'), 
                    DB::raw('MAX(watt) as watt'))
            ->groupBy('hour')
            ->get();        

        return response()->json([
            'success' => true,
            'message'=>'Device hou usages created successfully',
            'data' => $usage
        ], 200);
    }

    public function getTotalUsageDaily()
    {
        $usage = DB::table('total_usages')
            ->select(DB::raw('DATE(created_at) as date'), 
                    DB::raw('SUM(kwh) as kwh'), 
                    DB::raw('MAX(watt) as watt'))
            ->groupBy('date')
            ->get();       

        return response()->json([
            'success' => true,
            'message'=>'Device daily usages created successfully',
            'data' => $usage
        ], 200);
    }

    public function getTotalUsageWeekly()
    {
        $usage = DB::table('total_usages')
            ->select(DB::raw('YEARWEEK(created_at) as week'), 
                    DB::raw('SUM(kwh) as kwh'), 
                    DB::raw('MAX(watt) as watt'))
            ->groupBy('week')
            ->get();        

        return response()->json([
            'success' => true,
            'message'=>'Device weekly usages created successfully',
            'data' => $usage
        ], 200);
    }

    public function getTotalUsageMonthly()
    {
        $usage = DB::table('total_usages')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), 
                    DB::raw('SUM(kwh) as kwh'), 
                    DB::raw('MAX(watt) as watt'))
            ->groupBy('month')
            ->get();      

        return response()->json([
            'success' => true,
            'message'=>'Device monthly usages created successfully',
            'data' => $usage
        ], 200);
    }
}

