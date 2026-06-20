<?php

namespace App\Notifications;

use App\Models\Matches;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewFixtureNotification extends Notification
{
    use Queueable;

    public function __construct(public Matches $match)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'new_fixture',
            'title' => 'New Fixture Added',
            'message' => "{$this->match->homeTeam->name} vs {$this->match->awayTeam->name} on {$this->match->match_date->format('d M Y, H:i')}",
            'match_id' => $this->match->id,
            'competition' => $this->match->competition?->name,
            'match_date' => $this->match->match_date->toISOString(),
        ];
    }
}
