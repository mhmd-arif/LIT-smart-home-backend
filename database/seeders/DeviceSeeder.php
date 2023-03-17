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
            [
                "user_id" => 1,
                "device_name" => "LIT-Lamp-1",
                "category" => "Smart Lamp",
                "is_favorite" => true,
                "volt" => "100",
                "ampere" => "1",
                "watt" => "100",
                "state" => true,
                "icon_url" => "mdi-ceiling-light",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "user_id" => 2,
                "device_name" => "LIT-Lamp-2",
                "category" => "Smart Lamp",
                "is_favorite" => false,
                "volt" => "200",
                "ampere" => "1",
                "watt" => "200",
                "state" => false,
                "icon_url" => "mdi-ceiling-light",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "user_id" => 2,
                "device_name" => "LIT-Super-Duper-Smart-Terminal",
                "category" => "Smart Terminal",
                "is_favorite" => true,
                "volt" => "100",
                "ampere" => "1",
                "watt" => "120",
                "state" => false,
                "icon_url" => "mdi-power-socket-eu",
                "created_at" => now(),
                "updated_at" => now(),
            ]
        ]);
    }
}
