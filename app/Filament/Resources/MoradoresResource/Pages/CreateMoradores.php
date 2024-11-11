<?php

namespace App\Filament\Resources\MoradoresResource\Pages;

use App\Filament\Resources\MoradoresResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMoradores extends CreateRecord
{
    protected static string $resource = MoradoresResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Morador criado com sucesso!';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }
}
