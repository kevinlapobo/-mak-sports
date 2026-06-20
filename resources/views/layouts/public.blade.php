@php \App\Models\Matches::checkAndUpdateStatuses(); @endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>{{ $title ?? 'Makerere University Sports' }}</title>
<meta name="description" content="Official Makerere University Sports Platform — Live scores, fixtures, results and standings"/>
<script src="https://cdn.tailwindcss.com"></script>
@livewireStyles
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

  :root {
    --muk-green:      #28A745;
    --muk-green-dark: #1e7e34;
    --muk-green-mid:  #239e3e;
    --muk-gold:       #FFC107;
    --muk-gold-dark:  #d4a017;
    --muk-red:        #ee0000;
    --muk-black:      #0a0a0a;
    --muk-white:      #ffffff;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }
  body {
    font-family: 'Inter', Arial, sans-serif;
    background: #f5f5f5;
    color: #111;
    overflow-x: hidden;
  }

  /* ── NAVBAR ─────────────────────────────── */
  #main-nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    height: 64px;
    transition: background .3s ease, border-bottom .3s ease, box-shadow .3s ease, height .3s ease;
    background: var(--muk-green);
    border-bottom: 3px solid var(--muk-red);
    box-shadow: 0 2px 10px rgba(0,0,0,.2);
  }
  #main-nav.with-hero {
    background: transparent;
    border-bottom: 1px solid rgba(255,255,255,.4);
    box-shadow: none;
  }
  #main-nav.with-hero .nav-link {
    text-shadow: 0 1px 6px rgba(0,0,0,.6);
  }
  #main-nav.scrolled {
    background: #3CB043;
    border-bottom: 3px solid var(--muk-red);
    box-shadow: 0 4px 20px rgba(0,0,0,.3);
    height: 56px;
  }
  #main-nav .nav-inner {
    max-width: 1200px;
    margin: 0 auto;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
  }
  .nav-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
  }
  .nav-logo img {
    height: 44px;
    width: auto;
    transition: height .3s;
  }
  #main-nav.scrolled .nav-logo img { height: 36px; }
  .nav-logo-text { line-height: 1.1; }
  .nav-logo-text .title {
    font-size: 16px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -.3px;
  }
  .nav-logo-text .sub {
    font-size: 10px;
    color: rgba(255,255,255,.6);
  }
  .nav-links {
    display: flex;
    align-items: center;
    gap: 2px;
  }
  .nav-link {
    color: rgba(255,255,255,.85);
    font-size: 13px;
    font-weight: 600;
    padding: 6px 10px;
    border-radius: 8px;
    text-decoration: none;
    transition: background .15s, color .15s;
    white-space: nowrap;
  }
  .nav-link:hover { background: rgba(255,255,255,.12); color: #fff; }
  .nav-link.active {
    background: rgba(255,255,255,.15);
    color: var(--muk-gold);
  }
  .nav-link.live-link {
    color: #fff;
    background: var(--muk-red);
    animation: livePulse 2s infinite;
    padding: 6px 12px;
  }
  @keyframes livePulse {
    0%,100% { background: var(--muk-red); }
    50% { background: #990000; }
  }
  /* Dropdown */
  .nav-dropdown { position: relative; }
  .nav-dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background: var(--muk-green-dark);
    border-radius: 10px;
    padding: 6px;
    min-width: 170px;
    box-shadow: 0 8px 24px rgba(0,0,0,.3);
    z-index: 1001;
  }
  .nav-dropdown:hover .nav-dropdown-menu,
  .nav-dropdown-menu.open { display: flex; flex-direction: column; gap: 2px; }
  .nav-dropdown-menu a {
    color: rgba(255,255,255,.85);
    font-size: 13px;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    transition: background .15s;
    white-space: nowrap;
  }
  .nav-dropdown-menu a:hover { background: rgba(255,255,255,.12); color: #fff; }
  .nav-dropdown-menu a.active { background: rgba(255,255,255,.15); color: var(--muk-gold); }
  .nav-dropdown-arrow { font-size: 8px; margin-left: 4px; }
  /* Mobile menu */
  .mobile-menu-btn {
    display: none;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 6px;
    color: #fff;
    font-size: 24px;
  }
  .mobile-nav {
    display: none;
    background: var(--muk-green-dark);
    padding: 12px 16px 20px;
    flex-direction: column;
    gap: 4px;
    max-height: calc(100vh - 64px);
    overflow-y: auto;
  }
  .mobile-nav.open { display: flex; }

  /* ── HERO ─────────────────────────────── */
  .hero {
    min-height: 80vh;
    background: linear-gradient(
      160deg,
      #1a1a2e 0%,
      var(--muk-green-dark) 40%,
      var(--muk-green) 70%,
      var(--muk-green-dark) 100%
    );
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    padding-top: 64px;
  }
  .hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
      radial-gradient(ellipse at 80% 50%, rgba(255,215,0,.08) 0%, transparent 60%),
      radial-gradient(ellipse at 20% 80%, rgba(0,0,0,.3) 0%, transparent 50%);
  }
  .hero-pattern {
    position: absolute;
    inset: 0;
    opacity: .04;
    background-image:
      repeating-linear-gradient(
        45deg,
        #fff 0, #fff 1px,
        transparent 0, transparent 50%
      );
    background-size: 20px 20px;
  }
  .hero-content {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
    width: 100%;
  }
  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,215,0,.15);
    border: 1px solid rgba(255,215,0,.3);
    color: var(--muk-gold);
    font-size: 12px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 999px;
    margin-bottom: 16px;
    letter-spacing: .5px;
    text-transform: uppercase;
  }
  .hero h1 {
    font-size: clamp(32px, 5vw, 56px);
    font-weight: 900;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 16px;
    letter-spacing: -1px;
  }
  .hero h1 span { color: var(--muk-gold); }
  .hero p {
    font-size: 16px;
    color: rgba(255,255,255,.75);
    max-width: 560px;
    line-height: 1.7;
    margin-bottom: 28px;
  }
  .hero-ctas {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
  }
  .btn-gold {
    background: var(--muk-gold);
    color: var(--muk-black);
    padding: 12px 24px;
    border-radius: 9px;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    transition: background .15s;
    display: inline-block;
  }
  .btn-gold:hover { background: var(--muk-gold-dark); }
  .btn-ghost {
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
  .btn-ghost:hover { background: rgba(255,255,255,.2); }

  /* ── LIVE TICKER ──────────────────────── */
  .live-ticker {
    background: var(--muk-red);
    overflow: hidden;
    white-space: nowrap;
  }
  .ticker-inner {
    display: inline-flex;
    animation: ticker 30s linear infinite;
    gap: 60px;
    padding: 10px 0;
  }
  @keyframes ticker {
    0% { transform: translateX(100vw); }
    100% { transform: translateX(-100%); }
  }
  .ticker-item {
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .ticker-score {
    background: rgba(255,255,255,.2);
    padding: 2px 10px;
    border-radius: 5px;
    font-size: 14px;
    letter-spacing: 1px;
  }

  /* ── SECTION STYLES ─────────────────── */
  .section { padding: 60px 20px; }
  .section-sm { padding: 40px 20px; }
  .container { max-width: 1200px; margin: 0 auto; }
  .section-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--muk-green);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .section-title::before {
    content: '';
    width: 24px;
    height: 3px;
    background: var(--muk-gold);
    border-radius: 2px;
    display: inline-block;
  }
  .section-heading {
    font-size: clamp(22px, 3vw, 32px);
    font-weight: 800;
    color: var(--muk-black);
    line-height: 1.2;
    margin-bottom: 6px;
  }
  .section-sub {
    font-size: 14px;
    color: #666;
    margin-bottom: 32px;
  }

  /* ── MATCH CARDS ─────────────────────── */
  .match-card {
    background: #fff;
    border-radius: 14px;
    padding: 0;
    overflow: hidden;
    border: 1px solid #e8e8e8;
    transition: transform .2s, box-shadow .2s;
    text-decoration: none;
    display: block;
  }
  .match-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(0,0,0,.12);
  }
  .match-card-header {
    background: var(--muk-green);
    padding: 8px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .match-card-header span {
    font-size: 10px;
    font-weight: 700;
    color: rgba(255,255,255,.8);
    text-transform: uppercase;
    letter-spacing: .5px;
  }
  .match-card-body {
    padding: 20px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }
  .team-side {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    text-align: center;
  }
  .team-logo {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: var(--muk-green);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 800;
    color: #fff;
    overflow: hidden;
  }
  .team-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }
  .team-name {
    font-size: 13px;
    font-weight: 700;
    color: #111;
    line-height: 1.3;
  }
  .score-box {
    background: var(--muk-black);
    color: #fff;
    border-radius: 10px;
    padding: 10px 18px;
    text-align: center;
    flex-shrink: 0;
  }
  .score-box .score {
    font-size: 26px;
    font-weight: 900;
    letter-spacing: 3px;
    line-height: 1;
  }
  .score-box .score-label {
    font-size: 9px;
    color: rgba(255,255,255,.5);
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-top: 3px;
  }
  .vs-box {
    background: #f5f5f5;
    color: #666;
    border-radius: 8px;
    padding: 8px 14px;
    text-align: center;
    flex-shrink: 0;
  }
  .vs-box .vs { font-size: 14px; font-weight: 800; }
  .vs-box .time { font-size: 11px; color: var(--muk-green); font-weight: 700; }
  .match-card-footer {
    padding: 8px 16px;
    background: #f9f9f9;
    border-top: 1px solid #f0f0f0;
    font-size: 11px;
    color: #888;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  /* ── SPORTS GRID ────────────────────── */
  .sport-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 999px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    color: #333;
    transition: all .15s;
    white-space: nowrap;
  }
  .sport-pill:hover {
    border-color: var(--muk-green);
    color: var(--muk-green);
    background: #e8f5ee;
  }
  .sport-pill.active {
    background: var(--muk-green);
    border-color: var(--muk-green);
    color: #fff;
  }

  /* ── STANDINGS TABLE ─────────────────── */
  .standings-table { width: 100%; border-collapse: collapse; }
  .standings-table th {
    background: var(--muk-green);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 10px 12px;
    text-align: center;
  }
  .standings-table th:first-child { text-align: left; }
  .standings-table td {
    padding: 10px 12px;
    font-size: 13px;
    color: #333;
    text-align: center;
    border-bottom: 1px solid #f0f0f0;
  }
  .standings-table td:first-child { text-align: left; }
  .standings-table tr:hover td { background: #f9fffe; }
  .standings-table tr.top3 td { background: #e8f5ee; font-weight: 600; }
  .standings-table .pos {
    font-size: 12px;
    font-weight: 800;
    color: #888;
    width: 28px;
  }
  .standings-table .pts {
    font-weight: 800;
    color: var(--muk-green);
  }

  /* ── NEWS CARD ───────────────────────── */
  .news-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e8e8e8;
    transition: transform .2s, box-shadow .2s;
    text-decoration: none;
    display: block;
  }
  .news-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,.1);
  }
  .news-card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
  }
  .news-card .news-body { padding: 14px; }
  .news-card .news-tag {
    font-size: 10px;
    font-weight: 700;
    color: var(--muk-green);
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 6px;
  }
  .news-card .news-title {
    font-size: 14px;
    font-weight: 700;
    color: #111;
    line-height: 1.4;
    margin-bottom: 8px;
  }
  .news-card .news-date {
    font-size: 11px;
    color: #888;
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

  /* ── LIVE BADGE ──────────────────────── */
  .live-badge {
    background: var(--muk-red);
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    padding: 3px 8px;
    border-radius: 999px;
    letter-spacing: .5px;
    animation: liveBlink 1.5s infinite;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  @keyframes liveBlink {
    0%,100% { opacity: 1; }
    50% { opacity: .7; }
  }

  /* ── FOOTER ──────────────────────────── */
  .footer {
    background: var(--muk-green-dark);
    color: rgba(255,255,255,.75);
    padding: 48px 20px 24px;
  }
  .footer-inner {
    max-width: 1200px;
    margin: 0 auto;
  }
  .footer-top {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr;
    gap: 40px;
    margin-bottom: 40px;
    padding-bottom: 40px;
    border-bottom: 1px solid rgba(255,255,255,.1);
  }
  .footer-brand .brand-title {
    font-size: 18px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 8px;
  }
  .footer-brand p {
    font-size: 13px;
    line-height: 1.7;
    margin-bottom: 16px;
  }
  .footer-heading {
    font-size: 12px;
    font-weight: 700;
    color: var(--muk-gold);
    text-transform: uppercase;
    letter-spacing: .8px;
    margin-bottom: 14px;
  }
  .footer-links { list-style: none; }
  .footer-links li { margin-bottom: 8px; }
  .footer-links a {
    color: rgba(255,255,255,.65);
    text-decoration: none;
    font-size: 13px;
    transition: color .15s;
  }
  .footer-links a:hover { color: var(--muk-gold); }
  .footer-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
    color: rgba(255,255,255,.4);
    flex-wrap: wrap;
    gap: 8px;
  }
  .social-links {
    display: flex;
    gap: 10px;
  }
  .social-link {
    width: 34px;
    height: 34px;
    background: rgba(255,255,255,.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 14px;
    transition: background .15s;
  }
  .social-link:hover { background: var(--muk-gold); }

  /* ── RESPONSIVE OVERFLOW FIXES ────── */
  img, video, iframe { max-width: 100%; height: auto; }
  table { width: 100%; }
  [style*="overflow-x:auto"] { -webkit-overflow-scrolling: touch; }
  pre, code { white-space: pre-wrap; word-break: break-word; }
  .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%; }
  [style*="white-space:nowrap"] { max-width: 100%; }
  [style*="display:grid"] { box-sizing: border-box; }
  [style*="padding:0 16px"],[style*="padding:0 20px"] { box-sizing: border-box; }

  /* ── RESPONSIVE ──────────────────────── */
  @media (max-width: 1100px) {
    .nav-links { display: none; }
    .mobile-menu-btn { display: block; }
    .nav-logo-text .title { font-size: 14px; }
    .nav-logo img { height: 34px; }
    #main-nav { height: 56px; }
    #main-nav .nav-inner { padding: 0 12px; }
  }
  @media (max-width: 768px) {
    .nav-logo-text .sub { display: none; }
    .nav-logo img { height: 30px; }
    .footer-top { grid-template-columns: 1fr 1fr !important; gap: 20px !important; }
    .footer-bottom { flex-direction: column; text-align: center; }
  }
  @media (max-width: 480px) {
    .nav-logo-text .title { font-size: 13px; }
    .footer-top { grid-template-columns: 1fr !important; }
    .nav-logo-text .sub { display: none; }
    .nav-logo img { height: 28px; }
    #main-nav { height: 50px; }
  }
  @media (max-width: 768px) {
    .footer-top { grid-template-columns: 1fr 1fr; gap: 24px; }
    .hero h1 { font-size: 28px; }
  }
  @media (max-width: 480px) {
    .footer-top { grid-template-columns: 1fr; }
  }

  /* ── UTILITY ─────────────────────────── */
  .grid-2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 16px; }
  .grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; }
  .grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; }
  @media(max-width:900px) {
    .grid-4,.grid-3 { grid-template-columns: repeat(2,1fr); }
  }
  @media(max-width:560px) {
    .grid-4,.grid-3,.grid-2 { grid-template-columns: 1fr; }
  }
  @keyframes spin { to { transform: rotate(360deg); } }
</style>
</head>
<body>

{{-- ═══════════════════════════════════
     FIXED NAVBAR — changes on scroll
     ═══════════════════════════════════ --}}
<nav id="main-nav" class="{{ request()->routeIs('home') ? 'with-hero' : '' }}">
    <div class="nav-inner">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="nav-logo">
            <img
                src="https://safespace.mak.ac.ug/assets/images/logo-sm.png"
                
            />
            <div class="nav-logo-text">
                <div class="title">Makerere Sports</div>
                <div class="sub">Official Sports Platform</div>
            </div>
        </a>

        {{-- Desktop nav --}}
        <div class="nav-links">
            @php $showPublicNav = !auth()->check() || !in_array(auth()->user()->role, ['admin', 'facility_manager']); @endphp
            @if($showPublicNav)
            <a href="{{ route('fixtures') }}"
               class="nav-link {{ request()->routeIs('fixtures') ? 'active' : '' }}">
               Fixtures
            </a>
            <a href="{{ route('results') }}"
               class="nav-link {{ request()->routeIs('results') ? 'active' : '' }}">
               Results
            </a>
            <a href="{{ route('teams') }}"
               class="nav-link {{ request()->routeIs('teams') ? 'active' : '' }}">
               Teams
            </a>
            @endif
            <a href="{{ route('contact') }}"
               class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
               Contact
            </a>
            @auth
                <a href="{{ route('live') }}"
                   class="nav-link live-link {{ request()->routeIs('live') ? 'active' : '' }}">
                   ● LIVE
                </a>
                <a href="{{ route('standings') }}"
                   class="nav-link {{ request()->routeIs('standings') ? 'active' : '' }}">
                   Standings
                </a>
                @if(auth()->user()->role === 'coach')
                    <a href="{{ route('venues.index') }}"
                       class="nav-link {{ request()->routeIs('venue.*') ? 'active' : '' }}"
                       style="background:rgba(204,0,0,.8); color:#fff;">
                       🏟 Book Venue
                    </a>
                    <a href="{{ route('coach.my-teams') }}"
                       class="nav-link {{ request()->routeIs('coach.my-teams') ? 'active' : '' }}">
                       My Teams
                    </a>
                    <a href="{{ route('coach.profile') }}"
                       class="nav-link {{ request()->routeIs('coach.profile') ? 'active' : '' }}">
                       Profile
                    </a>
                    <a href="{{ route('coach.stats') }}"
                       class="nav-link {{ request()->routeIs('coach.stats') ? 'active' : '' }}">
                       My Stats
                    </a>
                @endif
                @if(auth()->user()->role === 'player')
                    <a href="{{ route('player.profile') }}"
                       class="nav-link {{ request()->routeIs('player.profile') ? 'active' : '' }}">
                       Profile
                    </a>
                @endif
                @if(in_array(auth()->user()->role, ['admin', 'facility_manager']))
                    <a href="{{ route('facility.approvals') }}"
                       class="nav-link {{ request()->routeIs('facility.approvals') ? 'active' : '' }}">
                       👥 Approvals
                    </a>
                    <a href="{{ route('facility.venue-bookings') }}"
                       class="nav-link {{ request()->routeIs('facility.venue-bookings') ? 'active' : '' }}">
                       🏟 Bookings
                    </a>
                @endif
            @endauth

            {{-- Auth Links --}}
            @auth
                @php $u = auth()->user(); @endphp
                @if(in_array($u->role, ['admin', 'facility_manager']))
                    <div class="nav-dropdown">
                        <span class="nav-link" style="cursor:pointer;">📋 Fixtures<span class="nav-dropdown-arrow">▼</span></span>
                        <div class="nav-dropdown-menu">
                            <a href="{{ route('admin.manage-fixtures') }}" class="{{ request()->routeIs('admin.manage-fixtures') ? 'active' : '' }}">➕ Create Fixture</a>
                            <a href="{{ route('fixtures') }}" class="{{ request()->routeIs('fixtures') ? 'active' : '' }}">📅 All Fixtures</a>
                        </div>
                    </div>
                    <div class="nav-dropdown">
                        <span class="nav-link" style="cursor:pointer;">⚽ Results<span class="nav-dropdown-arrow">▼</span></span>
                        <div class="nav-dropdown-menu">
                            @if($u->role === 'admin')
                            <a href="{{ route('admin.add-results') }}" class="{{ request()->routeIs('admin.add-results') ? 'active' : '' }}">📝 Add Results</a>
                            <a href="{{ route('admin.pending-results') }}" class="{{ request()->routeIs('admin.pending-results') ? 'active' : '' }}">⏳ Pending</a>
                            @endif
                            <a href="{{ route('results') }}" class="{{ request()->routeIs('results') ? 'active' : '' }}">📊 All Results</a>
                        </div>
                    </div>
                    <div class="nav-dropdown">
                        <span class="nav-link" style="cursor:pointer;">🏆 Teams<span class="nav-dropdown-arrow">▼</span></span>
                        <div class="nav-dropdown-menu">
                            <a href="{{ route('teams') }}" class="{{ request()->routeIs('teams') ? 'active' : '' }}">👥 All Teams</a>
                            @if($u->role === 'admin')
                            <a href="{{ route('admin.new-teams') }}" class="{{ request()->routeIs('admin.new-teams') ? 'active' : '' }}">🆕 New Teams</a>
                            @endif
                        </div>
                    </div>
                @endif
                <livewire:notifications.notification-bell :key="'bell-'.$u->id" wire:key="'bell-'.$u->id"/>
                <a href="{{ route('dashboard') }}"
                   class="nav-link" style="display:flex; align-items:center; gap:6px; background:rgba(255,215,0,.2); color:var(--muk-gold);">
                   <span style="width:26px; height:26px; border-radius:50%; background:var(--muk-gold); color:var(--muk-black); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:800; flex-shrink:0;">{{ strtoupper(substr($u->name, 0, 1)) }}</span>
                   Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="nav-link" style="background:transparent; border:none; cursor:pointer;">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="nav-link" style="border:1.5px solid rgba(255,255,255,.3);">
                   Sign In
                </a>
                <a href="{{ route('register') }}"
                   class="nav-link" style="background:var(--muk-gold); color:var(--muk-black);">
                   Register
                </a>
            @endauth
        </div>

        {{-- Mobile menu button --}}
        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">☰</button>

    </div>

    {{-- Mobile nav --}}
    <div class="mobile-nav" id="mobile-menu">
        @php $mRole = auth()->check() ? auth()->user()->role : ''; $showMobilePublic = !in_array($mRole, ['admin', 'facility_manager']); @endphp
        @if($showMobilePublic)
        <a href="{{ route('fixtures') }}" class="nav-link">Fixtures</a>
        <a href="{{ route('results') }}" class="nav-link">Results</a>
        <a href="{{ route('teams') }}" class="nav-link">Teams</a>
        @endif
        <a href="{{ route('contact') }}" class="nav-link">Contact</a>

        @auth
            <a href="{{ route('live') }}" class="nav-link live-link">● LIVE</a>
            <a href="{{ route('standings') }}" class="nav-link">Standings</a>
            @if(auth()->user()->role === 'coach')
                <a href="{{ route('venues.index') }}" class="nav-link" style="background:var(--muk-red); color:#fff;">🏟 Book Venue</a>
                <a href="{{ route('coach.my-teams') }}" class="nav-link">My Teams</a>
                <a href="{{ route('coach.profile') }}" class="nav-link">Profile</a>
                <a href="{{ route('coach.stats') }}" class="nav-link">My Stats</a>
            @endif
            @if(auth()->user()->role === 'player')
                <a href="{{ route('player.profile') }}" class="nav-link">Profile</a>
            @endif
            @if(in_array(auth()->user()->role, ['admin', 'facility_manager']))
                <a href="{{ route('facility.approvals') }}" class="nav-link">👥 Approvals</a>
                <a href="{{ route('facility.venue-bookings') }}" class="nav-link">🏟 Bookings</a>
            @endif
            @if(in_array(auth()->user()->role, ['admin', 'facility_manager']))
                @php $mUser = auth()->user(); @endphp
                <div style="padding: 4px 16px; font-size: 11px; color: rgba(255,255,255,.35); text-transform: uppercase; letter-spacing:1px; margin-top:4px;">Fixtures</div>
                <a href="{{ route('admin.manage-fixtures') }}" class="nav-link">➕ Create Fixture</a>
                <a href="{{ route('fixtures') }}" class="nav-link">📅 All Fixtures</a>
                <div style="padding: 4px 16px; font-size: 11px; color: rgba(255,255,255,.35); text-transform: uppercase; letter-spacing:1px; margin-top:4px;">Results</div>
                @if($mUser->role === 'admin')
                <a href="{{ route('admin.add-results') }}" class="nav-link">📝 Add Results</a>
                <a href="{{ route('admin.pending-results') }}" class="nav-link">⏳ Pending</a>
                @endif
                <a href="{{ route('results') }}" class="nav-link">📊 All Results</a>
                <div style="padding: 4px 16px; font-size: 11px; color: rgba(255,255,255,.35); text-transform: uppercase; letter-spacing:1px; margin-top:4px;">Teams</div>
                <a href="{{ route('teams') }}" class="nav-link">👥 All Teams</a>
                @if($mUser->role === 'admin')
                <a href="{{ route('admin.new-teams') }}" class="nav-link">🆕 New Teams</a>
                @endif
            @endif
            <a href="{{ route('notifications') }}" class="nav-link" style="display:flex; align-items:center; gap:6px;">🔔 Notifications</a>
            <a href="{{ route('dashboard') }}" class="nav-link" style="color:var(--muk-gold);">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link" style="background:transparent; border:none; cursor:pointer; width:100%; text-align:left;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="nav-link" style="border:1px solid rgba(255,255,255,.3);">Sign In for Live & Standings</a>
            <a href="{{ route('register') }}" class="nav-link" style="background:var(--muk-gold); color:var(--muk-black);">Register</a>
        @endauth
    </div>
</nav>

{{-- ═══════════════════════════════════
     MAIN CONTENT
     ═══════════════════════════════════ --}}
<div style="padding-top:{{ request()->routeIs('home') ? '0' : '64px' }};" id="main-content">
{{ $slot }}
</div>
<script>
// Adjust padding when navbar height changes on resize
function adjustPadding() {
    var nav = document.getElementById('main-nav');
    var content = document.getElementById('main-content');
    if (nav && content && !document.querySelector('.hero-static')) {
        content.style.paddingTop = nav.offsetHeight + 'px';
    }
}
window.addEventListener('resize', adjustPadding);
window.addEventListener('load', adjustPadding);
</script>

{{-- ═══════════════════════════════════
     FOOTER
     ═══════════════════════════════════ --}}
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-top">

            {{-- Brand --}}
            <div class="footer-brand">
                <img
                    src="https://safespace.mak.ac.ug/assets/images/logo-sm.png"
                    style="height:44px; margin-bottom:12px;"
                />
                <div class="brand-title">Makerere Sports</div>
                <p>
                    The official sports platform for Makerere University.
                    Live scores, fixtures, results and standings for all
                    university sports.
                </p>
                <div class="social-links">
                    <a href="https://facebook.com/Makerere" class="social-link" target="_blank">f</a>
                    <a href="https://twitter.com/Makerere" class="social-link" target="_blank">𝕏</a>
                    <a href="https://instagram.com/Makerere" class="social-link" target="_blank">📷</a>
                    <a href="https://youtube.com/Makerere" class="social-link" target="_blank">▶</a>
                </div>
            </div>

            {{-- Sports --}}
            <div>
                <div class="footer-heading">Sports</div>
                <ul class="footer-links">
                    <li><a href="{{ route('fixtures') }}?sport=football">⚽ Football</a></li>
                    <li><a href="{{ route('fixtures') }}?sport=basketball">🏀 Basketball</a></li>
                    <li><a href="{{ route('fixtures') }}?sport=volleyball">🏐 Volleyball</a></li>
                    <li><a href="{{ route('fixtures') }}?sport=rugby">🏉 Rugby</a></li>
                    <li><a href="{{ route('fixtures') }}?sport=netball">🥅 Netball</a></li>
                    <li><a href="{{ route('fixtures') }}?sport=athletics">🏃 Athletics</a></li>
                </ul>
            </div>

            {{-- Quick links --}}
            <div>
                <div class="footer-heading">Quick Links</div>
                <ul class="footer-links">
                    <li><a href="{{ route('live') }}">Live Scores</a></li>
                    <li><a href="{{ route('fixtures') }}">Fixtures</a></li>
                    <li><a href="{{ route('results') }}">Results</a></li>
                    <li><a href="{{ route('standings') }}">Standings</a></li>
                    <li><a href="{{ route('teams') }}">Teams</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </div>

            {{-- University --}}
            <div>
                <div class="footer-heading">Makerere University</div>
                <ul class="footer-links">
                    <li><a href="https://mak.ac.ug" target="_blank">Main Website</a></li>
                    <li><a href="https://mak.ac.ug/students/sports-recreation" target="_blank">Sports & Recreation</a></li>
                    <li><a href="https://mak.ac.ug/emergency-contact" target="_blank">Emergency Contacts</a></li>
                    <li><a href="https://myportal.mak.ac.ug" target="_blank">Student Portal</a></li>
                </ul>
                <div style="margin-top:16px; font-size:12px; line-height:1.7;">
                    <div>📞 +256-704-923105</div>
                    <div>📍 Makerere Hill Road, Kampala</div>
                </div>
            </div>

        </div>

        {{-- Bottom bar --}}
        <div class="footer-bottom">
            <span>© {{ date('Y') }} Makerere University Sports Platform. All rights reserved.</span>
            <span>Department of Sports & Recreation | Makerere University</span>
        </div>
    </div>
</footer>

@livewireScripts

<script>
/* ── Navbar scroll effect ── */
const nav = document.getElementById('main-nav');

function handleScroll() {
    if (window.scrollY > 60) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }
}
window.addEventListener('scroll', handleScroll, { passive: true });
handleScroll();

/* ── Mobile menu toggle ── */
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('open');
}

/* ── Auto-refresh on live page ── */
@if(request()->routeIs('live'))
setInterval(() => {
    if (typeof Livewire !== 'undefined') {
        Livewire.dispatch('refresh');
    }
}, 5000);
@endif

/* ── Fix inline style overflow ── */
(function(){
    function fixOverflow() {
        document.querySelectorAll('[style*="grid-template-columns"], [style*="display:grid"]').forEach(function(el) {
            if (el.offsetWidth > window.innerWidth && !el.classList.contains('responsive-grid')) {
                el.style.overflowX = 'auto';
                el.style.WebkitOverflowScrolling = 'touch';
            }
        });
        document.querySelectorAll('[style*="overflow-x:auto"]').forEach(function(el) {
            var wrapper = el.closest('[style*="max-width"]');
            if (wrapper && wrapper.scrollWidth > wrapper.offsetWidth) {
                wrapper.style.overflow = 'hidden';
            }
        });
    }
    window.addEventListener('load', fixOverflow);
    window.addEventListener('resize', fixOverflow);
})();

/* ── Scroll reveal animation ── */
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('revealed');
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.reveal').forEach(el => {
    observer.observe(el);
});
</script>

{{-- Notification popup for users with unread notifications --}}
@auth
@php $unreadNotifs = auth()->user()->unreadNotifications; @endphp
@if($unreadNotifs->count() > 0)
<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 8000)"
     x-transition:enter.duration.400ms
     x-transition:leave.duration.300ms
     style="position:fixed; bottom:24px; right:24px; z-index:10000; background:#fff; border-radius:16px; box-shadow:0 10px 40px rgba(0,0,0,.2); max-width:360px; width:100%; overflow:hidden; border:1px solid #e5e7eb;">
    <div style="background:var(--muk-green-dark); padding:12px 16px; display:flex; align-items:center; justify-content:space-between;">
        <span style="color:#fff; font-weight:800; font-size:14px;">🔔 {{ $unreadNotifs->count() }} New Notification(s)</span>
        <button @click="show = false" style="background:rgba(255,255,255,.2); border:none; color:#fff; border-radius:50%; width:24px; height:24px; font-size:12px; cursor:pointer; display:flex; align-items:center; justify-content:center;">✕</button>
    </div>
    <div style="padding:8px 16px; max-height:200px; overflow-y:auto;">
        @foreach($unreadNotifs->sortByDesc('created_at')->take(4) as $notification)
        <div style="padding:10px 0; border-bottom:1px solid #f3f4f6; font-size:13px;">
            <div style="font-weight:700; color:var(--muk-green-dark);">{{ $notification->data['title'] ?? 'Notification' }}</div>
            <div style="font-size:12px; color:#6b7280; margin-top:2px;">{{ Str::limit($notification->data['message'] ?? '', 80) }}</div>
        </div>
        @endforeach
    </div>
    <a href="{{ route('notifications') }}" style="display:block; text-align:center; padding:10px; background:#f9fafb; color:var(--muk-green); font-weight:700; font-size:13px; text-decoration:none; border-top:1px solid #e5e7eb;">View All Notifications →</a>
</div>
@endif
@endauth

</body>
</html>
