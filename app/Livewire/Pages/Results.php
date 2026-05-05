<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Matches;
use App\Models\Sport;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Results extends Component
{
    use WithPagination;

    public string $sport = '';
    public string $search = '';

    public function mount(): void
    {
        $this->sport = request('sport', '');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Matches::with(['homeTeam', 'awayTeam', 'competition'])
            ->where('status', 'finished')
            ->orderByDesc('match_date');

        if ($this->sport) {
            $query->whereHas(
                'competition.sport',
                fn($q) =>
                $q->where('slug', $this->sport)
            );
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas(
                    'homeTeam',
                    fn($t) =>
                    $t->where('name', 'like', "%{$this->search}%")
                )->orWhereHas(
                    'awayTeam',
                    fn($t) =>
                    $t->where('name', 'like', "%{$this->search}%")
                );
            });
        }

        return view('livewire.pages.results', [
            'results' => $query->paginate(15),
            'sports'  => Sport::where('is_active', true)
                ->orderBy('display_order')->get(),
        ])->layout('layouts.public', ['title' => 'Results — Makerere Sports']);
    }
}
