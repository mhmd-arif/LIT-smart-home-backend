<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('devices')->insert([
            ["device_name" => "LIT-Lamp-1",
            "type" => "Smart Lamp",
            "volt" => "100",
            "ampere" => "1",
            "watt" => "100"
            ],
            ["device_name" => "LIT-Lamp-2",
            "type" => "Smart Lamp",
            "volt" => "200",
            "ampere" => "1",
            "watt" => "200"
            ]
        ]);
    }
}
