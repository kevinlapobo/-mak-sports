<?php

namespace App\Livewire\Pages;

use App\Models\Competition;
use Livewire\Component;
use App\Models\Match;
use App\Models\Matches;
use App\Models\Sport;
use App\Models\NewsUpdate;
use App\Models\Player;
use App\Models\Standing;

class Home extends Component
{
    public function render()
    {
        // Featured match — live first, then today's, then upcoming
        $featuredMatch = Matches::with(['homeTeam', 'awayTeam', 'competition', 'venue'])
            ->where('is_featured', true)
            ->where('status', 'live')
            ->first()
            ?? Matches::with(['homeTeam', 'awayTeam', 'competition', 'venue'])
            ->whereDate('match_date', today())
            ->where('status', 'scheduled')
            ->first()
            ?? Matches::with(['homeTeam', 'awayTeam', 'competition', 'venue'])
            ->where('status', 'scheduled')
            ->where('match_date', '>=', now())
            ->first();

        // Live matches for ticker
        $liveMatches = Matches::with(['homeTeam', 'awayTeam'])
            ->where('status', 'live')
            ->get();

        // Today's fixtures
        $todayFixtures = Matches::with(['homeTeam', 'awayTeam', 'competition', 'venue'])
            ->whereDate('match_date', today())
            ->where('status', 'scheduled')
            ->orderBy('match_date')
            ->get();

        // Recent results
        $recentResults = Matches::with(['homeTeam', 'awayTeam', 'competition'])
            ->where('status', 'finished')
            ->orderByDesc('match_date')
            ->take(6)
            ->get();

        // Standings preview — top competition
        $topCompetition = Competition::where('is_active', true)->first();
        $standingsPreview = Standing::where('competition_id', $topCompetition?->id)
            ->with('team')
            ->orderByDesc('points')
            ->take(8)
            ->get();

        // Top scorers
        $topScorers = Player::with('team')
            ->where('goals', '>', 0)
            ->orderByDesc('goals')
            ->take(5)
            ->get();

        // Sports with team counts
        $sports = Sport::withCount('teams')
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();

        // Latest news
        $latestNews = NewsUpdate::where('is_published', true)
            ->orderByDesc('published_at')
            ->take(8)
            ->get();

        // Stats for hero
        $stats = [
            'sports'  => Sport::where('is_active', true)->count(),
            'teams'   => \App\Models\Team::where('is_active', true)->count(),
            'matches' => Matches::where('status', 'finished')->count(),
            'players' => Player::where('is_active', true)->count(),
        ];

        return view('livewire.pages.home', compact(
            'featuredMatch',
            'liveMatches',
            'todayFixtures',
            'recentResults',
            'standingsPreview',
            'topCompetition',
            'topScorers',
            'sports',
            'latestNews',
            'stats'
        ))->layout('layouts.public', ['title' => 'Makerere University Sports']);
    }
}
