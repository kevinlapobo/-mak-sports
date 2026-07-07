<?php

namespace App\Console\Commands;

use App\Models\Competition;
use App\Models\Matches;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Console\Command;

class GenerateFixtures extends Command
{
    protected $signature = 'fixtures:generate {competition? : The ID of the competition}';
    protected $description = 'Generate round-robin fixtures for a competition';

    public function handle(): int
    {
        $competitionId = $this->argument('competition');

        $query = Competition::where('is_active', true);
        if ($competitionId) {
            $query->where('id', $competitionId);
        }

        $competitions = $query->get();

        if ($competitions->isEmpty()) {
            $this->error('No active competitions found.');
            return 1;
        }

        $venues = Venue::all();
        if ($venues->isEmpty()) {
            $this->error('No venues found. Please add venues first.');
            return 1;
        }

        foreach ($competitions as $competition) {
            $this->generateForCompetition($competition, $venues);
        }

        $this->info('Fixtures generated successfully!');
        return 0;
    }

    protected function generateForCompetition(Competition $competition, iterable $venues): void
    {
        $teams = Team::where('sport_id', $competition->sport_id)
            ->where('is_active', true)
            ->get();

        if ($teams->count() < 2) {
            $this->warn("Competition '{$competition->name}' has fewer than 2 teams. Skipping.");
            return;
        }

        $existingCount = Matches::where('competition_id', $competition->id)->count();
        if ($existingCount > 0) {
            $this->warn("Competition '{$competition->name}' already has {$existingCount} fixtures. Skipping.");
            return;
        }

        $teamIds = $teams->pluck('id')->toArray();
        $rounds = $this->generateRoundRobin($teamIds);

        $startDate = $competition->start_date ? $competition->start_date->copy()->addDay() : now()->addDay();
        $matchDay = 0;
        $created = 0;

        foreach ($rounds as $round) {
            foreach ($round as $matchup) {
                [$homeId, $awayId] = $matchup;
                $matchDate = $startDate->copy()->addDays($matchDay * 3);

                if ($competition->end_date && $matchDate->gt($competition->end_date)) {
                    break 2;
                }

                $venue = $venues->random();

                Matches::create([
                    'competition_id' => $competition->id,
                    'home_team_id' => $homeId,
                    'away_team_id' => $awayId,
                    'venue_id' => $venue->id,
                    'match_date' => $matchDate->format('Y-m-d H:i:s'),
                    'status' => 'scheduled',
                ]);

                $created++;
            }
            $matchDay++;
        }

        $this->info("Created {$created} fixtures for '{$competition->name}'");
    }

    protected function generateRoundRobin(array $teams): array
    {
        if (count($teams) % 2 !== 0) {
            $teams[] = 0;
        }

        $totalRounds = count($teams) - 1;
        $matchesPerRound = count($teams) / 2;
        $rounds = [];

        for ($round = 0; $round < $totalRounds; $round++) {
            $roundMatchups = [];
            for ($match = 0; $match < $matchesPerRound; $match++) {
                $home = $teams[$match];
                $away = $teams[count($teams) - 1 - $match];

                if ($home !== 0 && $away !== 0) {
                    $roundMatchups[] = [$home, $away];
                }
            }
            $rounds[] = $roundMatchups;

            $last = array_pop($teams);
            array_splice($teams, 1, 0, [$last]);
        }

        $secondHalf = [];
        foreach ($rounds as $round) {
            $reverseRound = [];
            foreach ($round as $matchup) {
                $reverseRound[] = [$matchup[1], $matchup[0]];
            }
            $secondHalf[] = $reverseRound;
        }

        return array_merge($rounds, $secondHalf);
    }
}
