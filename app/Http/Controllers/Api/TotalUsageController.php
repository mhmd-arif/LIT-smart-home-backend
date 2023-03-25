<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Device;
use App\Models\DeviceUsage;
use App\Models\TotalUsage;
use Carbon\Carbon;

class TotalUsageController extends Controller
{
    public function getTotalUsage()
    {
        $total_usages = DB::table('total_usages')->get();
        return response()->json([
            'success' => true,
            'message' => 'Device usages created successfully',
            'data' => $total_usages
        ], 200);
    }

    public function getTotalUsageHourly($id)
    {
        $usage = DB::table('total_usages')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as hour'),
                DB::raw('SUM(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('hour')
            ->get();

        $devices = DB::table('device_usages')
            ->select(
                'device_id',
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as hour'),
                DB::raw('MAX(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('hour', 'device_id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Device hourly usages created successfully',
            'data' => [
                'total_usages' => $usage,
                'device_usages' => $devices
            ]
        ], 200);
    }

    public function getTotalUsageDaily()
    {
        $usage = DB::table('total_usages')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('date')
            ->get();

        $devices = DB::table('device_usages')
            ->select(
                'device_id',
                DB::raw('DATE(created_at) as date'),
                DB::raw('MAX(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('date', 'device_id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Device daily usages created successfully',
            'data' => [
                'total_usages' => $usage,
                'device_usages' => $devices
            ]
        ], 200);
    }

    public function getTotalUsageWeekly()
    {
        $usage = DB::table('total_usages')
            ->select(
                DB::raw('YEARWEEK(created_at) as week'),
                DB::raw('SUM(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('week')
            ->get();

        $devices = DB::table('device_usages')
            ->select(
                'device_id',
                DB::raw('YEARWEEK(created_at) as week'),
                DB::raw('MAX(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('week', 'device_id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Device weekly usages created successfully',
            'data' => [
                'total_usages' => $usage,
                'device_usages' => $devices
            ]
        ], 200);
    }

    public function getTotalUsageMonthly()
    {
        $usage = DB::table('total_usages')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('month')
            ->get();

        $devices = DB::table('device_usages')
            ->select(
                'device_id',
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('MAX(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('month', 'device_id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Device monthly usages created successfully',
            'data' => [
                'total_usages' => $usage,
                'device_usages' => $devices
            ]
        ], 200);
    }
}
