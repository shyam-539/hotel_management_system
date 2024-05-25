<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookupFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            'Air Conditioning',
            'Heating',
            'Free Wi-Fi',
            'Television',
            'Refrigerator',
            'Microwave',
            'Coffee/Tea Maker',
            'Safe Deposit Box',
            'Iron/Ironing Board',
            'Hairdryer',
            'Telephone',
            'Work Desk',
            'Wardrobe/Closet',
            'Bathrobe',
            'Slippers',
            'Towels',
            'Shower',
            'Bathtub',
            'Toiletries',
            'Daily Housekeeping',
            'Room Service',
            'Laundry Service',
            'Wake-up Service',
            'Alarm Clock',
            'Balcony/Terrace',
            'City View',
            'Sea View',
            'Pool View',
            'Accessible Rooms',
            'Mini Bar',
            'Non-smoking Rooms',
            'Connecting/Adjoining Rooms',
            'Pet-friendly Rooms',
            'Pool',
            'Private Pool',
        ];

        foreach ($facilities as $facility) {
            DB::table('lookup_facilities')->insert(['name' => $facility]);
        }
    
    }
}
