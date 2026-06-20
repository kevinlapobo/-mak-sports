<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Venue;

class Contacts extends Component
{
    public function render()
    {
        return view('livewire.pages.contacts', [
            'venues' => Venue::orderBy('name')->get(),
        ])->layout('layouts.public', ['title' => 'Contact Us — Makerere Sports']);
    }
}
