<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VenueBooking;

class BookingPrintController extends Controller
{
    public function print(int $id)
    {
        $booking = VenueBooking::with(['venue', 'user', 'approver'])->findOrFail($id);

        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Booking ' . $booking->reference_number . '</title>
<style>
body{font-family:Arial,sans-serif;max-width:650px;margin:30px auto;padding:20px;color:#333}
h1{color:#006633;text-align:center;font-size:24px;margin-bottom:4px}
.sub{text-align:center;color:#888;font-size:12px;margin-bottom:30px}
.row{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #eee}
.label{color:#888;font-size:11px;text-transform:uppercase}
.value{font-weight:700;font-size:14px}
.sig{display:flex;gap:60px;margin-top:60px}
.sig div{flex:1;border-bottom:1px solid #333;padding-top:60px;text-align:center;font-size:12px}
footer{margin-top:40px;text-align:center;font-size:11px;color:#aaa}
@media print{body{margin:0;padding:10px}}
</style></head><body>
<h1>BOOKING CONFIRMATION</h1>
<p class="sub">MAKSPORTS — Makerere University | ' . $booking->reference_number . '</p>';

        $rows = [
            ['Venue', $booking->venue->name],
            ['Purpose', $booking->purpose],
            ['Date', $booking->booking_date->format('d M, Y')],
            ['Time', $booking->start_time . ' — ' . $booking->end_time],
            ['Organizer', $booking->organizer_name],
            ['Phone', $booking->organizer_phone],
            ['Email', $booking->organizer_email],
            ['Attendees', $booking->expected_attendees],
        ];

        if ($booking->description) {
            $rows[] = ['Description', $booking->description];
        }

        foreach ($rows as $r) {
            $html .= '<div class="row"><span class="label">' . $r[0] . '</span><span class="value">' . $r[1] . '</span></div>';
        }

        $html .= '<div class="sig"><div>Organizer Signature</div><div>Facility Manager Signature</div></div>';
        $html .= '<footer>Booked on ' . $booking->created_at->format('d M, Y, H:i') . ' by ' . $booking->user->name . ' | Approved on ' . ($booking->approved_at?->format('d M, Y, H:i') ?? 'N/A') . '</footer>';
        $html .= '<script>window.onload=function(){window.print()}<\/script></body></html>';

        return response($html)->header('Content-Type', 'text/html; charset=utf-8');
    }
}
