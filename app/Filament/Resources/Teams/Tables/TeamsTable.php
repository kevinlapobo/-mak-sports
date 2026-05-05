<?php

namespace App\Filament\Resources\Teams\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sport.name')
                    ->searchable(),
                TextColumn::make('coach.name')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('logo')
                    ->searchable(),
                TextColumn::make('faculty')
                    ->searchable(),
                TextColumn::make('home_venue')
                    ->searchable(),
                TextColumn::make('founded_year')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('Sport')
                    ->searchable()
                    ->placeholder('search any sport')
                    ->options([
                        'football' => 'football',
                        'Tennis' => 'Tennis',
                        'Basketball' => 'Basketball',
                        'Badminton' => 'Badminton',
                        'Volleyball' => 'Volleyball',
                        'Rugby' => 'Rugby',
                        'Netball' => 'Netball',
                        'Athletics' => 'Athletics',
                        'Swimming' => 'Swimming'

                    ]),
                SelectFilter::make('Name')
                    ->searchable('name of team'),
                SelectFilter::make('Faculty')
                    ->searchable()

            ])
            ->FiltersLayout(filtersLayout::AboveContent)
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
