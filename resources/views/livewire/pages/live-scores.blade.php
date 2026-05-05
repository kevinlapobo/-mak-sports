<div>

{{-- Header --}}
<div style="display:flex; align-items:center; justify-content:space-between;
     margin-bottom:20px;">
    <div style="display:flex; align-items:center; gap:12px;">
        <span class="live-badge">● LIVE</span>
        <h1 style="font-size:22px; font-weight:800; color:#004d26; margin:0;">
            Live Scores
        </h1>
    </div>
    <div style="font-size:11px; color:#9a9a9a;">
        Auto-updates every 5s · Last: {{ $lastRefreshed }}
    </div>
</div>

{{-- Live matches --}}
@forelse($liveMatches as $match)
<div style="background:#fff; border-radius:14px; margin-bottom:16px;
     border:2px solid #CC0000; overflow:hidden;
     box-shadow:0 4px 16px rgba(204,0,0,.1);">

    {{-- Match header --}}
    <div style="background:#CC0000; padding:8px 16px;
         display:flex; align-items:center; justify-content:space-between;">
        <span style="font-size:11px; font-weight:700; color:#fff;">
            {{ $match->competition->name ?? 'Match' }}
        </span>
        <span class="live-badge" style="background:rgba(255,255,255,.2);">
            ● LIVE {{ $match->minute }}'
        </span>
    </div>

    {{-- Score --}}
    <div style="padding:20px 24px; display:flex; align-items:center;
         justify-content:space-between;">
        <div style="flex:1; text-align:center;">
            @if($match->homeTeam->logo)
            <img src="{{ asset('storage/'.$match->homeTeam->logo) }}"
                 style="width:50px; height:50px; object-fit:contain;
                 margin-bottom:8px;"/>
            @else
            <div style="width:50px; height:50px; background:#006633;
                 border-radius:50%; display:flex; align-items:center;
                 justify-content:center; font-size:20px; font-weight:800;
                 color:#fff; margin:0 auto 8px;">
                {{ strtoupper(substr($match->homeTeam->name, 0, 1)) }}
            </div>
            @endif
            <div style="font-size:15px; font-weight:800; color:#111;">
                {{ $match->homeTeam->name }}
            </div>
        </div>

        <div style="text-align:center; padding:0 20px;">
            <div style="font-size:42px; font-weight:800; color:#111;
                 letter-spacing:4px; line-height:1;">
                {{ $match->home_score }}
                <span style="color:#ccc;">-</span>
                {{ $match->away_score }}
            </div>
            <div style="font-size:11px; color:#CC0000; font-weight:700;
                 margin-top:4px;">
                {{ $match->minute }}'
            </div>
            @if($match->venue)
            <div style="font-size:10px; color:#9a9a9a; margin-top:4px;">
                📍 {{ $match->venue->name }}
            </div>
            @endif
        </div>

        <div style="flex:1; text-align:center;">
            @if($match->awayTeam->logo)
            <img src="{{ asset('storage/'.$match->awayTeam->logo) }}"
                 style="width:50px; height:50px; object-fit:contain;
                 margin-bottom:8px;"/>
            @else
            <div style="width:50px; height:50px; background:#006633;
                 border-radius:50%; display:flex; align-items:center;
                 justify-content:center; font-size:20px; font-weight:800;
                 color:#fff; margin:0 auto 8px;">
                {{ strtoupper(substr($match->awayTeam->name, 0, 1)) }}
            </div>
            @endif
            <div style="font-size:15px; font-weight:800; color:#111;">
                {{ $match->awayTeam->name }}
            </div>
        </div>
    </div>

    {{-- Match events --}}
    @if($match->events->count() > 0)
    <div style="border-top:1px solid #f0f0f0; padding:12px 16px;">
        <div style="font-size:11px; font-weight:700; color:#9a9a9a;
             text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">
            Match Events
        </div>
        @foreach($match->events->sortByDesc('minute') as $event)
        <div style="display:flex; align-items:center; gap:10px;
             padding:4px 0; font-size:12px; color:#333;">
            <span style="width:28px; font-size:10px; font-weight:700;
                  color:#9a9a9a; text-align:right; flex-shrink:0;">
                {{ $event->minute }}'
            </span>
            <span>
                @switch($event->event_type)
                    @case('goal')     ⚽ @break
                    @case('yellow_card') 🟨 @break
                    @case('red_card') 🟥 @break
                    @case('substitution') 🔄 @break
                    @case('penalty') 🎯 @break
                    @default 📋
                @endswitch
            </span>
            <span style="font-weight:600;">
                {{ $event->player->name ?? 'Unknown' }}
            </span>
            <span style="color:#9a9a9a;">
                ({{ $event->team->name ?? '' }})
            </span>
        </div>
        @endforeach
    </div>
    @endif

</div>
@empty

{{-- No live matches --}}
<div style="background:#fff; border-radius:14px; padding:48px 24px;
     text-align:center; border:1px solid #e5e7eb; margin-bottom:20px;">
    <div style="font-size:48px; margin-bottom:12px;">⚽</div>
    <div style="font-size:18px; font-weight:700; color:#111; margin-bottom:6px;">
        No live matches right now
    </div>
    <div style="font-size:13px; color:#9a9a9a;">
        Check fixtures for upcoming matches
    </div>
</div>

@endforelse

{{-- Upcoming today --}}
@if($upcomingToday->count() > 0)
<div style="background:#fff; border-radius:12px; padding:18px;
     border:1px solid #e5e7eb;">
    <h3 style="font-size:15px; font-weight:800; color:#004d26;
         margin-bottom:14px;">Starting Soon Today</h3>
    @foreach($upcomingToday as $match)
    <div style="display:flex; align-items:center; padding:10px 0;
         border-bottom:1px solid #f5f5f5;">
        <div style="font-size:14px; font-weight:700; color:#CC0000;
             width:50px; flex-shrink:0;">
            {{ $match->match_date->format('H:i') }}
        </div>
        <div style="flex:1; font-size:13px; font-weight:600; color:#111;">
            {{ $match->homeTeam->name }}
            <span style="color:#9a9a9a; font-weight:400;"> vs </span>
            {{ $match->awayTeam->name }}
        </div>
        <div style="font-size:11px; color:#9a9a9a;">
            {{ $match->venue?->name ?? 'TBD' }}
        </div>
    </div>
    @endforeach
</div>
@endif

</div>