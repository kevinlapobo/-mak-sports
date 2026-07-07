<?php

namespace App\Livewire\Feedback;

use App\Models\Feedback;
use Livewire\Component;
use Livewire\WithPagination;

class ManageFeedback extends Component
{
    use WithPagination;

    public string $filter = '';

    public function mount(): void
    {
        if (!in_array(auth()->user()->role, ['admin', 'facility_manager'])) {
            abort(403);
        }
    }

    public function markAsRead(int $id): void
    {
        $fb = Feedback::findOrFail($id);
        $fb->update(['is_read' => true]);
    }

    public function markAllRead(): void
    {
        Feedback::where('is_read', false)->update(['is_read' => true]);
    }

    public function render()
    {
        $query = Feedback::with('user');

        if ($this->filter === 'unread') {
            $query->where('is_read', false);
        }

        $feedbacks = $query->latest()->paginate(20);
        $unreadCount = Feedback::where('is_read', false)->count();

        return view('livewire.feedback.manage-feedback', [
            'feedbacks' => $feedbacks,
            'unreadCount' => $unreadCount,
        ])->layout('layouts.public', ['title' => 'User Feedback']);
    }
}
