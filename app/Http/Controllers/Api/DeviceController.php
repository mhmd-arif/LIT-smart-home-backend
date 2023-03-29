<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DeviceUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;

class DeviceController extends Controller
{
    public function createDevice(Request $request)
    {
        try {
            $request->validate([
                'category' => 'required',
                'volt' => 'required',
                'ampere' => 'required',
                'watt' => 'required',
                'icon_url' => 'required'
            ]);
            
            DB::table('devices')->insert([
                [
                    'category' => $request->category,
                    'volt' => $request->volt,
                    'ampere' => $request->ampere,
                    'watt' => $request->watt,
                    'icon_url' => $request->icon_url,
                    "created_at" => now(),
                ]
            ]);

            $device = DB::table('devices')->get()->last();
            
            return response()->json([
                'success' => true,
                'message' => 'Device is created successfully',
                'data' => $device
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function getDevices()
    {
        try {
            $devices = Device::get();
            return response()->json([
                'success' => true,
                'message' => 'Devices is fetched successfully',
                'data' => $devices
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function findDevice($id)
    {
        try {
            $device = Device::find($id);

            return response()->json([
                'success' => true,
                'message' => 'Your device is found',
                'data' => $device
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function updateDevice($id, Request $request)
    {
        try {
            $device = Device::find($id);
            
            $request->validate([
                'category' => 'required',
                'volt' => 'required|numeric',
                'ampere' => 'required|numeric',
                'watt' => 'required|numeric',
                'icon_url' => 'required'
            ]);

            $device->category = $request->category;
            $device->volt = $request->volt;
            $device->ampere = $request->ampere;
            $device->watt = $request->watt;
            $device->icon_url = $request->icon_url;
            $device->save();

            return response()->json([
                'success' => true,
                'message' => 'Your device is updated succesfully',
                'data' => $device
            ], 200);

        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function deleteDevices($id)
    {
        try {
            $device = Device::find($id);
            
            $device->delete();
            return response()->json([
                'success' => true,
                'message' => 'Your device is deleted successfully',
                'data' => $device
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
