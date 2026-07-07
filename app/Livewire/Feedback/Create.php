<?php

namespace App\Livewire\Feedback;

use App\Models\Feedback;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public string $message = '';
    public string $type = 'general';

    public function submit()
    {
        $this->validate([
            'message' => 'required|string|min:10|max:2000',
            'type' => 'required|in:general,suggestion,bug_report',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'message' => $this->message,
            'type' => $this->type,
        ]);

        session()->flash('feedback_sent', true);
        $this->reset(['message', 'type']);
    }

    public function render()
    {
        return view('livewire.feedback.create')
            ->layout('layouts.public', ['title' => 'Submit Feedback']);
    }
}
