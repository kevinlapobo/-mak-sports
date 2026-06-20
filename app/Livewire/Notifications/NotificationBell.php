<?php

namespace App\Livewire\Notifications;

use Livewire\Component;

class NotificationBell extends Component
{
    protected $listeners = ['$refresh'];

    public function getUnreadCount(): int
    {
        if (!auth()->check()) {
            return 0;
        }
        return auth()->user()->unreadNotifications()->count();
    }

    public function markAllRead()
    {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
        }
    }

    public function render()
    {
        return view('livewire.notifications.notification-bell', [
            'count' => $this->getUnreadCount(),
        ]);
    }
}
