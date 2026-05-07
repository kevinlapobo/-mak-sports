<?php

namespace App\Livewire\Venues;

use App\Models\VenueBooking;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BookingPending extends Component
{
    public VenueBooking $booking;

    public function mount(int $id): void
    {
        $this->booking = VenueBooking::with(['venue', 'user'])->findOrFail($id);
        if ($this->booking->user_id !== Auth::id()) {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.Venues.booking-pending')->layout('layouts.public', ['title' => 'Booking Pending - ' . $this->booking->reference_number]);
    }
}
