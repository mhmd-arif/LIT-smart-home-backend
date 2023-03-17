<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Device;
use App\Models\DeviceUsage;
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
        $devices = DB::table('devices')->get();
        foreach ($devices as $device)
        {
            if($device->state==1){
                $time_last_change = (new Carbon($device->updated_at))->toImmutable()->setTimezone('Asia/Jakarta');

                $get_diff_hour = ($time_last_change->diffInSeconds(now()))/3600;

                $kwh = round(($get_diff_hour * $device->watt)/1000, 5) + ($device->last_kwh);
            } else {
                $kwh = round($device->last_kwh/1000, 5);
            }

            DB::table('device_usages')->insert([
                ["device_id"=>$device->id,
                    "kwh"=>$kwh,
                    "created_at"=>now()
                ]
            ]);
            var_dump($kwh);
        }
    }
}

