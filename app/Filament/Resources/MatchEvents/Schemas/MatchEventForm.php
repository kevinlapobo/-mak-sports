<?php

namespace App\Filament\Resources\MatchEvents\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MatchEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('match_id')
                    ->required()
                    ->numeric(),
                TextInput::make('team_id')
                    ->required()
                    ->numeric(),
                TextInput::make('player_id')
                    ->numeric(),
                TextInput::make('event_type')
                    ->required(),
                TextInput::make('minute')
                    ->required()
                    ->numeric(),
                TextInput::make('description'),
            ]);
    }
}
