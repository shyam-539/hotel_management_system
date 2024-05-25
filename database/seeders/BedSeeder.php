<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beds = [
            ['bed_type' => 'Single', 'adult_capacity' => 1, 'child_capacity' => 0],
            ['bed_type' => 'Double', 'adult_capacity' => 2, 'child_capacity' => 1],
            ['bed_type' => 'Twin', 'adult_capacity' => 2, 'child_capacity' => 1],
            ['bed_type' => 'Queen', 'adult_capacity' => 2, 'child_capacity' => 1],
            ['bed_type' => 'King', 'adult_capacity' => 2, 'child_capacity' => 2],
            ['bed_type' => 'California King', 'adult_capacity' => 2, 'child_capacity' => 2],
            ['bed_type' => 'Sofa Bed', 'adult_capacity' => 2, 'child_capacity' => 1],
            ['bed_type' => 'Bunk Bed', 'adult_capacity' => 2, 'child_capacity' => 2],
            ['bed_type' => 'Cot', 'adult_capacity' => 1, 'child_capacity' => 0],
        ];

        foreach ($beds as $bed) {
            DB::table('beds')->insert($bed);
        }
    }
}
