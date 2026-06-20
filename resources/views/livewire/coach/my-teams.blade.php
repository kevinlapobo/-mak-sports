<div>
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:800px; margin:0 auto;">

        <div style="background:linear-gradient(135deg, var(--muk-green) 0%, var(--muk-green-dark) 100%); border-radius:16px 16px 0 0; padding:20px 24px; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">🏟 My Teams</h1>
                <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">Register and manage your teams</p>
            </div>
            @if($coach && auth()->user()->status === 'approved')
            <button wire:click="$set('showForm', true)" wire:loading.attr="disabled" style="background:var(--muk-gold); color:var(--muk-black); border:none; padding:10px 20px; border-radius:10px; font-size:13px; font-weight:800; cursor:pointer; transition:transform .15s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">+ New Team</button>
            @elseif($coach && auth()->user()->status !== 'approved')
            <span style="background:#fef3c7; color:#d97706; padding:10px 20px; border-radius:10px; font-size:12px; font-weight:600;">⏳ Approval pending — register teams after approval</span>
            @endif
        </div>

        <div style="background:#fff; border:1px solid #e5e7eb; border-top:none; border-radius:0 0 16px 16px; overflow:hidden;">

            <div wire:loading wire:target="createTeam" style="padding:16px; text-align:center; background:#f0fdf4; border-bottom:1px solid #bbf7d0;">
                <span style="display:inline-block; width:16px; height:16px; border:2px solid var(--muk-green); border-top-color:transparent; border-radius:50%; animation:spin .6s linear infinite; vertical-align:middle; margin-right:8px;"></span>
                <span style="font-size:13px; font-weight:600; color:var(--muk-green);">Registering team...</span>
            </div>

            @if(session('success'))
            <div style="background:#f0fdf4; border-left:4px solid var(--muk-green); padding:12px 20px; margin:16px; border-radius:0 8px 8px 0; font-size:14px; font-weight:600; color:var(--muk-green);">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div style="background:#fef2f2; border-left:4px solid var(--muk-red); padding:12px 20px; margin:16px; border-radius:0 8px 8px 0; font-size:14px; font-weight:600; color:var(--muk-red);">⚠️ {{ session('error') }}</div>
            @endif

            {{-- Creation Form --}}
            @if($showForm)
            <div style="padding:20px; border-bottom:1px solid #e5e7eb; background:#f9fafb;">
                <h3 style="font-size:16px; font-weight:700; color:#333; margin-bottom:16px;">Register a New Team</h3>
                <form wire:submit="createTeam">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
                        <div>
                            <label style="font-size:12px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Team Name <span style="color:var(--muk-red);">*</span></label>
                            <input type="text" wire:model="name" required style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                            @error('name') <span style="font-size:11px; color:var(--muk-red);">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label style="font-size:12px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Sport <span style="color:var(--muk-red);">*</span></label>
                            <select wire:model="sport_id" required style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                                <option value="">Select sport...</option>
                                @foreach($sports as $sport)
                                <option value="{{ $sport->id }}">{{ $sport->name }}</option>
                                @endforeach
                            </select>
                            @error('sport_id') <span style="font-size:11px; color:var(--muk-red);">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="font-size:12px; font-weight:600; color:#333; display:block; margin-bottom:4px;">Home Venue</label>
                        <input type="text" wire:model="home_venue" placeholder="e.g. Makerere Main Pitch" style="width:100%; padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px;">
                    </div>

                    {{-- Players (minimum 13) --}}
                    <div style="margin-bottom:14px;">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
                            <label style="font-size:12px; font-weight:600; color:#333;">Players <span style="color:var(--muk-red);">*</span></label>
                            <span style="font-size:11px; color:#888;">(minimum 13)</span>
                            <span style="margin-left:auto; font-size:11px; font-weight:600; color:{{ count($playerNames) >= 13 ? 'var(--muk-green)' : 'var(--muk-red)' }};">{{ count($playerNames) }} / 13</span>
                        </div>
                        <div style="max-height:360px; overflow-y:auto; padding-right:4px;">
                        @foreach($playerNames as $index => $pname)
                        <div style="display:flex; gap:6px; margin-bottom:5px;">
                            <span style="width:24px; height:34px; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:600; color:#888; flex-shrink:0;">{{ $index + 1 }}.</span>
                            <input type="text" wire:model="playerNames.{{ $index }}" placeholder="Player {{ $index + 1 }} name" required style="flex:1; padding:8px 10px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                            @if(count($playerNames) > 13)
                            <button type="button" wire:click="removePlayerInput({{ $index }})" style="background:#fee2e2; color:var(--muk-red); border:none; width:30px; border-radius:8px; font-size:13px; cursor:pointer; flex-shrink:0;">✕</button>
                            @endif
                        </div>
                        @endforeach
                        </div>
                        <div style="margin-top:6px;">
                            <button type="button" wire:click="addPlayerInput" style="background:transparent; color:var(--muk-green); border:1.5px dashed var(--muk-green); padding:6px 14px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer;">+ Add more players</button>
                        </div>
                        @error('playerNames') <span style="font-size:11px; color:var(--muk-red); display:block; margin-top:4px;">{{ $message }}</span> @enderror
                    </div>

                    <div style="display:flex; gap:10px;">
                        <button type="submit" wire:loading.attr="disabled" style="background:var(--muk-green); color:#fff; border:none; padding:10px 24px; border-radius:8px; font-size:13px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:8px;">
                            <span wire:loading.remove wire:target="createTeam">Register Team</span>
                            <span wire:loading wire:target="createTeam" style="display:flex; align-items:center; gap:6px;"><span style="width:14px;height:14px;border:2px solid #fff;border-top-color:transparent;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;"></span> Processing...</span>
                        </button>
                        <button type="button" wire:click="$set('showForm', false)" wire:loading.attr="disabled" style="background:#fff; color:#666; border:1px solid #e5e7eb; padding:10px 24px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">Cancel</button>
                    </div>
                </form>
            </div>
            @endif

            {{-- Team Details View --}}
            @if($selectedTeam)
            <div style="padding:20px; border-bottom:1px solid #e5e7eb;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <button wire:click="closeDetails" style="background:transparent; border:none; font-size:18px; cursor:pointer; color:#888;">←</button>
                    <h3 style="font-size:18px; font-weight:800; color:#111; margin:0;">{{ $selectedTeam->name }}</h3>
                    <span style="background:var(--muk-green); color:#fff; font-size:10px; padding:3px 8px; border-radius:999px;">{{ $selectedTeam->sport->name ?? 'N/A' }}</span>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                    <div style="background:#f9fafb; padding:12px; border-radius:10px;">
                        <div style="font-size:11px; color:#888;">Venue</div>
                        <div style="font-size:14px; font-weight:700; color:#111;">{{ $selectedTeam->home_venue ?? 'Not set' }}</div>
                    </div>
                    <div style="background:#f9fafb; padding:12px; border-radius:10px;">
                        <div style="font-size:11px; color:#888;">Players</div>
                        <div style="font-size:14px; font-weight:700; color:#111;">{{ $selectedTeam->players_count ?? $selectedTeam->players->count() }}</div>
                    </div>
                </div>
                @if($selectedTeam->players && $selectedTeam->players->count() > 0)
                <h4 style="font-size:14px; font-weight:700; color:#333; margin-bottom:10px;">Players</h4>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    @foreach($selectedTeam->players as $player)
                    <div style="display:flex; align-items:center; gap:10px; padding:8px 12px; background:#f9fafb; border-radius:8px;">
                        <div style="width:32px; height:32px; border-radius:50%; background:var(--muk-green); color:#fff; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700;">{{ strtoupper(substr($player->name, 0, 1)) }}</div>
                        <div style="flex:1; font-size:13px; font-weight:600;">{{ $player->name }}</div>
                        <div style="font-size:11px; color:#888;">{{ $player->position ?? 'N/A' }} · #{{ $player->jersey_number ?? '?' }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endif

            {{-- My Registered Teams --}}
            @if(!$selectedTeam)
            <div style="padding:16px 20px;">
                <h3 style="font-size:14px; font-weight:700; color:#333; margin-bottom:12px;">My Registered Teams</h3>
                @forelse($myTeams as $team)
                <div style="display:flex; align-items:center; gap:14px; padding:14px; background:#f9fafb; border-radius:12px; margin-bottom:8px; cursor:pointer; transition:background .15s;" wire:click="viewTeam({{ $team->id }})" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='#f9fafb'">
                    <div style="width:44px; height:44px; border-radius:12px; background:var(--muk-green); color:#fff; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:800;">{{ strtoupper(substr($team->name, 0, 2)) }}</div>
                    <div style="flex:1;">
                        <div style="font-size:15px; font-weight:700; color:#111;">{{ $team->name }}</div>
                        <div style="font-size:12px; color:#888;">{{ $team->sport->name ?? 'N/A' }} @if($team->home_venue) · {{ $team->home_venue }} @endif</div>
                    </div>
                    <span style="font-size:11px; color:var(--muk-green); font-weight:600;">View →</span>
                </div>
                @empty
                <div style="text-align:center; padding:32px;">
                    <div style="font-size:36px; margin-bottom:8px;">🏟</div>
                    <div style="font-size:14px; color:#888;">You haven't registered any teams yet.</div>
                </div>
                @endforelse
            </div>

            {{-- All Teams (read-only) --}}
            <div style="border-top:1px solid #e5e7eb; padding:16px 20px;">
                <h3 style="font-size:14px; font-weight:700; color:#333; margin-bottom:12px;">All Teams <span style="font-size:11px; font-weight:400; color:#888;">(view only)</span></h3>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    @forelse($allTeams as $team)
                    <div style="display:flex; align-items:center; gap:12px; padding:10px 14px; background:#fff; border:1px solid #f0f0f0; border-radius:10px;">
                        <div style="width:36px; height:36px; border-radius:8px; background:#e5e7eb; color:#888; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700;">{{ strtoupper(substr($team->name, 0, 2)) }}</div>
                        <div style="flex:1; font-size:13px; font-weight:600; color:#333;">{{ $team->name }}</div>
                        <div style="font-size:11px; color:#888;">{{ $team->sport->name ?? 'N/A' }}</div>
                        @if($myTeams->contains('id', $team->id))
                        <span style="font-size:10px; background:var(--muk-green); color:#fff; padding:2px 8px; border-radius:999px;">Yours</span>
                        @endif
                    </div>
                    @empty
                    <div style="text-align:center; padding:16px; font-size:13px; color:#888;">No teams found.</div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>
</div>
