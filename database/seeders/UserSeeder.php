<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'lit-user-1',
                'email' => 'lit-user-1@gmail.com',
                'password' => bcrypt('litpassword'),
            ],
            ['name' => 'lit-user-2',
                'email' => 'lit-user-2@gmail.com',
                'password' => bcrypt('litpassword'),
            ],
        ]);
    }
}
