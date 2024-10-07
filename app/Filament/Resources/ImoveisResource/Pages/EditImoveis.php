<?php

namespace App\Filament\Resources\ImoveisResource\Pages;

use App\Filament\Resources\ImoveisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImoveis extends EditRecord
{
    protected static string $resource = ImoveisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
