<?php

namespace App\Filament\Resources\ArrivalResource\Pages;

use App\Filament\Resources\ArrivalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArrival extends EditRecord
{
    protected static string $resource = ArrivalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
