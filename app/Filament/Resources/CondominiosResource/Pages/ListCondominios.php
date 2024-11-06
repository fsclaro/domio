<?php

namespace App\Filament\Resources\CondominiosResource\Pages;

use App\Filament\Resources\CondominiosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCondominios extends ListRecords
{
    protected static string $resource = CondominiosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
