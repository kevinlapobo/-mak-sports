<?php

namespace App\Livewire\Player;

use App\Models\User;
use App\Models\Player;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Profile extends Component
{
    use WithFileUploads;

    public User $user;
    public string $full_name = '';
    public string $phone = '';
    public string $email = '';
    public ?string $position = '';
    public ?string $jersey_number = '';
    public ?string $faculty = '';
    public $newPhoto = null;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->full_name = $this->user->full_name ?? '';
        $this->phone = $this->user->phone ?? '';
        $this->email = $this->user->email;

        $player = Player::where('id', $this->user->player_id)->first();
        if ($player) {
            $this->position = $player->position ?? '';
            $this->jersey_number = $player->jersey_number ?? '';
            $this->faculty = $player->faculty ?? '';
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'jersey_number' => 'nullable|integer|min:0|max:99',
            'faculty' => 'nullable|string|max:255',
            'newPhoto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'full_name' => $this->full_name,
            'phone' => $this->phone,
        ];

        if ($this->newPhoto) {
            //delete old photo
            if ($this->user->photo) {
                Storage::disk('public')->delete($this->user->photo);
            }
            $data['photo'] = $this->newPhoto->store('photos', 'public');
        }

        $this->user->update($data);

        if ($this->user->player_id) {
            $player = Player::where('id', $this->user->player_id)->first();
            $player->fill([
                'position' => $this->position,
                'jersey_number' => $this->jersey_number,
                'faculty' => $this->faculty,
            ])->save();
        }

        $this->newPhoto = null;
        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.player.profile')->layout('layouts.public', ['title' => 'Player Profile']);
    }
}
