<?php

namespace App\Filament\Resources\ImoveisResource\Pages;

use App\Filament\Resources\ImoveisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImoveis extends ListRecords
{
    protected static string $resource = ImoveisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
