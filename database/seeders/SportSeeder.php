<?php

namespace Database\Seeders;

use App\Models\Sport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sports = [
            ['name' => 'Football',     'slug' => 'football',      'icon' => '⚽'],
            ['name' => 'Basketball',   'slug' => 'basketball',    'icon' => '🏀'],
            ['name' => 'Volleyball',   'slug' => 'volleyball',    'icon' => '🏐'],
            ['name' => 'Rugby',        'slug' => 'rugby',         'icon' => '🏉'],
            ['name' => 'Netball',      'slug' => 'netball',       'icon' => '🥅'],
            ['name' => 'Athletics',    'slug' => 'athletics',     'icon' => '🏃'],
            ['name' => 'Tennis',       'slug' => 'tennis',        'icon' => '🎾'],
            ['name' => 'Hockey',       'slug' => 'hockey',        'icon' => '🏑'],
            ['name' => 'Swimming',     'slug' => 'swimming',      'icon' => '🏊'],
            ['name' => 'Table Tennis', 'slug' => 'table-tennis',  'icon' => '🏓'],
            ['name' => 'Badminton',    'slug' => 'badminton',     'icon' => '🏸'],
            ['name' => 'Chess',        'slug' => 'chess',         'icon' => '♟️'],
        ];
        foreach ($sports as $i => $sport) {
            Sport::create(array_merge($sport, [
                'is_active'     => true,
                'display_order' => $i + 1,
            ]));
        }
    }
}
