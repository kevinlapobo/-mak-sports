<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Matches;
use Livewire\Attributes\On;

class LiveScores extends Component
{
    // Livewire listens for refresh event every 5 seconds
    #[On('refresh')]
    public function refresh(): void
    {
        // Just re-render — Livewire handles the rest
    }

    public function render()
    {
        $liveMatches = Matches::with([
            'homeTeam',
            'awayTeam',
            'competition',
            'events.player'
        ])
            ->where('status', 'live')
            ->orderByDesc('updated_at')
            ->get();

        $upcomingToday = Matches::with(['homeTeam', 'awayTeam', 'competition', 'venue'])
            ->whereDate('match_date', today())
            ->where('status', 'scheduled')
            ->orderBy('match_date')
            ->get();

        return view('livewire.pages.live-scores', [
            'liveMatches'   => $liveMatches,
            'upcomingToday' => $upcomingToday,
            'lastRefreshed' => now()->format('H:i:s'),
        ])->layout('layouts.public', ['title' => 'Live Scores — Makerere Sports']);
    }
}
