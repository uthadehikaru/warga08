<?php

namespace App\Filament\Resources\ArrivalResource\Pages;

use App\Filament\Resources\ArrivalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArrivals extends ListRecords
{
    protected static string $resource = ArrivalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
