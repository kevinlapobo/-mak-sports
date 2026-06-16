<div>
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:960px; margin:0 auto; padding:0 16px;">

        <div style="background:linear-gradient(135deg, #1e7e34, #28A745); border-radius:16px 16px 0 0; padding:20px 24px;">
            <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">🏟 Venue Bookings</h1>
            <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">Manage and approve venue booking requests</p>
        </div>

        <div style="background:#fff; border:1px solid #e5e7eb; border-top:none; border-radius:0 0 16px 16px; overflow:hidden;">

            @if(session('success'))
            <div style="background:#f0fdf4; border-left:4px solid var(--muk-green); padding:12px 20px; margin:16px; border-radius:0 8px 8px 0; font-size:14px; font-weight:600; color:var(--muk-green);">✅ {{ session('success') }}</div>
            @endif

            {{-- Filters --}}
            <div style="padding:16px 20px; display:flex; gap:12px; flex-wrap:wrap; border-bottom:1px solid #e5e7eb;">
                <input type="text" wire:model.live.debounce="search" placeholder="Search reference, organizer, venue..." style="flex:1; min-width:200px; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">

                <select wire:model.live="statusFilter" style="padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                    <option value="pending_approval">Pending Approval</option>
                    <option value="pending_signature">Pending Signature</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="">All Status</option>
                </select>
            </div>

            {{-- Table --}}
            <div class="table-wrap" style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:13px; min-width:600px;">
                    <thead>
                        <tr style="background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Reference</th>
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Venue</th>
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Organizer</th>
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Date</th>
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Time</th>
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Status</th>
                            <th style="padding:12px 14px; text-align:right; font-weight:700; color:#333;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr style="border-bottom:1px solid #f0f0f0;">
                            <td style="padding:12px 14px; font-weight:600; font-size:12px; font-family:monospace;">{{ $booking->reference_number }}</td>
                            <td style="padding:12px 14px; font-weight:600;">{{ $booking->venue->name }}</td>
                            <td style="padding:12px 14px;">
                                <div style="font-weight:600;">{{ $booking->organizer_name }}</div>
                                <div style="font-size:11px; color:#888;">{{ $booking->organizer_phone }}</div>
                            </td>
                            <td style="padding:12px 14px; color:#333; white-space:nowrap;">{{ $booking->booking_date->format('d M Y') }}</td>
                            <td style="padding:12px 14px; color:#333; white-space:nowrap; font-size:12px;">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</td>
                            <td style="padding:12px 14px;">
                                @php
                                    $statusColors = [
                                        'pending_approval' => ['bg' => '#fef3c7', 'text' => '#d97706', 'label' => 'Pending'],
                                        'pending_signature' => ['bg' => '#fef3c7', 'text' => '#d97706', 'label' => 'Signature'],
                                        'approved' => ['bg' => '#f0fdf4', 'text' => 'var(--muk-green)', 'label' => 'Approved'],
                                        'rejected' => ['bg' => '#fef2f2', 'text' => '#ef4444', 'label' => 'Rejected'],
                                    ];
                                    $sc = $statusColors[$booking->status] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280', 'label' => $booking->status];
                                @endphp
                                <span style="background:{{ $sc['bg'] }}; color:{{ $sc['text'] }}; padding:3px 10px; border-radius:999px; font-size:11px; font-weight:600;">{{ $sc['label'] }}</span>
                            </td>
                            <td style="padding:12px 14px; text-align:right; white-space:nowrap;">
                                @if(in_array($booking->status, ['pending_approval', 'pending_signature']))
                                <button wire:click="approve({{ $booking->id }})" style="background:var(--muk-green); color:#fff; border:none; padding:6px 14px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; margin-right:4px;">Approve</button>
                                <button wire:click="confirmReject({{ $booking->id }})" style="background:#fee2e2; color:var(--muk-red); border:none; padding:6px 14px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer;">Reject</button>
                                @elseif($booking->status === 'approved')
                                <span style="font-size:11px; color:var(--muk-green); font-weight:600;">✓ {{ $booking->approver?->name ?? 'Approved' }}</span>
                                @else
                                <span style="font-size:11px; color:var(--muk-red); font-weight:600;">✕ Rejected</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="padding:40px; text-align:center; color:#888;">
                                <div style="font-size:36px; margin-bottom:8px;">📋</div>
                                <div style="font-size:14px;">No venue bookings found.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #e5e7eb;">
                {{ $bookings->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Reject modal --}}
@if($rejectBookingId)
<div style="position:fixed; inset:0; z-index:2000; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,.5); padding:20px;" wire:click.self="cancelReject">
    <div style="background:#fff; border-radius:16px; padding:24px; max-width:460px; width:100%; box-shadow:0 20px 60px rgba(0,0,0,.3);">
        <h3 style="font-size:18px; font-weight:800; margin:0 0 4px; color:var(--muk-red);">Reject Booking</h3>
        <p style="font-size:13px; color:#666; margin-bottom:16px;">Provide a reason for rejecting this booking request.</p>

        <textarea wire:model="rejectionReason" rows="3" placeholder="e.g. Venue unavailable on requested date..." style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px; font-family:inherit; resize:vertical;"></textarea>
        @error('rejectionReason') <div style="color:var(--muk-red); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror

        <div style="display:flex; gap:10px; margin-top:16px; justify-content:flex-end;">
            <button wire:click="cancelReject" style="padding:10px 20px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:13px; font-weight:600; background:#fff; cursor:pointer;">Cancel</button>
            <button wire:click="reject" style="padding:10px 20px; background:var(--muk-red); color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer;">Reject Booking</button>
        </div>
    </div>
</div>
@endif
</div>
