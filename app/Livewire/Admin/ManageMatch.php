<?php

namespace App\Livewire\Admin;

use App\Models\Matches;
use App\Models\MatchEvent;
use App\Models\User;
use App\Notifications\NewResultNotification;
use Livewire\Component;

class ManageMatch extends Component
{
    public $match;
    public $home_score = 0;
    public $away_score = 0;
    public $match_notes = '';

    public $event_type = 'goal';
    public $event_player = '';
    public $event_minute = '';
    public $event_team = 'home';

    public function mount($id)
    {
        if (auth()->user()->role !== 'admin') {
            redirect('/')->with('error', 'Access denied.');
        }

        $this->match = Matches::with(['homeTeam', 'awayTeam', 'venue', 'competition.sport', 'events.team', 'events.player'])
            ->findOrFail($id);

        $this->home_score = $this->match->home_score ?? 0;
        $this->away_score = $this->match->away_score ?? 0;
        $this->match_notes = $this->match->match_notes ?? '';
    }

    public function addEvent()
    {
        $this->validate([
            'event_type' => 'required|in:goal,yellow_card,red_card,substitution,own_goal',
            'event_player' => 'required|string|max:100',
            'event_minute' => 'required|integer|min:0|max:120',
            'event_team' => 'required|in:home,away',
        ]);

        $teamId = $this->event_team === 'home'
            ? $this->match->home_team_id
            : $this->match->away_team_id;

        MatchEvent::create([
            'match_id' => $this->match->id,
            'team_id' => $teamId,
            'event_type' => $this->event_type,
            'minute' => $this->event_minute,
            'description' => $this->event_player,
        ]);

        $this->reset(['event_type', 'event_player', 'event_minute', 'event_team']);
        $this->match->load('events.team');
        session()->flash('event_success', 'Event added.');
    }

    public function removeEvent($eventId)
    {
        MatchEvent::where('match_id', $this->match->id)->where('id', $eventId)->delete();
        $this->match->load('events.team');
    }

    public function approve()
    {
        $this->validate([
            'home_score' => 'required|integer|min:0|max:99',
            'away_score' => 'required|integer|min:0|max:99',
        ]);

        $this->match->update([
            'home_score' => $this->home_score,
            'away_score' => $this->away_score,
            'status' => 'finished',
            'match_notes' => $this->match_notes,
        ]);

        User::whereIn('role', ['student', 'player', 'coach', 'admin', 'facility_manager'])
            ->where('status', 'approved')
            ->chunk(100, function ($users) {
                foreach ($users as $user) {
                    $user->notify(new NewResultNotification($this->match));
                }
            });

        session()->flash('success', "Result approved: {$this->match->homeTeam->name} {$this->home_score} - {$this->away_score} {$this->match->awayTeam->name}");
    }

    public function reject()
    {
        $this->match->update([
            'status' => 'cancelled',
            'home_score' => null,
            'away_score' => null,
            'match_notes' => $this->match_notes ?: 'Match cancelled',
        ]);

        session()->flash('success', 'Match has been cancelled.');
    }

    public function render()
    {
        return view('livewire.admin.manage-match', [
            'matchEvents' => $this->match->events()->with('team')->orderBy('minute')->get(),
        ])->layout('layouts.public', ['title' => 'Manage Match']);
    }
}
