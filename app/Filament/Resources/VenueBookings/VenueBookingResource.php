<?php

namespace App\Filament\Resources\VenueBookings;

use App\Filament\Resources\VenueBookings\Pages\CreateVenueBooking;
use App\Filament\Resources\VenueBookings\Pages\EditVenueBooking;
use App\Filament\Resources\VenueBookings\Pages\ListVenueBookings;
use App\Filament\Resources\VenueBookings\Schemas\VenueBookingForm;
use App\Filament\Resources\VenueBookings\Tables\VenueBookingsTable;
use App\Models\VenueBooking;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VenueBookingResource extends Resource
{
    protected static ?string $model = VenueBooking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBolt;

    protected static ?string $recordTitleAttribute = 'VenueBooking';

    protected static string|UnitEnum|null $navigationGroup = 'Venueu Management';


    public static function form(Schema $schema): Schema
    {
        return VenueBookingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VenueBookingsTable::configure($table);
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
            'index' => ListVenueBookings::route('/'),
            'create' => CreateVenueBooking::route('/create'),
            'edit' => EditVenueBooking::route('/{record}/edit'),
        ];
    }
}
