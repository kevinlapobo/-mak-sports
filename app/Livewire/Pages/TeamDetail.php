<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Matches;
use App\Models\Team;
use Livewire\Attributes\On;

class TeamDetail extends Component
{
    public Team $team;

    public function mount(string $slug): void
    {
        $this->team = Team::with(['sport', 'coach', 'players'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render()
    {
        // Recent matches (last 5)
        $recentMatches = Matches::with(['homeTeam', 'awayTeam', 'competition'])
            ->where(
                fn($q) =>
                $q->where('home_team_id', $this->team->id)
                    ->orWhere('away_team_id', $this->team->id)
            )
            ->where('status', 'finished')
            ->orderByDesc('match_date')
            ->take(5)
            ->get();

        // Upcoming matches (next 5)
        $upcomingMatches = Matches::with(['homeTeam', 'awayTeam', 'competition', 'venue'])
            ->where(
                fn($q) =>
                $q->where('home_team_id', $this->team->id)
                    ->orWhere('away_team_id', $this->team->id)
            )
            ->where('status', 'scheduled')
            ->orderBy('match_date')
            ->take(5)
            ->get();

        // Team stats
        $totalMatches = Matches::where(
            fn($q) =>
            $q->where('home_team_id', $this->team->id)
                ->orWhere('away_team_id', $this->team->id)
        )->where('status', 'finished')->count();

        $wins = Matches::where(
            fn($q) =>
            $q->where(
                fn($w) =>
                $w->where('home_team_id', $this->team->id)
                    ->whereRaw('home_score > away_score')
            )->orWhere(
                fn($w) =>
                $w->where('away_team_id', $this->team->id)
                    ->whereRaw('away_score > home_score')
            )
        )->where('status', 'finished')->count();

        return view('livewire.pages.team-detail', [
            'recentMatches'  => $recentMatches,
            'upcomingMatches' => $upcomingMatches,
            'totalMatches'   => $totalMatches,
            'wins'           => $wins,
        ])->layout('layouts.public', [
            'title' => $this->team->name . ' — Makerere Sports'
        ]);
    }
}
