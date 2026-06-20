<?php

namespace App\Livewire\Admin;

use App\Models\Matches;
use App\Models\Team;
use App\Models\Venue;
use App\Models\Competition;
use App\Models\User;
use App\Notifications\NewFixtureNotification;
use Livewire\Component;
use Livewire\WithPagination;

class ManageFixtures extends Component
{
    use WithPagination;

    public $competition_id = '';
    public $home_team_id = '';
    public $away_team_id = '';
    public $venue_id = '';
    public $match_date = '';
    public $match_time = '';
    public $match_notes = '';
    public $editId = null;

    public function mount()
    {
        if (!in_array(auth()->user()->role, ['admin', 'facility_manager'])) {
            redirect('/')->with('error', 'Access denied.');
        }
        $this->match_date = today()->format('Y-m-d');
        $this->match_time = '16:00';
    }

    public function createFixture()
    {
        $this->validate([
            'competition_id' => 'required|exists:competitions,id',
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'venue_id' => 'required|exists:venues,id',
            'match_date' => 'required|date|after_or_equal:today',
            'match_time' => 'required',
            'match_notes' => 'nullable|string|max:500',
        ], [
            'home_team_id.different' => 'Home and away teams must be different.',
            'away_team_id.different' => 'Home and away teams must be different.',
        ]);

        $datetime = "{$this->match_date} {$this->match_time}:00";

        $conflict = Matches::where('venue_id', $this->venue_id)
            ->where('match_date', $datetime)
            ->whereIn('status', ['scheduled', 'live'])
            ->exists();

        if ($conflict) {
            session()->flash('error', 'This venue already has a fixture scheduled at this date and time.');
            return;
        }

        $match = Matches::create([
            'competition_id' => $this->competition_id,
            'home_team_id' => $this->home_team_id,
            'away_team_id' => $this->away_team_id,
            'venue_id' => $this->venue_id,
            'match_date' => $datetime,
            'status' => 'scheduled',
            'match_notes' => $this->match_notes,
        ]);

        User::whereIn('role', ['student', 'player', 'coach', 'admin', 'facility_manager'])
            ->where('status', 'approved')
            ->chunk(100, function ($users) use ($match) {
                foreach ($users as $user) {
                    $user->notify(new NewFixtureNotification($match));
                }
            });

        session()->flash('success', 'Fixture created successfully. All users notified.');
        $this->reset(['home_team_id', 'away_team_id', 'venue_id', 'match_notes']);
    }

    public function deleteFixture($id)
    {
        $match = Matches::findOrFail($id);
        if ($match->status === 'finished') {
            session()->flash('error', 'Cannot delete a finished match.');
            return;
        }
        $match->delete();
        session()->flash('success', 'Fixture deleted.');
    }

    public function render()
    {
        return view('livewire.admin.manage-fixtures', [
            'fixtures' => Matches::with(['homeTeam', 'awayTeam', 'venue', 'competition.sport'])
                ->orderBy('match_date', 'desc')
                ->paginate(15),
            'teams' => Team::where('is_active', true)->orderBy('name')->get(),
            'venues' => Venue::orderBy('name')->get(),
            'competitions' => Competition::where('is_active', true)->with('sport')->orderBy('name')->get(),
        ])->layout('layouts.public', ['title' => 'Manage Fixtures']);
    }
}
