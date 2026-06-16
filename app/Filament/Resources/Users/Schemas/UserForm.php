<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Phone')
                    ->maxLength(20),
                Select::make('role')
                    ->options([
                        'student' => 'Student',
                        'player' => 'Player',
                        'coach' => 'Coach',
                        'facility_manager' => 'Facility Manager',
                    ])
                    ->required(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                    ])
                    ->required(),
                TextInput::make('student_number')
                    ->label('Student Number')
                    ->maxLength(50),
                TextInput::make('password')
                    ->password()
                    ->hiddenOn('edit')
                    ->required(),
            ]);
    }
}
