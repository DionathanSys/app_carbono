<?php

namespace App\Enum;

enum PropertyTypeEnum: string
{
    case RURAL = 'RURAL';
    case URBANA = 'URBANA';

    public static function toSelectArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($item) => [$item->value => $item->value])
            ->toArray();
    }
}
