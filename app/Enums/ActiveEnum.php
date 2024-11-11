<?php

namespace App\Enums;

enum ActiveEnum: int
{
    case INACTIVE = 0;
    case ACTIVE   = 1;

    public function description(): string
    {
        return match ($this) {
            self::ACTIVE   => 'Ativo',
            self::INACTIVE => 'Inativo',
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
