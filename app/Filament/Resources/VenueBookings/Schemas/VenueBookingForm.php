<?php

namespace App\Filament\Resources\VenueBookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VenueBookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('venue_id')
                    ->relationship('venue', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('purpose')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Football training session'),

                Textarea::make('description')
                    ->rows(3)
                    ->placeholder('Additional details about the booking'),

                TextInput::make('expected_attendees')
                    ->numeric()
                    ->required()
                    ->label('Expected Number of Attendees'),


                Section::make('Date & Time')
                    ->schema([
                        DatePicker::make('booking_date')
                            ->required()
                            ->minDate(now()->toDateString())
                            ->label('Booking Date'),

                        TimePicker::make('start_time')
                            ->required()
                            ->label('Start Time'),

                        TimePicker::make('end_time')
                            ->required()
                            ->label('End Time')
                            ->after('start_time'),
                    ])->columns(3),

                Section::make('Organizer Information')
                    ->schema([
                        TextInput::make('organizer_name')
                            ->required()
                            ->label('Organizer Name'),

                        TextInput::make('organizer_phone')
                            ->required()
                            ->tel()
                            ->label('Phone Number'),

                        TextInput::make('organizer_email')
                            ->required()
                            ->email()
                            ->label('Email Address'),
                    ])->columns(3),

            ])->columns(2);
    }
}
