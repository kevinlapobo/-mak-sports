<div>
<div class="container" style="padding-top:80px; padding-bottom:40px;">
    <div style="max-width:900px; margin:0 auto;">

        <div style="background:var(--muk-green); border-radius:16px 16px 0 0; padding:24px;">
            <h1 style="font-size:22px; font-weight:900; color:#fff; margin:0;">🏟 Browse Venues</h1>
            <p style="color:rgba(255,255,255,.7); font-size:13px; margin:4px 0 0;">Select a venue to make a booking</p>
        </div>

        <div style="background:#fff; border:1px solid #e5e7eb; border-top:none; border-radius:0 0 16px 16px; overflow:hidden;">
            @forelse($venues as $venue)
            <div style="display:flex; align-items:center; gap:16px; padding:20px; border-bottom:1px solid #f0f0f0; {{ $loop->last ? 'border-bottom:none;' : '' }}">
                <div style="width:56px; height:56px; background:var(--muk-green); border-radius:12px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:24px; flex-shrink:0;">
                    🏟
                </div>
                <div style="flex:1;">
                    <div style="font-size:16px; font-weight:700; color:#333;">{{ $venue->name }}</div>
                    <div style="font-size:13px; color:#888; margin-top:2px;">
                        📍 {{ $venue->location }} &bull; Capacity: {{ number_format($venue->capacity) }}
                    </div>
                </div>
                <a href="{{ route('venue.book', $venue->id) }}" style="background:var(--muk-red); color:#fff; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:700; text-decoration:none; white-space:nowrap;">
                    Book Now →
                </a>
            </div>
            @empty
            <div style="padding:40px; text-align:center;">
                <div style="font-size:48px; margin-bottom:12px;">🏟</div>
                <div style="font-size:18px; font-weight:700; color:#333; margin-bottom:4px;">No Venues Available</div>
                <div style="font-size:14px; color:#888;">Check back later for venue availability.</div>
            </div>
            @endforelse
        </div>
    </div>
</div>
</div>
