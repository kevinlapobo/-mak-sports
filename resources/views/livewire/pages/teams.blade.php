<div>
    {{-- HEADER --}}
    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:800; color:var(--muk-green-dark); margin-bottom:8px;">
            Teams
        </h1>
        <p style="font-size:14px; color:#9a9a9a;">
            Browse all teams across sports
        </p>
    </div>

    {{-- FILTERS --}}
    <div style="background:#fff; border-radius:12px; padding:16px; margin-bottom:20px; border:1px solid #e5e7eb;">
        <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
            <div style="flex:1; min-width:200px;">
                <label style="font-size:12px; font-weight:700; color:var(--muk-green-dark); display:block; margin-bottom:4px;">Search Teams</label>
                <input wire:model.live="search" type="text" placeholder="Search by team name..." style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 12px; font-size:13px;">
            </div>
            <div>
                <label style="font-size:12px; font-weight:700; color:var(--muk-green-dark); display:block; margin-bottom:4px;">Sport</label>
                <select wire:model.live="sport" style="border:1px solid #e5e7eb; border-radius:8px; padding:8px 12px; font-size:13px; min-width:150px;">
                    <option value="">All Sports</option>
                    @foreach($sports as $s)
                        <option value="{{ $s->slug }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- TEAMS GRID --}}
    @if($teams->count() > 0)
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:16px;">
            @foreach($teams as $team)
                <a href="{{ route('team.detail', $team->slug) }}"
                   style="background:#fff; border-radius:12px; padding:18px; border:1px solid #e5e7eb; text-decoration:none; transition:box-shadow .15s;"
                   onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'"
                   onmouseout="this.style.boxShadow='none'">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                        <div style="width:50px; height:50px; background:var(--muk-green); border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:20px; font-weight:800;">
                            {{ strtoupper(substr($team->name, 0, 2)) }}
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:15px; font-weight:700; color:#111;">{{ $team->name }}</div>
                            @if($team->sport)
                                <div style="font-size:11px; color:#9a9a9a;">{{ $team->sport->name }}</div>
                            @endif
                        </div>
                    </div>
                    <div style="display:flex; gap:12px; font-size:12px; color:#9a9a9a; padding-top:12px; border-top:1px solid #f0f0f0;">
                        @if($team->coach)
                            <div>Coach: <span style="color:#111; font-weight:600;">{{ $team->coach->name }}</span></div>
                        @endif
                        <div>Players: <span style="color:#111; font-weight:600;">{{ $team->players_count ?? 0 }}</span></div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div style="background:#fff; border-radius:12px; padding:40px; text-align:center; border:1px solid #e5e7eb;">
            <div style="font-size:48px; margin-bottom:12px;">🏅</div>
            <div style="font-size:16px; font-weight:700; color:#111; margin-bottom:4px;">No Teams Found</div>
            <div style="font-size:13px; color:#9a9a9a;">Try adjusting your search or filters</div>
        </div>
    @endif
</div>
