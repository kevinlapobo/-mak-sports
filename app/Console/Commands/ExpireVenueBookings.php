<?php

namespace App\Console\Commands;

use App\Models\VenueBooking;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('bookings:expire')]
#[Description('Mark past venue bookings as completed')]
class ExpireVenueBookings extends Command
{
    public function handle(): void
    {
        $count = VenueBooking::expired()->update(['status' => VenueBooking::STATUS_COMPLETED]);

        $this->info("{$count} expired booking(s) marked as completed.");
    }
}
