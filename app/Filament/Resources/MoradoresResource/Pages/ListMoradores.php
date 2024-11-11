<?php

namespace App\Filament\Resources\MoradoresResource\Pages;

use App\Filament\Resources\MoradoresResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMoradores extends ListRecords
{
    protected static string $resource = MoradoresResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
