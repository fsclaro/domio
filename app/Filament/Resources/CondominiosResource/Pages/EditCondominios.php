<?php

namespace App\Filament\Resources\CondominiosResource\Pages;

use App\Filament\Resources\CondominiosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCondominios extends EditRecord
{
    protected static string $resource = CondominiosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
