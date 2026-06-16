<div>

{{-- HERO SECTION — Stadium pitch --}}
<div class="hero-static">
    <div class="hero-inner">
        <div class="hero-left">
            <div class="hero-badge">
                <span class="live-badge" style="background:var(--muk-red); color:#fff;">
                    @if($liveMatches->count() > 0) ● {{ $liveMatches->count() }} LIVE @else MAK SPORTS @endif
                </span>
            </div>
            <div class="hero-label">Official Makerere University Sports Platform</div>
            <h1>Where Legends<br />Are Made<br /><span>#MUKPride</span></h1>
            <p>Every match tells a story. Every athlete inspires. Join the legacy of Makerere University sports excellence.</p>
            <div class="hero-ctas">
                <a href="{{ route('standings') }}" class="btn-hero">View Standings</a>
                <a href="{{ route('fixtures') }}" class="btn-hero-outline">Upcoming Matches</a>
                <a href="{{ route('register') }}" class="btn-hero-outline">Join the Team</a>
            </div>
            <div class="hero-stats">
                <div><div class="stat-num">{{ $stats['sports'] }}</div><div class="stat-label">Sports</div></div>
                <div><div class="stat-num">{{ $stats['teams'] }}</div><div class="stat-label">Teams</div></div>
                <div><div class="stat-num">{{ $stats['matches'] }}</div><div class="stat-label">Matches</div></div>
                <div><div class="stat-num">{{ $stats['players'] }}</div><div class="stat-label">Players</div></div>
            </div>
        </div>
        <div class="hero-right">@include('livewire.pages._hero_card', ['featuredMatch' => $featuredMatch])</div>
    </div>
</div>

{{-- LIVE BANNER (auth only, just after hero) --}}
@auth
@if($liveMatches->count() > 0)
<div style="background:var(--muk-red); overflow:hidden; white-space:nowrap;">
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
        <div class="home-grid" style="display:grid; grid-template-columns:2fr 1fr; gap:24px;">

            {{-- LEFT COLUMN --}}
            <div>
                {{-- TODAY'S FIXTURES --}}
                @if($todayFixtures->count() > 0)
                <div style="margin-bottom:28px;" class="reveal">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:4px;">
                        <div class="section-title" style="margin-bottom:0;">Today's Fixtures</div>
                        <span style="font-size:11px; color:#9ca3af; font-weight:500;">{{ today()->format('l, F j, Y') }}</span>
                    </div>
                    <div style="margin-top:16px; display:flex; flex-direction:column; gap:10px;">
                        @foreach($todayFixtures->take(4) as $match)
                        <a href="{{ route('match.detail', $match->id) }}" class="match-card" style="border-radius:12px; border:1px solid #e8e8e8; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                            <div class="match-card-header" style="background:linear-gradient(135deg, var(--muk-green) 0%, var(--muk-green-dark) 100%); padding:8px 14px;">
                                <span style="display:flex; align-items:center; gap:6px; font-size:10px; font-weight:700; color:rgba(255,255,255,.85); text-transform:uppercase; letter-spacing:.5px;">
                                    <span style="width:6px; height:6px; border-radius:50%; background:rgba(255,255,255,.4);"></span>
                                    {{ $match->competition->name ?? 'Friendly' }}
                                </span>
                                <span style="background:rgba(255,255,255,.15); padding:2px 8px; border-radius:4px; font-size:10px; font-weight:700; color:#fff;">{{ $match->match_date->format('H:i') }}</span>
                            </div>
                            <div class="match-card-body" style="padding:16px 14px;">
                                <div class="team-side" style="flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; text-align:center;">
                                    <div class="team-logo" style="width:40px; height:40px; border-radius:50%; background:var(--muk-green); display:flex; align-items:center; justify-content:center; font-size:15px; font-weight:800; color:#fff;">{{ strtoupper(substr($match->homeTeam->name, 0, 2)) }}</div>
                                    <div class="team-name" style="font-size:13px; font-weight:700; color:#111; line-height:1.2;">{{ $match->homeTeam->name }}</div>
                                </div>
                                <div class="vs-box" style="background:#f8fafc; border:1px solid #e8e8e8; border-radius:10px; padding:10px 18px; text-align:center; flex-shrink:0;">
                                    <div class="vs" style="font-size:13px; font-weight:800; color:#6b7280;">VS</div>
                                    <div class="time" style="font-size:12px; font-weight:700; color:var(--muk-green); margin-top:2px;">{{ $match->match_date->format('H:i') }}</div>
                                </div>
                                <div class="team-side" style="flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; text-align:center;">
                                    <div class="team-logo" style="width:40px; height:40px; border-radius:50%; background:var(--muk-green); display:flex; align-items:center; justify-content:center; font-size:15px; font-weight:800; color:#fff;">{{ strtoupper(substr($match->awayTeam->name, 0, 2)) }}</div>
                                    <div class="team-name" style="font-size:13px; font-weight:700; color:#111; line-height:1.2;">{{ $match->awayTeam->name }}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @if($todayFixtures->count() > 4)
                    <a href="{{ route('fixtures') }}" style="display:block; text-align:center; margin-top:14px; font-size:13px; color:var(--muk-green); font-weight:700; text-decoration:none; padding:10px; background:#f9fafb; border-radius:10px; transition:background .15s;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='#f9fafb'">
                        View all {{ $todayFixtures->count() }} fixtures today →
                    </a>
                    @endif
                </div>
                @endif

                {{-- RECENT RESULTS --}}
                @if($recentResults->count() > 0)
                <div class="reveal">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:4px;">
                        <div class="section-title" style="margin-bottom:0;">Recent Results</div>
                    </div>
                    <div style="margin-top:16px; display:grid; grid-template-columns:repeat(2, 1fr); gap:12px;">
                        @foreach($recentResults->take(4) as $match)
                        <a href="{{ route('match.detail', $match->id) }}" class="match-card" style="border-radius:12px; border:1px solid #e8e8e8; box-shadow:0 1px 4px rgba(0,0,0,.04);">
                            <div class="match-card-header" style="background:#1a1a2e; padding:6px 12px;">
                                <span style="font-size:9px; font-weight:700; color:rgba(255,255,255,.6); text-transform:uppercase;">{{ $match->competition->name ?? '' }}</span>
                                <span style="font-size:9px; font-weight:800; color:var(--muk-gold);">FT</span>
                            </div>
                            <div class="match-card-body" style="padding:12px 10px; display:flex; align-items:center; gap:6px;">
                                <div class="team-side" style="flex:1; text-align:center;">
                                    <div class="team-name" style="font-size:11px; font-weight:700; color:#111;">{{ $match->homeTeam->name }}</div>
                                </div>
                                <div class="score-box" style="background:var(--muk-black); color:#fff; border-radius:8px; padding:6px 12px; text-align:center; flex-shrink:0;">
                                    <div class="score" style="font-size:18px; font-weight:900; letter-spacing:2px; line-height:1;">{{ $match->home_score }}-{{ $match->away_score }}</div>
                                </div>
                                <div class="team-side" style="flex:1; text-align:center;">
                                    <div class="team-name" style="font-size:11px; font-weight:700; color:#111;">{{ $match->awayTeam->name }}</div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <a href="{{ route('results') }}" style="display:block; text-align:center; margin-top:14px; font-size:13px; color:var(--muk-green); font-weight:700; text-decoration:none; padding:10px; background:#f9fafb; border-radius:10px; transition:background .15s;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='#f9fafb'">
                        View all results →
                    </a>
                </div>
                @endif
            </div>

            {{-- RIGHT COLUMN --}}
            <div>
                {{-- TOP SCORERS TABLE --}}
                @if($topScorers->count() > 0)
                <div class="reveal" style="background:#fff; border-radius:14px; border:1px solid #e8e8e8; overflow:hidden; margin-bottom:20px; box-shadow:0 2px 12px rgba(0,0,0,.06);">
                    <div style="background:linear-gradient(135deg, var(--muk-green) 0%, var(--muk-green-dark) 100%); padding:14px 18px; display:flex; align-items:center; gap:10px;">
                        <span style="font-size:18px;">⚽</span>
                        <span style="font-size:15px; font-weight:800; color:#fff;">Top Scorers</span>
                        <span style="margin-left:auto; font-size:11px; color:rgba(255,255,255,.6); font-weight:600;">Goals</span>
                    </div>
                    <div style="padding:4px 0;">
                        @php $medals = ['🥇', '🥈', '🥉']; @endphp
                        @foreach($topScorers->take(10) as $i => $player)
                        <div style="display:flex; align-items:center; gap:12px; padding:10px 16px; {{ !$loop->last ? 'border-bottom:1px solid #f3f4f6;' : '' }} transition:background .15s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background=''">
                            <div style="width:28px; text-align:center; font-size:{{ $i < 3 ? '16px' : '14px' }}; font-weight:{{ $i < 3 ? '800' : '600' }}; color:{{ $i < 3 ? '#111' : '#9ca3af' }};">
                                @if($i < 3) {!! $medals[$i] !!} @else {{ $i + 1 }} @endif
                            </div>
                            <div style="width:36px; height:36px; border-radius:50%; background:{{ $i === 0 ? 'linear-gradient(135deg,#f59e0b,#d97706)' : ($i === 1 ? 'linear-gradient(135deg,#9ca3af,#6b7280)' : ($i === 2 ? 'linear-gradient(135deg,#d97706,#92400e)' : 'var(--muk-green)')) }}; display:flex; align-items:center; justify-content:center; color:#fff; font-size:13px; font-weight:700; flex-shrink:0;">
                                {{ strtoupper(substr($player->name, 0, 1)) }}
                            </div>
                            <div style="flex:1; min-width:0;">
                                <div style="font-size:14px; font-weight:700; color:#111; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $player->name }}</div>
                                @if($player->team)
                                <div style="font-size:11px; color:#9ca3af;">{{ $player->team->name }}</div>
                                @endif
                            </div>
                            <div style="background:{{ $i < 3 ? 'var(--muk-gold)' : 'var(--muk-green)' }}; color:{{ $i < 3 ? '#111' : '#fff' }}; min-width:36px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:15px; font-weight:800;">{{ $player->goals }}</div>
                        </div>
                        @endforeach
                    </div>
                    @if($topScorers->count() > 10)
                    <a href="{{ route('standings') }}" style="display:block; text-align:center; padding:10px; font-size:12px; color:var(--muk-green); font-weight:700; text-decoration:none; border-top:1px solid #f3f4f6;">View full standings →</a>
                    @endif
                </div>
                @endif

                {{-- QUICK LINKS --}}
                <div class="reveal" style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <a href="{{ route('live') }}" style="background:var(--muk-red); color:#fff; padding:16px; border-radius:12px; text-align:center; text-decoration:none; transition:transform .15s; box-shadow:0 2px 8px rgba(238,0,0,.2);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
                        <div style="font-size:24px; font-weight:900;">● LIVE</div>
                        <div style="font-size:11px; opacity:.8;">Live Scores</div>
                    </a>
                    <a href="{{ route('teams') }}" style="background:#fff; border:1px solid #e5e7eb; padding:16px; border-radius:12px; text-align:center; text-decoration:none; transition:transform .15s, box-shadow .15s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 4px 12px rgba(0,0,0,.08)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
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
<div class="section reveal" style="background:#fff;">
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
<div class="section reveal" style="background:linear-gradient(135deg, var(--muk-red) 0%, #990000 100%); text-align:center;">
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

/* ── HERO SECTION ─────────────────── */
.hero-static {
    position: relative;
    width: 100%;
    min-height: 100vh;
    background-image: url('https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=1600&q=80');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
}
.hero-static::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.55);
    z-index: 1;
}
.hero-inner {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 120px 20px 60px;
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 40px;
    align-items: center;
    z-index: 2;
}
.hero-label {
    font-size: 12px;
    font-weight: 700;
    color: rgba(255,255,255,.6);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 8px;
    text-shadow: 0 1px 6px rgba(0,0,0,.6);
}
.hero-static h1 {
    font-size: clamp(36px, 5vw, 56px);
    font-weight: 900;
    color: #fff;
    line-height: 1.05;
    margin-bottom: 16px;
    letter-spacing: -1px;
    text-shadow: 0 2px 12px rgba(0,0,0,.7);
}
.hero-static h1 span { color: var(--muk-red); text-shadow: 0 2px 12px rgba(0,0,0,.5); }
.hero-static p {
    font-size: 16px;
    color: rgba(255,255,255,.9);
    max-width: 560px;
    line-height: 1.7;
    margin-bottom: 28px;
    text-shadow: 0 1px 8px rgba(0,0,0,.6);
}
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
    color: var(--muk-red);
    text-shadow: 0 1px 8px rgba(0,0,0,.6);
}
.stat-label {
    font-size: 11px;
    color: rgba(255,255,255,.6);
    text-transform: uppercase;
    letter-spacing: .5px;
    text-shadow: 0 1px 6px rgba(0,0,0,.6);
}

/* HERO BUTTONS */
.btn-hero {
    background: var(--muk-red);
    color: #fff;
    padding: 12px 24px;
    border-radius: 9px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    transition: background .15s;
    display: inline-block;
}
.btn-hero:hover { background: #990000; }
.btn-hero-outline {
    background: rgba(255,255,255,.1);
    color: #fff;
    border: 1.5px solid rgba(255,255,255,.3);
    padding: 12px 24px;
    border-radius: 9px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    transition: background .15s;
    display: inline-block;
}
.btn-hero-outline:hover { background: rgba(255,255,255,.2); }

/* LIVE CARD */
.live-card {
    background: rgba(0,0,0,.6);
    backdrop-filter: blur(12px);
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
    color: var(--muk-red);
    font-weight: 700;
    margin-top: 4px;
}
.live-card-footer {
    padding: 8px 16px;
    background: rgba(0,0,0,.25);
    font-size: 11px;
    color: rgba(255,255,255,.4);
    text-align: center;
}

/* RED BUTTON (for use outside hero) */
.btn-red {
    background: var(--muk-red);
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

/* ── SCROLL REVEAL ─────────────────── */
.reveal {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity .6s ease-out, transform .6s ease-out;
}
.reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}

@media (max-width:900px) {
    .hero-static { min-height: 70vh; }
    .hero-inner { grid-template-columns: 1fr; padding: 100px 16px 40px; }
    .hero-right { display: none; }
    .hero-stats { grid-template-columns: repeat(2, 1fr) !important; gap: 12px; margin-top: 24px; max-width: 100%; }
    .stat-num { font-size: 22px; }
    .hero-static h1 { font-size: clamp(28px, 8vw, 36px); }
    .hero-static p { font-size: 14px; }
    .hero-ctas { flex-direction: column; gap: 10px; }
    .hero-ctas a { text-align: center; }
    .slider-item { min-width: 220px; max-width: 220px; }
}

@media (max-width: 640px) {
    .hero-static { min-height: 60vh; }
    .hero-stats { grid-template-columns: repeat(2, 1fr) !important; }
    .hero-label { font-size: 10px; }
}

/* Responsive content grid */
@media (max-width: 768px) {
    .home-grid { grid-template-columns: 1fr !important; }
    .match-card-body { padding: 12px 10px !important; }
    .team-name { font-size: 11px !important; }
    .score-box { padding: 6px 10px !important; }
    .score-box .score { font-size: 18px !important; }
    .news-slider { gap: 12px; }
    .slider-item { min-width: 200px; max-width: 200px; }
    .section { padding: 32px 16px !important; }
    [style*="grid-template-columns:repeat(2, 1fr)"] { grid-template-columns: 1fr !important; }}

@media (max-width: 480px) {
    .hero-stats { max-width: 100% !important; }
    .hero-ctas a { width: 100%; text-align: center; box-sizing: border-box; }
    .stat-num { font-size: 20px !important; }
    .hero-static h1 { font-size: 24px !important; }
    .section-title { font-size: 11px !important; }
    .reveal .match-card { margin: 0; }
    [style*="grid-template-columns:repeat(2, 1fr)"] { grid-template-columns: 1fr !important; }
    .slider-item { min-width: 160px; max-width: 160px; }
    .btn-hero, .btn-hero-outline { width: 100%; text-align: center; }
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
