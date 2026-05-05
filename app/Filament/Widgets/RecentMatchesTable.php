<?php

namespace App\Filament\Widgets;

use App\Models\Matches;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentMatchesTable extends TableWidget
{
    protected static ?int $sort = 5;
    protected int|array|string $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Matches::with(['homeTeam', 'awayTeam', 'competition'])
            ->where('status', 'finished')
            ->orderByDesc('match_date')
            ->latest('match_date')
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('match_date')
                ->label('Date')
                ->dateTime('M d, Y H:i')
                ->sortable(),
            Tables\Columns\TextColumn::make('homeTeam.name')
                ->label('Home Team')
                ->searchable(),
            Tables\Columns\TextColumn::make('home_score')
                ->label('Score')
                ->alignCenter(),
            Tables\Columns\TextColumn::make('away_score')
                ->label('')
                ->alignCenter(),
            Tables\Columns\TextColumn::make('awayTeam.name')
                ->label('Away Team')
                ->searchable(),
            Tables\Columns\TextColumn::make('competition.name')
                ->label('Competition')
                ->badge()
                ->color('success'),
            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'finished' => 'success',
                    'live' => 'danger',
                    'scheduled' => 'warning',
                    'cancelled' => 'gray',
                    default => 'gray',
                }),
        ];
    }

    protected function getTableHeading(): string
    {
        return 'Recent Match Results';
    }

    protected function getTablePaginationEnabled(): bool
    {
        return false;
    }
}
