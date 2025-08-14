<?php

namespace App\Enum;

enum StatusOfferEnum: string
{
    case PENDENTE   = 'PENDENTE';
    case VISUALIZADO = 'VISUALIZADO';
    case APROVADO   = 'APROVADO';
    case REJEITADO  = 'REJEITADO';
    case CONCLUIDO  = 'CONCLUÍDO';
    case CANCELADO  = 'CANCELADO';

    public static function toSelectArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($item) => [$item->value => $item->value])
            ->toArray();
    }
}
