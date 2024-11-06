<?php

namespace App\Filament\Resources\ComunicadosResource\Pages;

use App\Filament\Resources\ComunicadosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListComunicados extends ListRecords
{
    protected static string $resource = ComunicadosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
