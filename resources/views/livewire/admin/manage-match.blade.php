<div>
<div style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:760px; margin:0 auto; padding:0 16px;">

        @if(session('success'))
        <div style="background:#f0fdf4; border-left:4px solid var(--muk-green); padding:12px 20px; margin-bottom:16px; border-radius:0 8px 8px 0; font-size:14px; font-weight:600; color:var(--muk-green);">✅ {{ session('success') }}</div>
        @endif

        {{-- Match Header --}}
        <div style="background:linear-gradient(135deg, #1e7e34, #28A745); border-radius:16px 16px 0 0; padding:20px 24px;">
            <h1 style="font-size:20px; font-weight:900; color:#fff; margin:0;">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h1>
            <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">
                {{ $match->competition?->name ?? 'Friendly' }} · {{ $match->match_date->format('d M Y, H:i') }}
                @if($match->venue) · {{ $match->venue->name }} @endif
            </p>
        </div>

        <div style="background:#fff; border:1px solid #e5e7eb; border-top:none; border-radius:0 0 16px 16px; overflow:hidden;">

            {{-- Score Inputs --}}
            <div style="padding:20px; border-bottom:2px solid #e5e7eb;">
                <h3 style="font-size:15px; font-weight:800; color:var(--muk-green-dark); margin-bottom:14px;">📊 Score</h3>
                <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                    <div style="flex:1; min-width:120px;">
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">{{ $match->homeTeam->name }}</label>
                        <input type="number" wire:model="home_score" min="0" max="99" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:16px; font-weight:700; text-align:center;">
                    </div>
                    <div style="font-size:20px; font-weight:800; color:#888; padding-top:18px;">:</div>
                    <div style="flex:1; min-width:120px;">
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">{{ $match->awayTeam->name }}</label>
                        <input type="number" wire:model="away_score" min="0" max="99" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:16px; font-weight:700; text-align:center;">
                    </div>
                </div>
                <div style="margin-top:12px;">
                    <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Match Notes</label>
                    <textarea wire:model="match_notes" rows="2" style="width:100%; padding:9px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px; font-family:inherit; resize:vertical;" placeholder="Any additional notes..."></textarea>
                </div>
            </div>

            {{-- Events Form --}}
            <div style="padding:20px; border-bottom:2px solid #e5e7eb;">
                <h3 style="font-size:15px; font-weight:800; color:var(--muk-green-dark); margin-bottom:14px;">⚽ Add Event</h3>

                @if(session('event_success'))
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; padding:8px 14px; border-radius:8px; font-size:13px; color:var(--muk-green); font-weight:600; margin-bottom:12px;">{{ session('event_success') }}</div>
                @endif

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Event Type</label>
                        <select wire:model="event_type" style="width:100%; padding:9px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                            <option value="goal">⚽ Goal</option>
                            <option value="yellow_card">🟨 Yellow Card</option>
                            <option value="red_card">🟥 Red Card</option>
                            <option value="substitution">🔄 Substitution</option>
                            <option value="own_goal">😬 Own Goal</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Team</label>
                        <select wire:model="event_team" style="width:100%; padding:9px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                            <option value="home">{{ $match->homeTeam->name }}</option>
                            <option value="away">{{ $match->awayTeam->name }}</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Player Name</label>
                        <input type="text" wire:model="event_player" placeholder="e.g. John Doe" style="width:100%; padding:9px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                        @error('event_player') <div style="color:var(--muk-red); font-size:11px; margin-top:2px;">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Minute</label>
                        <input type="number" wire:model="event_minute" min="0" max="120" placeholder="e.g. 34" style="width:100%; padding:9px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                        @error('event_minute') <div style="color:var(--muk-red); font-size:11px; margin-top:2px;">{{ $message }}</div> @enderror
                    </div>
                </div>
                <button wire:click="addEvent" wire:loading.attr="disabled" style="margin-top:12px; padding:9px 20px; background:var(--muk-green); color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                    <span wire:loading.remove wire:target="addEvent">+ Add Event</span>
                    <span wire:loading wire:target="addEvent" style="display:flex; align-items:center; gap:6px;"><span style="width:14px;height:14px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span> Processing...</span>
                </button>
            </div>

            {{-- Events List --}}
            @if($matchEvents->count() > 0)
            <div style="padding:20px; border-bottom:2px solid #e5e7eb;">
                <h3 style="font-size:15px; font-weight:800; color:var(--muk-green-dark); margin-bottom:14px;">📋 Events ({{ $matchEvents->count() }})</h3>
                <div style="display:flex; flex-direction:column; gap:8px;">
                    @foreach($matchEvents as $event)
                    <div style="display:flex; align-items:center; gap:10px; padding:10px 14px; background:#f9fafb; border-radius:8px;">
                        <div style="font-size:13px; font-weight:700; color:var(--muk-green); width:40px;">{{ $event->minute }}'</div>
                        <div style="font-size:16px;">
                            @if($event->event_type === 'goal') ⚽
                            @elseif($event->event_type === 'yellow_card') 🟨
                            @elseif($event->event_type === 'red_card') 🟥
                            @elseif($event->event_type === 'substitution') 🔄
                            @elseif($event->event_type === 'own_goal') 😬
                            @endif
                        </div>
                        <div style="flex:1; font-size:13px; font-weight:600; color:#111;">{{ $event->description }}</div>
                        <div style="font-size:11px; color:#888;">{{ $event->team?->name ?? '' }}</div>
                        <button wire:click="removeEvent({{ $event->id }})" style="background:none; border:none; color:#ccc; cursor:pointer; font-size:14px; padding:2px;">✕</button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div style="padding:20px; display:flex; gap:12px; flex-wrap:wrap;">
                <button wire:click="approve" wire:loading.attr="disabled" style="padding:12px 28px; background:var(--muk-green); color:#fff; border:none; border-radius:10px; font-size:14px; font-weight:800; cursor:pointer; display:flex; align-items:center; gap:8px;">
                    <span wire:loading.remove wire:target="approve">✅ Approve Result</span>
                    <span wire:loading wire:target="approve" style="display:flex; align-items:center; gap:6px;"><span style="width:14px;height:14px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span> Processing...</span>
                </button>
                <button wire:click="reject" wire:loading.attr="disabled" style="padding:12px 28px; background:#fee2e2; color:var(--muk-red); border:none; border-radius:10px; font-size:14px; font-weight:800; cursor:pointer; display:flex; align-items:center; gap:8px;" onclick="return confirm('Cancel this match?')">
                    <span wire:loading.remove wire:target="reject">❌ Cancel Match</span>
                    <span wire:loading wire:target="reject" style="display:flex; align-items:center; gap:6px;"><span style="width:14px;height:14px;border:2px solid var(--muk-red);border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span> Processing...</span>
                </button>
                <a href="{{ route('admin.manage-fixtures') }}" style="padding:12px 28px; background:#f9fafb; color:#666; border:1px solid #e5e7eb; border-radius:10px; font-size:14px; font-weight:600; text-decoration:none;">← Back</a>
            </div>

        </div>
    </div>
</div>
</div>
