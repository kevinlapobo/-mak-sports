<div>
    {{-- TEAM HEADER --}}
    <div style="background:#fff; border-radius:12px; padding:24px; margin-bottom:20px; border:1px solid #e5e7eb;">
        <div style="display:flex; gap:20px; align-items:center;">
            <div style="width:80px; height:80px; background:var(--muk-green); border-radius:16px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:32px; font-weight:800; flex-shrink:0;">
                {{ strtoupper(substr($team->name, 0, 2)) }}
            </div>
            <div style="flex:1;">
                <h1 style="font-size:24px; font-weight:800; color:var(--muk-green-dark); margin-bottom:4px;">{{ $team->name }}</h1>
                @if($team->sport)
                    <div style="font-size:14px; color:#9a9a9a; margin-bottom:8px;">{{ $team->sport->name }}</div>
                @endif
                @if($team->coach)
                    <div style="font-size:13px; color:#111;">Coach: <span style="font-weight:700;">{{ $team->coach->name }}</span></div>
                @endif
            </div>
        </div>

        {{-- STATS --}}
        <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:12px; margin-top:20px; padding-top:20px; border-top:1px solid #f0f0f0;">
            <div style="text-align:center; background:#f9fafb; border-radius:10px; padding:14px;">
                <div style="font-size:24px; font-weight:800; color:var(--muk-green);">{{ $totalMatches }}</div>
                <div style="font-size:11px; color:#9a9a9a; margin-top:4px;">Total Matches</div>
            </div>
            <div style="text-align:center; background:#f0faf4; border-radius:10px; padding:14px;">
                <div style="font-size:24px; font-weight:800; color:var(--muk-green);">{{ $wins }}</div>
                <div style="font-size:11px; color:#9a9a9a; margin-top:4px;">Wins</div>
            </div>
            <div style="text-align:center; background:#f9fafb; border-radius:10px; padding:14px;">
                <div style="font-size:24px; font-weight:800; color:var(--muk-green);">{{ $team->players->count() }}</div>
                <div style="font-size:11px; color:#9a9a9a; margin-top:4px;">Players</div>
            </div>
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        {{-- RECENT MATCHES --}}
        <div>
            <h3 style="font-size:16px; font-weight:800; color:var(--muk-green-dark); margin-bottom:12px;">Recent Matches</h3>
            @if($recentMatches->count() > 0)
                <div style="background:#fff; border-radius:12px; padding:14px; border:1px solid #e5e7eb;">
                    <div style="display:flex; flex-direction:column; gap:10px;">
                        @foreach($recentMatches as $match)
                            <a href="{{ route('match.detail', $match->id) }}"
                               style="display:flex; align-items:center; padding:12px; background:#f9fafb; border-radius:9px; text-decoration:none; gap:8px;">
                                <div style="flex:1; text-align:right;">
                                    <div style="font-size:13px; font-weight:700; color:#111;">
                                        {{ $match->homeTeam->name }}
                                    </div>
                                </div>
                                <div style="background:#111; color:#fff; border-radius:8px; padding:8px 12px; text-align:center; flex-shrink:0;">
                                    <div style="font-size:16px; font-weight:800; letter-spacing:1px;">
                                        {{ $match->home_score }} - {{ $match->away_score }}
                                    </div>
                                    <div style="font-size:9px; color:#aaa;">FT</div>
                                </div>
                                <div style="flex:1;">
                                    <div style="font-size:13px; font-weight:700; color:#111;">
                                        {{ $match->awayTeam->name }}
                                    </div>
                                    <div style="font-size:10px; color:#9a9a9a;">
                                        {{ $match->match_date->format('d M') }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <div style="background:#fff; border-radius:12px; padding:30px; text-align:center; border:1px solid #e5e7eb;">
                    <div style="font-size:13px; color:#9a9a9a;">No recent matches</div>
                </div>
            @endif
        </div>

        {{-- UPCOMING MATCHES --}}
        <div>
            <h3 style="font-size:16px; font-weight:800; color:var(--muk-green-dark); margin-bottom:12px;">Upcoming Matches</h3>
            @if($upcomingMatches->count() > 0)
                <div style="background:#fff; border-radius:12px; padding:14px; border:1px solid #e5e7eb;">
                    <div style="display:flex; flex-direction:column; gap:10px;">
                        @foreach($upcomingMatches as $match)
                            <a href="{{ route('match.detail', $match->id) }}"
                               style="display:flex; align-items:center; padding:12px; background:#f0faf4; border-radius:9px; text-decoration:none; gap:8px;">
                                <div style="font-size:11px; color:#9a9a9a; font-weight:600; width:55px; flex-shrink:0; text-align:center;">
                                    {{ $match->match_date->format('H:i') }}
                                </div>
                                <div style="flex:1; display:flex; align-items:center; justify-content:center; gap:8px;">
                                    <span style="font-size:12px; font-weight:700; color:#111; text-align:right; flex:1;">
                                        {{ $match->homeTeam->name }}
                                    </span>
                                    <span style="background:var(--muk-green); color:#fff; padding:4px 10px; border-radius:6px; font-size:10px; font-weight:700;">
                                        VS
                                    </span>
                                    <span style="font-size:12px; font-weight:700; color:#111; flex:1;">
                                        {{ $match->awayTeam->name }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <div style="background:#fff; border-radius:12px; padding:30px; text-align:center; border:1px solid #e5e7eb;">
                    <div style="font-size:13px; color:#9a9a9a;">No upcoming matches</div>
                </div>
            @endif
        </div>
    </div>

    {{-- PLAYERS ROSTER --}}
    @if($team->players->count() > 0)
        <div style="margin-top:24px;">
            <h3 style="font-size:16px; font-weight:800; color:var(--muk-green-dark); margin-bottom:12px;">Players Roster</h3>
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:12px;">
                @foreach($team->players as $player)
                    <a href="{{ route('player.detail', $player->id) }}"
                       style="background:#fff; border-radius:10px; padding:14px; border:1px solid #e5e7eb; text-decoration:none; text-align:center; transition:box-shadow .15s;"
                       onmouseover="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'"
                       onmouseout="this.style.boxShadow='none'">
                        <div style="width:50px; height:50px; background:#f0faf4; border-radius:50%; margin:0 auto 8px; display:flex; align-items:center; justify-content:center; font-size:18px; font-weight:800; color:var(--muk-green);">
                            {{ strtoupper(substr($player->name, 0, 1)) }}
                        </div>
                        <div style="font-size:13px; font-weight:700; color:#111;">{{ $player->name }}</div>
                        @if($player->position)
                            <div style="font-size:11px; color:#9a9a9a; margin-top:2px;">{{ $player->position }}</div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
