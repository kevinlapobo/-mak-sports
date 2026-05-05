<div>
    {{-- HEADER --}}
    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:800; color:#004d26; margin-bottom:8px;">
            League Standings
        </h1>
        <p style="font-size:14px; color:#9a9a9a;">
            Current standings across all competitions
        </p>
    </div>

    {{-- SPORT FILTER --}}
    @if($sports->count() > 0)
        <div style="margin-bottom:16px; display:flex; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('standings') }}"
               style="background:{{ !$sport ? '#006633' : '#fff' }}; color:{{ !$sport ? '#fff' : '#111' }}; border:1.5px solid #e5e7eb; border-radius:10px; padding:8px 14px; text-decoration:none; font-size:12px; font-weight:700;">
                All
            </a>
            @foreach($sports as $s)
                <a href="{{ route('standings', ['sport' => $s->slug]) }}"
                   style="background:{{ $sport === $s->slug ? '#006633' : '#fff' }}; color:{{ $sport === $s->slug ? '#fff' : '#111' }}; border:1.5px solid #e5e7eb; border-radius:10px; padding:8px 14px; text-decoration:none; font-size:12px; font-weight:700;">
                    {{ $s->icon }} {{ $s->name }}
                </a>
            @endforeach
        </div>
    @endif

    {{-- COMPETITION TABS --}}
    @if($competitions->count() > 0)
        <div style="background:#fff; border-radius:12px; padding:12px; margin-bottom:20px; border:1px solid #e5e7eb; display:flex; gap:8px; flex-wrap:wrap;">
            @foreach($competitions as $comp)
                <button wire:click="selectCompetition({{ $comp->id }})"
                        style="background:{{ $competitionId === $comp->id ? '#006633' : '#f9fafb' }}; color:{{ $competitionId === $comp->id ? '#fff' : '#111' }}; border:none; border-radius:8px; padding:8px 14px; font-size:12px; font-weight:700; cursor:pointer;">
                    {{ $comp->name }}
                    @if($comp->sport)
                        <span style="opacity:0.7;">({{ $comp->sport->name }})</span>
                    @endif
                </button>
            @endforeach
        </div>
    @endif

    {{-- STANDINGS TABLE --}}
    @if($standings->count() > 0 && $competition)
        <div style="background:#fff; border-radius:12px; overflow:hidden; border:1px solid #e5e7eb;">
            {{-- Competition Header --}}
            <div style="background:#006633; color:#fff; padding:14px 18px;">
                <div style="font-size:16px; font-weight:800;">{{ $competition->name }}</div>
                @if($competition->sport)
                    <div style="font-size:11px; opacity:0.8;">{{ $competition->sport->name }}</div>
                @endif
            </div>

            {{-- Table Header --}}
            <div style="display:grid; grid-template-columns:40px 1fr repeat(7, 50px); gap:4px; padding:10px 14px; background:#f9fafb; border-bottom:1px solid #e5e7eb; font-size:11px; font-weight:700; color:#004d26; text-align:center;">
                <div>#</div>
                <div style="text-align:left;">Team</div>
                <div>P</div>
                <div>W</div>
                <div>D</div>
                <div>L</div>
                <div>GD</div>
                <div>PTS</div>
            </div>

            {{-- Table Rows --}}
            @foreach($standings as $index => $standing)
                <div style="display:grid; grid-template-columns:40px 1fr repeat(7, 50px); gap:4px; padding:10px 14px; border-bottom:1px solid #f0f0f0; font-size:13px; text-align:center; align-items:center; {{ $index < 2 ? 'background:#f0faf4;' : '' }}"
                     onmouseover="this.style.background='#f9fafb'"
                     onmouseout="this.style.background='{{ $index < 2 ? '#f0faf4' : '#fff' }}'">
                    <div style="font-weight:800; color:#004d26;">{{ $index + 1 }}</div>
                    <div style="text-align:left; font-weight:700; color:#111; display:flex; align-items:center; gap:8px;">
                        @if($standing->team)
                            {{ $standing->team->name }}
                        @endif
                    </div>
                    <div>{{ $standing->played ?? 0 }}</div>
                    <div>{{ $standing->wins ?? 0 }}</div>
                    <div>{{ $standing->draws ?? 0 }}</div>
                    <div>{{ $standing->losses ?? 0 }}</div>
                    <div style="color:{{ ($standing->goal_difference ?? 0) >= 0 ? '#006633' : '#CC0000' }}; font-weight:700;">
                        {{ ($standing->goal_difference ?? 0) > 0 ? '+' : '' }}{{ $standing->goal_difference ?? 0 }}
                    </div>
                    <div style="font-weight:800; color:#004d26;">{{ $standing->points ?? 0 }}</div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background:#fff; border-radius:12px; padding:40px; text-align:center; border:1px solid #e5e7eb;">
            <div style="font-size:48px; margin-bottom:12px;">📊</div>
            <div style="font-size:16px; font-weight:700; color:#111; margin-bottom:4px;">No Standings Available</div>
            <div style="font-size:13px; color:#9a9a9a;">Select a competition to view standings</div>
        </div>
    @endif
</div>
