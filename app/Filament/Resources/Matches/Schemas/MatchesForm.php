<?php

namespace App\Filament\Resources\Matches\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MatchesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('competition_id')
                    ->relationship('competition', 'name')
                    ->required(),
                Select::make('home_team_id')
                    ->relationship('homeTeam', 'name')
                    ->required(),
                Select::make('away_team_id')
                    ->relationship('awayTeam', 'name')
                    ->required(),
                Select::make('venue_id')
                    ->relationship('venue', 'name'),
                TextInput::make('home_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('away_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('status')
                    ->required()
                    ->default('scheduled'),
                DateTimePicker::make('match_date')
                    ->required(),
                TextInput::make('minute')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_featured')
                    ->required(),
                Textarea::make('match_notes')
                    ->columnSpanFull(),
            ]);
    }
}
