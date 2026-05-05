<?php

namespace App\Filament\Resources\Standings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StandingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('competition_id')
                    ->relationship('competition', 'name')
                    ->required(),
                Select::make('team_id')
                    ->relationship('team', 'name')
                    ->required(),
                TextInput::make('played')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('won')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('drawn')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('lost')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('goals_for')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('goals_against')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('goal_difference')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('points')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
