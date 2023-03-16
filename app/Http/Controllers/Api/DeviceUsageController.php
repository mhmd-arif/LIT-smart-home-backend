<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceUsage;
use Illuminate\Http\Request;

class DeviceUsageController extends Controller
{
    public function index()
    {
        $device_usages = DeviceUsage::paginate();
        return response()->json($device_usages);
    }

    public function store(Request $request)
    {
        $request  -> validate([
            'device_id' => 'required|exists:devices,id',
            // 'user_id' => 'required|exists:users,id',
            'kwh' => 'required',
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

    public function destroy(DeviceUsage $device_usage)
    {
        $device_usage->delete();

        return response()-> json(['message'=>'device_usage delete successfully']);
    }
}

