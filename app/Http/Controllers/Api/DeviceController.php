<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DeviceUsage;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::orderBy('is_favorite', 'desc')->paginate();
        return response()->json($devices);
    }

    public function store(Request $request)
    {
        $request -> validate([
            'user_id' => 'required|exists:users,id',
            'device_name' => 'required',
            'category' => 'required',
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
            'user_id' => 'required|exists:users,id',
            'device_name' => 'required',
            'category' => 'required',
            'volt' => 'required|numeric',
            'ampere' => 'required|numeric',
            'watt' => 'required|numeric',
        ]);

        $device->device_name = $request->device_name;
        $device->category = $request->category;
        $device->volt = $request->volt;
        $device->ampere = $request->ampere;
        $device->watt = $request->watt;   
        $device->save();

        return response()->json($device);
    }

    public function updateState(Request $request, $id)
    {
        $request -> validate([
            'state' => 'required',
        ]);

        // $last_kwh = DeviceUsage::orderBy('created_at', 'desc')->where("device_id", $id)->first()->;

        $device = Device::where("id", $id)->update([
            "state" => $request->state,
            // "last_kwh" => $last_kwh,
        ]);

        $device = Device::find($id);

        return response()->json($device);
    }

    public function updateFavorite(Request $request, $id)
    {
        $request -> validate([
            'is_favorite' => 'required',
        ]);

        $device = Device::where("id", $id)->update([
            "is_favorite" => $request->is_favorite,
        ]);

        $device = Device::find($id);

        return response()->json($device);
    }

    public function destroy(Device $device)
    {
        $device->delete(); 
        return response()-> json($device);
    }
}

