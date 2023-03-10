<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::paginate();
        return response()->json($devices);
    }

    public function store(Request $request)
    {
        $request -> validate([
            'device_name' => 'required',
            'type' => 'required',
            'volt' => 'required',
            'ampere' => 'required',
            'watt' => 'required',
        ]);

        $device = Device::create($request->all());
        return response()->json($device);
    }

    public function show(Device $device)
    {
        return $device;
    }

    public function update(Device $device, Request $request)
    {
        $request -> validate([
            'device_name' => 'required',
            'type' => 'required',
            'volt' => 'required',
            'ampere' => 'required',
            'watt' => 'required',
        ]);

        $device->device_name = $request->device_name;
        $device->type = $request->type;
        $device->volt = $request->volt;
        $device->ampere = $request->ampere;
        $device->watt = $request->watt;        
        $device->save();

        return response()->json($device);
    }

    public function destroy(Device $device)
    {
        $device->delete();

        return response()-> json(['message'=>'device delete successfully']);
    }
}

