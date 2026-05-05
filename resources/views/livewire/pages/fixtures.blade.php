<div>
    {{-- HEADER --}}
    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:800; color:#004d26; margin-bottom:8px;">
            Upcoming Fixtures
        </h1>
        <p style="font-size:14px; color:#9a9a9a;">
            Don't miss any of the upcoming matches
        </p>
    </div>

    {{-- FILTERS --}}
    <div style="background:#fff; border-radius:12px; padding:16px; margin-bottom:20px; border:1px solid #e5e7eb;">
        <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
            <div>
                <label style="font-size:12px; font-weight:700; color:#004d26; display:block; margin-bottom:4px;">Sport</label>
                <select wire:model.live="sport" style="border:1px solid #e5e7eb; border-radius:8px; padding:8px 12px; font-size:13px; min-width:150px;">
                    <option value="">All Sports</option>
                    @foreach($sports as $s)
                        <option value="{{ $s->slug }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:12px; font-weight:700; color:#004d26; display:block; margin-bottom:4px;">Period</label>
                <select wire:model.live="dateRange" style="border:1px solid #e5e7eb; border-radius:8px; padding:8px 12px; font-size:13px;">
                    <option value="upcoming">All Upcoming</option>
                    <option value="today">Today</option>
                    <option value="this_week">This Week</option>
                </select>
            </div>
        </div>
    </div>

    {{-- FIXTURES BY DATE --}}
    @forelse($fixtures as $date => $dayFixtures)
        <div style="margin-bottom:24px;">
            <h3 style="font-size:15px; font-weight:800; color:#004d26; margin-bottom:12px; padding-bottom:8px; border-bottom:2px solid #006633;">
                {{ \Carbon\Carbon::parse($date)->format('l, F d, Y') }}
            </h3>
            <div style="display:flex; flex-direction:column; gap:10px;">
                @foreach($dayFixtures as $match)
                    <a href="{{ route('match.detail', $match->id) }}"
                       style="display:flex; align-items:center; padding:14px; background:#fff; border-radius:10px; text-decoration:none; border:1px solid #e5e7eb; transition:box-shadow .15s;"
                       onmouseover="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.1)'"
                       onmouseout="this.style.boxShadow='none'">
                        <div style="font-size:12px; color:#9a9a9a; font-weight:600; width:60px; flex-shrink:0; text-align:center;">
                            {{ $match->match_date->format('H:i') }}
                        </div>
                        <div style="flex:1; display:flex; align-items:center; justify-content:center; gap:12px;">
                            <span style="font-size:14px; font-weight:700; color:#111; text-align:right; flex:1;">
                                {{ $match->homeTeam->name }}
                            </span>
                            <span style="background:#006633; color:#fff; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:700;">
                                VS
                            </span>
                            <span style="font-size:14px; font-weight:700; color:#111; flex:1;">
                                {{ $match->awayTeam->name }}
                            </span>
                        </div>
                        @if($match->competition)
                            <div style="font-size:10px; color:#9a9a9a; width:120px; text-align:right; flex-shrink:0;">
                                {{ Str::limit($match->competition->name, 25) }}
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    @empty
        <div style="background:#fff; border-radius:12px; padding:40px; text-align:center; border:1px solid #e5e7eb;">
            <div style="font-size:48px; margin-bottom:12px;">📅</div>
            <div style="font-size:16px; font-weight:700; color:#111; margin-bottom:4px;">No Fixtures Found</div>
            <div style="font-size:13px; color:#9a9a9a;">Try adjusting your filters</div>
        </div>
    @endforelse
</div>
