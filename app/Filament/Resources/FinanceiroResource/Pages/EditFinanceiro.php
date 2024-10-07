<?php

namespace App\Filament\Resources\FinanceiroResource\Pages;

use App\Filament\Resources\FinanceiroResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinanceiro extends EditRecord
{
    protected static string $resource = FinanceiroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
