<?php

namespace App\Enum;

enum BiomaEnum: string
{
    case AMAZONIA       = 'Amazônia';
    case CERRADO        = 'Cerrado';
    case CAATINGA       = 'Caatinga';
    case MATA_ATLANTICA = 'Mata Atlântica';
    case PAMPA          = 'Pampa';
    case PANTANAL       = 'Pantanal';

    /**
     * Retorna todos os valores como array
     */
    public static function toSelectArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($item) => [$item->value => $item->value])
            ->toArray();
    }

    /**
     * Retorna código abreviado do bioma
     */
    public function codigo(): string
    {
        return match ($this) {
            self::AMAZONIA => 'AMAZ',
            self::CERRADO => 'CERR',
            self::CAATINGA => 'CAAT',
            self::MATA_ATLANTICA => 'MATA',
            self::PAMPA => 'PAMP',
            self::PANTANAL => 'PANT',
        };
    }
}
