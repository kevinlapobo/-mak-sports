<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Livewire\WithPagination;

class NotificationsPage extends Component
{
    use WithPagination;

    public string $filter = 'all';

    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function deleteNotification($notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->delete();
    }

    public function deleteAll()
    {
        auth()->user()->notifications()->delete();
    }

    public function render()
    {
        $query = auth()->user()->notifications();

        if ($this->filter === 'unread') {
            $query->whereNull('read_at');
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('livewire.notifications.notifications-page', [
            'notifications' => $notifications,
        ])->layout('layouts.public', ['title' => 'Notifications — Makerere Sports']);
    }
}
