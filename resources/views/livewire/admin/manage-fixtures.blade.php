<div>
<div style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:960px; margin:0 auto; padding:0 16px;">

        <div style="background:linear-gradient(135deg, #1e7e34, #28A745); border-radius:16px 16px 0 0; padding:20px 24px;">
            <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">📋 Manage Fixtures</h1>
            <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">Create and manage match fixtures</p>
        </div>

        <div style="background:#fff; border:1px solid #e5e7eb; border-top:none; border-radius:0 0 16px 16px; overflow:hidden;">

            @if(session('success'))
            <div style="background:#f0fdf4; border-left:4px solid var(--muk-green); padding:12px 20px; margin:16px; border-radius:0 8px 8px 0; font-size:14px; font-weight:600; color:var(--muk-green);">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div style="background:#fef2f2; border-left:4px solid var(--muk-red); padding:12px 20px; margin:16px; border-radius:0 8px 8px 0; font-size:14px; font-weight:600; color:var(--muk-red);">❌ {{ session('error') }}</div>
            @endif

            {{-- Create Fixture Form --}}
            <form wire:submit="createFixture" style="padding:20px; border-bottom:2px solid #e5e7eb;">
                <h3 style="font-size:15px; font-weight:800; color:var(--muk-green-dark); margin-bottom:16px;">➕ New Fixture</h3>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div>
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Competition *</label>
                        <select wire:model="competition_id" style="width:100%; padding:9px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                            <option value="">Select competition...</option>
                            @foreach($competitions as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }} ({{ $comp->sport?->name }})</option>
                            @endforeach
                        </select>
                        @error('competition_id') <div style="color:var(--muk-red); font-size:11px; margin-top:2px;">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Venue *</label>
                        <select wire:model="venue_id" style="width:100%; padding:9px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                            <option value="">Select venue...</option>
                            @foreach($venues as $venue)
                                <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                            @endforeach
                        </select>
                        @error('venue_id') <div style="color:var(--muk-red); font-size:11px; margin-top:2px;">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Home Team *</label>
                        <select wire:model="home_team_id" style="width:100%; padding:9px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                            <option value="">Select home team...</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                        @error('home_team_id') <div style="color:var(--muk-red); font-size:11px; margin-top:2px;">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Away Team *</label>
                        <select wire:model="away_team_id" style="width:100%; padding:9px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                            <option value="">Select away team...</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                        @error('away_team_id') <div style="color:var(--muk-red); font-size:11px; margin-top:2px;">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Match Date *</label>
                        <input type="date" wire:model="match_date" style="width:100%; padding:9px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                        @error('match_date') <div style="color:var(--muk-red); font-size:11px; margin-top:2px;">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Match Time *</label>
                        <input type="time" wire:model="match_time" style="width:100%; padding:9px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                        @error('match_time') <div style="color:var(--muk-red); font-size:11px; margin-top:2px;">{{ $message }}</div> @enderror
                    </div>
                    <div style="grid-column:1/-1;">
                        <label style="font-size:12px; font-weight:700; color:#333; display:block; margin-bottom:4px;">Match Notes (optional)</label>
                        <textarea wire:model="match_notes" rows="2" style="width:100%; padding:9px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px; font-family:inherit; resize:vertical;" placeholder="Any additional info..."></textarea>
                    </div>
                </div>
                <button type="submit" wire:loading.attr="disabled" style="margin-top:16px; padding:10px 24px; background:var(--muk-green); color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;">
    <span wire:loading.remove wire:target="createFixture">Create Fixture</span>
    <span wire:loading wire:target="createFixture" style="display:flex; align-items:center; gap:6px;"><span style="width:14px;height:14px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span> Processing...</span>
</button>
            </form>

            {{-- Fixtures List --}}
            <div class="table-wrap" style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:13px; min-width:650px;">
                    <thead>
                        <tr style="background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Date</th>
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Competition</th>
                            <th style="padding:12px 14px; text-align:center; font-weight:700; color:#333;">Home</th>
                            <th style="padding:12px 14px; text-align:center; font-weight:700; color:#333;">Score</th>
                            <th style="padding:12px 14px; text-align:center; font-weight:700; color:#333;">Away</th>
                            <th style="padding:12px 14px; text-align:center; font-weight:700; color:#333;">Status</th>
                            <th style="padding:12px 14px; text-align:right; font-weight:700; color:#333;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fixtures as $match)
                        <tr style="border-bottom:1px solid #f0f0f0;">
                            <td style="padding:12px 14px; white-space:nowrap; font-size:12px;">{{ $match->match_date->format('d M Y, H:i') }}</td>
                            <td style="padding:12px 14px; font-size:12px; color:#666;">{{ $match->competition?->name ?? 'N/A' }}</td>
                            <td style="padding:12px 14px; text-align:center; font-weight:700;">{{ $match->homeTeam->name }}</td>
                            <td style="padding:12px 14px; text-align:center; font-weight:800; {{ $match->status === 'finished' ? 'color:var(--muk-green);' : 'color:#bbb;' }}">
                                {{ $match->status === 'finished' ? "{$match->home_score} - {$match->away_score}" : '- : -' }}
                            </td>
                            <td style="padding:12px 14px; text-align:center; font-weight:700;">{{ $match->awayTeam->name }}</td>
                            <td style="padding:12px 14px; text-align:center;">
                                @php
                                    $sc = $match->status === 'finished' ? ['bg'=>'#f0fdf4','text'=>'var(--muk-green)','label'=>'Finished']
                                        : ($match->status === 'live' ? ['bg'=>'#fef2f2','text'=>'var(--muk-red)','label'=>'LIVE']
                                        : ['bg'=>'#fef3c7','text'=>'#d97706','label'=>'Scheduled']);
                                @endphp
                                <span style="background:{{ $sc['bg'] }}; color:{{ $sc['text'] }}; padding:2px 10px; border-radius:999px; font-size:11px; font-weight:600;">{{ $sc['label'] }}</span>
                            </td>
                            <td style="padding:12px 14px; text-align:right;">
                                @if($match->status !== 'finished')
                                <button wire:click="deleteFixture({{ $match->id }})" wire:loading.attr="disabled" style="background:#fee2e2; color:var(--muk-red); border:none; padding:5px 12px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:4px;" onclick="return confirm('Delete this fixture?')">
    <span wire:loading.remove wire:target="deleteFixture({{ $match->id }})">Delete</span>
    <span wire:loading wire:target="deleteFixture({{ $match->id }})" style="display:flex; align-items:center; gap:4px;"><span style="width:12px;height:12px;border:2px solid var(--muk-red);border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span></span>
</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" style="padding:40px; text-align:center; color:#888;"><div style="font-size:36px; margin-bottom:8px;">📅</div><div>No fixtures yet.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($fixtures->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #e5e7eb;">{{ $fixtures->links() }}</div>
            @endif
        </div>
    </div>
</div>
</div>
