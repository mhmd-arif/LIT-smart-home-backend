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
    // public function getDevices()
    // {
    //     try {
    //         $currentUser = Auth::user();
    //         $devices = Device::where('user_id', $currentUser->id)
    //         ->orderBy('is_favorite', 'desc')
    //         ->get();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Devices is fetched successfully',
    //             'data' => $devices
    //         ], 200);
    //     } catch (\Exception $e) {
    //         throw new HttpException(500, $e->getMessage());
    //     }
    // }

    // public function createDevice(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'device_name' => 'required',
    //             'user_id' => 'required|exists:users,id',
    //             'category' => 'required',
    //             'volt' => 'required',
    //             'ampere' => 'required',
    //             'watt' => 'required',
    //             'icon_url' => 'required'
    //         ]);
            
    //         DB::table('devices')->insert([
    //             [
    //                 'device_name' => $request->device_name,
    //                 'user_id' => $request->user_id,
    //                 'category' => $request->category,
    //                 'volt' => $request->volt,
    //                 'ampere' => $request->ampere,
    //                 'watt' => $request->watt,
    //                 'icon_url' => $request->icon_url,
    //                 "created_at" => now(),
    //             ]
    //         ]);

    //         $device = DB::table('devices')->get()->last();
            
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Device is created successfully',
    //             'data' => $device
    //         ], 200);
    //     } catch (\Exception $e) {
    //         throw new HttpException(500, $e->getMessage());
    //     }
    // }

    // public function findDevice($id)
    // {
    //     try {
    //         $currentUser = Auth::user();
    //         $device = Device::find($id);
    //         $checkedDevice = $device !== null ? $device->user_id : false;

    //         if ($checkedDevice != $currentUser->id){
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Unauthorized - cant access this device',
    //             ], 400);
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Your device (' . $device->device_name . ') is found',
    //             'data' => $device
    //         ], 200);
    //     } catch (\Exception $e) {
    //         throw new HttpException(500, $e->getMessage());
    //     }
    // }

    // public function updateDevice($id, Request $request)
    // {
    //     try {
    //         $currentUser = Auth::user();
    //         $device = Device::find($id);
    //         $checkedDevice = $device !== null ? $device->user_id : false;

    //         if ($checkedDevice != $currentUser->id){
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Unauthorized - cant access this device',
    //             ], 400);
    //         }
    //         $request->validate([
    //             'device_name' => 'required',
    //             'category' => 'required',
    //             'volt' => 'required|numeric',
    //             'ampere' => 'required|numeric',
    //             'watt' => 'required|numeric',
    //             'icon_url' => 'required'
    //         ]);

    //         $device->device_name = $request->device_name;
    //         $device->category = $request->category;
    //         $device->volt = $request->volt;
    //         $device->ampere = $request->ampere;
    //         $device->watt = $request->watt;
    //         $device->icon_url = $request->icon_url;
    //         $device->save();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Your device (' . $device->device_name . ') is updated succesfully',
    //             'data' => $device
    //         ], 200);

    //     } catch (\Exception $e) {
    //         throw new HttpException(500, $e->getMessage());
    //     }
    // }

    // public function updateState(Request $request, $id)
    // {
    //     try {
    //         $currentUser = Auth::user();
    //         $device = Device::find($id);
    //         $checkedDevice = $device !== null ? $device->user_id : false;

    //         if ($checkedDevice != $currentUser->id){
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Unauthorized - cant access this device',
    //             ], 400);
    //         }

    //         $request->validate([
    //             'state' => 'required',
    //         ]);
    
    //         if ($device->state == 1) {
    //             $time_last_change = (new Carbon($device->updated_at))->toImmutable()->setTimezone('Asia/Jakarta');
    //             $get_diff_hour = ($time_last_change->diffInSeconds(now())) / 3600;
    //             $last_kwh = round(($get_diff_hour * $device->watt) / 1000, 5) + ($device->last_kwh);
    //         } else if ($device->state == 0) {
    //             $last_kwh = $device->last_kwh;
    //         }
    
    //         $device = Device::where("id", $id)->update([
    //             "state" => $request->state,
    //             "last_kwh" => $last_kwh,
    //         ]);
    
    //         $device = Device::find($id);
    
    //         return response()->json($device);

    //     } catch (\Exception $e) {
    //         throw new HttpException(500, $e->getMessage());
    //     }
    // }

    // public function updateFavorite(Request $request, $id)
    // {
    //     try {
    //         $currentUser = Auth::user();
    //         $device = Device::find($id);
    //         $checkedDevice = $device !== null ? $device->user_id : false;

    //         if ($checkedDevice != $currentUser->id){
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Unauthorized - cant access this device',
    //             ], 400);
    //         }

    //         $request->validate([
    //             'is_favorite' => 'required',
    //         ]);
    
    //         $device = Device::where("id", $id)->update([
    //             "is_favorite" => $request->is_favorite,
    //         ]);
    
    //         $device = Device::find($id);
    
    //         return response()->json($device);
    //     } catch (\Exception $e) {
    //         throw new HttpException(500, $e->getMessage());
    //     }
        
    // }

    // public function deleteDevices($id)
    // {
    //     try {
    //         $currentUser = Auth::user();
    //         $device = Device::find($id);
    //         $checkedDevice = $device !== null ? $device->user_id : false;

    //         if ($checkedDevice != $currentUser->id){
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Unauthorized - cant access this device',
    //             ], 400);
    //         }
            
    //         $device->delete();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Your device (' . $device->device_name . ') is deleted successfully',
    //             'data' => $device
    //         ], 200);
    //     } catch (\Exception $e) {
    //         throw new HttpException(500, $e->getMessage());
    //     }
    // }
}
