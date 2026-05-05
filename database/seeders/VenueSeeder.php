<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venues = [
            ['name' => 'Makerere Main Sports Grounds',    'location' => 'Makerere University, Kampala'],
            ['name' => 'Makerere Rugby Grounds "The Graveyard"', 'location' => 'Makerere University'],
            ['name' => 'Makerere Basketball Court',       'location' => 'Makerere University'],
            ['name' => 'Makerere Swimming Pool',          'location' => 'Makerere University'],
            ['name' => 'Makerere Indoor Hall',            'location' => 'Makerere University'],
        ];
        foreach ($venues as $venue) {
            Venue::create($venue);
        }
    }
}
