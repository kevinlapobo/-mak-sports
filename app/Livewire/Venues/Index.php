<?php

namespace App\Livewire\Venues;

use App\Models\Venue;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.venues.index', [
            'Venues' => Venue::orderBy('name')->get(),
        ])->layout('layouts.public', ['title' => 'Browse Venues']);
    }
}
