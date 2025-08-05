<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateProperty extends CreateRecord
{
    protected static string $resource = PropertyResource::class;

}
