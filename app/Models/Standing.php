<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Standing extends Model
{
    use HasFactory;
    protected $fillable = [
        'competition_id',
        'team_id',
        'played',
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
        'goal_difference',
        'points'
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    // Auto-calculate goal difference before saving

    protected static function booted(): void
    {
        static::saving(function (Standing $s) {
            $s->goal_difference = $s->goals_for - $s->goals_against;
            $s->points = ($s->won * 3) + $s->drawn;
        });
    }
}
