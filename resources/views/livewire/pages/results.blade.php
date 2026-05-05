<div>
    {{-- HEADER --}}
    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:800; color:#004d26; margin-bottom:8px;">
            Match Results
        </h1>
        <p style="font-size:14px; color:#9a9a9a;">
            Recent match results and scores
        </p>
    </div>

    {{-- FILTERS --}}
    <div style="background:#fff; border-radius:12px; padding:16px; margin-bottom:20px; border:1px solid #e5e7eb;">
        <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
            <div style="flex:1; min-width:200px;">
                <label style="font-size:12px; font-weight:700; color:#004d26; display:block; margin-bottom:4px;">Search Teams</label>
                <input wire:model.live="search" type="text" placeholder="Search by team name..." style="width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:8px 12px; font-size:13px;">
            </div>
            <div>
                <label style="font-size:12px; font-weight:700; color:#004d26; display:block; margin-bottom:4px;">Sport</label>
                <select wire:model.live="sport" style="border:1px solid #e5e7eb; border-radius:8px; padding:8px 12px; font-size:13px; min-width:150px;">
                    <option value="">All Sports</option>
                    @foreach($sports as $s)
                        <option value="{{ $s->slug }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- RESULTS LIST --}}
    @if($results->count() > 0)
        <div style="background:#fff; border-radius:12px; padding:18px; border:1px solid #e5e7eb;">
            <div style="display:flex; flex-direction:column; gap:10px;">
                @foreach($results as $match)
                    <a href="{{ route('match.detail', $match->id) }}"
                       style="display:flex; align-items:center; padding:14px; background:#f9fafb; border-radius:10px; text-decoration:none; gap:12px; transition:background .15s;"
                       onmouseover="this.style.background='#f0f0f0'"
                       onmouseout="this.style.background='#f9fafb'">
                        <div style="flex:1; text-align:right;">
                            <div style="font-size:14px; font-weight:700; color:#111;">
                                {{ $match->homeTeam->name }}
                            </div>
                            @if($match->competition)
                                <div style="font-size:10px; color:#9a9a9a; margin-top:2px;">
                                    {{ Str::limit($match->competition->name, 30) }}
                                </div>
                            @endif
                        </div>
                        <div style="background:#111; color:#fff; border-radius:10px; padding:10px 16px; text-align:center; flex-shrink:0;">
                            <div style="font-size:20px; font-weight:800; letter-spacing:2px;">
                                {{ $match->home_score }} - {{ $match->away_score }}
                            </div>
                            <div style="font-size:9px; color:#aaa; margin-top:2px;">FT</div>
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:14px; font-weight:700; color:#111;">
                                {{ $match->awayTeam->name }}
                            </div>
                            <div style="font-size:10px; color:#9a9a9a; margin-top:2px;">
                                {{ $match->match_date->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div style="margin-top:20px;">
                {{ $results->links() }}
            </div>
        </div>
    @else
        <div style="background:#fff; border-radius:12px; padding:40px; text-align:center; border:1px solid #e5e7eb;">
            <div style="font-size:48px; margin-bottom:12px;">🏆</div>
            <div style="font-size:16px; font-weight:700; color:#111; margin-bottom:4px;">No Results Found</div>
            <div style="font-size:13px; color:#9a9a9a;">Try adjusting your search or filters</div>
        </div>
    @endif
</div>
