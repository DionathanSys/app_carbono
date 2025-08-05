<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = Auth::user()->id;

                    return $data;
                }),
        ];
    }
}
