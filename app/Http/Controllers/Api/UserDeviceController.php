<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserDevice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;

class UserDeviceController extends Controller
{
    public function createUserDevice(Request $request)
    {
        try {
            $currentUser = Auth::user();
            $request->validate([
                'device_name' => 'required',
                'device_id' => 'required|exists:devices,id',
            ]);
            
            DB::table('user_devices')->insert([
                [
                    'device_name' => $request->device_name,
                    'user_id' => $currentUser->id,
                    'device_id' => $request->device_id,
                    "created_at" => now(),
                ]
            ]);

            $device = DB::table('user_devices')->get()->last();
            
            return response()->json([
                'success' => true,
                'message' => 'UserDevice is created successfully',
                'data' => $device
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
    
    public function getUserDevices()
    {
        try {
            $currentUser = Auth::user();

            $devices = UserDevice::where('user_id', $currentUser->id)
            ->orderBy('is_favorite', 'desc')
            ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Devices is fetched successfully',
                'data' => $devices
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function findUserDevice($id)
    {
        try {
            $currentUser = Auth::user();
            $device = UserDevice::find($id);
            $checkedDevice = $device !== null ? $device->user_id : false;

            if ($checkedDevice != $currentUser->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized - cant access this device',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Your device (' . $device->device_name . ') is found',
                'data' => $device
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function updateUserDevice($id, Request $request)
    {
        try {
            $currentUser = Auth::user();
            $device = UserDevice::find($id);
            $checkedDevice = $device !== null ? $device->user_id : false;

            if ($checkedDevice != $currentUser->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized - cant access this device',
                ], 400);
            }
            $request->validate([
                'device_name' => 'required',
            ]);

            $device->device_name = $request->device_name;
            $device->save();

            return response()->json([
                'success' => true,
                'message' => 'Your device (' . $device->device_name . ') is updated succesfully',
                'data' => $device
            ], 200);

        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function updateState(Request $request, $id)
    {
        try {
            $currentUser = Auth::user();
            $device = UserDevice::find($id);
            $checkedDevice = $device !== null ? $device->user_id : false;

            if ($checkedDevice != $currentUser->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized - cant access this device',
                ], 400);
            }

            $request->validate([
                'state' => 'required',
            ]);
    
            if ($device->state == 1) {
                $time_last_change = (new Carbon($device->updated_at))->toImmutable()->setTimezone('Asia/Jakarta');
                $get_diff_hour = ($time_last_change->diffInSeconds(now())) / 3600;
                $last_kwh = round(($get_diff_hour * $device->watt) / 1000, 5) + ($device->last_kwh);
            } else if ($device->state == 0) {
                $last_kwh = $device->last_kwh;
            }
    
            $device = UserDevice::where("id", $id)->update([
                "state" => $request->state,
                "last_kwh" => $last_kwh,
            ]);
    
            $device = UserDevice::find($id);
    
            return response()->json($device);

        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function updateFavorite(Request $request, $id)
    {
        try {
            $currentUser = Auth::user();
            $device = UserDevice::find($id);
            $checkedDevice = $device !== null ? $device->user_id : false;

            if ($checkedDevice != $currentUser->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized - cant access this device',
                ], 400);
            }

            $request->validate([
                'is_favorite' => 'required',
            ]);
    
            $device = UserDevice::where("id", $id)->update([
                "is_favorite" => $request->is_favorite,
            ]);
    
            $device = UserDevice::find($id);
    
            return response()->json($device);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
        
    }

    public function deleteUserDevices($id)
    {
        try {
            $currentUser = Auth::user();
            $device = UserDevice::find($id);
            $checkedDevice = $device !== null ? $device->user_id : false;

            if ($checkedDevice != $currentUser->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized - cant access this device',
                ], 400);
            }
            
            $device->delete();
            return response()->json([
                'success' => true,
                'message' => 'Your device (' . $device->device_name . ') is deleted successfully',
                'data' => $device
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
