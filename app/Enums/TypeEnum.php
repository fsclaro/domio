<?php

namespace App\Enums;

enum TypeEnum: int
{
    case DOMIO                = 0;
    case GESTOR               = 1;
    case PROPRIETARIO_MORADOR = 2;

    public function description(): string
    {
        return match ($this) {
            self::DOMIO                => 'Adm. Domio',
            self::GESTOR               => 'Gestor Condomínio',
            self::PROPRIETARIO_MORADOR => 'Proprietário/Morador',
        };
    }

    public static function all(): array
    {
        return array_map(fn ($status) => [
            'value'       => $status->value,
            'description' => $status->description(),
        ], self::cases());
    }
}
