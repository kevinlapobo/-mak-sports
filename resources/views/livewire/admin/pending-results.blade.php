<div>
<div style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:960px; margin:0 auto; padding:0 16px;">

        <div style="background:linear-gradient(135deg, #b91c1c, #ef4444); border-radius:16px 16px 0 0; padding:20px 24px;">
            <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">⏳ Pending Results</h1>
            <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">Past fixtures awaiting scores</p>
        </div>

        <div style="background:#fff; border:1px solid #e5e7eb; border-top:none; border-radius:0 0 16px 16px; overflow:hidden;">

            <div style="padding:16px 20px; display:flex; gap:12px; border-bottom:1px solid #e5e7eb;">
                <select wire:model.live="sportFilter" style="padding:9px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:13px;">
                    <option value="">All Sports</option>
                    @foreach($sports as $sport)
                        <option value="{{ $sport->slug }}">{{ $sport->name }}</option>
                    @endforeach
                </select>
                <span style="font-size:13px; color:#888; align-self:center;">{{ $fixtures->total() }} pending</span>
            </div>

            <div class="table-wrap" style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:13px; min-width:650px;">
                    <thead>
                        <tr style="background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Date</th>
                            <th style="padding:12px 14px; text-align:left; font-weight:700; color:#333;">Sport</th>
                            <th style="padding:12px 14px; text-align:center; font-weight:700; color:#333;">Home</th>
                            <th style="padding:12px 14px; text-align:center; font-weight:700; color:#333;">Score</th>
                            <th style="padding:12px 14px; text-align:center; font-weight:700; color:#333;">Away</th>
                            <th style="padding:12px 14px; text-align:center; font-weight:700; color:#333;">Venue</th>
                            <th style="padding:12px 14px; text-align:center; font-weight:700; color:#333;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fixtures as $match)
                        <tr style="border-bottom:1px solid #f0f0f0; background:#fefce8; cursor:pointer; transition:background .15s;" onclick="window.location='{{ route('admin.manage-match', $match->id) }}'" onmouseover="this.style.background='#fef9c3'" onmouseout="this.style.background='#fefce8'">
                            <td style="padding:12px 14px; white-space:nowrap; font-size:12px; color:#b91c1c; font-weight:600;">
                                ⏳ {{ $match->match_date->format('d M Y') }}
                            </td>
                            <td style="padding:12px 14px; font-size:12px; color:#666;">{{ $match->competition?->sport?->name ?? 'N/A' }}</td>
                            <td style="padding:12px 14px; text-align:center; font-weight:700; color:var(--muk-green-dark);">{{ $match->homeTeam->name }}</td>
                            <td style="padding:12px 14px; text-align:center; font-weight:800; color:#b91c1c;">? - ?</td>
                            <td style="padding:12px 14px; text-align:center; font-weight:700; color:var(--muk-green-dark);">{{ $match->awayTeam->name }}</td>
                            <td style="padding:12px 14px; text-align:center; font-size:12px; color:#666;">{{ $match->venue?->name ?? '—' }}</td>
                            <td style="padding:12px 14px; text-align:center;">
                                <a href="{{ route('admin.manage-match', $match->id) }}" style="padding:6px 14px; background:#f59e0b; color:#fff; border:none; border-radius:6px; font-size:11px; font-weight:700; text-decoration:none; white-space:nowrap;">Manage</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" style="padding:40px; text-align:center; color:#888;">
                            <div style="font-size:48px; margin-bottom:8px;">✅</div>
                            <div style="font-size:14px;">All fixtures have results posted!</div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($fixtures->hasPages())
            <div style="padding:16px 20px; border-top:1px solid #e5e7eb;">{{ $fixtures->links() }}</div>
            @endif
        </div>
    </div>
</div>
</div>
