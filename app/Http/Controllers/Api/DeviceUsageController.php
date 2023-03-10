<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceUsage;
use Illuminate\Http\Request;

class DeviceUsageController extends Controller
{
    public function index()
    {
        $devices_usage = DeviceUsage::paginate();
        return response()->json($devices_usage);
    }

    public function store(Request $request)
    {
        $request -> validate([
            'kwh' => 'required',
            'is_on' => 'required',
            'created_at' => 'required',
        ]);

        $device_usage = DeviceUsage::create($request->all());
        return response()->json($device_usage);
    }

    public function show(DeviceUsage $device_usage)
    {
        // return response()->json($device_usage);
        return $device_usage;

    }

    public function update(DeviceUsage $device_usage, Request $request)
    {
        // $request -> validate([
        //     'kwh' => 'required',
        //     'is_on' => 'required',
        //     'created_at' => 'required',
        // ]);

        // $device_usage->kwh = $request->kwh;
        // $device_usage->is_on = $request->is_on;
        // $device_usage->created_at = $request->created_at;
        // $device_usage->save();

        // return response()->json($device_usage);
        return response()-> json(['message'=>'device_usage cant be updated']);
    }

    public function destroy(DeviceUsage $device_usage)
    {
        $device_usage->delete();

        return response()-> json(['message'=>'device_usage delete successfully']);
    }
}

