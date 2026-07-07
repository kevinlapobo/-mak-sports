<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AccountApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(public User $user)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'account_approved',
            'title' => 'Account Approved',
            'message' => "Your account has been approved. You are now registered as a {$this->user->role}.",
            'role' => $this->user->role,
        ];
    }
}
