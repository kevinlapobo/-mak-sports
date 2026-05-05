<?php

namespace App\Filament\Resources\Matches\Pages;

use App\Filament\Resources\Matches\MatchesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMatches extends EditRecord
{
    protected static string $resource = MatchesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
