<?php

namespace App\Filament\Resources\JumantikResource\Pages;

use App\Filament\Resources\JumantikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJumantik extends EditRecord
{
    protected static string $resource = JumantikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
