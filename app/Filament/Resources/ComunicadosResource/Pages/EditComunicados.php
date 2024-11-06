<?php

namespace App\Filament\Resources\ComunicadosResource\Pages;

use App\Filament\Resources\ComunicadosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComunicados extends EditRecord
{
    protected static string $resource = ComunicadosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
