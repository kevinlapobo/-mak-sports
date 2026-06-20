<div>
<div style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:960px; margin:0 auto; padding:0 16px;">

        <div style="background:linear-gradient(135deg, #1e7e34, #28A745); border-radius:16px 16px 0 0; padding:20px 24px;">
            <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">🆕 New Teams</h1>
            <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">Teams recently created by coaches</p>
        </div>

        <div style="background:#fff; border:1px solid #e5e7eb; border-top:none; border-radius:0 0 16px 16px; overflow:hidden;">

            {{-- Search --}}
            <div style="padding:16px 20px; border-bottom:1px solid #e5e7eb;">
                <input wire:model.live.debounce.300ms="search" placeholder="Search teams..." style="width:100%; max-width:320px; padding:9px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
            </div>

            <div class="table-wrap" style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:13px; min-width:700px;">
                    <thead>
                        <tr style="background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Team</th>
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Sport</th>
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Coach</th>
                            <th style="padding:12px 14px; text-align:center; font-weight:700; color:#333;">Players</th>
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Faculty</th>
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teams as $team)
                        <tr style="border-bottom:1px solid #f0f0f0;">
                            <td style="padding:12px 14px; font-weight:700;">
                                <a href="{{ route('team.detail', $team->slug) }}" style="color:var(--muk-green-dark); text-decoration:none;">{{ $team->name }}</a>
                            </td>
                            <td style="padding:12px 14px; font-size:12px; color:#555;">{{ $team->sport?->name ?? 'N/A' }}</td>
                            <td style="padding:12px 14px; font-size:12px; color:#555;">{{ $team->coach?->name ?? 'N/A' }}</td>
                            <td style="padding:12px 14px; text-align:center; font-weight:700; color:#333;">{{ $team->players->count() }}</td>
                            <td style="padding:12px 14px; font-size:12px; color:#555;">{{ $team->faculty ?? 'N/A' }}</td>
                            <td style="padding:12px 14px; font-size:12px; color:#888; white-space:nowrap;">{{ $team->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" style="padding:40px; text-align:center; color:#888;"><div style="font-size:36px; margin-bottom:8px;">🏆</div><div>No teams found.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($teams->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #e5e7eb;">{{ $teams->links() }}</div>
            @endif
        </div>
    </div>
</div>
</div>
