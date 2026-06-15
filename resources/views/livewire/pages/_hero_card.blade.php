@if($featuredMatch)
<a href="{{ route('match.detail', $featuredMatch->id) }}" class="live-card">
    <div class="live-card-header" style="{{ $featuredMatch->status === 'live' ? 'background:var(--muk-red);' : 'background:var(--muk-green);' }}">
        <span>{{ $featuredMatch->competition->name ?? 'MUK League' }}</span>
        @if($featuredMatch->status === 'live')
        <span class="live-badge">● LIVE {{ $featuredMatch->minute }}'</span>
        @elseif($featuredMatch->status === 'scheduled')
        <span>{{ $featuredMatch->match_date->format('d M, H:i') }}</span>
        @else
        <span>FT</span>
        @endif
    </div>
    <div class="live-card-body">
        <div class="live-card-team">
            <div class="live-card-logo">{{ strtoupper(substr($featuredMatch->homeTeam->name, 0, 2)) }}</div>
            <div class="live-card-name">{{ $featuredMatch->homeTeam->name }}</div>
        </div>
        <div class="live-card-score">
            @if($featuredMatch->status === 'live' || $featuredMatch->status === 'finished')
            <div class="score-big">{{ $featuredMatch->home_score }} — {{ $featuredMatch->away_score }}</div>
            @else
            <div class="vs-big">VS</div>
            <div class="time-small">{{ $featuredMatch->match_date->format('H:i') }}</div>
            @endif
        </div>
        <div class="live-card-team">
            <div class="live-card-logo">{{ strtoupper(substr($featuredMatch->awayTeam->name, 0, 2)) }}</div>
            <div class="live-card-name">{{ $featuredMatch->awayTeam->name }}</div>
        </div>
    </div>
    <div class="live-card-footer">
        {{ $featuredMatch->venue->name ?? 'Main Stadium' }}
    </div>
</a>
@else
<div class="live-card" style="opacity:.6;">
    <div class="live-card-header" style="background:var(--muk-green);">
        <span>No Live Match</span>
    </div>
    <div class="live-card-body" style="justify-content:center; align-items:center; min-height:200px;">
        <div style="text-align:center; color:rgba(255,255,255,.6);">
            <div style="font-size:36px; margin-bottom:8px;">🏟️</div>
            <div style="font-size:13px;">No match in progress</div>
        </div>
    </div>
</div>
@endif
