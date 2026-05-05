<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Matches;
use App\Models\Sport;
use App\Models\Team;
use Livewire\Attributes\On;

class Teams extends Component
{
    public string $sport  = '';
    public string $search = '';

    public function mount(): void
    {
        $this->sport = request('sport', '');
    }

    public function render()
    {
        $query = Team::with(['sport', 'coach'])
            ->withCount('players')
            ->where('is_active', true);

        if ($this->sport) {
            $query->whereHas(
                'sport',
                fn($q) =>
                $q->where('slug', $this->sport)
            );
        }

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        return view('livewire.pages.teams', [
            'teams'  => $query->orderBy('name')->get(),
            'sports' => Sport::where('is_active', true)
                ->orderBy('display_order')->get(),
        ])->layout('layouts.public', ['title' => 'Teams — Makerere Sports']);
    }
}
