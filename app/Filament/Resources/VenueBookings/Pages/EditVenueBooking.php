<?php

namespace App\Filament\Resources\VenueBookings\Pages;

use App\Filament\Resources\VenueBookings\VenueBookingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVenueBooking extends EditRecord
{
    protected static string $resource = VenueBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
