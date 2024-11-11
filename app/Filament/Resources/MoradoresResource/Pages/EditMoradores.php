<?php

namespace App\Filament\Resources\MoradoresResource\Pages;

use App\Filament\Resources\MoradoresResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMoradores extends EditRecord
{
    protected static string $resource = MoradoresResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Morador atualizado com sucesso!';
    }
}
