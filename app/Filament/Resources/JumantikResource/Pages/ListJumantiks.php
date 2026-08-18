<?php

namespace App\Filament\Resources\JumantikResource\Pages;

use App\Filament\Resources\JumantikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJumantiks extends ListRecords
{
    protected static string $resource = JumantikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
