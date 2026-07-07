<?php

namespace App\Notifications;

use App\Models\VenueBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingStatusNotification extends Notification
{
    use Queueable;

    public function __construct(public VenueBooking $booking, public string $status)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $messages = [
            'pending_approval' => 'Your booking request for ' . $this->booking->venue->name . ' on ' . $this->booking->booking_date->format('d M Y') . ' has been submitted and is pending approval.',
            'pending_signature' => 'Your booking for ' . $this->booking->venue->name . ' on ' . $this->booking->booking_date->format('d M Y') . ' is confirmed. Please visit the Facility Manager to sign.',
            'approved' => 'Your booking for ' . $this->booking->venue->name . ' on ' . $this->booking->booking_date->format('d M Y') . ' has been approved!',
            'rejected' => 'Your booking request for ' . $this->booking->venue->name . ' on ' . $this->booking->booking_date->format('d M Y') . ' was rejected.' . ($this->booking->rejection_reason ? ' Reason: ' . $this->booking->rejection_reason : ''),
        ];

        return [
            'type' => 'booking_status',
            'title' => $this->status === 'approved' ? 'Booking Approved' : ($this->status === 'rejected' ? 'Booking Rejected' : 'Booking Submitted'),
            'message' => $messages[$this->status] ?? 'Your booking status has been updated.',
            'booking_id' => $this->booking->id,
            'reference_number' => $this->booking->reference_number,
            'status' => $this->status,
        ];
    }
}
