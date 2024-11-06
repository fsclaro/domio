<?php

namespace App\Enums;

enum YesNoEnum: int
{
    case NO  = 0;
    case YES = 1;

    public function description(): string
    {
        return match ($this) {
            self::NO  => 'Não',
            self::YES => 'Sim',
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
