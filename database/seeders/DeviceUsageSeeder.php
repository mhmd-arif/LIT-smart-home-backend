<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('device_usages')->insert([
            ["device_id"=>1,
                "user_id"=>1,
                "kwh"=>0,
                "is_on"=>true,
                "created_at"=>"2023-01-01 00:00:00"
            ],
            ["device_id"=>1,
                "user_id"=>1,
                "kwh"=>15,
                "is_on"=>true,
                "created_at"=>"2023-01-01 00:15:00"
            ],
            ["device_id"=>1,
                "user_id"=>1,
                "kwh"=>30,
                "is_on"=>false,
                "created_at"=>"2023-01-01 00:30:00"
            ],
            ["device_id"=>1,
                "user_id"=>1,
                "kwh"=>30,
                "is_on"=>false,
                "created_at"=>"2023-01-01 00:45:00"
            ],
            ["device_id"=>1,
                "user_id"=>1,
                "kwh"=>30,
                "is_on"=>true,
                "created_at"=>"2023-01-01 01:00:00"
            ],
            ["device_id"=>1,
                "user_id"=>1,
                "kwh"=>45,
                "is_on"=>true,
                "created_at"=>"2023-01-01 01:15:00"
            ],
            ["device_id"=>1,
                "user_id"=>1,
                "kwh"=>60,
                "is_on"=>true,
                "created_at"=>"2023-01-01 01:30:00"
            ],
            
            ["device_id"=>2,
                "user_id"=>1,
                "kwh"=>0,
                "is_on"=>false,
                "created_at"=>"2023-01-01 00:00:00"
            ],
            ["device_id"=>2,
                "user_id"=>1,
                "kwh"=>0,
                "is_on"=>false,
                "created_at"=>"2023-01-01 00:15:00"
            ],
            ["device_id"=>2,
                "user_id"=>1,
                "kwh"=>0,
                "is_on"=>true,
                "created_at"=>"2023-01-01 00:30:00"
            ],
            ["device_id"=>2,
                "user_id"=>1,
                "kwh"=>30,
                "is_on"=>false,
                "created_at"=>"2023-01-01 00:45:00"
            ],
            ["device_id"=>2,
                "user_id"=>1,
                "kwh"=>30,
                "is_on"=>true,
                "created_at"=>"2023-01-01 01:00:00"
            ],
            ["device_id"=>2,
                "user_id"=>1,
                "kwh"=>60,
                "is_on"=>true,
                "created_at"=>"2023-01-01 01:15:00"
            ],
            ["device_id"=>2,
                "user_id"=>1,
                "kwh"=>60,
                "is_on"=>false,
                "created_at"=>"2023-01-01 01:30:00"
            ],
        ]);
    }
}
