<?php

namespace App\Filament\Resources\Players\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('team_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('photo'),
                TextInput::make('position'),
                TextInput::make('jersey_number')
                    ->numeric(),
                TextInput::make('student_id'),
                TextInput::make('year_of_study'),
                TextInput::make('faculty'),
                TextInput::make('goals')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('assists')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('yellow_cards')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('red_cards')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
