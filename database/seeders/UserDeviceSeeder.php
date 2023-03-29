<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_devices')->insert([
            [
                "user_id" => 1,
                "device_id" => 1,
                "device_name" => "LIT-Lamp-1",
                "is_favorite" => true,
                "state" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "user_id" => 2,
                "device_id" => 1,
                "device_name" => "LIT-Lamp-2",
                "is_favorite" => false,
                "state" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "user_id" => 2,
                "device_id" => 1,
                "device_name" => "LIT-Super-Duper-Smart-Terminal",
                "is_favorite" => false,
                "state" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ]
        ]);
    }
}
