<?php

namespace App\Livewire\Venues;

use App\Models\Venue;
use App\Models\VenueBooking;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BookVenue extends Component
{
    public int $venueId;
    public Venue $venue;

    public string $purpose = '';
    public string $description = '';
    public string $organizer_name = '';
    public string $organizer_phone = '';
    public string $organizer_email = '';
    public int $expected_attendees = 50;
    public string $booking_date = '';
    public string $start_time = '';
    public string $end_time = '';
    public string $booking_type = 'immediate';
    public ?array $conflict = null;
    public ?string $pastDateError = null;
    public array $bookedDates = [];

    public function mount(int $venueId): void
    {
        $this->venue = Venue::findOrFail($venueId);
        $user = Auth::user();
        $this->organizer_name = $user->full_name ?? $user->name;
        $this->organizer_email = $user->email;
        $this->organizer_phone = $user->phone ?? '';
        $this->loadBookedDates();
    }

    public function loadBookedDates(): void
    {
        $this->bookedDates = VenueBooking::where('venue_id', $this->venue->id)
            ->whereIn('status', ['pending_approval', 'pending_signature', 'approved'])
            ->selectRaw('DATE(booking_date) as date')
            ->distinct()
            ->orderBy('date')
            ->pluck('date')
            ->toArray();
    }

    public function checkAvailability(): void
    {
        $this->conflict = null;
        $this->pastDateError = null;

        if ($this->booking_date) {
            if ($this->booking_date < date('Y-m-d')) {
                $this->pastDateError = 'You cannot select a date in the past. Please choose today or a future date.';
                return;
            }
        }

        if ($this->booking_date && $this->start_time && $this->end_time) {
            if (VenueBooking::hasConflict($this->venue->id, $this->booking_date, $this->start_time, $this->end_time)) {
                $this->conflict = ['message' => 'This venue is already booked during this time. Please choose a different date or time slot.'];
            }
        }
    }

    public function updatedBookingDate(): void
    {
        $this->checkAvailability();
    }
    public function updatedStartTime(): void
    {
        $this->checkAvailability();
    }
    public function updatedEndTime(): void
    {
        $this->checkAvailability();
    }

    public function submit()
    {
        $this->validate([
            'purpose' => 'required|string|max:255',
            'description' => 'nullable|string',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'expected_attendees' => 'required|integer|min:1|max:5000',
            'booking_type' => 'required|in:immediate,non_immediate',
        ]);

        if (VenueBooking::hasConflict($this->venue->id, $this->booking_date, $this->start_time, $this->end_time)) {
            $this->conflict = ['message' => 'This venue is already booked during this time. Please choose a different date or time slot.'];
            return;
        }

        $booking = VenueBooking::create([
            'user_id' => Auth::id(),
            'venue_id' => $this->venue->id,
            'purpose' => $this->purpose,
            'description' => $this->description,
            'organizer_name' => $this->organizer_name,
            'organizer_phone' => $this->organizer_phone,
            'organizer_email' => $this->organizer_email,
            'expected_attendees' => $this->expected_attendees,
            'booking_date' => $this->booking_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->booking_type === 'immediate' ? 'pending_signature' : 'pending_approval',
        ]);

        if ($this->booking_type === 'immediate') {
            $this->redirectRoute('venue.receipt', $booking->id, navigate: true);
        } else {
            $this->redirectRoute('venue.pending', $booking->id, navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.venues.book-venue')->layout('layouts.public', ['title' => 'Book ' . $this->venue->name]);
    }
}
