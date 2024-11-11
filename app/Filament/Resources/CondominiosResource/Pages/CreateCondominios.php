<?php

namespace App\Filament\Resources\CondominiosResource\Pages;

use App\Filament\Resources\CondominiosResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCondominios extends CreateRecord
{
    protected static string $resource = CondominiosResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['clientes_id'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Condomínio criado com sucesso!';
    }
}
