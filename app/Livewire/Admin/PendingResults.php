<?php

namespace App\Livewire\Admin;

use App\Models\Matches;
use Livewire\Component;
use Livewire\WithPagination;

class PendingResults extends Component
{
    use WithPagination;

    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            redirect('/')->with('error', 'Access denied. Only admins can view pending results.');
        }
    }

    public string $sportFilter = '';

    public function render()
    {
        $query = Matches::with(['homeTeam', 'awayTeam', 'venue', 'competition.sport'])
            ->where('status', 'scheduled')
            ->where('match_date', '<', now())
            ->orderBy('match_date', 'desc');

        if ($this->sportFilter) {
            $query->whereHas('competition.sport', fn($q) => $q->where('slug', $this->sportFilter));
        }

        return view('livewire.admin.pending-results', [
            'fixtures' => $query->paginate(20),
            'sports' => \App\Models\Sport::where('is_active', true)->orderBy('name')->get(),
        ])->layout('layouts.public', ['title' => 'Pending Results']);
    }
}
