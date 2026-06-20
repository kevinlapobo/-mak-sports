<?php

namespace App\Livewire\Admin;

use App\Models\Matches;
use App\Models\User;
use App\Notifications\NewResultNotification;
use Livewire\Component;
use Livewire\WithPagination;

class AddResults extends Component
{
    use WithPagination;

    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            redirect('/')->with('error', 'Access denied. Only admins can add results.');
        }
    }

    public $home_score = 0;
    public $away_score = 0;
    public $matchNotes = '';

    public function addResult($matchId)
    {
        $this->validate([
            'home_score' => 'required|integer|min:0|max:99',
            'away_score' => 'required|integer|min:0|max:99',
        ]);

        $match = Matches::findOrFail($matchId);

        if ($match->status === 'finished') {
            session()->flash('error', 'Result already posted for this match.');
            return;
        }

        $match->update([
            'home_score' => $this->home_score,
            'away_score' => $this->away_score,
            'status' => 'finished',
            'match_notes' => $this->matchNotes ?: $match->match_notes,
        ]);

        User::whereIn('role', ['student', 'player', 'coach', 'admin', 'facility_manager'])
            ->where('status', 'approved')
            ->chunk(100, function ($users) use ($match) {
                foreach ($users as $user) {
                    $user->notify(new NewResultNotification($match));
                }
            });

        session()->flash('success', "Result posted: {$match->homeTeam->name} {$this->home_score} - {$this->away_score} {$match->awayTeam->name}. All users notified.");
        $this->reset(['home_score', 'away_score', 'matchNotes']);
    }

    public function render()
    {
        return view('livewire.admin.add-results', [
            'matches' => Matches::with(['homeTeam', 'awayTeam', 'venue', 'competition.sport'])
                ->where('status', 'scheduled')
                ->where('match_date', '<=', now()->addHours(2))
                ->orderBy('match_date', 'asc')
                ->paginate(15),
        ])->layout('layouts.public', ['title' => 'Add Results']);
    }
}
