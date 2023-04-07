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
                "category" => "Smart LED",
                "volt" => "12",
                "ampere" => "1",
                "watt" => "12",
                "icon_url" => "mdi-lightbulb",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "category" => "Adaptor LED Strip",
                "volt" => "12",
                "ampere" => "1",
                "watt" => "12",
                "icon_url" => "mdi-led-strip",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "category" => "Smart Wall Light",
                "volt" => "9",
                "ampere" => "1",
                "watt" => "9",
                "icon_url" => "mdi-led-strip-variant",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "category" => "Smart Wall Socket",
                "volt" => "220",
                "ampere" => "4", //max 16A
                "watt" => "880",
                "icon_url" => "mdi-power-socket-eu",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "category" => "Smart Wall Switch",
                "volt" => "200",
                "ampere" => "1", //max 4A
                "watt" => "200",
                "icon_url" => "mdi-light-switch",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "category" => "Smart Extension Power",
                "volt" => "220",
                "ampere" => "2.5", //max 10A
                "watt" => "550",
                "icon_url" => "mdi-power-plug",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "category" => "Smart Portable Plug",
                "volt" => "220",
                "ampere" => "4", //max 16A
                "watt" => "880",
                "icon_url" => "mdi-connection",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ]);
    }
}
