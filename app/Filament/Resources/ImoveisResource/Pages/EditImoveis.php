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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Imóvel atualizado com sucesso!';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

}
