<div>
    {{-- PLAYER HEADER --}}
    <div style="background:#fff; border-radius:12px; padding:24px; margin-bottom:20px; border:1px solid #e5e7eb;">
        <div style="display:flex; gap:20px; align-items:center;">
            <div style="width:80px; height:80px; background:var(--muk-green); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:32px; font-weight:800; flex-shrink:0;">
                {{ strtoupper(substr($player->name, 0, 1)) }}
            </div>
            <div style="flex:1;">
                <h1 style="font-size:24px; font-weight:800; color:var(--muk-green-dark); margin-bottom:4px;">{{ $player->name }}</h1>
                @if($player->position)
                    <div style="font-size:16px; color:var(--muk-green); font-weight:700; margin-bottom:4px;">{{ $player->position }}</div>
                @endif
                @if($player->team)
                    <div style="font-size:14px; color:#9a9a9a;">
                        Team: <a href="{{ route('team.detail', $player->team->slug) }}" style="color:var(--muk-green); font-weight:700; text-decoration:none;">{{ $player->team->name }}</a>
                        @if($player->team->sport)
                            <span style="color:#9a9a9a;">({{ $player->team->sport->name }})</span>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- PLAYER INFO --}}
        @if($player->jersey_number || $player->date_of_birth || $player->height || $player->weight)
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(120px, 1fr)); gap:12px; margin-top:20px; padding-top:20px; border-top:1px solid #f0f0f0;">
                @if($player->jersey_number)
                    <div style="text-align:center; background:#f9fafb; border-radius:10px; padding:14px;">
                        <div style="font-size:24px; font-weight:800; color:var(--muk-green);">{{ $player->jersey_number }}</div>
                        <div style="font-size:11px; color:#9a9a9a; margin-top:4px;">Jersey #</div>
                    </div>
                @endif
                @if($player->date_of_birth)
                    <div style="text-align:center; background:#f9fafb; border-radius:10px; padding:14px;">
                        <div style="font-size:16px; font-weight:800; color:#111;">{{ \Carbon\Carbon::parse($player->date_of_birth)->age }}</div>
                        <div style="font-size:11px; color:#9a9a9a; margin-top:4px;">Age</div>
                    </div>
                @endif
                @if($player->height)
                    <div style="text-align:center; background:#f9fafb; border-radius:10px; padding:14px;">
                        <div style="font-size:16px; font-weight:800; color:#111;">{{ $player->height }}</div>
                        <div style="font-size:11px; color:#9a9a9a; margin-top:4px;">Height (cm)</div>
                    </div>
                @endif
                @if($player->weight)
                    <div style="text-align:center; background:#f9fafb; border-radius:10px; padding:14px;">
                        <div style="font-size:16px; font-weight:800; color:#111;">{{ $player->weight }}</div>
                        <div style="font-size:11px; color:#9a9a9a; margin-top:4px;">Weight (kg)</div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- STATISTICS --}}
    <div style="background:#fff; border-radius:12px; padding:20px; border:1px solid #e5e7eb;">
        <h3 style="font-size:16px; font-weight:800; color:var(--muk-green-dark); margin-bottom:16px;">Statistics</h3>
        <div style="font-size:14px; color:#9a9a9a; text-align:center; padding:20px 0;">
            Statistics will be available once matches are recorded
        </div>
    </div>
</div>
