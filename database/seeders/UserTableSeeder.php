<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            //student
             [
                 'first_name' =>  'user',
                 'last_name' => 'test',
                 'email' => 'user@gmail.com',
                 'phone' => '9999999931',
                 'city'  => 'palazhi',
                 'district'  => 'kozhikode',
                 'state'  => 'kerala',
                 'pin_code'  => 673014,
                 'password' => Hash::make('password'),
                 'total_points' => 5,
             ],
            ]);
    }
}
