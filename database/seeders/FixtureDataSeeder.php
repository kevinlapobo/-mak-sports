<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FixtureDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Add scheduled fixtures within the past 2 hours so they show up in Add Results
        // The Add Results page filters: status=scheduled AND match_date <= now+2h
        $fixtures = [
            // Football
            ['competition_id' => 1, 'home_team_id' => 1, 'away_team_id' => 3, 'venue_id' => 1, 'status' => 'scheduled', 'match_date' => $now->copy()->subMinutes(45), 'minute' => 0, 'is_featured' => true],
            ['competition_id' => 1, 'home_team_id' => 4, 'away_team_id' => 6, 'venue_id' => 1, 'status' => 'scheduled', 'match_date' => $now->copy()->subMinutes(90), 'minute' => 0, 'is_featured' => false],
            ['competition_id' => 1, 'home_team_id' => 2, 'away_team_id' => 5, 'venue_id' => 2, 'status' => 'scheduled', 'match_date' => $now->copy()->subMinutes(15), 'minute' => 0, 'is_featured' => false],
            ['competition_id' => 2, 'home_team_id' => 1, 'away_team_id' => 4, 'venue_id' => 6, 'status' => 'scheduled', 'match_date' => $now->copy()->subHours(1), 'minute' => 0, 'is_featured' => false],
            ['competition_id' => 1, 'home_team_id' => 3, 'away_team_id' => 2, 'venue_id' => 2, 'status' => 'scheduled', 'match_date' => $now->copy()->addMinutes(30), 'minute' => 0, 'is_featured' => false],
            // Basketball
            ['competition_id' => 3, 'home_team_id' => 7, 'away_team_id' => 9, 'venue_id' => 2, 'status' => 'scheduled', 'match_date' => $now->copy()->subMinutes(30), 'minute' => 0, 'is_featured' => true],
            ['competition_id' => 3, 'home_team_id' => 8, 'away_team_id' => 10, 'venue_id' => 2, 'status' => 'scheduled', 'match_date' => $now->copy()->subMinutes(75), 'minute' => 0, 'is_featured' => false],
            ['competition_id' => 3, 'home_team_id' => 9, 'away_team_id' => 7, 'venue_id' => 2, 'status' => 'scheduled', 'match_date' => $now->copy()->addHours(1), 'minute' => 0, 'is_featured' => false],
            // Volleyball
            ['competition_id' => 4, 'home_team_id' => 11, 'away_team_id' => 13, 'venue_id' => 3, 'status' => 'scheduled', 'match_date' => $now->copy()->subMinutes(60), 'minute' => 0, 'is_featured' => false],
            ['competition_id' => 4, 'home_team_id' => 12, 'away_team_id' => 14, 'venue_id' => 3, 'status' => 'scheduled', 'match_date' => $now->copy()->subMinutes(10), 'minute' => 0, 'is_featured' => false],
            ['competition_id' => 4, 'home_team_id' => 13, 'away_team_id' => 11, 'venue_id' => 3, 'status' => 'scheduled', 'match_date' => $now->copy()->addMinutes(45), 'minute' => 0, 'is_featured' => false],
            // Rugby
            ['competition_id' => 5, 'home_team_id' => 15, 'away_team_id' => 16, 'venue_id' => 4, 'status' => 'scheduled', 'match_date' => $now->copy()->subMinutes(40), 'minute' => 0, 'is_featured' => true],
            // Netball
            ['competition_id' => 6, 'home_team_id' => 17, 'away_team_id' => 19, 'venue_id' => 5, 'status' => 'scheduled', 'match_date' => $now->copy()->subMinutes(25), 'minute' => 0, 'is_featured' => false],
            ['competition_id' => 6, 'home_team_id' => 18, 'away_team_id' => 20, 'venue_id' => 5, 'status' => 'scheduled', 'match_date' => $now->copy()->subMinutes(5), 'minute' => 0, 'is_featured' => false],
            ['competition_id' => 6, 'home_team_id' => 19, 'away_team_id' => 17, 'venue_id' => 5, 'status' => 'scheduled', 'match_date' => $now->copy()->addMinutes(15), 'minute' => 0, 'is_featured' => false],
        ];

        foreach ($fixtures as $fixture) {
            $fixture['home_score'] = 0;
            $fixture['away_score'] = 0;
            $fixture['created_at'] = $now;
            $fixture['updated_at'] = $now;
            DB::table('matches')->insert($fixture);
        }

        $this->command->info('✅ Added 15 fixtures for Add Results page');
    }
}
