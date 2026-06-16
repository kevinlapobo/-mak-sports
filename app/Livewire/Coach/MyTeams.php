<?php

namespace App\Livewire\Coach;

use App\Models\Team;
use App\Models\Sport;
use App\Models\Coach;
use App\Models\Player;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MyTeams extends Component
{
    public $name = '';
    public $sport_id = '';
    public $home_venue = '';
    public $showForm = false;
    public $selectedTeam = null;
    public $playerNames = ['', '', '', '', '', '', '', '', '', '', '', '', ''];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:teams,name',
            'sport_id' => 'required|exists:sports,id',
            'home_venue' => 'nullable|string|max:255',
            'playerNames' => 'required|array|min:13',
            'playerNames.*' => 'required|string|max:255',
        ];
    }

    public function addPlayerInput()
    {
        $this->playerNames[] = '';
    }

    public function removePlayerInput($index)
    {
        unset($this->playerNames[$index]);
        $this->playerNames = array_values($this->playerNames);
    }

    public function createTeam()
    {
        $user = Auth::user();

        if ($user->status !== 'approved') {
            session()->flash('error', 'Your account must be approved before you can register a team. Please wait for facility manager approval.');
            return;
        }

        $this->validate();

        $coach = Coach::where('id', $user->coach_id)->first();

        if (!$coach) {
            session()->flash('error', 'Please set up your coach profile first before registering a team.');
            $this->redirectRoute('coach.profile');
            return;
        }

        $team = Team::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name) . '-' . Str::random(4),
            'sport_id' => $this->sport_id,
            'coach_id' => $coach->id,
            'home_venue' => $this->home_venue,
            'is_active' => true,
        ]);

        foreach ($this->playerNames as $playerName) {
            if (trim($playerName)) {
                Player::create([
                    'team_id' => $team->id,
                    'name' => trim($playerName),
                    'is_active' => true,
                ]);
            }
        }

        $this->reset(['name', 'sport_id', 'home_venue', 'showForm', 'playerNames']);
        $this->playerNames = ['', '', '', '', '', '', '', '', '', '', '', '', ''];
        session()->flash('success', 'Team "' . $this->name . '" registered successfully!');
    }

    public function viewTeam($teamId)
    {
        $user = Auth::user();
        $coach = Coach::where('id', $user->coach_id)->first();

        $team = Team::with(['sport', 'players'])->findOrFail($teamId);

        if (!$coach || $team->coach_id !== $coach->id) {
            session()->flash('error', 'You can only view details of teams you registered.');
            $this->selectedTeam = null;
            return;
        }

        $this->selectedTeam = $team;
    }

    public function closeDetails()
    {
        $this->selectedTeam = null;
    }

    public function render()
    {
        $user = Auth::user();
        $coach = Coach::where('id', $user->coach_id)->first();

        $myTeams = $coach ? Team::where('coach_id', $coach->id)->with('sport')->get() : collect();
        $allTeams = Team::with('sport')->orderBy('name')->get();
        $sports = Sport::orderBy('name')->get();

        return view('livewire.coach.my-teams', [
            'myTeams' => $myTeams,
            'allTeams' => $allTeams,
            'sports' => $sports,
            'coach' => $coach,
        ])->layout('layouts.public', ['title' => 'My Teams']);
    }
}
