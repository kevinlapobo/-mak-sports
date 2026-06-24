<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\Fixtures;
use App\Livewire\Pages\Results;
use App\Livewire\Pages\Standings;
use App\Livewire\Pages\LiveScores;
use App\Livewire\Pages\Teams;
use App\Livewire\Pages\TeamDetail;
use App\Livewire\Pages\PlayerDetail;
use App\Livewire\Pages\MatchDetail;
use App\Livewire\Pages\NewsDetail;
use App\Livewire\Pages\Contacts;
use App\Livewire\Notifications\NotificationsPage;
use App\Livewire\Admin\ManageFixtures;
use App\Livewire\Admin\AddResults;
use App\Livewire\Admin\PendingResults;
use App\Livewire\Admin\NewTeams;
use App\Livewire\Admin\ManageMatch;
use App\Livewire\Venues\Index as VenuesIndex;
use App\Livewire\Venues\BookVenue;
use App\Livewire\Venues\BookingReceipt;
use App\Livewire\Venues\BookingPending;
use App\Livewire\Coach\Profile as CoachProfile;
use App\Livewire\Coach\Stats as CoachStats;
use App\Livewire\Coach\MyTeams as CoachMyTeams;
use App\Livewire\Player\Profile as PlayerProfile;
use App\Livewire\Facility\Approvals as FacilityApprovals;
use App\Livewire\Facility\VenueBookings as FacilityVenueBookings;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\BookingPrintController;

Route::get('/',           Home::class)->name('home');
Route::get('/fixtures',   Fixtures::class)->name('fixtures');
Route::get('/results',    Results::class)->name('results');
Route::get('/teams',      Teams::class)->name('teams');
Route::get('/teams/{slug}',   TeamDetail::class)->name('team.detail');
Route::get('/players/{id}',   PlayerDetail::class)->name('player.detail');
Route::get('/matches/{id}',   MatchDetail::class)->name('match.detail');
Route::get('/news/{id}',      NewsDetail::class)->name('news.detail');
Route::get('/contact',        Contacts::class)->name('contact');

Route::get('/live',       LiveScores::class)->name('live')->middleware('auth');
Route::get('/standings',  Standings::class)->name('standings')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/venues', VenuesIndex::class)->name('venues.index');
    Route::get('/venues/{venueId}/book', BookVenue::class)->name('venue.book');
    Route::get('/venue-receipt/{id}',      BookingReceipt::class)->name('venue.receipt');
    Route::get('/venue-pending/{id}',      BookingPending::class)->name('venue.pending');
    Route::get('/coach/profile',           CoachProfile::class)->name('coach.profile');
    Route::get('/coach/stats',             CoachStats::class)->name('coach.stats');
    Route::get('/coach/my-teams',          CoachMyTeams::class)->name('coach.my-teams');
    Route::get('/player/profile',          PlayerProfile::class)->name('player.profile');
    Route::get('/facility/approvals',      FacilityApprovals::class)->name('facility.approvals');
    Route::get('/facility/venue-bookings', FacilityVenueBookings::class)->name('facility.venue-bookings');
    Route::get('/notifications',           NotificationsPage::class)->name('notifications');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/manage/fixtures', ManageFixtures::class)->name('admin.manage-fixtures');
    Route::get('/manage/results',  AddResults::class)->name('admin.add-results');
    Route::get('/manage/pending',  PendingResults::class)->name('admin.pending-results');
    Route::get('/manage/new-teams', NewTeams::class)->name('admin.new-teams');
    Route::get('/manage/match/{id}', ManageMatch::class)->name('admin.manage-match');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/venue-bookings/{id}/print', [BookingPrintController::class, 'print'])->name('admin.venue-bookings.print');
});

Route::get('/debug-auth', function () {
    $user = auth()->user();
    if (!$user) return 'Not authenticated';
    return "User: {$user->name}<br>Email: {$user->email}<br>Role: {$user->role}<br>ID: {$user->id}";
})->middleware('auth');
