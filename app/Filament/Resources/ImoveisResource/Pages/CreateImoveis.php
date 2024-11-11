<?php

namespace App\Filament\Resources\ImoveisResource\Pages;

use App\Filament\Resources\ImoveisResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateImoveis extends CreateRecord
{
    protected static string $resource = ImoveisResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Imóvel criado com sucesso!';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }

}
