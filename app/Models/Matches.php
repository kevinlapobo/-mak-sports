<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matches extends Model
{
    use HasFactory;
    protected $table = 'matches';
    protected $fillable = [
        'competition_id',
        'home_team_id',
        'away_team_id',
        'venue_id',
        'home_score',
        'away_score',
        'status',
        'match_date',
        'minute',
        'is_featured',
        'match_notes'
    ];
    protected $casts = [
        'match_date'  => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
    public function events(): HasMany
    {
        return $this->hasMany(MatchEvent::class, 'match_id');
    }

    public function isLive(): bool
    {
        return $this->status === 'live';
    }
    public function isFinished(): bool
    {
        return $this->status === 'finished';
    }
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    public static function checkAndUpdateStatuses(): void
    {
        $now = now();

        // Set scheduled fixtures that have reached their match time to live
        self::where('status', 'scheduled')
            ->where('match_date', '<=', $now)
            ->update(['status' => 'live']);
    }
}
