<?php

namespace App\Filament\Resources\VenueBookings\Pages;

use App\Filament\Resources\VenueBookings\VenueBookingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVenueBookings extends ListRecords
{
    protected static string $resource = VenueBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
