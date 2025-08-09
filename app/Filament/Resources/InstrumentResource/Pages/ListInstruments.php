<?php

namespace App\Filament\Resources\InstrumentResource\Pages;

use App\Enum\StatusDiversosEnum;
use App\Filament\Resources\InstrumentResource;
use App\Models\Instrument;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;

class ListInstruments extends ListRecords
{
    protected static string $resource = InstrumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ativo')
                ->icon('heroicon-o-plus')
                ->modalWidth(MaxWidth::FiveExtraLarge)
                ->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = Auth::id();
                    $data['status'] = StatusDiversosEnum::PENDENTE;
                    return $data;
                })
                ->successRedirectUrl(fn(Instrument $record): string => InstrumentResource::getUrl('edit', ['record' => $record->id])),
        ];
    }
}
