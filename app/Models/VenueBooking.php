<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VenueBooking extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PENDING_APPROVAL = 'pending_approval';
    public const STATUS_PENDING_SIGNATURE = 'pending_signature';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_COMPLETED = 'completed';

    protected $fillable = [
        'user_id',
        'venue_id',
        'purpose',
        'description',
        'organizer_name',
        'organizer_phone',
        'organizer_email',
        'expected_attendees',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'reference_number',
    ];

    protected $casts = [
        'booking_date' => 'date:Y-m-d',
        'approved_at'  => 'datetime',
        'start_time'   => 'string',
        'end_time'     => 'string',
    ];

    // Auto-generate reference on create
    protected static function booted(): void
    {
        static::creating(function (VenueBooking $booking) {
            $booking->reference_number = 'VB-' . date('Y') . '-' . str_pad(
                static::count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );
        });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Check if this booking conflicts with another
    public static function hasConflict(
        int $venueId,
        string $date,
        string $startTime,
        string $endTime,
        ?int $excludeId = null
    ): bool {
        return static::where('venue_id', $venueId)
            ->where('booking_date', $date)
            ->whereNotIn('status', [self::STATUS_REJECTED, self::STATUS_COMPLETED])
            ->where('id', '!=', $excludeId)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where(function ($inner) use ($startTime, $endTime) {
                    $inner->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            })
            ->exists();
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isPendingApproval(): bool
    {
        return $this->status === self::STATUS_PENDING_APPROVAL;
    }

    public function isPendingSignature(): bool
    {
        return $this->status === self::STATUS_PENDING_SIGNATURE;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function getDurationAttribute(): string
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        $diff = $start->diff($end);

        $hours = $diff->h + ($diff->days * 24);
        $mins = $diff->i;

        if ($hours > 0 && $mins > 0) {
            return "{$hours}h {$mins}min";
        }
        if ($hours > 0) {
            return "{$hours}h";
        }
        if ($mins > 0) {
            return "{$mins}min";
        }
        return '0min';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', [
                self::STATUS_PENDING_APPROVAL,
                self::STATUS_PENDING_SIGNATURE,
                self::STATUS_APPROVED,
            ])
            ->where('booking_date', '>=', now()->format('Y-m-d'));
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('booking_date', '<', now()->format('Y-m-d'))
            ->whereIn('status', [
                self::STATUS_PENDING_APPROVAL,
                self::STATUS_PENDING_SIGNATURE,
                self::STATUS_APPROVED,
            ]);
    }

    public function scopeForVenue(Builder $query, int $venueId): Builder
    {
        return $query->where('venue_id', $venueId);
    }
}
