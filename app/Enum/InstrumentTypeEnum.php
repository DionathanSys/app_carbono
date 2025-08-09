<?php

namespace App\Enum;

enum InstrumentTypeEnum: string
{
    case COTA_RESERVA_AMBIENTAL = 'COTA RESERVA AMBIENTAL';
    case CREDITO_CARBONO = 'CRÉDITO CARBONO';
    case COMPENSACAO_RESERVA_LEGAL = 'COMPENSAÇÃO RESERVA LEGAL';

    public static function toSelectArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($item) => [$item->value => $item->value])
            ->toArray();
    }
}
