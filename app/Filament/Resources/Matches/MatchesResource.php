<?php

namespace App\Filament\Resources\Matches;

use App\Filament\Resources\Matches\Pages\CreateMatches;
use App\Filament\Resources\Matches\Pages\EditMatches;
use App\Filament\Resources\Matches\Pages\ListMatches;
use App\Filament\Resources\Matches\Schemas\MatchesForm;
use App\Filament\Resources\Matches\Tables\MatchesTable;
use App\Models\Matches;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MatchesResource extends Resource
{
    protected static ?string $model = Matches::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBold;

    protected static ?string $recordTitleAttribute = 'Matches';

    protected static string|UnitEnum|null $navigationGroup = 'Games';


    public static function form(Schema $schema): Schema
    {
        return MatchesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MatchesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMatches::route('/'),
            'create' => CreateMatches::route('/create'),
            'edit' => EditMatches::route('/{record}/edit'),
        ];
    }
}
