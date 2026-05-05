<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VenueBooking extends Model
{
    use HasFactory;

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
        'booking_date' => 'date',
        'approved_at'  => 'datetime',
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
            ->where('status', '!=', 'rejected')
            ->where('id', '!=', $excludeId)
            ->where(function ($q) use ($startTime, $endTime) {
                // Overlapping time check
                $q->where(function ($inner) use ($startTime, $endTime) {
                    $inner->where('start_time', '<', $endTime)
                        ->where('end_time', '>', $startTime);
                });
            })
            ->exists();
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
