<?php

namespace App\Enum;

enum StatusDiversosEnum: string
{
    case PENDENTE   = 'PENDENTE';
    case VALIDO     = 'VÁLIDO';
    case INVALIDO   = 'INVÁLIDO';
    case CANCELADO  = 'CANCELADO';
    case BLOQUEADO  = 'BLOQUEADO';

    public static function toSelectArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($item) => [$item->value => $item->value])
            ->toArray();
    }
}
