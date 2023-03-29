<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\UserDevice;
use App\Models\DeviceUsage;
use App\Models\TotalUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;


class TotalUsageController extends Controller
{

    public function getTotalUsage()
    {
        try {
            $currentUser = Auth::user();

            $today = date('Y-m-d H:i:s');
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $total_usages = DB::table('total_usages')
            ->where('user_id', $currentUser->id)
            ->whereBetween('created_at', [$yesterday, $today])
            ->get();

            return response()->json([
                'success' => true,
                'message' => 'Device regularly created successfully',
                'data' => $total_usages
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function getTotalUsageHourly()
    {
        try {
            $currentUser = Auth::user();

            $today = date('Y-m-d H:i:s');
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $usage = DB::table('total_usages')
                ->where('user_id', $currentUser->id)
                ->whereBetween('created_at', [$yesterday, $today])
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%H:00:00") as hour'),
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
                    DB::raw('YEARWEEK(created_at) as week'),
                    DB::raw('DATE_FORMAT(created_at, "%m") as month'),
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('MAX(kwh) as kwh'),
                    DB::raw('MAX(watt) as watt')
                )
                ->groupBy('hour', 'date', 'week', 'month', 'year')
                ->orderBy('hour', 'asc')
                ->get();

            $devices = DB::table('device_usages')
                ->whereBetween('created_at', [$yesterday, $today])
                ->select(
                    'user_device_id',
                    DB::raw('DATE_FORMAT(created_at, "%H:00:00") as hour'),
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
                    DB::raw('YEARWEEK(created_at) as week'),
                    DB::raw('DATE_FORMAT(created_at, "%m") as month'),
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('MAX(kwh) as kwh'),
                    DB::raw('MAX(watt) as watt')
                )
                ->groupBy('hour', 'user_device_id', 'date', 'week', 'month', 'year')
                ->orderBy('hour', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Device hourly usages created successfully',
                'data' => [
                    'total_usages' => $usage,
                    'device_usages' => $devices
                ],
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function getTotalUsageDaily()
    {
        try {
            $currentUser = Auth::user();

            $today = date('Y-m-d H:i:s');
            $yesterday = date('Y-m-d', strtotime('-7 day'));
            $usage = DB::table('total_usages')
                ->where('user_id', $currentUser->id)
                ->whereBetween('created_at', [$yesterday, $today])
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('YEARWEEK(created_at) as week'),
                    DB::raw('DATE_FORMAT(created_at, "%m") as month'),
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('MAX(kwh) as kwh'),
                    DB::raw('MAX(watt) as watt')
                )
                ->groupBy('date', 'week', 'month', 'year')
                ->orderBy('date', 'asc')
                ->get();

            $devices = DB::table('device_usages')
                ->whereBetween('created_at', [$yesterday, $today])
                ->select(
                    'user_device_id',
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('YEARWEEK(created_at) as week'),
                    DB::raw('DATE_FORMAT(created_at, "%m") as month'),
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('MAX(kwh) as kwh'),
                    DB::raw('MAX(watt) as watt')
                )
                ->groupBy('date', 'user_device_id', 'week', 'month', 'year')
                ->orderBy('date', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Device daily usages created successfully',
                'data' => [
                    'total_usages' => $usage,
                    'device_usages' => $devices
                ]
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function getTotalUsageWeekly()
    {
        try {
            $currentUser = Auth::user();

            $today = date('Y-m-d H:i:s');
            $yesterday = date('Y-m-d', strtotime('-30 day'));
            $usage = DB::table('total_usages')
                ->where('user_id', $currentUser->id)
                ->whereBetween('created_at', [$yesterday, $today])
                ->select(
                    DB::raw('YEARWEEK(created_at) as week'),
                    DB::raw('DATE_FORMAT(created_at, "%m") as month'),
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('MAX(kwh) as kwh'),
                    DB::raw('MAX(watt) as watt')
                )
                ->groupBy('week', 'month', 'year')
                ->orderBy('week', 'asc')
                ->get();

            $devices = DB::table('device_usages')
                ->whereBetween('created_at', [$yesterday, $today])
                ->select(
                    'user_device_id',
                    DB::raw('YEARWEEK(created_at) as week'),
                    DB::raw('DATE_FORMAT(created_at, "%m") as month'),
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('MAX(kwh) as kwh'),
                    DB::raw('MAX(watt) as watt')
                )
                ->groupBy('week', 'user_device_id', 'month', 'year')
                ->orderBy('week', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Device weekly usages created successfully',
                'data' => [
                    'total_usages' => $usage,
                    'device_usages' => $devices
                ]
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function getTotalUsageMonthly()
    {
        try {
            $currentUser = Auth::user();

            $today = date('Y-m-d H:i:s');
            $yesterday = date('Y-m-d', strtotime('-365 day'));
            $usage = DB::table('total_usages')
                ->where('user_id', $currentUser->id)
                ->whereBetween('created_at', [$yesterday, $today])
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('MAX(kwh) as kwh'),
                    DB::raw('MAX(watt) as watt')
                )
                ->groupBy('month', 'year')
                ->orderBy('month', 'asc')
                ->get();

            $devices = DB::table('device_usages')
                ->whereBetween('created_at', [$yesterday, $today])
                ->select(
                    'user_device_id',
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('DATE_FORMAT(created_at, "%Y") as year'),
                    DB::raw('MAX(kwh) as kwh'),
                    DB::raw('MAX(watt) as watt')
                )
                ->groupBy('month', 'user_device_id', 'year')
                ->orderBy('month', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Device monthly usages created successfully',
                'data' => [
                    'total_usages' => $usage,
                    'device_usages' => $devices
                ]
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}