<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            //student
             [
                 'name' =>  'admin',
                 'email' => 'admin@gmail.com',
                 'phone' => '9999999991',
                 'password' => Hash::make('password'),
             ],
        ]);
    }
}
