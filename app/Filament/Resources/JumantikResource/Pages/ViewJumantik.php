<?php

namespace App\Filament\Resources\JumantikResource\Pages;

use App\Filament\Resources\JumantikResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewJumantik extends ViewRecord
{
    protected static string $resource = JumantikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
