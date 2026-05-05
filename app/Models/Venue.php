<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    protected $fillable = [
        'name',
        'location',
        'capacity',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(VenueBooking::class);
    }
}
