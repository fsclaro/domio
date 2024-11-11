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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['clientes_id'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Condomínio atualizado com sucesso!';
    }
}
