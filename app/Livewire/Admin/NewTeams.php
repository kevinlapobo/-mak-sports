<?php

namespace App\Livewire\Admin;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;

class NewTeams extends Component
{
    use WithPagination;

    public $search = '';

    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            redirect('/')->with('error', 'Access denied.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Team::with(['sport', 'coach'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        return view('livewire.admin.new-teams', [
            'teams' => $query->paginate(20),
        ])->layout('layouts.public', ['title' => 'New Teams']);
    }
}
