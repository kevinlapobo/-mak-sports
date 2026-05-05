<div>
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:600px; margin:0 auto; text-align:center;">

        <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:var(--muk-green); font-weight:600; text-decoration:none; margin-bottom:24px;">
            ← Back to Home
        </a>

        <div style="background:#fff; border-radius:16px; border:1px solid #e5e7eb; overflow:hidden;">
            <div style="background:#f59e0b; padding:30px;">
                <div style="font-size:56px; margin-bottom:8px;">⏳</div>
                <div style="font-size:22px; font-weight:900; color:#fff;">Booking Submitted</div>
                <div style="color:rgba(255,255,255,.8); font-size:14px; margin-top:4px;">Pending Facility Manager Approval</div>
            </div>

            <div style="padding:24px;">
                <div style="background:#fef3c7; border-radius:10px; padding:16px; margin-bottom:20px;">
                    <div style="font-size:12px; color:#92400e; font-weight:700; text-transform:uppercase;">Reference Number</div>
                    <div style="font-size:22px; font-weight:800; color:#92400e;">{{ $booking->reference_number }}</div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
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
                </div>

                <hr style="border:none; border-top:1px solid #e5e7eb; margin-bottom:20px;">

                <div style="padding:16px; background:#f0fdf4; border-radius:10px; border-left:4px solid var(--muk-green); text-align:left;">
                    <div style="font-size:14px; font-weight:700; color:var(--muk-green);">📋 What happens next?</div>
                    <div style="font-size:13px; color:#333; margin-top:6px; line-height:1.6;">
                        1. The Facility Manager will review your booking request.<br>
                        2. You will receive a notification once your booking is approved.<br>
                        3. After approval, you can print or download your booking confirmation.<br>
                        4. If rejected, you will be notified with a reason.
                    </div>
                </div>

                <div id="pending-actions" style="display:flex; gap:10px; margin-top:20px; justify-content:center; flex-wrap:wrap;">
                    <button id="btn-print-pending" style="display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #e5e7eb; padding:10px 18px; border-radius:8px; font-size:13px; font-weight:600; color:#333; cursor:pointer;">🖨️ Print Summary</button>
                    <button id="btn-download-pending" style="display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #e5e7eb; padding:10px 18px; border-radius:8px; font-size:13px; font-weight:600; color:#333; cursor:pointer;">📥 Download</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print { #main-nav, footer, #pending-actions { display:none !important; } }
</style>
<script>
document.getElementById('btn-print-pending').addEventListener('click', function() { window.print(); });
document.getElementById('btn-download-pending').addEventListener('click', function() {
    var b = {!! json_encode($booking->toArray()) !!};
    var v = {!! json_encode($booking->venue->toArray()) !!};
    var html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Booking ' + b.reference_number + '</title><style>body{font-family:Arial,sans-serif;max-width:500px;margin:30px auto;padding:20px;text-align:center;}h1{color:#f59e0b;font-size:20px;}p{font-size:14px;}.ref{background:#fef3c7;padding:10px;border-radius:8px;font-size:18px;font-weight:800;color:#92400e;display:inline-block;margin:16px 0;}</style></head><body><h1>BOOKING PENDING APPROVAL</h1><p>MAKSPORTS — Makerere University</p><div class="ref">' + b.reference_number + '</div>';
    html += '<p><strong>' + v.name + '</strong></p><p>' + b.purpose + '</p><p>' + b.booking_date + ' | ' + b.start_time + ' — ' + b.end_time + '</p>';
    html += '<p style="color:#888;font-size:11px;margin-top:30px;">Submitted: ' + b.created_at + '</p></body></html>';
    var blob = new Blob([html], {type:'text/html'});
    var a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'booking_' + b.reference_number + '.html';
    a.click();
    URL.revokeObjectURL(a.href);
});
</script>
</div>
