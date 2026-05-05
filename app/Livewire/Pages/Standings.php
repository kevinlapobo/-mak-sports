<?php

namespace App\Livewire\Pages;

use App\Models\Competition;
use Livewire\Component;
use App\Models\Matches;
use App\Models\Sport;
use App\Models\Standing;
use Livewire\Attributes\On;

class Standings extends Component
{
    public ?int $competitionId = null;
    public string $sport       = '';

    public function mount(): void
    {
        $this->sport = request('sport', '');
        // Default to first active competition
        $first = Competition::where('is_active', true)->first();
        $this->competitionId = $first?->id;
    }

    public function selectCompetition(int $id): void
    {
        $this->competitionId = $id;
    }

    public function render()
    {
        $competitions = Competition::where('is_active', true)
            ->when(
                $this->sport,
                fn($q) =>
                $q->whereHas(
                    'sport',
                    fn($s) =>
                    $s->where('slug', $this->sport)
                )
            )
            ->with('sport')
            ->get();

        $standings = Standing::where('competition_id', $this->competitionId)
            ->with('team')
            ->orderByDesc('points')
            ->orderByDesc('goal_difference')
            ->orderByDesc('goals_for')
            ->get();

        $competition = Competition::find($this->competitionId);

        return view('livewire.pages.standings', [
            'competitions' => $competitions,
            'standings'    => $standings,
            'competition'  => $competition,
            'sports'       => Sport::where('is_active', true)
                ->orderBy('display_order')->get(),
        ])->layout('layouts.public', ['title' => 'Standings — Makerere Sports']);
    }
}
