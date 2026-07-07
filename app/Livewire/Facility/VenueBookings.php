<?php

namespace App\Livewire\Facility;

use App\Models\VenueBooking;
use App\Notifications\BookingStatusNotification;
use Livewire\Component;
use Livewire\WithPagination;

class VenueBookings extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'pending_approval';
    public string $rejectBookingId = '';
    public string $rejectionReason = '';

    public function approve($bookingId)
    {
        $booking = VenueBooking::findOrFail($bookingId);
        $booking->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        $booking->user->notify(new BookingStatusNotification($booking, 'approved'));
        session()->flash('success', "Booking {$booking->reference_number} approved.");
    }

    public function confirmReject($bookingId)
    {
        $this->rejectBookingId = $bookingId;
        $this->rejectionReason = '';
    }

    public function reject()
    {
        $this->validate(['rejectionReason' => 'required|string|max:500']);

        $booking = VenueBooking::findOrFail($this->rejectBookingId);
        $booking->update([
            'status' => 'rejected',
            'rejection_reason' => $this->rejectionReason,
        ]);
        $booking->user->notify(new BookingStatusNotification($booking, 'rejected'));

        $this->rejectBookingId = '';
        $this->rejectionReason = '';
        session()->flash('success', "Booking {$booking->reference_number} rejected.");
    }

    public function cancelReject()
    {
        $this->rejectBookingId = '';
        $this->rejectionReason = '';
    }

    public function render()
    {
        $query = VenueBooking::query()->with(['venue', 'user', 'approver']);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('reference_number', 'like', "%{$this->search}%")
                  ->orWhere('organizer_name', 'like', "%{$this->search}%")
                  ->orWhere('purpose', 'like', "%{$this->search}%")
                  ->orWhereHas('venue', function ($v) {
                      $v->where('name', 'like', "%{$this->search}%");
                  });
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('livewire.facility.venue-bookings', [
            'bookings' => $bookings,
        ])->layout('layouts.public', ['title' => 'Venue Bookings']);
    }
}
