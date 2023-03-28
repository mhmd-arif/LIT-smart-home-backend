<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Device;
use App\Models\DeviceUsage;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;

class DeviceUsageController extends Controller
{
    public function index()
    {
        try {
            $currentUser = Auth::user();
            $device_usages = DeviceUsage::where('user_id', $currentUser->id)
            ->get();
            return response()->json([
                'success' => true,
                'message' => 'Device usages is fetched successfully',
                'data' => $device_usages
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    public function createUsage()
    {
        try {
            $users = DB::table('users')->get();

            foreach ($users as $user){
                $devices = DB::table('devices')
                    ->where('user_id', $user->id)
                    ->get();

                $total_kwh = 0;
                $total_watt = 0;

                foreach ($devices as $device) {
                    if ($device->state == 1) {
                        $time_last_change = (new Carbon($device->updated_at))->toImmutable()->setTimezone('Asia/Jakarta');
    
                        $get_diff_hour = ($time_last_change->diffInSeconds(now())) / 3600;
    
                        $kwh = round(($get_diff_hour * $device->watt) / 1000, 5) + ($device->last_kwh);
                        $watt = $device->watt;
                    } else {
                        $kwh = round($device->last_kwh, 5);
                        $watt = 0;
                    }
    
                    DB::table('device_usages')->insert([
                        [
                            "device_id" => $device->id,
                            "user_id" => $device->user_id,
                            "kwh" => $kwh,
                            "watt" => $watt,
                            "state" => $device->state,
                            "created_at" => now()
                        ]
                    ]);
    
                    $total_kwh = round($total_kwh + $kwh, 5);
                    $total_watt += $watt;
    
                    Device::where("id", $device->id)->update([
                        "last_kwh" => $kwh,
                    ]);
                }
    
                DB::table('total_usages')->insert([
                    [
                        "user_id" => $device->user_id,
                        "kwh" => $total_kwh,
                        "watt" => $total_watt,
                        "created_at" => now(),
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Device usages created successfully'
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    // not used
    public function show(DeviceUsage $device_usage)
    {
        try {
            $currentUser = Auth::user();
            if ($device_usage->user_id != $currentUser->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized - cant access this device',
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Device usage is fetched successfully',
                'data' => $device_usage
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    // get usage (watt and kwh) PER DEVICE with the timeline
    public function getUsage($id)
    {
        try {
            $usage = Device::find($id)->deviceUsage->first();
            $usages = Device::find($id)->deviceUsage;
            $currentUser = Auth::user();

            if ($usage->user_id != $currentUser->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized - cant access this device',
                ], 400);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Device usage by is fetched successfully',
                'data' => $usages
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    // not used
    public function destroy(DeviceUsage $device_usage)
    {
        try {
            $currentUser = Auth::user();
            if ($device_usage->user_id != $currentUser->id){
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized - cant access this device',
                ], 400);
            }

            $device_usage->delete();
            return response()->json([
                'success' => true,
                'message' => 'Device usage is deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }
}
