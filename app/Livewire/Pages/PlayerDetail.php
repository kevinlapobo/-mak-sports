<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Matches;
use App\Models\Player;
use Livewire\Attributes\On;

class PlayerDetail extends Component
{
    public Player $player;

    public function mount(int $id): void
    {
        $this->player = Player::with(['team.sport'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.pages.player-detail')
            ->layout('layouts.public', [
                'title' => $this->player->name . ' — Makerere Sports'
            ]);
    }
}
