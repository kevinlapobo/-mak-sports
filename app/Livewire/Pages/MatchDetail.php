<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Matches;
use Livewire\Attributes\On;

class MatchDetail extends Component
{
    public Matches $match;

    public function mount(int $id): void
    {
        $this->match = Matches::with([
            'homeTeam.players',
            'awayTeam.players',
            'competition',
            'venue',
            'events.player',
            'events.team',
        ])->findOrFail($id);
    }

    #[On('refresh')]
    public function refresh(): void
    {
        $this->match->refresh();
        $this->match->load(['events.player', 'events.team']);
    }

    public function render()
    {
        return view('livewire.pages.match-detail')
            ->layout('layouts.public', [
                'title' => $this->match->homeTeam->name
                    . ' vs ' . $this->match->awayTeam->name
                    . ' — Makerere Sports'
            ]);
    }
}
