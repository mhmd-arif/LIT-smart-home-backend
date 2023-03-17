<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Device;
use App\Models\DeviceUsage;
use Carbon\Carbon;

class DeviceUsageController extends Controller
{
    public function index()
    {
        $device_usages = DeviceUsage::paginate();
        return response()->json($device_usages);
    }

    public function store(Request $request)
    {
        $devices = DB::table('devices')->get();
        foreach ($devices as $device)
        {
            if($device->state==1){
                $time_last_change = (new Carbon($device->updated_at))->toImmutable()->setTimezone('Asia/Jakarta');

                $get_minutes = ($time_last_change->diffInSeconds(now()))/3600;

                $kwh = round( $get_minutes * $device->watt, 2) + ($device->last_kwh);
            } else {
                $kwh = $device->last_kwh;
            }

            DB::table('device_usages')->insert([
                ["device_id"=>$device->id,
                    "kwh"=>$kwh,
                    "created_at"=>now()
                ]
            ]);
        }
        return response()->json(['message'=>'device_usage created successfully']);
    }

    public function show(DeviceUsage $device_usage)
    {
        // return response()->json($device_usage);
        return $device_usage;

    }

    public function destroy(DeviceUsage $device_usage)
    {
        $device_usage->delete();

        return response()-> json(['message'=>'device_usage delete successfully']);
    }
}

