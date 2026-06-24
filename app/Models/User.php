<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'role', 'full_name', 'phone', 'player_id', 'coach_id', 'team_id', 'google_id', 'student_number', 'photo', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['admin', 'facility_manager']);
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isPlayer(): bool
    {
        return $this->role === 'player';
    }

    public function isCoach(): bool
    {
        return $this->role === 'coach';
    }

    public function isSpectator(): bool
    {
        return $this->role === 'spectator';
    }

    public function isFacilityManager(): bool
    {
        return $this->role === 'facility_manager';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class, 'coach_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
