<?php

namespace App\Filament\Resources\Venues\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VenueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('location'),
                TextInput::make('capacity')
                    ->numeric(),
                TextInput::make('photo'),
                TextInput::make('google_maps_url')
                    ->url(),
            ]);
    }
}
