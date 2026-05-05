<div>

{{-- HERO SECTION --}}
<div class="hero">
    <div class="hero-pattern"></div>
    <div class="hero-inner">

        {{-- LEFT: Text --}}
        <div class="hero-left">
            <div class="hero-badge">
                <span class="live-badge" style="background:#CC0000; color:#fff;">
                    @if($liveMatches->count() > 0) ● {{ $liveMatches->count() }} LIVE @else MAK SPORTS @endif
                </span>
            </div>
            <div class="hero-label">Official Makerere University Sports Platform</div>
            <h1>
                Makerere<br />University<br /><span>Sports</span>
            </h1>
            <p>
                Live scores, fixtures, results and standings for all Makerere University sports. Free to view — register to unlock personalised features.
            </p>
            <div class="hero-ctas">
                <a href="{{ route('live') }}" class="btn-red">
                    @if($liveMatches->count() > 0) Watch Live @else View Live Scores @endif
                </a>
                <a href="{{ route('fixtures') }}" class="btn-ghost">See Fixtures</a>
                <a href="{{ route('standings') }}" class="btn-ghost">Standings</a>
            </div>

            {{-- Hero Stats --}}
            <div class="hero-stats">
                <div style="text-align:center;">
                    <div class="stat-num">{{ $stats['sports'] }}</div>
                    <div class="stat-label">Sports</div>
                </div>
                <div style="text-align:center;">
                    <div class="stat-num">{{ $stats['teams'] }}</div>
                    <div class="stat-label">Teams</div>
                </div>
                <div style="text-align:center;">
                    <div class="stat-num">{{ $stats['matches'] }}</div>
                    <div class="stat-label">Matches</div>
                </div>
                <div style="text-align:center;">
                    <div class="stat-num">{{ $stats['players'] }}</div>
                    <div class="stat-label">Players</div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Live Match Card --}}
        <div class="hero-right">
            @if($featuredMatch)
            <a href="{{ route('match.detail', $featuredMatch->id) }}" class="live-card">
                <div class="live-card-header" style="{{ $featuredMatch->status === 'live' ? 'background:#CC0000;' : 'background:var(--muk-green);' }}">
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
        </div>

    </div>
</div>

{{-- LIVE BANNER (auth only, just after hero) --}}
@auth
@if($liveMatches->count() > 0)
<div style="background:#CC0000; overflow:hidden; white-space:nowrap;">
    <div style="display:inline-flex; animation:ticker 30s linear infinite; gap:60px; padding:12px 0;">
        @foreach($liveMatches as $match)
        <span style="font-size:14px; font-weight:700; color:#fff; display:inline-flex; align-items:center; gap:10px;">
            <span class="live-badge">● LIVE</span>
            {{ $match->homeTeam->name }}
            <span style="background:rgba(255,255,255,.2); padding:4px 12px; border-radius:5px; letter-spacing:1px; font-size:16px;">
                {{ $match->home_score }} - {{ $match->away_score }}
            </span>
            {{ $match->awayTeam->name }}
            <span style="font-size:12px; opacity:.9;">{{ $match->minute }}'</span>
            <a href="{{ route('match.detail', $match->id) }}" style="color:#fff; font-size:12px; text-decoration:underline;">View Match →</a>
        </span>
        @endforeach
    </div>
</div>
@endif
@endauth

{{-- SPORTS NAVIGATION PILLS --}}
<div class="section-sm" style="background:#fff; border-bottom:1px solid #e5e7eb;">
    <div class="container">
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            @foreach($sports as $sport)
            <a href="{{ route('fixtures', ['sport' => $sport->slug]) }}" class="sport-pill">
                <span style="font-size:18px;">{{ $sport->icon }}</span>
                <span>{{ $sport->name }}</span>
                @if($sport->teams_count > 0)
                <span style="background:var(--muk-green); color:#fff; font-size:10px; padding:2px 7px; border-radius:999px;">{{ $sport->teams_count }}</span>
                @endif
            </a>
            @endforeach
        </div>
    </div>
</div>

{{-- MAIN CONTENT GRID --}}
<div class="section" style="background:#f5f5f5;">
    <div class="container">
        <div style="display:grid; grid-template-columns:2fr 1fr; gap:24px;">

            {{-- LEFT COLUMN --}}
            <div>
                {{-- TODAY'S FIXTURES --}}
                @if($todayFixtures->count() > 0)
                <div style="margin-bottom:28px;">
                    <div class="section-title">Today's Fixtures</div>
                    <div class="section-heading">{{ today()->format('l, F j, Y') }}</div>
                    <div style="margin-top:16px; display:flex; flex-direction:column; gap:10px;">
                        @foreach($todayFixtures->take(4) as $match)
                        <a href="{{ route('match.detail', $match->id) }}" class="match-card">
                            <div class="match-card-header">
                                <span>{{ $match->competition->name ?? 'Friendly' }}</span>
                                <span>{{ $match->match_date->format('H:i') }}</span>
                            </div>
                            <div class="match-card-body">
                                <div class="team-side">
                                    <div class="team-logo">{{ strtoupper(substr($match->homeTeam->name, 0, 2)) }}</div>
                                    <div class="team-name">{{ $match->homeTeam->name }}</div>
                                </div>
                                <div class="vs-box">
                                    <div class="vs">VS</div>
                                    <div class="time">{{ $match->match_date->format('H:i') }}</div>
                                </div>
                                <div class="team-side">
                                    <div class="team-logo">{{ strtoupper(substr($match->awayTeam->name, 0, 2)) }}</div>
                                    <div class="team-name">{{ $match->awayTeam->name }}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @if($todayFixtures->count() > 4)
                    <a href="{{ route('fixtures') }}" style="display:block; text-align:center; margin-top:12px; font-size:13px; color:var(--muk-green); font-weight:700; text-decoration:none;">
                        View all fixtures →
                    </a>
                    @endif
                </div>
                @endif

                {{-- RECENT RESULTS --}}
                @if($recentResults->count() > 0)
                <div>
                    <div class="section-title">Recent Results</div>
                    <div class="section-heading">Latest Match Outcomes</div>
                    <div style="margin-top:16px; display:grid; grid-template-columns:repeat(2, 1fr); gap:12px;">
                        @foreach($recentResults->take(4) as $match)
                        <a href="{{ route('match.detail', $match->id) }}" class="match-card">
                            <div class="match-card-header" style="background:#111;">
                                <span>{{ $match->competition->name ?? '' }}</span>
                                <span>FT</span>
                            </div>
                            <div class="match-card-body" style="padding:14px 12px;">
                                <div class="team-side">
                                    <div class="team-name" style="font-size:12px;">{{ $match->homeTeam->name }}</div>
                                </div>
                                <div class="score-box" style="padding:8px 12px;">
                                    <div class="score" style="font-size:20px;">{{ $match->home_score }}-{{ $match->away_score }}</div>
                                </div>
                                <div class="team-side">
                                    <div class="team-name" style="font-size:12px;">{{ $match->awayTeam->name }}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <a href="{{ route('results') }}" style="display:block; text-align:center; margin-top:12px; font-size:13px; color:var(--muk-green); font-weight:700; text-decoration:none;">
                        View all results →
                    </a>
                </div>
                @endif
            </div>

            {{-- RIGHT COLUMN --}}
            <div>
                {{-- STANDINGS PREVIEW (auth only) --}}
                @auth
                @if($standingsPreview->count() > 0)
                <div style="background:#fff; border-radius:14px; border:1px solid #e8e8e8; overflow:hidden; margin-bottom:20px;">
                    <div style="background:var(--muk-green); padding:12px 16px;">
                        <div style="font-size:14px; font-weight:800; color:#fff;">
                            {{ $topCompetition->name ?? 'League' }} Standings
                        </div>
                    </div>
                    <table class="standings-table">
                        <thead>
                            <tr>
                                <th style="text-align:left;">#</th>
                                <th style="text-align:left;">Team</th>
                                <th>P</th>
                                <th>GD</th>
                                <th>Pts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($standingsPreview as $i => $standing)
                            <tr class="{{ $i < 3 ? 'top3' : '' }}">
                                <td class="pos">{{ $i + 1 }}</td>
                                <td style="font-size:12px; font-weight:600;">{{ $standing->team->name ?? 'N/A' }}</td>
                                <td>{{ $standing->played ?? 0 }}</td>
                                <td style="color:{{ ($standing->goal_difference ?? 0) >= 0 ? 'var(--muk-green)' : '#CC0000' }}; font-weight:600;">{{ $standing->goal_difference ?? 0 }}</td>
                                <td class="pts">{{ $standing->points ?? 0 }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('standings') }}" style="display:block; text-align:center; padding:10px; font-size:12px; color:var(--muk-green); font-weight:700; text-decoration:none; border-top:1px solid #f0f0f0;">
                        View full standings →
                    </a>
                </div>
                @endif
                @endauth

                @guest
                {{-- LOGIN PROMPT FOR GUESTS --}}
                <div style="background:linear-gradient(135deg, #CC0000 0%, #990000 100%); border-radius:14px; overflow:hidden; margin-bottom:20px; padding:24px; text-align:center;">
                    <div style="font-size:32px; margin-bottom:8px;">🔒</div>
                    <div style="font-size:16px; font-weight:800; color:#fff; margin-bottom:4px;">Live Scores & Standings</div>
                    <div style="font-size:12px; color:rgba(255,255,255,.7); margin-bottom:16px;">Sign in or create a free account to view live scores, league standings, and personalised content.</div>
                    <a href="{{ route('login') }}" style="display:inline-block; background:#fff; color:#CC0000; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:700; text-decoration:none; margin-right:8px;">Sign In</a>
                    <a href="{{ route('register') }}" style="display:inline-block; background:rgba(255,255,255,.15); color:#fff; border:1.5px solid rgba(255,255,255,.3); padding:10px 20px; border-radius:8px; font-size:13px; font-weight:700; text-decoration:none;">Register</a>
                </div>
                @endguest

                {{-- TOP SCORERS --}}
                @if($topScorers->count() > 0)
                <div style="background:#fff; border-radius:14px; border:1px solid #e8e8e8; overflow:hidden; margin-bottom:20px;">
                    <div style="background:var(--muk-green); padding:12px 16px;">
                        <div style="font-size:14px; font-weight:800; color:#fff;">⚽ Top Scorers</div>
                    </div>
                    <div style="padding:12px;">
                        @foreach($topScorers as $i => $player)
                        <div style="display:flex; align-items:center; gap:10px; padding:8px 0; {{ !$loop->last ? 'border-bottom:1px solid #f0f0f0;' : '' }}">
                            <div style="font-size:12px; font-weight:800; color:#888; width:20px;">{{ $i + 1 }}</div>
                            <div style="width:32px; height:32px; background:var(--muk-green); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:12px; font-weight:700;">{{ strtoupper(substr($player->name, 0, 1)) }}</div>
                            <div style="flex:1;">
                                <div style="font-size:13px; font-weight:600;">{{ $player->name }}</div>
                                @if($player->team)
                                <div style="font-size:10px; color:#888;">{{ $player->team->name }}</div>
                                @endif
                            </div>
                            <div style="background:var(--muk-green); color:#fff; padding:4px 10px; border-radius:6px; font-size:14px; font-weight:800;">{{ $player->goals }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- QUICK LINKS --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <a href="{{ route('live') }}" style="background:#CC0000; color:#fff; padding:16px; border-radius:12px; text-align:center; text-decoration:none;">
                        <div style="font-size:24px; font-weight:900;">● LIVE</div>
                        <div style="font-size:11px; opacity:.8;">Live Scores</div>
                    </a>
                    <a href="{{ route('teams') }}" style="background:#fff; border:1px solid #e5e7eb; padding:16px; border-radius:12px; text-align:center; text-decoration:none;">
                        <div style="font-size:24px; font-weight:900;">🏅</div>
                        <div style="font-size:11px; color:#888;">Teams</div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- NEWS SLIDER SECTION --}}
@if($latestNews->count() > 0)
<div class="section" style="background:#fff;">
    <div class="container">
        <div class="section-title">Latest News</div>
        <div class="section-heading">Happening Around Campus</div>
        <p class="section-sub">Stories about sports, players, and innovations across Makerere University</p>

        <div class="news-slider-wrapper" id="newsSliderWrapper">
            <button class="slider-btn slider-prev" id="sliderPrev">‹</button>
            <div class="news-slider" id="newsSlider">
                @foreach($latestNews as $news)
                <a href="{{ route('news.detail', $news->id) }}" class="news-card slider-item">
                    <div style="height:160px; background:linear-gradient(135deg, var(--muk-green) 0%, var(--muk-green-dark) 100%); display:flex; align-items:center; justify-content:center; color:#fff; font-size:32px;">📰</div>
                    <div class="news-body">
                        <div class="news-tag">{{ $news->category ?? 'Sports' }}</div>
                        <div class="news-title">{{ Str::limit($news->title, 80) }}</div>
                        <div class="news-date">{{ $news->published_at?->format('d M, Y') ?? 'Recent' }}</div>
                    </div>
                </a>
                @endforeach
            </div>
            <button class="slider-btn slider-next" id="sliderNext">›</button>
            <div class="slider-dots" id="sliderDots"></div>
        </div>
    </div>
</div>
@endif

{{-- REGISTER CTA --}}
@guest
<div class="section" style="background:linear-gradient(135deg, #CC0000 0%, #990000 100%); text-align:center;">
    <div class="container">
        <div style="font-size:28px; font-weight:900; color:#fff; margin-bottom:8px;">Get Your Personalised Sports Experience</div>
        <div style="font-size:15px; color:rgba(255,255,255,.7); margin-bottom:24px;">Register as a Student, Player, or Coach to access tailored content</div>
        <a href="{{ route('register') }}" class="btn-red" style="font-size:16px; padding:14px 32px;">Create Free Account</a>
    </div>
</div>
@endguest

</div>

<style>
@keyframes ticker {
    0% { transform: translateX(100vw); }
    100% { transform: translateX(-100%); }
}

.hero-inner {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 40px;
    align-items: center;
}
.hero-label {
    font-size: 12px;
    font-weight: 700;
    color: rgba(255,255,255,.6);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 8px;
}
.hero h1 {
    font-size: clamp(36px, 5vw, 56px);
    font-weight: 900;
    color: #fff;
    line-height: 1.05;
    margin-bottom: 16px;
    letter-spacing: -1px;
}
.hero h1 span { color: #CC0000; }
.hero-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-top: 40px;
    max-width: 400px;
}
.stat-num {
    font-size: 28px;
    font-weight: 900;
    color: #CC0000;
}
.stat-label {
    font-size: 11px;
    color: rgba(255,255,255,.6);
    text-transform: uppercase;
    letter-spacing: .5px;
}

/* LIVE CARD */
.live-card {
    background: var(--muk-green-dark);
    border-radius: 16px;
    overflow: hidden;
    text-decoration: none;
    box-shadow: 0 20px 60px rgba(0,0,0,.4);
    transition: transform .2s, box-shadow .2s;
}
.live-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 28px 70px rgba(0,0,0,.5);
}
.live-card-header {
    padding: 10px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.live-card-header span {
    font-size: 10px;
    font-weight: 700;
    color: rgba(255,255,255,.85);
    text-transform: uppercase;
    letter-spacing: .5px;
}
.live-card-body {
    padding: 24px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.live-card-team {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    text-align: center;
}
.live-card-logo {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(255,255,255,.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 800;
    color: #fff;
}
.live-card-name {
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
}
.live-card-score {
    background: rgba(0,0,0,.4);
    border-radius: 10px;
    padding: 12px 20px;
    text-align: center;
    flex-shrink: 0;
}
.score-big {
    font-size: 24px;
    font-weight: 900;
    color: #fff;
    letter-spacing: 2px;
    line-height: 1;
}
.vs-big {
    font-size: 18px;
    font-weight: 900;
    color: rgba(255,255,255,.4);
}
.time-small {
    font-size: 11px;
    color: #CC0000;
    font-weight: 700;
    margin-top: 4px;
}
.live-card-footer {
    padding: 8px 16px;
    background: rgba(0,0,0,.15);
    font-size: 11px;
    color: rgba(255,255,255,.4);
    text-align: center;
}

/* RED BUTTON */
.btn-red {
    background: #CC0000;
    color: #fff;
    padding: 12px 24px;
    border-radius: 9px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    transition: background .15s;
    display: inline-block;
}
.btn-red:hover { background: #990000; }

/* NEWS SLIDER */
.news-slider-wrapper {
    position: relative;
    overflow: hidden;
}
.news-slider {
    display: flex;
    gap: 16px;
    overflow-x: hidden;
    padding: 4px 0 16px;
}
.slider-item {
    min-width: 260px;
    max-width: 260px;
    flex-shrink: 0;
    transition: transform .4s ease, opacity .4s ease;
}
.slider-item.active-slide {
    transform: scale(1.03);
}
.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #fff;
    border: 1px solid #e5e7eb;
    font-size: 20px;
    font-weight: 700;
    color: var(--muk-green);
    cursor: pointer;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
    transition: background .15s, transform .15s;
}
.slider-btn:hover { background: #f5f5f5; transform: translateY(-50%) scale(1.1); }
.slider-prev { left: -8px; }
.slider-next { right: -8px; }

/* Slider progress dots */
.slider-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 16px;
}
.slider-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ddd;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: background .3s, transform .3s;
}
.slider-dot.active-dot {
    background: var(--muk-green);
    transform: scale(1.3);
}

@media (max-width:900px) {
    .hero-inner { grid-template-columns: 1fr; }
    .hero-right { display: none; }
    .hero-stats { grid-template-columns: repeat(2, 1fr) !important; }
    .slider-item { min-width: 220px; max-width: 220px; }
}
</style>

<script>
(function() {
    var slider    = document.getElementById('newsSlider');
    var wrapper   = document.getElementById('newsSliderWrapper');
    var dotsWrap  = document.getElementById('sliderDots');
    var btnPrev   = document.getElementById('sliderPrev');
    var btnNext   = document.getElementById('sliderNext');
    if (!slider || !slider.children.length) return;

    var items   = slider.querySelectorAll('.slider-item');
    var total   = items.length;
    var current = 0;
    var autoTimer = null;
    var itemW   = 276; /* 260px + 16px gap */

    /* Build dots */
    for (var i = 0; i < total; i++) {
        var dot = document.createElement('button');
        dot.className = 'slider-dot' + (i === 0 ? ' active-dot' : '');
        dot.setAttribute('aria-label', 'Slide ' + (i + 1));
        dot.addEventListener('click', (function(idx) {
            return function() { goTo(idx); resetAuto(); };
        })(i));
        dotsWrap.appendChild(dot);
    }
    var dots = dotsWrap.querySelectorAll('.slider-dot');

    function goTo(index) {
        if (index < 0) index = total - 1;
        if (index >= total) index = 0;
        current = index;
        slider.scrollTo({ left: current * itemW, behavior: 'smooth' });
        dots.forEach(function(d, i) { d.classList.toggle('active-dot', i === current); });
        items.forEach(function(it, i) { it.classList.toggle('active-slide', i === current); });
    }

    function nextSlide() { goTo(current + 1); }
    function prevSlide() { goTo(current - 1); }

    btnNext.addEventListener('click', function() { nextSlide(); resetAuto(); });
    btnPrev.addEventListener('click', function() { prevSlide(); resetAuto(); });

    function startAuto() {
        autoTimer = setInterval(nextSlide, 3500);
    }
    function resetAuto() {
        clearInterval(autoTimer);
        startAuto();
    }

    /* Pause on hover */
    wrapper.addEventListener('mouseenter', function() { clearInterval(autoTimer); });
    wrapper.addEventListener('mouseleave', function() { startAuto(); });

    /* Keyboard support */
    wrapper.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowRight') { nextSlide(); resetAuto(); }
        if (e.key === 'ArrowLeft')  { prevSlide(); resetAuto(); }
    });

    /* Touch swipe support */
    var startX = 0;
    slider.addEventListener('touchstart', function(e) { startX = e.touches[0].clientX; }, { passive: true });
    slider.addEventListener('touchend', function(e) {
        var diff = startX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) {
            if (diff > 0) nextSlide(); else prevSlide();
            resetAuto();
        }
    }, { passive: true });

    /* Init */
    goTo(0);
    startAuto();
})();
</script>
