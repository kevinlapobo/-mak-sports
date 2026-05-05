<?php

namespace App\Filament\Widgets;

use App\Models\Matches;
use App\Models\Team;
use App\Models\Player;
use App\Models\Competition;
use App\Models\NewsUpdate;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SportsStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Total Teams', Team::count())
                ->description('Active teams')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Players', Player::count())
                ->description('Registered players')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            Stat::make('Competitions', Competition::count())
                ->description('Active competitions')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('warning'),
            Stat::make('Total Matches', Matches::count())
                ->description('All matches')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
            Stat::make('Live Matches', Matches::where('status', 'live')->count())
                ->description('Currently in progress')
                ->descriptionIcon('heroicon-m-signal')
                ->color('danger'),
            Stat::make('News Articles', NewsUpdate::count())
                ->description('Published articles')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('success'),
        ];
    }
}
