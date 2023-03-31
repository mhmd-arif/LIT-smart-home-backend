<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DeviceUsage;
use App\Events\DeviceCreated;
use App\Events\DeviceUpdated;
use App\Events\DeviceDeleted;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;

class DeviceController extends Controller
{
    public function createDevice(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'category' => 'required|string|max:50|unique:devices',
                'volt' => 'required|numeric',
                'ampere' => 'required|numeric',
                'watt' => 'required|numeric',
                'icon_url' => 'required|string'
            ]);

            if($validator->fails()){
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors(),
                ], 400);       
            }
            
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
            
            DeviceCreated::dispatch($device);
            
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

            if($device === null){
                return response()->json([
                    "success" => false,
                    'message' => 'Bad request - device not found',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Device ( ' . $device->category . ' ) is found',
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

            if($device === null){
                return response()->json([
                    "success" => false,
                    'message' => 'Bad request - device not found',
                ], 400);
            }

            $validator = Validator::make($request->all(),[
                'category' => 'required|string|max:50|unique:devices',
                'volt' => 'required|numeric',
                'ampere' => 'required|numeric',
                'watt' => 'required|numeric',
                'icon_url' => 'required|string'
            ]);

            if($validator->fails()){
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors(),
                ], 400);       
            }

            $device->category = $request->category;
            $device->volt = $request->volt;
            $device->ampere = $request->ampere;
            $device->watt = $request->watt;
            $device->icon_url = $request->icon_url;
            $device->save();

            DeviceUpdated::dispatch($device);

            return response()->json([
                'success' => true,
                'message' => 'Device ( ' . $device->category . ' ) is updated succesfully',
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

            if($device === null){
                return response()->json([
                    "success" => false,
                    'message' => 'Bad request - device not found',
                ], 400);
            }
            
            $device->delete();

            DeviceDeleted::dispatch($device);

            return response()->json([
                'success' => true,
                'message' => 'Device ( ' . $device->category . ' ) is deleted successfully',
                'data' => $device
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
