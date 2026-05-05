<?php

namespace App\Livewire\Coach;

use App\Models\User;
use App\Models\Coach;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public User $user;
    public string $full_name = '';
    public string $phone = '';
    public string $email = '';
    public ?string $specialization = '';
    public ?string $experience_years = '';
    public ?string $qualification = '';

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->full_name = $this->user->full_name ?? '';
        $this->phone = $this->user->phone ?? '';
        $this->email = $this->user->email;

        $coach = Coach::where('id', $this->user->coach_id)->first();
        if ($coach) {
            $this->specialization = $coach->specialization ?? '';
            $this->experience_years = $coach->experience_years ?? '';
            $this->qualification = $coach->qualification ?? '';
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'qualification' => 'nullable|string',
        ]);

        $this->user->update([
            'full_name' => $this->full_name,
            'phone' => $this->phone,
        ]);

        if ($this->user->coach_id) {
            $coach = Coach::where('id', $this->user->coach_id)->first();
            $coach->fill([
                'specialization' => $this->specialization,
                'experience_years' => $this->experience_years,
                'qualification' => $this->qualification,
            ])->save();
        } else {
            $coach = Coach::create([
                'name' => $this->full_name,
                'specialization' => $this->specialization,
                'experience_years' => $this->experience_years,
                'qualification' => $this->qualification,
            ]);
            $this->user->coach_id = $coach->id;
            $this->user->save();
        }

        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.coach.profile')->layout('layouts.public', ['title' => 'Coach Profile']);
    }
}
