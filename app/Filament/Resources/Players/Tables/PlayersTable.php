<?php

namespace App\Filament\Resources\Players\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PlayersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('team_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('photo')
                    ->searchable(),
                TextColumn::make('position')
                    ->searchable(),
                TextColumn::make('jersey_number')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('student_id')
                    ->searchable(),
                TextColumn::make('year_of_study')
                    ->searchable(),
                TextColumn::make('faculty')
                    ->searchable(),
                TextColumn::make('goals')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('assists')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('yellow_cards')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('red_cards')
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
                SelectFilter::make('Name')
                    ->searchable(),
                SelectFilter::make('Goals')
                    ->searchable()
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
