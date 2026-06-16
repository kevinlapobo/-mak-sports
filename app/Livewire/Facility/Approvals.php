<?php

namespace App\Livewire\Facility;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Approvals extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';
    public string $statusFilter = 'pending';

    public function approve($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => 'approved']);
        session()->flash('success', "{$user->name} approved as {$user->role}.");
    }

    public function reject($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => 'rejected']);
        session()->flash('success', "{$user->name} rejected.");
    }

    public function render()
    {
        $query = User::query()->whereIn('role', ['player', 'coach']);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }
        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('livewire.facility.approvals', [
            'users' => $users,
        ])->layout('layouts.public', ['title' => 'Pending Approvals']);
    }
}
