<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Matches;
use App\Models\Sport;
use Livewire\Attributes\On;

class Fixtures extends Component
{
    public string $sport     = '';
    public string $dateRange = 'upcoming';

    public function mount(): void
    {
        $this->sport = request('sport', '');
    }

    public function render()
    {
        $query = Matches::with(['homeTeam', 'awayTeam', 'competition', 'venue'])
            ->where('status', 'scheduled')
            ->orderBy('match_date');

        if ($this->sport) {
            $query->whereHas(
                'competition.sport',
                fn($q) =>
                $q->where('slug', $this->sport)
            );
        }

        if ($this->dateRange === 'today') {
            $query->whereDate('match_date', today());
        } elseif ($this->dateRange === 'this_week') {
            $query->whereBetween('match_date', [now(), now()->endOfWeek()]);
        } else {
            $query->where('match_date', '>=', now());
        }

        // Group fixtures by date
        $fixtures = $query->get()->groupBy(
            fn($m) =>
            $m->match_date->format('Y-m-d')
        );

        return view('livewire.pages.fixtures', [
            'fixtures' => $fixtures,
            'sports'   => Sport::where('is_active', true)
                ->orderBy('display_order')->get(),
        ])->layout('layouts.public', ['title' => 'Fixtures — Makerere Sports']);
    }
}
