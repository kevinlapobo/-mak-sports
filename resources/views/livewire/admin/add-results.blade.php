<div>
<div style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:960px; margin:0 auto; padding:0 16px;">

        <div style="background:linear-gradient(135deg, #d97706, #f59e0b); border-radius:16px 16px 0 0; padding:20px 24px;">
            <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">⚽ Add Results</h1>
            <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">Post scores for scheduled matches</p>
        </div>

        <div style="background:#fff; border:1px solid #e5e7eb; border-top:none; border-radius:0 0 16px 16px; overflow:hidden;">

            @if(session('success'))
            <div style="background:#f0fdf4; border-left:4px solid var(--muk-green); padding:12px 20px; margin:16px; border-radius:0 8px 8px 0; font-size:14px; font-weight:600; color:var(--muk-green);">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div style="background:#fef2f2; border-left:4px solid var(--muk-red); padding:12px 20px; margin:16px; border-radius:0 8px 8px 0; font-size:14px; font-weight:600; color:var(--muk-red);">❌ {{ session('error') }}</div>
            @endif

            {{-- Pending matches list --}}
            <div style="padding:16px 20px;">
                @forelse($matches as $match)
                <div style="padding:16px; border:1px solid #e5e7eb; border-radius:10px; margin-bottom:12px; {{ $match->match_date->isPast() ? 'background:#fefce8;' : 'background:#fff;' }} cursor:pointer; transition:background .15s;" onclick="window.location='{{ route('admin.manage-match', $match->id) }}'" onmouseover="this.style.borderColor='var(--muk-green)'" onmouseout="this.style.borderColor='#e5e7eb'">
                    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                        <div style="flex:1; min-width:200px;">
                            <div style="font-size:14px; font-weight:800; color:var(--muk-green-dark); margin-bottom:2px;">
                                {{ $match->homeTeam->name }} <span style="color:#888; font-weight:400;">vs</span> {{ $match->awayTeam->name }}
                            </div>
                            <div style="font-size:12px; color:#888;">
                                {{ $match->match_date->format('d M Y, H:i') }}
                                @if($match->venue) · {{ $match->venue->name }} @endif
                                @if($match->competition) · {{ $match->competition->name }} @endif
                            </div>
                        </div>
                        <a href="{{ route('admin.manage-match', $match->id) }}" style="padding:8px 18px; background:var(--muk-green); color:#fff; border-radius:8px; font-size:13px; font-weight:700; text-decoration:none; white-space:nowrap;">Manage Match →</a>
                    </div>
                </div>
                @empty
                <div style="padding:40px; text-align:center;">
                    <div style="font-size:48px; margin-bottom:8px;">📭</div>
                    <div style="font-size:16px; font-weight:700; color:#111; margin-bottom:4px;">No Matches Pending Results</div>
                    <div style="font-size:13px; color:#888;">All scheduled matches have scores posted.</div>
                </div>
                @endforelse
            </div>

            @if($matches->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #e5e7eb;">{{ $matches->links() }}</div>
            @endif
        </div>
    </div>
</div>
</div>
