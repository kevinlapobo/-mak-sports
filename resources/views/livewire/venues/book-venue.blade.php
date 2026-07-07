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

            @if($pastDateError)
            <div style="background:#fef2f2; border-left:4px solid var(--muk-red); padding:16px 20px; margin:16px; border-radius:0 8px 8px 0;">
                <div style="font-size:14px; font-weight:700; color:var(--muk-red);">⚠️ Invalid Date</div>
                <div style="font-size:13px; color:#333; margin-top:4px;">{{ $pastDateError }}</div>
            </div>
            @endif

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

                <div style="margin-bottom:16px;">
                    <label style="font-size:14px; font-weight:700; color:#333; display:block; margin-bottom:8px;">📅 Select Date <span style="color:var(--muk-red);">*</span></label>

                    {{-- Calendar Widget --}}
                    <div style="background:#fff; border:2px solid {{ $conflict || $pastDateError ? 'var(--muk-red)' : '#e5e7eb' }}; border-radius:12px; overflow:hidden;">

                        {{-- Calendar Header --}}
                        <div style="background:var(--muk-green); padding:12px 16px; display:flex; align-items:center; justify-content:space-between;">
                            <button type="button" wire:click="prevMonth" style="background:rgba(255,255,255,.15); border:none; color:#fff; width:32px; height:32px; border-radius:8px; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center; {{ now()->format('Y-m') === sprintf('%04d-%02d', $calYear, $calMonth) ? 'opacity:.4;cursor:not-allowed;' : '' }}" @if(now()->format('Y-m') !== sprintf('%04d-%02d', $calYear, $calMonth)) wire:click="prevMonth" @endif>‹</button>
                            <span style="color:#fff; font-size:15px; font-weight:800;">{{ $monthNames[$calMonth] }} {{ $calYear }}</span>
                            <button type="button" wire:click="nextMonth" style="background:rgba(255,255,255,.15); border:none; color:#fff; width:32px; height:32px; border-radius:8px; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center;">›</button>
                        </div>

                        {{-- Weekday Headers --}}
                        <div style="display:grid; grid-template-columns:repeat(7,1fr); background:#f0fdf4; border-bottom:1px solid #e5e7eb;">
                            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $wd)
                            <div style="padding:8px 4px; text-align:center; font-size:11px; font-weight:700; color:var(--muk-green); text-transform:uppercase;">{{ $wd }}</div>
                            @endforeach
                        </div>

                        {{-- Calendar Grid --}}
                        <div style="padding:4px;">
                            @foreach($calDays as $week)
                            <div style="display:grid; grid-template-columns:repeat(7,1fr); gap:2px; margin-bottom:2px;">
                                @foreach($week as $cell)
                                    @if($cell === null)
                                        <div style="padding:8px 4px; text-align:center;"></div>
                                    @else
                                        @php
                                            $isPast = $cell['isPast'];
                                            $isToday = $cell['isToday'];
                                            $isBooked = $cell['isBooked'];
                                            $isSelected = $cell['isSelected'];
                                            $dateStr = $cell['date'];
                                        @endphp
                                        <button type="button"
                                            wire:click="selectDate('{{ $dateStr }}')"
                                            @if($isPast) disabled @endif
                                            style="
                                                width:100%; padding:8px 2px; text-align:center; border:none; border-radius:8px; cursor:{{ $isPast ? 'not-allowed' : 'pointer' }};
                                                font-size:13px; font-weight:{{ $isToday || $isSelected ? '800' : '600' }};
                                                position:relative; transition:all .1s;
                                                background:{{ $isSelected ? 'var(--muk-green)' : ($isToday ? 'rgba(255,193,7,.25)' : ($isPast ? '#f9fafb' : '#fff')) }};
                                                color:{{ $isSelected ? '#fff' : ($isPast ? '#ccc' : ($isToday ? '#92400e' : '#333')) }};
                                            "
                                            onmouseover="this.style.background='{{ $isPast ? '#f9fafb' : ($isSelected ? 'var(--muk-green-dark)' : 'rgba(40,167,69,.1)') }}'"
                                            onmouseout="this.style.background='{{ $isSelected ? 'var(--muk-green)' : ($isToday ? 'rgba(255,193,7,.25)' : ($isPast ? '#f9fafb' : '#fff')) }}'"
                                        >
                                            {{ $cell['day'] }}
                                            @if($isBooked)
                                                <span style="position:absolute; bottom:2px; left:50%; transform:translateX(-50%); width:5px; height:5px; border-radius:50%; background:var(--muk-red); display:block;"></span>
                                            @endif
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                            @endforeach
                        </div>

                        {{-- Legend --}}
                        <div style="padding:8px 16px; border-top:1px solid #f0f0f0; display:flex; gap:16px; font-size:11px; color:#888;">
                            <span><span style="display:inline-block; width:10px; height:10px; border-radius:2px; background:var(--muk-green); margin-right:4px; vertical-align:middle;"></span> Selected</span>
                            <span><span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:var(--muk-red); margin-right:4px; vertical-align:middle;"></span> Booked</span>
                            <span><span style="display:inline-block; width:10px; height:10px; border-radius:2px; background:rgba(255,193,7,.4); margin-right:4px; vertical-align:middle;"></span> Today</span>
                        </div>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
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

                <button type="submit" wire:loading.attr="disabled" style="width:100%; padding:14px; background:var(--muk-red); color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;">
                    <span wire:loading.remove wire:target="submit">{{ $booking_type === 'immediate' ? '⚡ Book Immediately — Get Receipt' : '📅 Submit for Approval' }}</span>
                    <span wire:loading wire:target="submit" style="display:flex; align-items:center; gap:6px;"><span style="width:16px;height:16px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span> Processing...</span>
                </button>
            </form>
        </div>
    </div>
</div>
</div>
