<div>
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:700px; margin:0 auto;">

        <a href="{{ url()->previous() }}" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:var(--muk-green); font-weight:600; text-decoration:none; margin-bottom:24px;">
            ← Back
        </a>

        <div style="background:#fff; border-radius:16px; border:1px solid #e5e7eb; overflow:hidden;">
            <div style="background:var(--muk-green); padding:20px 24px;">
                <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">🏟 Book {{ $venue->name }}</h1>
                <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">{{ $venue->location }} • Capacity: {{ $venue->capacity }}</p>
            </div>

            @if($conflict)
            <div style="background:#fef2f2; border-left:4px solid var(--muk-red); padding:16px 20px; margin:16px; border-radius:0 8px 8px 0;">
                <div style="font-size:14px; font-weight:700; color:var(--muk-red);">⚠️ Venue Already Booked</div>
                <div style="font-size:13px; color:#333; margin-top:4px;">{{ $conflict['message'] }}</div>
            </div>
            @endif

            @if($errors->any())
            <div style="background:#fef2f2; border-left:4px solid var(--muk-red); padding:16px 20px; margin:16px; border-radius:0 8px 8px 0;">
                <div style="font-size:14px; font-weight:700; color:var(--muk-red);">⚠️ Please fix the following errors:</div>
                <ul style="margin:8px 0 0 20px; font-size:13px; color:#333;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form wire:submit="submit" style="padding:24px;">

                <div style="margin-bottom:24px;">
                    <label style="font-size:14px; font-weight:700; color:#333; display:block; margin-bottom:10px;">Booking Type <span style="color:var(--muk-red);">*</span></label>
                    <div style="display:flex; gap:16px;">
                        <label style="flex:1; padding:14px 18px; border:2px solid {{ $booking_type === 'immediate' ? 'var(--muk-red)' : '#e5e7eb' }}; border-radius:10px; cursor:pointer; {{ $booking_type === 'immediate' ? 'background:#fef2f2;' : 'background:#fff;' }}">
                            <input type="radio" wire:model.live="booking_type" value="immediate" style="accent-color:var(--muk-red);">
                            <span style="font-size:14px; font-weight:700;">⚡ Immediate</span>
                            <span style="font-size:11px; color:#888; display:block;">Book now, get receipt instantly</span>
                        </label>
                        <label style="flex:1; padding:14px 18px; border:2px solid {{ $booking_type === 'non_immediate' ? 'var(--muk-red)' : '#e5e7eb' }}; border-radius:10px; cursor:pointer; {{ $booking_type === 'non_immediate' ? 'background:#fef2f2;' : 'background:#fff;' }}">
                            <input type="radio" wire:model.live="booking_type" value="non_immediate" style="accent-color:var(--muk-red);">
                            <span style="font-size:14px; font-weight:700;">📅 Future</span>
                            <span style="font-size:11px; color:#888; display:block;">Submit for facility manager approval</span>
                        </label>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Purpose <span style="color:var(--muk-red);">*</span></label>
                        <input type="text" wire:model="purpose" placeholder="e.g. Football Tournament" required style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                    </div>
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Expected Attendees <span style="color:var(--muk-red);">*</span></label>
                        <input type="number" wire:model="expected_attendees" min="1" max="5000" required style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                    </div>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Description</label>
                    <textarea wire:model="description" rows="2" placeholder="Additional details..." style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px; resize:vertical;"></textarea>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:16px;">
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Date <span style="color:var(--muk-red);">*</span></label>
                        <input type="date" wire:model.live="booking_date" min="{{ date('Y-m-d') }}" required style="width:100%; padding:10px 12px; border:1px solid {{ $conflict ? 'var(--muk-red)' : '#e5e7eb' }}; border-radius:8px; font-size:14px;">
                    </div>
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Start Time <span style="color:var(--muk-red);">*</span></label>
                        <input type="time" wire:model.live="start_time" required style="width:100%; padding:10px 12px; border:1px solid {{ $conflict ? 'var(--muk-red)' : '#e5e7eb' }}; border-radius:8px; font-size:14px;">
                    </div>
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">End Time <span style="color:var(--muk-red);">*</span></label>
                        <input type="time" wire:model.live="end_time" required style="width:100%; padding:10px 12px; border:1px solid {{ $conflict ? 'var(--muk-red)' : '#e5e7eb' }}; border-radius:8px; font-size:14px;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Organizer</label>
                        <input type="text" wire:model="organizer_name" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px; background:#f9fafb;">
                    </div>
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Phone</label>
                        <input type="text" wire:model="organizer_phone" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                    </div>
                </div>

                <div style="margin-bottom:24px;">
                    <label style="font-size:13px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Email</label>
                    <input type="email" wire:model="organizer_email" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px; background:#f9fafb;">
                </div>

                <button type="submit" style="width:100%; padding:14px; background:var(--muk-red); color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:700; cursor:pointer;">
                    {{ $booking_type === 'immediate' ? '⚡ Book Immediately — Get Receipt' : '📅 Submit for Approval' }}
                </button>
            </form>
        </div>
    </div>
</div>
</div>
