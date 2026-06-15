<div>
    {{-- MATCH HEADER --}}
    <div style="background:#fff; border-radius:12px; padding:24px; margin-bottom:20px; border:1px solid #e5e7eb;">
        {{-- Competition & Status --}}
        <div style="text-align:center; margin-bottom:16px;">
            @if($match->competition)
                <div style="font-size:13px; color:#9a9a9a; font-weight:600; margin-bottom:4px;">{{ $match->competition->name }}</div>
            @endif
            <div style="display:inline-block; background:{{ $match->status === 'live' ? 'var(--muk-red)' : ($match->status === 'finished' ? '#111' : 'var(--muk-green)') }}; color:#fff; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:700; text-transform:uppercase;">
                {{ $match->status === 'live' ? '● LIVE' : ($match->status === 'finished' ? 'FT' : 'Scheduled') }}
            </div>
        </div>

        {{-- Score Display --}}
        <div style="display:flex; align-items:center; justify-content:center; gap:20px; margin-bottom:16px;">
            {{-- Home Team --}}
            <div style="flex:1; text-align:center;">
                <div style="width:60px; height:60px; background:var(--muk-green); border-radius:12px; margin:0 auto 8px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:24px; font-weight:800;">
                    {{ strtoupper(substr($match->homeTeam->name, 0, 2)) }}
                </div>
                <div style="font-size:16px; font-weight:700; color:#111;">{{ $match->homeTeam->name }}</div>
            </div>

            {{-- Score --}}
            <div style="background:#111; color:#fff; border-radius:12px; padding:16px 24px; text-align:center;">
                <div style="font-size:36px; font-weight:800; letter-spacing:4px;">
                    @if($match->status !== 'scheduled')
                        {{ $match->home_score ?? 0 }} - {{ $match->away_score ?? 0 }}
                    @else
                        VS
                    @endif
                </div>
                @if($match->status === 'live' && $match->minute)
                    <div style="font-size:12px; color:#ff6b6b; margin-top:4px;">{{ $match->minute }}'</div>
                @endif
            </div>

            {{-- Away Team --}}
            <div style="flex:1; text-align:center;">
                <div style="width:60px; height:60px; background:var(--muk-green); border-radius:12px; margin:0 auto 8px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:24px; font-weight:800;">
                    {{ strtoupper(substr($match->awayTeam->name, 0, 2)) }}
                </div>
                <div style="font-size:16px; font-weight:700; color:#111;">{{ $match->awayTeam->name }}</div>
            </div>
        </div>

        {{-- Match Info --}}
        <div style="display:flex; justify-content:center; gap:20px; font-size:13px; color:#9a9a9a; padding-top:16px; border-top:1px solid #f0f0f0;">
            @if($match->match_date)
                <div>{{ $match->match_date->format('l, F d, Y') }} at {{ $match->match_date->format('H:i') }}</div>
            @endif
            @if($match->venue)
                <div>📍 {{ $match->venue->name }}</div>
            @endif
        </div>
    </div>

    {{-- MATCH EVENTS --}}
    @if($match->events->count() > 0)
        <div style="background:#fff; border-radius:12px; padding:20px; margin-bottom:20px; border:1px solid #e5e7eb;">
            <h3 style="font-size:16px; font-weight:800; color:var(--muk-green-dark); margin-bottom:16px;">Match Events</h3>
            <div style="display:flex; flex-direction:column; gap:10px;">
                @foreach($match->events->sortBy('minute') as $event)
                    <div style="display:flex; align-items:center; gap:12px; padding:10px; background:#f9fafb; border-radius:8px;">
                        <div style="font-size:12px; font-weight:700; color:var(--muk-green); width:40px; flex-shrink:0;">{{ $event->minute }}'</div>
                        <div style="font-size:18px;">
                            @if($event->type === 'goal') ⚽
                            @elseif($event->type === 'yellow_card') 🟨
                            @elseif($event->type === 'red_card') 🟥
                            @elseif($event->type === 'substitution') 🔄
                            @else 📋
                            @endif
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:13px; font-weight:700; color:#111;">{{ $event->type }}</div>
                            @if($event->player)
                                <div style="font-size:11px; color:#9a9a9a;">{{ $event->player->name }}</div>
                            @endif
                        </div>
                        @if($event->team)
                            <div style="font-size:11px; color:#9a9a9a;">{{ $event->team->name }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- LINEUPS (if available) --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
        {{-- Home Team Players --}}
        <div style="background:#fff; border-radius:12px; padding:20px; border:1px solid #e5e7eb;">
            <h3 style="font-size:14px; font-weight:800; color:var(--muk-green-dark); margin-bottom:12px;">{{ $match->homeTeam->name }}</h3>
            @if($match->homeTeam->players->count() > 0)
                <div style="display:flex; flex-direction:column; gap:8px;">
                    @foreach($match->homeTeam->players->take(11) as $player)
                        <div style="display:flex; align-items:center; gap:10px; padding:8px; background:#f9fafb; border-radius:8px;">
                            <div style="width:30px; height:30px; background:var(--muk-green); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:11px; font-weight:800;">
                                {{ $player->jersey_number ?? '#' }}
                            </div>
                            <div style="font-size:13px; font-weight:600; color:#111;">{{ $player->name }}</div>
                            @if($player->position)
                                <div style="font-size:10px; color:#9a9a9a; margin-left:auto;">{{ $player->position }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div style="font-size:12px; color:#9a9a9a; text-align:center; padding:10px 0;">Lineup not available</div>
            @endif
        </div>

        {{-- Away Team Players --}}
        <div style="background:#fff; border-radius:12px; padding:20px; border:1px solid #e5e7eb;">
            <h3 style="font-size:14px; font-weight:800; color:var(--muk-green-dark); margin-bottom:12px;">{{ $match->awayTeam->name }}</h3>
            @if($match->awayTeam->players->count() > 0)
                <div style="display:flex; flex-direction:column; gap:8px;">
                    @foreach($match->awayTeam->players->take(11) as $player)
                        <div style="display:flex; align-items:center; gap:10px; padding:8px; background:#f9fafb; border-radius:8px;">
                            <div style="width:30px; height:30px; background:var(--muk-green); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:11px; font-weight:800;">
                                {{ $player->jersey_number ?? '#' }}
                            </div>
                            <div style="font-size:13px; font-weight:600; color:#111;">{{ $player->name }}</div>
                            @if($player->position)
                                <div style="font-size:10px; color:#9a9a9a; margin-left:auto;">{{ $player->position }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div style="font-size:12px; color:#9a9a9a; text-align:center; padding:10px 0;">Lineup not available</div>
            @endif
        </div>
    </div>
</div>
