<?php

namespace App\Filament\Resources\OfferResource\Pages;

use App\Filament\Resources\OfferResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListOffers extends ListRecords
{
    protected static string $resource = OfferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Propostas Realizadas' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', Auth::id())),
            'Propostas Recebidas' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('instrument', function (Builder $query) {
                    $query->where('user_id', Auth::id());
                })),


        ];
    }
}
