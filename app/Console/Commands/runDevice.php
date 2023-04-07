<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Device;
use App\Models\User;
use App\Models\DeviceUsage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class runDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:device';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {   
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
    }   
}

