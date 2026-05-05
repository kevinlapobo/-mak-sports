<?php

namespace App\Filament\Resources\VenueBookings\Tables;

use App\Models\VenueBooking;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use PHPUnit\Util\Filter;

class VenueBookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_number')
                    ->searchable()
                    ->sortable()
                    ->label('Ref #')
                    ->copyable(),

                TextColumn::make('venue.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('purpose')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('booking_date')
                    ->date('D, d M Y')
                    ->sortable(),

                TextColumn::make('start_time')
                    ->label('Time')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->start_time . ' - ' . $record->end_time
                    ),

                TextColumn::make('organizer_name')
                    ->searchable(),

                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger'  => 'rejected',
                    ]),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending'  => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),

                SelectFilter::make('venue')
                    ->relationship('venue', 'name'),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->actions([
                ViewAction::make(),
                EditAction::make(),

                // APPROVE ACTION
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => $record->isPending())
                    ->requiresConfirmation()
                    ->modalHeading('Approve Booking')
                    ->modalDescription(
                        fn($record) =>
                        "Approve booking {$record->reference_number} for {$record->venue->name} on {$record->booking_date->format('d M Y')}?"
                    )
                    ->action(function (VenueBooking $record) {
                        // Check for conflicts before approving
                        $conflict = VenueBooking::hasConflict(
                            $record->venue_id,
                            $record->booking_date,
                            $record->start_time,
                            $record->end_time,
                            $record->id
                        );

                        if ($conflict) {
                            \Filament\Notifications\Notification::make()
                                ->title('Conflict detected!')
                                ->body('Another approved booking exists for this venue at the same time.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->update([
                            'status'      => 'approved',
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title("✅ Booking {$record->reference_number} approved")
                            ->success()
                            ->send();
                    }),

                // REJECT ACTION
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn($record) => $record->isPending())
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Reason for rejection')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (VenueBooking $record, array $data) {
                        $record->update([
                            'status'           => 'rejected',
                            'rejection_reason' => $data['rejection_reason'],
                            'approved_by'      => auth()->id(),
                            'approved_at'      => now(),
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title("Booking {$record->reference_number} rejected")
                            ->warning()
                            ->send();
                    }),

                // PRINT CONFIRMATION
                Action::make('print')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->visible(fn($record) => $record->isApproved())
                    ->url(fn($record) => route('admin.venue-bookings.print', $record->id))
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
