<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'sport_id',
        'coach_id',
        'name',
        'slug',
        'logo',
        'faculty',
        'home_venue',
        'founded_year',
        'description',
        'is_active'
    ];
    protected $casts = ['is_active' => 'boolean'];

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }
    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function homeMatches(): HasMany
    {
        return $this->hasMany(Matches::class, 'home_team_id');
    }
    public function awayMatches(): HasMany
    {
        return $this->hasMany(Matches::class, 'away_team_id');
    }
}
