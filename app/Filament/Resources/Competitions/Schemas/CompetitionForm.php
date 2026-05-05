<?php

namespace App\Filament\Resources\Competitions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CompetitionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sport_id')
                    ->label('Sport_number')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->default('league'),
                TextInput::make('season'),
                DatePicker::make('start_date')
                    ->columnSpanFull(),
                DatePicker::make('end_date')
                    ->columnSpanFull(),
                TextInput::make('logo'),
                Toggle::make('is_active')
                    ->required(),
            ])
            ->columns(3)
        ;
    }
}
