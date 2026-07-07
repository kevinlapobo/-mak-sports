<?php

namespace App\Livewire\Venues;

use App\Models\Venue;
use App\Models\VenueBooking;
use App\Notifications\BookingStatusNotification;
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
    public array $bookedSlots = [];
    public array $selectedDateBookings = [];
    public string $tooltipDate = '';

    public int $calMonth;
    public int $calYear;
    public array $calDays = [];

    public array $monthNames = [
        1 => 'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December',
    ];

    public function mount(int $venueId): void
    {
        $this->venue = Venue::findOrFail($venueId);
        $user = Auth::user();
        $this->organizer_name = $user->full_name ?? $user->name;
        $this->organizer_email = $user->email;
        $this->organizer_phone = $user->phone ?? '';
        $this->calMonth = (int) date('n');
        $this->calYear = (int) date('Y');
        $this->loadBookedDates();
    }

    public function loadBookedDates(): void
    {
        $bookings = VenueBooking::forVenue($this->venue->id)
            ->active()
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get(['id', 'booking_date', 'start_time', 'end_time', 'purpose', 'organizer_name']);

        $grouped = [];
        $dates = [];
        foreach ($bookings as $b) {
            $d = $b->booking_date instanceof \Carbon\Carbon ? $b->booking_date->format('Y-m-d') : $b->booking_date;
            $dates[$d] = true;
            $grouped[$d][] = [
                'id' => $b->id,
                'start' => substr($b->start_time, 0, 5),
                'end' => substr($b->end_time, 0, 5),
                'purpose' => $b->purpose,
                'organizer' => $b->organizer_name,
            ];
        }

        $this->bookedDates = array_keys($dates);
        $this->bookedSlots = $grouped;
        $this->generateCalendar();
    }

    public function generateCalendar(): void
    {
        $firstDay = mktime(0, 0, 0, $this->calMonth, 1, $this->calYear);
        $daysInMonth = (int) date('t', $firstDay);
        $startWeekday = (int) date('w', $firstDay);
        $today = date('Y-m-d');

        $days = [];
        $dayNum = 1;
        $totalCells = (int) (ceil(($daysInMonth + $startWeekday) / 7) * 7);

        for ($i = 0; $i < $totalCells; $i++) {
            $weekIdx = (int) floor($i / 7);
            if (!isset($days[$weekIdx])) {
                $days[$weekIdx] = [];
            }

            if ($i < $startWeekday || $dayNum > $daysInMonth) {
                $days[$weekIdx][] = null;
            } else {
                $ds = sprintf('%04d-%02d-%02d', $this->calYear, $this->calMonth, $dayNum);
                $slots = $this->bookedSlots[$ds] ?? [];
                $days[$weekIdx][] = [
                    'day' => $dayNum,
                    'date' => $ds,
                    'isPast' => $ds < $today,
                    'isToday' => $ds === $today,
                    'isBooked' => count($slots) > 0,
                    'isSelected' => $ds === $this->booking_date,
                    'slots' => $slots,
                    'slotCount' => count($slots),
                ];
                $dayNum++;
            }
        }

        $this->calDays = $days;
    }

    public function nextMonth(): void
    {
        if ($this->calMonth === 12) {
            $this->calMonth = 1;
            $this->calYear++;
        } else {
            $this->calMonth++;
        }
        $this->generateCalendar();
    }

    public function prevMonth(): void
    {
        if (now()->format('Y-m') === sprintf('%04d-%02d', $this->calYear, $this->calMonth)) {
            return;
        }
        if ($this->calMonth === 1) {
            $this->calMonth = 12;
            $this->calYear--;
        } else {
            $this->calMonth--;
        }
        $this->generateCalendar();
    }

    public function selectDate(string $date): void
    {
        if ($date < date('Y-m-d')) {
            $this->pastDateError = 'You cannot select a date in the past. Please choose today or a future date.';
            return;
        }
        $this->pastDateError = null;
        $this->booking_date = $date;
        $this->selectedDateBookings = $this->bookedSlots[$date] ?? [];
        $this->generateCalendar();
        $this->checkAvailability();
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
        $this->generateCalendar();
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

        Auth::user()->notify(new BookingStatusNotification($booking, $booking->status));

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
