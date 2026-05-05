<div>
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:700px; margin:0 auto;">

        <div style="background:#fff; border-radius:16px; border:1px solid #e5e7eb; overflow:hidden;">
            <div style="background:var(--muk-green); padding:20px 24px;">
                <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">📊 Coach Statistics</h1>
            </div>

            @if(!$coach)
            <div style="padding:40px; text-align:center;">
                <div style="font-size:48px; margin-bottom:12px;">📭</div>
                <div style="font-size:18px; font-weight:700; color:#333; margin-bottom:4px;">No Coach Profile Found</div>
                <div style="font-size:14px; color:#888;">Please update your profile to start tracking your statistics.</div>
                <a href="{{ route('coach.profile') }}" style="display:inline-block; margin-top:16px; background:#CC0000; color:#fff; padding:10px 24px; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none;">Set Up Profile</a>
            </div>
            @else

            @if($stats['total_matches'] === 0)
            <div style="padding:40px; text-align:center;">
                <div style="font-size:48px; margin-bottom:12px;">📊</div>
                <div style="font-size:18px; font-weight:700; color:#333; margin-bottom:4px;">No Recent Stats</div>
                <div style="font-size:14px; color:#888;">Your team hasn't played any recorded matches yet. Stats will appear here once matches are completed.</div>
            </div>
            @else
            <div style="padding:24px;">
                <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:16px; margin-bottom:24px;">
                    <div style="text-align:center; padding:16px; background:#f0fdf4; border-radius:12px;">
                        <div style="font-size:28px; font-weight:900; color:var(--muk-green);">{{ $stats['total_matches'] }}</div>
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Total Matches</div>
                    </div>
                    <div style="text-align:center; padding:16px; background:#f0fdf4; border-radius:12px;">
                        <div style="font-size:28px; font-weight:900; color:var(--muk-green);">{{ $stats['wins'] }}</div>
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Wins</div>
                    </div>
                    <div style="text-align:center; padding:16px; background:#fefce8; border-radius:12px;">
                        <div style="font-size:28px; font-weight:900; color:#ca8a04;">{{ $stats['draws'] }}</div>
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Draws</div>
                    </div>
                    <div style="text-align:center; padding:16px; background:#fef2f2; border-radius:12px;">
                        <div style="font-size:28px; font-weight:900; color:#CC0000;">{{ $stats['losses'] }}</div>
                        <div style="font-size:11px; color:#888; text-transform:uppercase;">Losses</div>
                    </div>
                </div>

                <div style="text-align:center; padding:20px; background:var(--muk-green); border-radius:12px; margin-bottom:24px;">
                    <div style="font-size:40px; font-weight:900; color:#fff;">{{ $stats['win_rate'] }}%</div>
                    <div style="font-size:13px; color:rgba(255,255,255,.7); text-transform:uppercase; letter-spacing:1px;">Win Rate</div>
                </div>

                <div style="margin-bottom:24px;">
                    <h3 style="font-size:16px; font-weight:700; color:#333; margin-bottom:12px;">🏟 Teams Coached</h3>
                    @foreach($teams as $team)
                    <div style="display:flex; align-items:center; gap:12px; padding:12px; background:#f9fafb; border-radius:10px; margin-bottom:8px;">
                        <div style="width:40px; height:40px; background:var(--muk-green); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:14px; font-weight:700;">{{ strtoupper(substr($team->name, 0, 2)) }}</div>
                        <div style="flex:1;">
                            <div style="font-size:14px; font-weight:700;">{{ $team->name }}</div>
                            <div style="font-size:12px; color:#888;">{{ $team->sport->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @endif
        </div>
    </div>
</div>
</div>
