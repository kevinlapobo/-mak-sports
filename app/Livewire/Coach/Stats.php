<?php

namespace App\Livewire\Coach;

use App\Models\Team;
use App\Models\Coach;
use App\Models\Matches;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Stats extends Component
{
    public ?Coach $coach = null;
    public $teams = [];
    public array $stats = [];

    public function mount(): void
    {
        $user = Auth::user();
        $this->coach = Coach::where('id', $user->coach_id)->first();

        if ($this->coach) {
            $this->teams = Team::where('coach_id', $this->coach->id)->get();

            $stats = [
                'total_teams' => $this->teams->count(),
                'total_matches' => 0,
                'wins' => 0,
                'draws' => 0,
                'losses' => 0,
                'win_rate' => 0,
            ];

            foreach ($this->teams as $team) {
                $homeMatches = Matches::where('home_team_id', $team->id)->where('status', 'finished')->get();
                $awayMatches = Matches::where('away_team_id', $team->id)->where('status', 'finished')->get();

                foreach ($homeMatches as $match) {
                    $stats['total_matches']++;
                    if ($match->home_score > $match->away_score) $stats['wins']++;
                    elseif ($match->home_score == $match->away_score) $stats['draws']++;
                    else $stats['losses']++;
                }

                foreach ($awayMatches as $match) {
                    $stats['total_matches']++;
                    if ($match->away_score > $match->home_score) $stats['wins']++;
                    elseif ($match->away_score == $match->home_score) $stats['draws']++;
                    else $stats['losses']++;
                }
            }

            if ($stats['total_matches'] > 0) {
                $stats['win_rate'] = round(($stats['wins'] / $stats['total_matches']) * 100, 1);
            }

            $this->stats = $stats;
        }
    }

    public function render()
    {
        return view('livewire.coach.stats')->layout('layouts.public', ['title' => 'Coach Stats']);
    }
}
