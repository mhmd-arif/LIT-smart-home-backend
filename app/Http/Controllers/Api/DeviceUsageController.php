<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Device;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\DeviceUsage;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Carbon\Carbon;

class DeviceUsageController extends Controller
{
    public function getUsages()
    {
        try {
            $currentUser = Auth::user();
            $device_usages = DB::table('device_usages')->where('user_id', $currentUser->id)->get();
            
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
                $userDevices = DB::table('user_devices')
                    ->where('user_id', $user->id)
                    ->get();

                $total_kwh = 0;
                $total_watt = 0;

                foreach ($userDevices as $uDevice) {

                    $deviceWatt = UserDevice::find($uDevice->id)->device->watt;

                    if ($uDevice->state == 1) {
                        $time_last_change = (new Carbon($uDevice->updated_at))->toImmutable()->setTimezone('Asia/Jakarta');
    
                        $get_diff_hour = ($time_last_change->diffInSeconds(now())) / 3600;
    
                        $kwh = round(($get_diff_hour * $deviceWatt) / 1000, 5) + ($uDevice->last_kwh);
                        $watt = $deviceWatt;
                    } else {
                        $kwh = round($uDevice->last_kwh, 5);
                        $watt = 0;
                    }
    
                    DB::table('device_usages')->insert([
                        [
                            "user_device_id" => $uDevice->id,
                            "user_id" => $uDevice->user_id,
                            "kwh" => $kwh,
                            "watt" => $watt,
                            "state" => $uDevice->state,
                            "created_at" => now()
                        ]
                    ]);
    
                    $total_kwh = round($total_kwh + $kwh, 5);
                    $total_watt += $watt;
    
                    UserDevice::where("id", $uDevice->id)->update([
                        "last_kwh" => $kwh,
                    ]);
                }
    
                DB::table('total_usages')->insert([
                    [
                        "user_id" => $uDevice->user_id,
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

    // get usage (watt and kwh) PER DEVICE with the timeline
    public function findUsage($id)
    {
        try {
            $currentUser = Auth::user();
            $userDevice = UserDevice::find($id);
            $checkedDevice = ($userDevice !== null) ? $userDevice->user_id : false;

            if (($checkedDevice) != ($currentUser->id)){
                return response()->json([
                    'success' => false,
                    'message' => 'cant access this device',
                ], 401);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Device usage by is fetched successfully',
                'data' => $userDevice->deviceUsage
            ], 200);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
    }

    // // not used
    // public function destroy(DeviceUsage $device_usage)
    // {
    //     try {
    //         $currentUser = Auth::user();
    //         $checkedDevice = ($device !== null) ? $device->user_id : false;

    //         if (($checkedDevice) != ($currentUser->id)){
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Unauthorized - cant access this device',
    //             ], 400);
    //         }

    //         $device_usage->delete();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Device usage is deleted successfully'
    //         ], 200);
    //     } catch (\Exception $e) {
    //         throw new HttpException(500, $e->getMessage());
    //     }
    // }
}
