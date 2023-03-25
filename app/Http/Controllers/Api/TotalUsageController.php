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
        $today = date('Y-m-d H:i:s');
        $yesterday = date('Y-m-d H:i:s', strtotime('-1 day'));
        $total_usages = DB::table('total_usages')->whereBetween('created_at', [$yesterday, $today])->get();

        return response()->json([
            'success' => true,
            'message' => 'Device usages created successfully',
            'data' => $total_usages
        ], 200);
    }

    public function getTotalUsageHourly()
    {
        $today = date('Y-m-d H:i:s');
        $yesterday = date('Y-m-d H:i:s', strtotime('-1 day'));
        $usage = DB::table('total_usages')
            ->whereBetween('created_at', [$yesterday, $today])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%H:00:00") as hour'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
                DB::raw('MAX(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('hour', 'date')
            ->get();

        $devices = DB::table('device_usages')
            ->whereBetween('created_at', [$yesterday, $today])
            ->select(
                'device_id',
                DB::raw('DATE_FORMAT(created_at, "%H:00:00") as hour'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
                DB::raw('MAX(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('hour', 'device_id', 'date')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Device hourly usages created successfully',
            'data' => [
                'total_usages' => $usage,
                'device_usages' => $devices
            ],
        ], 200);
    }

    public function getTotalUsageDaily()
    {
        $today = date('Y-m-d H:i:s');
        $yesterday = date('Y-m-d H:i:s', strtotime('-1 day'));
        $usage = DB::table('total_usages')
            ->whereBetween('created_at', [$yesterday, $today])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('MAX(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('date')
            ->get();

        $devices = DB::table('device_usages')
            ->whereBetween('created_at', [$yesterday, $today])
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
        $today = date('Y-m-d H:i:s');
        $yesterday = date('Y-m-d H:i:s', strtotime('-1 day'));
        $usage = DB::table('total_usages')
            ->whereBetween('created_at', [$yesterday, $today])
            ->select(
                DB::raw('YEARWEEK(created_at) as week'),
                DB::raw('MAX(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('week')
            ->get();

        $devices = DB::table('device_usages')
            ->whereBetween('created_at', [$yesterday, $today])
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
        $today = date('Y-m-d H:i:s');
        $yesterday = date('Y-m-d H:i:s', strtotime('-1 day'));
        $usage = DB::table('total_usages')
            ->whereBetween('created_at', [$yesterday, $today])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('MAX(kwh) as kwh'),
                DB::raw('MAX(watt) as watt')
            )
            ->groupBy('month')
            ->get();

        $devices = DB::table('device_usages')
            ->whereBetween('created_at', [$yesterday, $today])
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
