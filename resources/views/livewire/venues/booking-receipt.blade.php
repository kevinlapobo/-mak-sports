<div>
<div id="receipt-content" class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:650px; margin:0 auto;">

        <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:var(--muk-green); font-weight:600; text-decoration:none; margin-bottom:24px;">
            ← Back to Home
        </a>

        {{-- Signature Banner --}}
        <div style="background:#fef3c7; border-left:4px solid #f59e0b; padding:16px 20px; border-radius:0 10px 10px 0; margin-bottom:20px;">
            <div style="font-size:14px; font-weight:700; color:#92400e;">⚠️ Pending Facility Manager Signature</div>
            <div style="font-size:13px; color:#92400e; margin-top:4px;">Please visit the <strong>Facility Manager's office</strong> to obtain your signature approval. Your booking is reserved but requires final signature to be confirmed.</div>
        </div>

        {{-- Receipt Card --}}
        <div style="background:#fff; border-radius:16px; border:2px solid var(--muk-green); overflow:hidden;">
            <div style="background:var(--muk-green); padding:20px; text-align:center;">
                <div style="font-size:36px; margin-bottom:4px;">✅</div>
                <div style="font-size:20px; font-weight:900; color:#fff;">BOOKING RECEIPT</div>
                <div style="color:rgba(255,255,255,.7); font-size:12px;">MAKSPORTS — Makerere University</div>
            </div>

            <div style="padding:24px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
                    <div>
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Reference Number</div>
                        <div style="font-size:18px; font-weight:800; color:var(--muk-green);">{{ $booking->reference_number }}</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Status</div>
                        <span style="background:#fef3c7; color:#92400e; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:700;">Pending Signature</span>
                    </div>
                </div>

                <hr style="border:none; border-top:1px solid #e5e7eb; margin-bottom:20px;">

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Venue</div>
                        <div style="font-size:15px; font-weight:700;">{{ $booking->venue->name }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Purpose</div>
                        <div style="font-size:15px; font-weight:700;">{{ $booking->purpose }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Date</div>
                        <div style="font-size:15px; font-weight:600;">{{ $booking->booking_date->format('d M, Y') }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Time</div>
                        <div style="font-size:15px; font-weight:600;">{{ $booking->start_time }} — {{ $booking->end_time }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Organizer</div>
                        <div style="font-size:15px; font-weight:600;">{{ $booking->organizer_name }}</div>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Attendees</div>
                        <div style="font-size:15px; font-weight:600;">{{ $booking->expected_attendees }}</div>
                    </div>
                </div>

                <hr style="border:none; border-top:1px solid #e5e7eb; margin:24px 0;">

                {{-- Signature Box --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:40px;">
                    <div>
                        <div style="border-bottom:1px solid #333; height:60px; margin-bottom:4px;"></div>
                        <div style="font-size:11px; color:#888; text-align:center;">Organizer Signature</div>
                    </div>
                    <div>
                        <div style="border-bottom:1px solid var(--muk-red); height:60px; margin-bottom:4px;"></div>
                        <div style="font-size:11px; color:var(--muk-red); text-align:center; font-weight:600;">Facility Manager Signature (Required)</div>
                    </div>
                </div>

                <div style="margin-top:20px; padding:12px; background:#f9fafb; border-radius:8px; text-align:center;">
                    <div style="font-size:12px; color:#666;">Booked on {{ $booking->created_at->format('d M, Y, H:i') }} by {{ $booking->user->full_name ?? $booking->user->name }}</div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div id="receipt-actions" style="display:flex; gap:10px; margin-top:20px; flex-wrap:wrap;">
            <button id="btn-print-receipt" style="display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #e5e7eb; padding:10px 18px; border-radius:8px; font-size:13px; font-weight:600; color:#333; cursor:pointer;">🖨️ Print Receipt</button>
            <button id="btn-download-receipt" style="display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #e5e7eb; padding:10px 18px; border-radius:8px; font-size:13px; font-weight:600; color:#333; cursor:pointer;">📥 Download</button>
            <a href="{{ route('feedback.create') }}" style="display:inline-flex; align-items:center; gap:6px; background:var(--muk-green); border:none; padding:10px 18px; border-radius:8px; font-size:13px; font-weight:700; color:#fff; text-decoration:none; cursor:pointer;">💬 Send Feedback</a>
        </div>

        <div id="toast-receipt" style="display:none; position:fixed; bottom:30px; left:50%; transform:translateX(-50%); background:var(--muk-green); color:#fff; padding:12px 24px; border-radius:10px; font-size:14px; font-weight:600; z-index:9999; box-shadow:0 8px 24px rgba(0,0,0,.25); transition:opacity .3s;"></div>
    </div>
</div>

<style>
@media print {
    #main-nav, footer, #receipt-actions, #toast-receipt { display: none !important; }
    #receipt-content { padding-top: 0 !important; }
    .container { max-width: 100% !important; }
}
</style>

<script>
document.getElementById('btn-print-receipt').addEventListener('click', function() { window.print(); });

document.getElementById('btn-download-receipt').addEventListener('click', function() {
    var b = {!! json_encode($booking->toArray()) !!};
    var v = {!! json_encode($booking->venue->toArray()) !!};
    var u = {!! json_encode($booking->user->toArray()) !!};
    var html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Booking Receipt ' + b.reference_number + '</title><style>body{font-family:Arial,sans-serif;max-width:600px;margin:30px auto;padding:20px;}h1{text-align:center;color:var(--muk-green);font-size:22px;}.row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee;}.label{color:#888;font-size:12px;text-transform:uppercase;}.value{font-size:14px;font-weight:600;}.sig{display:flex;gap:60px;margin-top:40px;}.sig div{flex:1;border-bottom:1px solid #333;padding-top:60px;text-align:center;font-size:12px;}</style></head><body><h1>BOOKING RECEIPT</h1><p style="text-align:center;color:#888;font-size:12px;">MAKSPORTS — Makerere University | ' + b.reference_number + '</p>';
    [
        ['Venue', v.name], ['Purpose', b.purpose],
        ['Date', b.booking_date], ['Time', b.start_time + ' — ' + b.end_time],
        ['Organizer', b.organizer_name], ['Attendees', b.expected_attendees],
        ['Status', 'Pending Signature']
    ].forEach(function(r) { html += '<div class="row"><span class="label">' + r[0] + '</span><span class="value">' + r[1] + '</span></div>'; });
    html += '<div class="sig"><div>Organizer Signature</div><div>Facility Manager Signature</div></div>';
    html += '<p style="text-align:center;font-size:11px;color:#888;margin-top:30px;">Booked on ' + b.created_at + ' by ' + u.name + '</p>';
    html += '</body></html>';
    var blob = new Blob([html], {type:'text/html'});
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'booking_' + b.reference_number + '.html';
    a.click();
    URL.revokeObjectURL(a.href);
    var t = document.getElementById('toast-receipt');
    t.textContent = 'Receipt downloaded!';
    t.style.display = 'block'; t.style.opacity = '1';
    setTimeout(function() { t.style.opacity = '0'; setTimeout(function() { t.style.display = 'none'; }, 300); }, 2500);
});
</script>
</div>
