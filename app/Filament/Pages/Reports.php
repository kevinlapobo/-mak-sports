<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\Team;
use App\Models\Player;
use App\Models\Coach;
use App\Models\Matches;
use App\Models\VenueBooking;
use Filament\Pages\Page;

class Reports extends Page
{
    protected string $view = 'filament.pages.reports';

    public string $selectedReport = 'users';

    public function getTitle(): string
    {
        return 'System Reports';
    }

    public static function getNavigationLabel(): string
    {
        return 'Reports';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-chart-bar';
    }

    public array $stats = [];
    public array $details = [];
    public array $totals = [];

    public function mount(): void
    {
        $this->stats = [
            'users' => User::count(),
            'pending' => User::where('status', 'pending')->count(),
            'teams' => Team::count(),
            'players' => Player::count(),
            'coaches' => Coach::count(),
            'matches' => Matches::count(),
            'completed' => Matches::where('status', 'finished')->count(),
            'bookings' => VenueBooking::count(),
        ];
        $this->loadDetails();
    }

    public function selectReport(string $report): void
    {
        $this->selectedReport = $report;
        $this->loadDetails();
    }

    public function loadDetails(): void
    {
        $this->details = [];
        $this->totals = [];

        match ($this->selectedReport) {
            'users' => $this->loadUsers(),
            'pending' => $this->loadPending(),
            'teams' => $this->loadTeams(),
            'players' => $this->loadPlayers(),
            'coaches' => $this->loadCoaches(),
            'matches' => $this->loadMatches(),
            'completed' => $this->loadCompleted(),
            'bookings' => $this->loadBookings(),
            default => null,
        };
    }

    protected function loadUsers(): void
    {
        $this->details = User::select('name', 'email', 'role', 'status', 'created_at')
            ->orderBy('created_at', 'desc')->get()->toArray();
        $this->totals = [
            'Total' => count($this->details),
            'Admins' => User::where('role', 'admin')->count(),
            'Facility Mgrs' => User::where('role', 'facility_manager')->count(),
            'Coaches' => User::where('role', 'coach')->count(),
            'Players' => User::where('role', 'player')->count(),
            'Students' => User::where('role', 'student')->count(),
        ];
    }

    protected function loadPending(): void
    {
        $this->details = User::select('name', 'email', 'role', 'created_at')
            ->where('status', 'pending')->whereIn('role', ['player', 'coach'])
            ->orderBy('created_at', 'desc')->get()->toArray();
        $this->totals = ['Pending Approvals' => count($this->details)];
    }

    protected function loadTeams(): void
    {
        $this->details = Team::with('sport')
            ->select('name', 'sport_id', 'coach_id', 'created_at')
            ->orderBy('created_at', 'desc')->get()
            ->map(fn ($t) => [
                'name' => $t->name,
                'sport' => $t->sport?->name ?? '-',
                'created_at' => $t->created_at->format('d M Y'),
            ])->toArray();
        $this->totals = ['Total Teams' => count($this->details)];
    }

    protected function loadPlayers(): void
    {
        $this->details = Player::with('user', 'team')
            ->select('id', 'user_id', 'team_id', 'created_at')
            ->orderBy('created_at', 'desc')->get()
            ->map(fn ($p) => [
                'name' => $p->user?->name ?? '-',
                'team' => $p->team?->name ?? '-',
                'created_at' => $p->created_at->format('d M Y'),
            ])->toArray();
        $this->totals = ['Total Players' => count($this->details)];
    }

    protected function loadCoaches(): void
    {
        $this->details = Coach::with('user')
            ->select('id', 'user_id', 'created_at')
            ->orderBy('created_at', 'desc')->get()
            ->map(fn ($c) => [
                'name' => $c->user?->name ?? '-',
                'email' => $c->user?->email ?? '-',
                'created_at' => $c->created_at->format('d M Y'),
            ])->toArray();
        $this->totals = ['Total Coaches' => count($this->details)];
    }

    protected function loadMatches(): void
    {
        $this->details = Matches::with(['homeTeam', 'awayTeam', 'sport'])
            ->select('id', 'home_team_id', 'away_team_id', 'sport_id', 'match_date', 'status')
            ->orderBy('match_date', 'desc')->get()
            ->map(fn ($m) => [
                'home' => $m->homeTeam?->name ?? '-',
                'away' => $m->awayTeam?->name ?? '-',
                'sport' => $m->sport?->name ?? '-',
                'date' => $m->match_date?->format('d M Y') ?? '-',
                'status' => $m->status,
            ])->toArray();
        $this->totals = [
            'Total' => count($this->details),
            'Pending' => Matches::where('status', 'pending')->count(),
            'Live' => Matches::where('status', 'live')->count(),
            'Finished' => Matches::where('status', 'finished')->count(),
        ];
    }

    protected function loadCompleted(): void
    {
        $this->details = Matches::with(['homeTeam', 'awayTeam', 'sport'])
            ->where('status', 'finished')
            ->select('id', 'home_team_id', 'away_team_id', 'sport_id', 'match_date', 'home_score', 'away_score')
            ->orderBy('match_date', 'desc')->get()
            ->map(fn ($m) => [
                'home' => $m->homeTeam?->name ?? '-',
                'score' => ($m->home_score ?? '?') . ' - ' . ($m->away_score ?? '?'),
                'away' => $m->awayTeam?->name ?? '-',
                'sport' => $m->sport?->name ?? '-',
                'date' => $m->match_date?->format('d M Y') ?? '-',
            ])->toArray();
        $this->totals = ['Completed Matches' => count($this->details)];
    }

    protected function loadBookings(): void
    {
        $this->details = VenueBooking::with(['venue', 'user'])
            ->select('id', 'venue_id', 'user_id', 'organizer_name', 'booking_date', 'start_time', 'end_time', 'status', 'reference_number')
            ->orderBy('created_at', 'desc')->get()
            ->map(fn ($b) => [
                'ref' => $b->reference_number,
                'venue' => $b->venue?->name ?? '-',
                'organizer' => $b->organizer_name,
                'date' => $b->booking_date->format('d M Y'),
                'time' => substr($b->start_time, 0, 5) . ' - ' . substr($b->end_time, 0, 5),
                'status' => $b->status,
            ])->toArray();
        $this->totals = [
            'Total' => count($this->details),
            'Approved' => VenueBooking::where('status', 'approved')->count(),
            'Pending' => VenueBooking::whereIn('status', ['pending_approval', 'pending_signature'])->count(),
            'Rejected' => VenueBooking::where('status', 'rejected')->count(),
        ];
    }
}
