<?php

namespace App\Filament\Resources\Standings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StandingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('competition.name')
                    ->searchable(),
                TextColumn::make('team.name')
                    ->searchable(),
                TextColumn::make('played')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('won')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('drawn')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lost')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('goals_for')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('goals_against')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('goal_difference')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('points')
                    ->numeric()
                    ->sortable(),
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
                //
            ])
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
