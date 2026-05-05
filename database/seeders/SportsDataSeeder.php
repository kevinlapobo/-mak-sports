<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SportsDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('venue_bookings')->truncate();
        DB::table('match_events')->truncate();
        DB::table('matches')->truncate();
        DB::table('standings')->truncate();
        DB::table('news_updates')->truncate();
        DB::table('players')->truncate();
        DB::table('teams')->truncate();
        DB::table('coaches')->truncate();
        DB::table('competitions')->truncate();
        DB::table('venues')->truncate();
        DB::table('sports')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ─── 1. SPORTS ───
        $sports = [
            ['name' => 'Football', 'slug' => 'football', 'icon' => '⚽', 'is_active' => true, 'display_order' => 1],
            ['name' => 'Basketball', 'slug' => 'basketball', 'icon' => '🏀', 'is_active' => true, 'display_order' => 2],
            ['name' => 'Volleyball', 'slug' => 'volleyball', 'icon' => '🏐', 'is_active' => true, 'display_order' => 3],
            ['name' => 'Rugby', 'slug' => 'rugby', 'icon' => '🏉', 'is_active' => true, 'display_order' => 4],
            ['name' => 'Netball', 'slug' => 'netball', 'icon' => '🥅', 'is_active' => true, 'display_order' => 5],
            ['name' => 'Athletics', 'slug' => 'athletics', 'icon' => '🏃', 'is_active' => true, 'display_order' => 6],
        ];
        foreach ($sports as $sport) {
            $sport['created_at'] = now();
            $sport['updated_at'] = now();
            DB::table('sports')->insert($sport);
        }

        // ─── 2. VENUES ───
        $venues = [
            ['name' => 'Makerere University Main Stadium', 'location' => 'Makerere Hill, Kampala', 'capacity' => 20000],
            ['name' => 'Wema Basketball Court', 'location' => 'Makerere University', 'capacity' => 2000],
            ['name' => 'Ivory Park Volleyball Court', 'location' => 'Makerere University', 'capacity' => 1500],
            ['name' => 'MUK Rugby Pitches', 'location' => 'Makerere Hill, Kampala', 'capacity' => 3000],
            ['name' => 'Netball Courts - Main Campus', 'location' => 'Makerere University', 'capacity' => 1000],
            ['name' => 'Makerere Athletics Track', 'location' => 'Makerere Hill, Kampala', 'capacity' => 10000],
        ];
        foreach ($venues as $venue) {
            $venue['created_at'] = now();
            $venue['updated_at'] = now();
            DB::table('venues')->insert($venue);
        }

        // ─── 3. COACHES ───
        $coaches = [
            ['name' => 'Dr. Moses Ochen', 'phone' => '+256700111111', 'email' => 'moses.ochen@mak.ac.ug', 'qualification' => 'CAF B License', 'is_active' => true],
            ['name' => 'Coach Sarah Nakamya', 'phone' => '+256700222222', 'email' => 'sarah.nakamya@mak.ac.ug', 'qualification' => 'FIBA Level 2', 'is_active' => true],
            ['name' => 'Mr. James Mugisha', 'phone' => '+256700333333', 'email' => 'james.mugisha@mak.ac.ug', 'qualification' => 'UVF Coaching Certificate', 'is_active' => true],
            ['name' => 'Coach Grace Achieng', 'phone' => '+256700444444', 'email' => 'grace.ach@mak.ac.ug', 'qualification' => 'NU Volleyball License', 'is_active' => true],
            ['name' => 'Mr. David Okello', 'phone' => '+256700555555', 'email' => 'david.okello@mak.ac.ug', 'qualification' => 'Rugby Uganda Level 3', 'is_active' => true],
            ['name' => 'Ms. Patience Auma', 'phone' => '+256700666666', 'email' => 'patience.auma@mak.ac.ug', 'qualification' => 'Netball Uganda Certificate', 'is_active' => true],
            ['name' => 'Coach Peter Ssemwanga', 'phone' => '+256700777777', 'email' => 'peter.ssem@mak.ac.ug', 'qualification' => 'Athletics Coach Level 2', 'is_active' => true],
            ['name' => 'Mr. Ibrahim Kasozi', 'phone' => '+256700888888', 'email' => 'ibrahim.kasozi@mak.ac.ug', 'qualification' => 'CAF A License', 'is_active' => true],
        ];
        foreach ($coaches as $coach) {
            $coach['joined_date'] = now()->subMonths(rand(6, 36))->format('Y-m-d');
            $coach['created_at'] = now();
            $coach['updated_at'] = now();
            DB::table('coaches')->insert($coach);
        }

        // ─── 4. COMPETITIONS ───
        $competitions = [
            ['sport_id' => 1, 'name' => 'MUK Premier League 2026', 'slug' => 'muk-premier-league-2026', 'type' => 'league', 'season' => '2025/2026', 'is_active' => true],
            ['sport_id' => 1, 'name' => 'GULF Inter-University Football', 'slug' => 'gulf-football-2026', 'type' => 'cup', 'season' => '2026', 'is_active' => true],
            ['sport_id' => 2, 'name' => 'MUK Basketball Championship 2026', 'slug' => 'muk-basketball-2026', 'type' => 'league', 'season' => '2025/2026', 'is_active' => true],
            ['sport_id' => 3, 'name' => 'MUK Volleyball League 2026', 'slug' => 'muk-volleyball-2026', 'type' => 'league', 'season' => '2025/2026', 'is_active' => true],
            ['sport_id' => 4, 'name' => 'MUK Rugby 7s 2026', 'slug' => 'muk-rugby-7s-2026', 'type' => 'tournament', 'season' => '2026', 'is_active' => true],
            ['sport_id' => 5, 'name' => 'MUK Netball Championship 2026', 'slug' => 'muk-netball-2026', 'type' => 'league', 'season' => '2025/2026', 'is_active' => true],
        ];
        foreach ($competitions as $comp) {
            $comp['start_date'] = '2026-01-15';
            $comp['end_date'] = '2026-06-30';
            $comp['created_at'] = now();
            $comp['updated_at'] = now();
            DB::table('competitions')->insert($comp);
        }

        // ─── 5. TEAMS ───
        $teams = [
            // Football (sport_id=1)
            ['sport_id' => 1, 'coach_id' => 1, 'name' => 'COCIS Football Team', 'slug' => 'cocis-football', 'faculty' => 'Computing & IT', 'home_venue' => 'Main Stadium', 'founded_year' => 2010, 'description' => 'COCIS School football team', 'is_active' => true],
            ['sport_id' => 1, 'coach_id' => 8, 'name' => 'CEDAT Football', 'slug' => 'cedat-football', 'faculty' => 'Engineering', 'home_venue' => 'Main Stadium', 'founded_year' => 2008, 'description' => 'College of Engineering Design football', 'is_active' => true],
            ['sport_id' => 1, 'coach_id' => 1, 'name' => 'CHUSS Strikers', 'slug' => 'chuss-strikers', 'faculty' => 'Humanities & Social Sciences', 'home_venue' => 'Main Stadium', 'founded_year' => 2012, 'description' => 'CHUSS football team', 'is_active' => true],
            ['sport_id' => 1, 'coach_id' => 1, 'name' => 'CONAS United', 'slug' => 'conas-united', 'faculty' => 'Natural Sciences', 'home_venue' => 'Main Stadium', 'founded_year' => 2009, 'description' => 'CONAS football team', 'is_active' => true],
            ['sport_id' => 1, 'coach_id' => 1, 'name' => 'CAES Football', 'slug' => 'caes-football', 'faculty' => 'Agriculture & Environment', 'home_venue' => 'Main Stadium', 'founded_year' => 2011, 'description' => 'CAES football squad', 'is_active' => true],
            ['sport_id' => 1, 'coach_id' => 1, 'name' => 'CHS Warriors', 'slug' => 'chs-warriors', 'faculty' => 'Health Sciences', 'home_venue' => 'Main Stadium', 'founded_year' => 2013, 'description' => 'CHS medical school team', 'is_active' => true],
            // Basketball (sport_id=2)
            ['sport_id' => 2, 'coach_id' => 2, 'name' => 'COCIS Hoops', 'slug' => 'cocis-hoops', 'faculty' => 'Computing & IT', 'home_venue' => 'Wema Court', 'founded_year' => 2014, 'description' => 'COCIS basketball', 'is_active' => true],
            ['sport_id' => 2, 'coach_id' => 2, 'name' => 'CEDAT Ballers', 'slug' => 'cedat-ballers', 'faculty' => 'Engineering', 'home_venue' => 'Wema Court', 'founded_year' => 2015, 'description' => 'CEDAT basketball', 'is_active' => true],
            ['sport_id' => 2, 'coach_id' => 2, 'name' => 'CHSS Dunkers', 'slug' => 'chss-dunkers', 'faculty' => 'Humanities', 'home_venue' => 'Wema Court', 'founded_year' => 2016, 'description' => 'CHSS basketball', 'is_active' => true],
            ['sport_id' => 2, 'coach_id' => 2, 'name' => 'CONAS Courts', 'slug' => 'conas-courts', 'faculty' => 'Natural Sciences', 'home_venue' => 'Wema Court', 'founded_year' => 2014, 'description' => 'CONAS basketball', 'is_active' => true],
            // Volleyball (sport_id=3)
            ['sport_id' => 3, 'coach_id' => 4, 'name' => 'COCIS Spikers', 'slug' => 'cocis-spikers', 'faculty' => 'Computing', 'home_venue' => 'Ivory Park', 'founded_year' => 2015, 'description' => 'COCIS volleyball', 'is_active' => true],
            ['sport_id' => 3, 'coach_id' => 4, 'name' => 'CEDAT Blockers', 'slug' => 'cedat-blockers', 'faculty' => 'Engineering', 'home_venue' => 'Ivory Park', 'founded_year' => 2016, 'description' => 'CEDAT volleyball', 'is_active' => true],
            ['sport_id' => 3, 'coach_id' => 4, 'name' => 'CHSS Net Force', 'slug' => 'chss-net-force', 'faculty' => 'Humanities', 'home_venue' => 'Ivory Park', 'founded_year' => 2017, 'description' => 'CHSS volleyball', 'is_active' => true],
            ['sport_id' => 3, 'coach_id' => 4, 'name' => 'CONAS Smash', 'slug' => 'conas-smash', 'faculty' => 'Natural Sciences', 'home_venue' => 'Ivory Park', 'founded_year' => 2015, 'description' => 'CONAS volleyball', 'is_active' => true],
            // Rugby (sport_id=4)
            ['sport_id' => 4, 'coach_id' => 5, 'name' => 'MUK Rugby Lions', 'slug' => 'muk-rugby-lions', 'faculty' => 'University', 'home_venue' => 'Rugby Pitches', 'founded_year' => 2005, 'description' => 'Main university rugby team', 'is_active' => true],
            ['sport_id' => 4, 'coach_id' => 5, 'name' => 'CEDAT Rhinos', 'slug' => 'cedat-rhinos', 'faculty' => 'Engineering', 'home_venue' => 'Rugby Pitches', 'founded_year' => 2010, 'description' => 'CEDAT rugby', 'is_active' => true],
            // Netball (sport_id=5)
            ['sport_id' => 5, 'coach_id' => 6, 'name' => 'CHS Netball Stars', 'slug' => 'chs-netball-stars', 'faculty' => 'Health Sciences', 'home_venue' => 'Netball Courts', 'founded_year' => 2012, 'description' => 'CHS netball', 'is_active' => true],
            ['sport_id' => 5, 'coach_id' => 6, 'name' => 'COCIS Net Queens', 'slug' => 'cocis-net-queens', 'faculty' => 'Computing', 'home_venue' => 'Netball Courts', 'founded_year' => 2014, 'description' => 'COCIS netball', 'is_active' => true],
            ['sport_id' => 5, 'coach_id' => 6, 'name' => 'CONAS Netball', 'slug' => 'conas-netball', 'faculty' => 'Natural Sciences', 'home_venue' => 'Netball Courts', 'founded_year' => 2013, 'description' => 'CONAS netball', 'is_active' => true],
            ['sport_id' => 5, 'coach_id' => 6, 'name' => 'CEDAT Netball', 'slug' => 'cedat-netball', 'faculty' => 'Engineering', 'home_venue' => 'Netball Courts', 'founded_year' => 2015, 'description' => 'CEDAT netball', 'is_active' => true],
        ];
        foreach ($teams as $team) {
            $team['created_at'] = now();
            $team['updated_at'] = now();
            DB::table('teams')->insert($team);
        }

        // ─── 6. PLAYERS ───
        $firstNames = ['Joseph', 'Brian', 'Ivan', 'Emmanuel', 'Patrick', 'Samuel', 'Allan', 'Dennis', 'Ronald', 'Frank', 'Geoffrey', 'Isaac', 'Victor', 'Timothy', 'Moses', 'Sarah', 'Grace', 'Esther', 'Faith', 'Joy', 'Diana', 'Ruth', 'Mary', 'Christine', 'Nancy', 'Ivan', 'Brian', 'Peter', 'David', 'Paul'];
        $lastNames = ['Mugisha', 'Nakamya', 'Ochieng', 'Ssemwanga', 'Achieng', 'Kasozi', 'Tumwine', 'Nantume', 'Okello', 'Auma', 'Byaruhanga', 'Namugga', 'Katende', 'Acen', 'Mugerwa', 'Nabirye', 'Kato', 'Tugume', 'Nakato', 'Opiyo', 'Nalwanga', 'Bukenya', 'Asiimwe', 'Lubega', 'Waiswa', 'Namayanja', 'Kizza', 'Nanyonjo', 'Tumusiime', 'Nakamya'];
        $positions = ['Goalkeeper', 'Defender', 'Midfielder', 'Forward', 'Center', 'Point Guard', 'Shooting Guard', 'Power Forward', 'Small Forward', 'Center Back', 'Fly Half', 'Winger', 'Scrum Half', 'Lock', 'Number 8', 'Goal Shooter', 'Goal Attack', 'Wing Attack', 'Center', 'Wing Defence', 'Goal Defence', 'Goal Keeper', 'Sprinter', 'Long Distance', 'Middle Distance'];
        $playerId = 1;
        $footballTeams = [1, 2, 3, 4, 5, 6];
        $basketballTeams = [7, 8, 9, 10];
        $volleyballTeams = [11, 12, 13, 14];
        $rugbyTeams = [15, 16];
        $netballTeams = [17, 18, 19, 20];

        foreach ([$footballTeams, $basketballTeams, $volleyballTeams, $rugbyTeams, $netballTeams] as $sportTeams) {
            foreach ($sportTeams as $teamId) {
                $playerCount = rand(10, 15);
                for ($i = 0; $i < $playerCount; $i++) {
                    $firstName = $firstNames[array_rand($firstNames)];
                    $lastName = $lastNames[array_rand($lastNames)];
                    $name = $firstName . ' ' . $lastName;

                    $player = [
                        'team_id' => $teamId,
                        'name' => $name,
                        'position' => $positions[array_rand($positions)],
                        'jersey_number' => rand(1, 99),
                        'student_id' => '20' . rand(20, 26) . '/' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT),
                        'year_of_study' => ['Year 1', 'Year 2', 'Year 3', 'Year 4'][rand(0, 3)],
                        'faculty' => DB::table('teams')->where('id', $teamId)->value('faculty'),
                        'goals' => rand(0, 15),
                        'assists' => rand(0, 10),
                        'yellow_cards' => rand(0, 5),
                        'red_cards' => rand(0, 2),
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    DB::table('players')->insert($player);
                    $playerId++;
                }
            }
        }

        // ─── 7. MATCHES ───
        $now = Carbon::now();

        // Finished matches (last 30 days)
        $finishedMatches = [];
        for ($i = 1; $i <= 20; $i++) {
            $matchDate = $now->copy()->subDays(rand(1, 30))->hour(rand(14, 18))->minute(0);
            $team1 = rand(1, 6);
            $team2 = rand(1, 6);
            while ($team2 === $team1) { $team2 = rand(1, 6); }
            $finishedMatches[] = [
                'competition_id' => 1,
                'home_team_id' => $team1,
                'away_team_id' => $team2,
                'venue_id' => rand(1, 2),
                'home_score' => rand(0, 5),
                'away_score' => rand(0, 4),
                'status' => 'finished',
                'match_date' => $matchDate,
                'minute' => 90,
                'is_featured' => $i <= 2,
                'created_at' => $matchDate,
                'updated_at' => $now,
            ];
        }

        // Basketball finished
        for ($i = 0; $i < 8; $i++) {
            $matchDate = $now->copy()->subDays(rand(1, 20))->hour(rand(14, 18))->minute(0);
            $team1 = rand(7, 10);
            $team2 = rand(7, 10);
            while ($team2 === $team1) { $team2 = rand(7, 10); }
            $finishedMatches[] = [
                'competition_id' => 3,
                'home_team_id' => $team1,
                'away_team_id' => $team2,
                'venue_id' => 2,
                'home_score' => rand(55, 95),
                'away_score' => rand(45, 90),
                'status' => 'finished',
                'match_date' => $matchDate,
                'minute' => 40,
                'is_featured' => $i < 2,
                'created_at' => $matchDate,
                'updated_at' => $now,
            ];
        }

        // Volleyball finished
        for ($i = 0; $i < 6; $i++) {
            $matchDate = $now->copy()->subDays(rand(1, 20))->hour(rand(14, 18))->minute(0);
            $team1 = rand(11, 14);
            $team2 = rand(11, 14);
            while ($team2 === $team1) { $team2 = rand(11, 14); }
            $finishedMatches[] = [
                'competition_id' => 4,
                'home_team_id' => $team1,
                'away_team_id' => $team2,
                'venue_id' => 3,
                'home_score' => rand(1, 3),
                'away_score' => rand(0, 3),
                'status' => 'finished',
                'match_date' => $matchDate,
                'minute' => 60,
                'is_featured' => false,
                'created_at' => $matchDate,
                'updated_at' => $now,
            ];
        }

        // Rugby finished
        for ($i = 0; $i < 4; $i++) {
            $matchDate = $now->copy()->subDays(rand(1, 20))->hour(rand(14, 18))->minute(0);
            $team1 = rand(15, 16);
            $team2 = $team1 === 15 ? 16 : 15;
            $finishedMatches[] = [
                'competition_id' => 5,
                'home_team_id' => $team1,
                'away_team_id' => $team2,
                'venue_id' => 4,
                'home_score' => rand(7, 35),
                'away_score' => rand(3, 28),
                'status' => 'finished',
                'match_date' => $matchDate,
                'minute' => 80,
                'is_featured' => $i < 2,
                'created_at' => $matchDate,
                'updated_at' => $now,
            ];
        }

        // Netball finished
        for ($i = 0; $i < 6; $i++) {
            $matchDate = $now->copy()->subDays(rand(1, 20))->hour(rand(14, 18))->minute(0);
            $team1 = rand(17, 20);
            $team2 = rand(17, 20);
            while ($team2 === $team1) { $team2 = rand(17, 20); }
            $finishedMatches[] = [
                'competition_id' => 6,
                'home_team_id' => $team1,
                'away_team_id' => $team2,
                'venue_id' => 5,
                'home_score' => rand(15, 45),
                'away_score' => rand(10, 40),
                'status' => 'finished',
                'match_date' => $matchDate,
                'minute' => 60,
                'is_featured' => false,
                'created_at' => $matchDate,
                'updated_at' => $now,
            ];
        }

        // Upcoming matches (next 30 days)
        $upcomingMatches = [];
        // Football upcoming
        for ($i = 0; $i < 12; $i++) {
            $matchDate = $now->copy()->addDays(rand(1, 30))->hour(rand(10, 17))->minute(0);
            $team1 = rand(1, 6);
            $team2 = rand(1, 6);
            while ($team2 === $team1) { $team2 = rand(1, 6); }
            $upcomingMatches[] = [
                'competition_id' => 1,
                'home_team_id' => $team1,
                'away_team_id' => $team2,
                'venue_id' => rand(1, 2),
                'home_score' => 0,
                'away_score' => 0,
                'status' => 'scheduled',
                'match_date' => $matchDate,
                'minute' => 0,
                'is_featured' => $i < 2,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Basketball upcoming
        for ($i = 0; $i < 6; $i++) {
            $matchDate = $now->copy()->addDays(rand(1, 25))->hour(rand(10, 17))->minute(0);
            $team1 = rand(7, 10);
            $team2 = rand(7, 10);
            while ($team2 === $team1) { $team2 = rand(7, 10); }
            $upcomingMatches[] = [
                'competition_id' => 3,
                'home_team_id' => $team1,
                'away_team_id' => $team2,
                'venue_id' => 2,
                'home_score' => 0,
                'away_score' => 0,
                'status' => 'scheduled',
                'match_date' => $matchDate,
                'minute' => 0,
                'is_featured' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Volleyball upcoming
        for ($i = 0; $i < 5; $i++) {
            $matchDate = $now->copy()->addDays(rand(1, 25))->hour(rand(10, 17))->minute(0);
            $team1 = rand(11, 14);
            $team2 = rand(11, 14);
            while ($team2 === $team1) { $team2 = rand(11, 14); }
            $upcomingMatches[] = [
                'competition_id' => 4,
                'home_team_id' => $team1,
                'away_team_id' => $team2,
                'venue_id' => 3,
                'home_score' => 0,
                'away_score' => 0,
                'status' => 'scheduled',
                'match_date' => $matchDate,
                'minute' => 0,
                'is_featured' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Rugby upcoming
        for ($i = 0; $i < 3; $i++) {
            $matchDate = $now->copy()->addDays(rand(1, 25))->hour(rand(10, 17))->minute(0);
            $team1 = rand(15, 16);
            $team2 = $team1 === 15 ? 16 : 15;
            $upcomingMatches[] = [
                'competition_id' => 5,
                'home_team_id' => $team1,
                'away_team_id' => $team2,
                'venue_id' => 4,
                'home_score' => 0,
                'away_score' => 0,
                'status' => 'scheduled',
                'match_date' => $matchDate,
                'minute' => 0,
                'is_featured' => $i < 2,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Netball upcoming
        for ($i = 0; $i < 5; $i++) {
            $matchDate = $now->copy()->addDays(rand(1, 25))->hour(rand(10, 17))->minute(0);
            $team1 = rand(17, 20);
            $team2 = rand(17, 20);
            while ($team2 === $team1) { $team2 = rand(17, 20); }
            $upcomingMatches[] = [
                'competition_id' => 6,
                'home_team_id' => $team1,
                'away_team_id' => $team2,
                'venue_id' => 5,
                'home_score' => 0,
                'away_score' => 0,
                'status' => 'scheduled',
                'match_date' => $matchDate,
                'minute' => 0,
                'is_featured' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Live match (football)
        $liveTeam1 = rand(3, 5);
        $liveTeam2 = rand(1, 6);
        while ($liveTeam2 === $liveTeam1) { $liveTeam2 = rand(1, 6); }
        $liveMatches = [
            [
                'competition_id' => 1,
                'home_team_id' => $liveTeam1,
                'away_team_id' => $liveTeam2,
                'venue_id' => 1,
                'home_score' => rand(1, 3),
                'away_score' => rand(0, 2),
                'status' => 'live',
                'match_date' => $now->copy()->subMinutes(rand(15, 75)),
                'minute' => rand(15, 85),
                'is_featured' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Cancelled
        $cancelled = [
            [
                'competition_id' => 2,
                'home_team_id' => 5,
                'away_team_id' => 6,
                'venue_id' => 1,
                'home_score' => 0,
                'away_score' => 0,
                'status' => 'cancelled',
                'match_date' => $now->copy()->subDays(5),
                'minute' => 0,
                'is_featured' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach (array_merge($finishedMatches, $upcomingMatches, $liveMatches, $cancelled) as $match) {
            DB::table('matches')->insert($match);
        }

        // ─── 8. MATCH EVENTS (for finished & live matches) ───
        $matchIds = DB::table('matches')->whereIn('status', ['finished', 'live'])->pluck('id');
        $eventTypes = ['goal', 'yellow_card', 'red_card', 'substitution'];

        foreach ($matchIds as $matchId) {
            $match = DB::table('matches')->find($matchId);
            $homePlayers = DB::table('players')->where('team_id', $match->home_team_id)->pluck('id')->toArray();
            $awayPlayers = DB::table('players')->where('team_id', $match->away_team_id)->pluck('id')->toArray();

            // Goals
            $totalGoals = $match->home_score + $match->away_score;
            for ($g = 0; $g < min($totalGoals, 10); $g++) {
                $isHome = $g < $match->home_score;
                $teamId = $isHome ? $match->home_team_id : $match->away_team_id;
                $players = $isHome ? $homePlayers : $awayPlayers;
                if (empty($players)) continue;
                DB::table('match_events')->insert([
                    'match_id' => $matchId,
                    'team_id' => $teamId,
                    'player_id' => $players[array_rand($players)],
                    'event_type' => 'goal',
                    'minute' => rand(1, (int)$match->minute ?: 90),
                    'description' => 'Goal scored',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Yellow cards
            for ($c = 0; $c < rand(0, 4); $c++) {
                $teamId = rand($match->home_team_id, $match->away_team_id);
                $players = ($teamId === $match->home_team_id) ? $homePlayers : $awayPlayers;
                if (empty($players)) continue;
                DB::table('match_events')->insert([
                    'match_id' => $matchId,
                    'team_id' => $teamId,
                    'player_id' => $players[array_rand($players)],
                    'event_type' => 'yellow_card',
                    'minute' => rand(1, (int)$match->minute ?: 90),
                    'description' => 'Yellow card',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ─── 9. STANDINGS ───

        // Football (competition_id=1)
        $footballStandings = [
            ['team_id' => 1, 'played' => 12, 'won' => 9, 'drawn' => 2, 'lost' => 1, 'goals_for' => 28, 'goals_against' => 8],
            ['team_id' => 2, 'played' => 12, 'won' => 8, 'drawn' => 2, 'lost' => 2, 'goals_for' => 24, 'goals_against' => 12],
            ['team_id' => 3, 'played' => 12, 'won' => 7, 'drawn' => 3, 'lost' => 2, 'goals_for' => 22, 'goals_against' => 11],
            ['team_id' => 4, 'played' => 12, 'won' => 5, 'drawn' => 3, 'lost' => 4, 'goals_for' => 18, 'goals_against' => 16],
            ['team_id' => 5, 'played' => 12, 'won' => 3, 'drawn' => 2, 'lost' => 7, 'goals_for' => 12, 'goals_against' => 22],
            ['team_id' => 6, 'played' => 12, 'won' => 1, 'drawn' => 2, 'lost' => 9, 'goals_for' => 8, 'goals_against' => 28],
        ];
        foreach ($footballStandings as $s) {
            $gd = $s['goals_for'] - $s['goals_against'];
            $pts = ($s['won'] * 3) + ($s['drawn'] * 1);
            DB::table('standings')->insert([
                'competition_id' => 1, 'team_id' => $s['team_id'],
                'played' => $s['played'], 'won' => $s['won'], 'drawn' => $s['drawn'], 'lost' => $s['lost'],
                'goals_for' => $s['goals_for'], 'goals_against' => $s['goals_against'],
                'goal_difference' => $gd, 'points' => $pts, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // Basketball (competition_id=3)
        $basketballStandings = [
            ['team_id' => 7, 'played' => 10, 'won' => 8, 'drawn' => 1, 'lost' => 1, 'goals_for' => 720, 'goals_against' => 580],
            ['team_id' => 8, 'played' => 10, 'won' => 7, 'drawn' => 1, 'lost' => 2, 'goals_for' => 690, 'goals_against' => 610],
            ['team_id' => 9, 'played' => 10, 'won' => 4, 'drawn' => 2, 'lost' => 4, 'goals_for' => 620, 'goals_against' => 640],
            ['team_id' => 10, 'played' => 10, 'won' => 1, 'drawn' => 2, 'lost' => 7, 'goals_for' => 510, 'goals_against' => 710],
        ];
        foreach ($basketballStandings as $s) {
            $gd = $s['goals_for'] - $s['goals_against'];
            $pts = ($s['won'] * 3) + ($s['drawn'] * 1);
            DB::table('standings')->insert([
                'competition_id' => 3, 'team_id' => $s['team_id'],
                'played' => $s['played'], 'won' => $s['won'], 'drawn' => $s['drawn'], 'lost' => $s['lost'],
                'goals_for' => $s['goals_for'], 'goals_against' => $s['goals_against'],
                'goal_difference' => $gd, 'points' => $pts, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // Volleyball (competition_id=4)
        $volleyballStandings = [
            ['team_id' => 11, 'played' => 8, 'won' => 7, 'drawn' => 0, 'lost' => 1, 'goals_for' => 21, 'goals_against' => 8],
            ['team_id' => 12, 'played' => 8, 'won' => 5, 'drawn' => 1, 'lost' => 2, 'goals_for' => 18, 'goals_against' => 12],
            ['team_id' => 13, 'played' => 8, 'won' => 3, 'drawn' => 1, 'lost' => 4, 'goals_for' => 14, 'goals_against' => 16],
            ['team_id' => 14, 'played' => 8, 'won' => 1, 'drawn' => 0, 'lost' => 7, 'goals_for' => 7, 'goals_against' => 24],
        ];
        foreach ($volleyballStandings as $s) {
            $gd = $s['goals_for'] - $s['goals_against'];
            $pts = ($s['won'] * 3) + ($s['drawn'] * 1);
            DB::table('standings')->insert([
                'competition_id' => 4, 'team_id' => $s['team_id'],
                'played' => $s['played'], 'won' => $s['won'], 'drawn' => $s['drawn'], 'lost' => $s['lost'],
                'goals_for' => $s['goals_for'], 'goals_against' => $s['goals_against'],
                'goal_difference' => $gd, 'points' => $pts, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // Rugby (competition_id=5)
        $rugbyStandings = [
            ['team_id' => 15, 'played' => 6, 'won' => 5, 'drawn' => 0, 'lost' => 1, 'goals_for' => 142, 'goals_against' => 85],
            ['team_id' => 16, 'played' => 6, 'won' => 1, 'drawn' => 0, 'lost' => 5, 'goals_for' => 68, 'goals_against' => 155],
        ];
        foreach ($rugbyStandings as $s) {
            $gd = $s['goals_for'] - $s['goals_against'];
            $pts = ($s['won'] * 3) + ($s['drawn'] * 1);
            DB::table('standings')->insert([
                'competition_id' => 5, 'team_id' => $s['team_id'],
                'played' => $s['played'], 'won' => $s['won'], 'drawn' => $s['drawn'], 'lost' => $s['lost'],
                'goals_for' => $s['goals_for'], 'goals_against' => $s['goals_against'],
                'goal_difference' => $gd, 'points' => $pts, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // Netball (competition_id=6)
        $netballStandings = [
            ['team_id' => 17, 'played' => 10, 'won' => 8, 'drawn' => 1, 'lost' => 1, 'goals_for' => 320, 'goals_against' => 210],
            ['team_id' => 18, 'played' => 10, 'won' => 6, 'drawn' => 2, 'lost' => 2, 'goals_for' => 285, 'goals_against' => 225],
            ['team_id' => 19, 'played' => 10, 'won' => 3, 'drawn' => 1, 'lost' => 6, 'goals_for' => 240, 'goals_against' => 280],
            ['team_id' => 20, 'played' => 10, 'won' => 1, 'drawn' => 0, 'lost' => 9, 'goals_for' => 180, 'goals_against' => 310],
        ];
        foreach ($netballStandings as $s) {
            $gd = $s['goals_for'] - $s['goals_against'];
            $pts = ($s['won'] * 3) + ($s['drawn'] * 1);
            DB::table('standings')->insert([
                'competition_id' => 6, 'team_id' => $s['team_id'],
                'played' => $s['played'], 'won' => $s['won'], 'drawn' => $s['drawn'], 'lost' => $s['lost'],
                'goals_for' => $s['goals_for'], 'goals_against' => $s['goals_against'],
                'goal_difference' => $gd, 'points' => $pts, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // ─── 10. NEWS ───
        $newsItems = [
            ['title' => 'MUK Premier League Heats Up: COCIS Leads the Table', 'body' => "COCIS Football Team continues to dominate the MUK Premier League with an impressive run of 9 wins from 12 matches. Their stellar defense has conceded only 8 goals this season.\n\nThe team, coached by Dr. Moses Ochen, has been in exceptional form since the start of the campaign. Key players include striker Joseph Mugisha who has scored 15 goals so far, and midfielder Brian Nakamya who has provided 10 assists.\n\nCOCIS head coach Dr. Ochen said: 'The boys have worked incredibly hard this season. We are taking it one match at a time and focused on maintaining our position at the top of the table.'\n\nWith 29 points from 12 matches, COCIS holds a comfortable 3-point lead over second-placed CEDAT Football. The race for the title is expected to intensify as the season progresses.", 'category' => 'Football', 'is_published' => true],
            ['title' => 'Inter-College Basketball Championship Kicks Off This Week', 'body' => "The annual inter-college basketball championship is set to begin with 8 teams competing for the coveted trophy. COCIS Hoops are the defending champions.\n\nThe tournament will feature round-robin group stages followed by knockout semifinals and a grand final scheduled for June 2026 at the Wema Basketball Court.\n\nCOCIS Hoops, led by their star center Patrick Tumwine, are the favorites to retain the title. However, CEDAT Ballers have strengthened their squad with new recruits and are expected to pose a serious challenge.\n\nCoach Sarah Nakamya of COCIS Hoops expressed confidence: 'We have been training hard and the team is ready. The players are motivated and we aim to bring the trophy back to COCIS for the second consecutive year.'\n\nAll matches will be streamed live on the MAKSPORTS platform.", 'category' => 'Basketball', 'is_published' => true],
            ['title' => 'Makerere Rugby Lions Qualify for National Rugby 7s Finals', 'body' => "The Makerere University Rugby Lions have secured their place in the national Rugby 7s finals after a stunning semi-final victory over Kyambogo University.\n\nThe Lions dominated the match with a scoreline of 35-21, showcasing their superior fitness and tactical awareness. David Okello, the team's scrum-half, was named Man of the Match for his outstanding performance.\n\nHead coach Mr. David Okello praised the team's effort: 'This is a result of months of dedicated training and teamwork. The boys gave everything on the pitch and deserved this victory.'\n\nThe final will be held at the Makerere Rugby Pitches next month, and tickets are expected to sell out quickly.", 'category' => 'Rugby', 'is_published' => true],
            ['title' => 'Netball Stars Prepare for East African University Games', 'body' => "Makerere netball teams are intensifying training ahead of the East African University Games scheduled for June 2026 in Nairobi, Kenya.\n\nFour teams from Makerere University have qualified to represent Uganda at the games: CHS Netball Stars, COCIS Net Queens, CONAS Netball, and CEDAT Netball.\n\nCoach Patience Auma, who oversees all four teams, said: 'We have been running intensive training sessions three times a week. The girls are in great shape and ready to compete against teams from Kenya, Tanzania, Rwanda, and Burundi.'\n\nThe university's Department of Sports & Recreation has provided new kits and equipment to ensure the teams are well-prepared for the regional competition.", 'category' => 'Netball', 'is_published' => true],
            ['title' => 'New Sports Equipment Arrives at Makerere Stadium', 'body' => "The Department of Sports has received new training equipment including footballs, basketballs, and volleyball nets to enhance training across all teams.\n\nThe shipment, funded by the university administration, includes:\n- 50 regulation footballs\n- 30 basketballs\n- 20 volleyballs\n- 10 rugby balls\n- Netball posts and nets\n- Training cones and bibs\n\nDirector of Sports said: 'We are committed to providing our athletes with the best resources to excel in their respective sports. This equipment will go a long way in improving the quality of our training programs.'", 'category' => 'General', 'is_published' => true],
            ['title' => 'CHSS Strikers Sign New Midfielder from Kyambogo', 'body' => "CHSS Strikers have bolstered their squad with the signing of talented midfielder Brian Ochieng from Kyambogo University ahead of the second half of the season.\n\nOchieng, a third-year student, has already made an impact in his debut appearance, scoring a crucial goal against CONAS United that helped CHSS secure a 2-1 victory.\n\nTeam manager expressed satisfaction with the signing: 'Brian brings a lot of creativity to our midfield. His vision and passing ability will be key to our push for the title.'", 'category' => 'Football', 'is_published' => true],
            ['title' => 'CEDAT Ballers Go on Unbeaten Run of 8 Matches', 'body' => "CEDAT Ballers have extended their unbeaten streak to 8 matches in the MUK Basketball Championship, cementing their position as serious title contenders.\n\nThe engineering faculty team has scored an average of 82 points per game during this run, with their defense limiting opponents to just 58 points on average.\n\nTheir next match against COCIS Hoops is expected to be a thrilling encounter that could determine the championship winner.", 'category' => 'Basketball', 'is_published' => true],
            ['title' => 'Volleyball: COCIS Spikers Dominate Ivory Park League', 'body' => "COCIS Spikers are having a remarkable season in the MUK Volleyball League, winning 7 out of their 8 matches so far.\n\nThe team's success is attributed to their strong serving and blocking, led by captain Emmanuel Ssemwanga who has been named Player of the Match in 4 games this season.\n\nCoach Grace Achieng said: 'The team chemistry is excellent. Everyone knows their role and executes it perfectly.'", 'category' => 'Volleyball', 'is_published' => true],
            ['title' => 'Athletics Team Breaks Three University Records', 'body' => "Makerere University's athletics team has broken three university records at the recent Inter-University Athletics Championship held at the Makerere Athletics Track.\n\nThe records broken include:\n- 100m Sprint: 10.2 seconds (previous record: 10.5s)\n- 400m Relay: 38.9 seconds (previous record: 39.8s)\n- Long Jump: 7.8 meters (previous record: 7.5m)\n\nThe athletes will now represent Makerere at the national university championships next month.", 'category' => 'Athletics', 'is_published' => true],
            ['title' => 'MAKSPORTS Platform Launches Live Match Coverage', 'body' => "The MAKSPORTS digital platform has launched live match coverage for all university sports events. Fans can now follow real-time scores, match events, and player statistics from their phones or computers.\n\nThe platform features:\n- Live score updates\n- Match commentary\n- Player statistics\n- League standings\n- Fixture schedules\n\nThis digital transformation is part of the university's broader initiative to modernize sports administration and engagement.", 'category' => 'Technology', 'is_published' => true],
            ['title' => 'Inter-Faculty Football Tournament Set for July', 'body' => "The annual Inter-Faculty Football Tournament will be held in July 2026 at the Makerere University Main Stadium, with 6 teams competing for the championship.\n\nThe tournament format includes a group stage followed by knockout semifinals and a grand final. All matches will be covered on the MAKSPORTS platform.\n\nParticipating teams: COCIS, CEDAT, CHUSS, CONAS, CAES, and CHS.", 'category' => 'Football', 'is_published' => true],
            ['title' => 'Makerere Sports Department Announces New Scholarship Program', 'body' => "The Department of Sports & Recreation has announced a new scholarship program for outstanding student-athletes. The program will cover tuition fees for top performers across all university sports.\n\nEligibility criteria include:\n- Minimum GPA of 3.0\n- Outstanding performance in university competitions\n- Active participation in training sessions\n- Good conduct and sportsmanship\n\nThe scholarship aims to attract and retain talented athletes while promoting academic excellence.", 'category' => 'General', 'is_published' => true],
        ];
        foreach ($newsItems as $i => $news) {
            $news['author'] = 'Sports Desk';
            $news['published_at'] = $now->copy()->subDays($i * 2);
            $news['created_at'] = $now->copy()->subDays($i * 2);
            $news['updated_at'] = $now;
            DB::table('news_updates')->insert($news);
        }

        // ─── 11. USERS ───
        $users = [
            ['name' => 'Admin', 'email' => 'admin@sports.mak.ac.ug', 'password' => Hash::make('password123'), 'role' => 'spectator', 'full_name' => 'Sports Admin', 'phone' => '+256700000001', 'email_verified_at' => now()],
            ['name' => 'John Student', 'email' => 'john@student.mak.ac.ug', 'password' => Hash::make('password123'), 'role' => 'student', 'full_name' => 'John Mugisha', 'phone' => '+256700000002', 'team_id' => 1, 'email_verified_at' => now()],
            ['name' => 'Jane Player', 'email' => 'jane@player.mak.ac.ug', 'password' => Hash::make('password123'), 'role' => 'player', 'full_name' => 'Jane Nakamya', 'phone' => '+256700000003', 'player_id' => 1, 'team_id' => 1, 'email_verified_at' => now()],
            ['name' => 'Coach Moses', 'email' => 'moses@coach.mak.ac.ug', 'password' => Hash::make('password123'), 'role' => 'coach', 'full_name' => 'Dr. Moses Ochen', 'phone' => '+256700111111', 'coach_id' => 1, 'team_id' => 1, 'email_verified_at' => now()],
            ['name' => 'Sports Fan', 'email' => 'fan@sports.mak.ac.ug', 'password' => Hash::make('password123'), 'role' => 'spectator', 'full_name' => 'Grace Achieng', 'phone' => '+256700000004', 'email_verified_at' => now()],
        ];
        foreach ($users as $user) {
            $user['created_at'] = now();
            $user['updated_at'] = now();
            DB::table('users')->insert($user);
        }

        // ─── 12. VENUE BOOKINGS ───
        $bookings = [
            ['user_id' => 1, 'venue_id' => 1, 'purpose' => 'Inter-Faculty Football Tournament', 'organizer_name' => 'Sports Admin', 'organizer_phone' => '+256700000001', 'organizer_email' => 'admin@sports.mak.ac.ug', 'expected_attendees' => 500, 'booking_date' => $now->copy()->addDays(7)->format('Y-m-d'), 'start_time' => '09:00:00', 'end_time' => '17:00:00', 'status' => 'approved', 'reference_number' => 'VB-2026-001'],
            ['user_id' => 2, 'venue_id' => 2, 'purpose' => 'Basketball Training Session', 'organizer_name' => 'John Mugisha', 'organizer_phone' => '+256700000002', 'organizer_email' => 'john@student.mak.ac.ug', 'expected_attendees' => 50, 'booking_date' => $now->copy()->addDays(3)->format('Y-m-d'), 'start_time' => '15:00:00', 'end_time' => '18:00:00', 'status' => 'pending', 'reference_number' => 'VB-2026-002'],
            ['user_id' => 3, 'venue_id' => 3, 'purpose' => 'Volleyball Practice', 'organizer_name' => 'Jane Nakamya', 'organizer_phone' => '+256700000003', 'organizer_email' => 'jane@player.mak.ac.ug', 'expected_attendees' => 30, 'booking_date' => $now->copy()->addDays(5)->format('Y-m-d'), 'start_time' => '14:00:00', 'end_time' => '16:00:00', 'status' => 'pending', 'reference_number' => 'VB-2026-003'],
        ];
        foreach ($bookings as $booking) {
            $booking['created_at'] = now();
            $booking['updated_at'] = now();
            DB::table('venue_bookings')->insert($booking);
        }

        $this->command->info('✅ Sports data seeded successfully!');
        $this->command->info('   Sports: 6');
        $this->command->info('   Venues: 6');
        $this->command->info('   Coaches: 8');
        $this->command->info('   Competitions: 6');
        $this->command->info('   Teams: 20');
        $this->command->info('   Players: ~200');
        $this->command->info('   Matches: 42 (finished, live, upcoming, cancelled)');
        $this->command->info('   Standings: 6 teams');
        $this->command->info('   News: 6 articles');
        $this->command->info('   Users: 5 (admin, student, player, coach, spectator)');
        $this->command->info('   Venue Bookings: 3');
        $this->command->info('');
        $this->command->info('🔑 Login credentials (all users use password: password123):');
        $this->command->info('   admin@sports.mak.ac.ug - Admin');
        $this->command->info('   john@student.mak.ac.ug - Student');
        $this->command->info('   jane@player.mak.ac.ug - Player');
        $this->command->info('   moses@coach.mak.ac.ug - Coach');
        $this->command->info('   fan@sports.mak.ac.ug - Fan/Spectator');
    }
}
