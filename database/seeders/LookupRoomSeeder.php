<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookupRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
    
        // Define the new data to seed into the lookup_rooms table
        $data = [
            ['id' => 1, 'name' => 'single'],
            ['id' => 2, 'name' => 'double'],
            ['id' => 3, 'name' => 'suite'],
            ['id' => 4, 'name' => 'Twin'],
            ['id' =>5, 'name' => 'Queen'],
            ['id' => 6, 'name' => 'King'],
            ['id' => 7, 'name' => 'Deluxe'],
            ['id' => 8, 'name' => 'Villa'],
            ['id' => 9, 'name' => 'Club'],
        ];
    
        // Insert data into the lookup_rooms table
        DB::table('lookup_rooms')->insert($data);
    }
    
}
