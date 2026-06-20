<?php

namespace App\Notifications;

use App\Models\Matches;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewResultNotification extends Notification
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
            'type' => 'new_result',
            'title' => 'Result Posted',
            'message' => "{$this->match->homeTeam->name} {$this->match->home_score} - {$this->match->away_score} {$this->match->awayTeam->name}",
            'match_id' => $this->match->id,
            'competition' => $this->match->competition?->name,
            'home_score' => $this->match->home_score,
            'away_score' => $this->match->away_score,
        ];
    }
}
