<?php

namespace App\Filament\Resources;

use App\Enum\PropertyTypeEnum;
use App\Enum\TipoServicoEnum;
use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $pluralModelLabel = 'Propriedades';

    protected static ?string $pluralLabel = 'Propriedades';

    protected static ?string $label = 'Propriedade';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::getNameFormFields(),
                static::getAreaFormFields(),
                static::getLocationFormFields(),
                static::getPropertyTypeFormFields(),
                static::getCarCodeFormFields(),
                static::getIsActiveFormFields(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query->where('user_id', Auth::user()->id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('area')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('property_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('car_code')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            // 'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }

    public static function getNameFormFields(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('name')
            ->label('Descrição')
            ->autocomplete(false)
            ->required()
            ->maxLength(255);
    }

    public static function getAreaFormFields(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('area')
            ->label('Área (m²)')
            ->autocomplete(false)
            ->numeric()
            ->inputMode('decimal')
            ->required();
    }

    public static function getLocationFormFields(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('location')
            ->label('Localização')
            ->autocomplete(false)
            ->required()
            ->maxLength(255);
    }

    public static function getPropertyTypeFormFields(): Forms\Components\Select
    {
        return Forms\Components\Select::make('property_type')
            ->label('Tipo de Propriedade')
            ->required()
            ->options(PropertyTypeEnum::toSelectArray());
    }

    // Cadastro Ambiental Rural
    public static function getCarCodeFormFields(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('car_code')
            ->label('Código CAR')
            ->autocomplete(false)
            ->hint('Código do Cadastro Ambiental Rural')
            ->required()
            ->maxLength(255);
    }

    public static function getIsActiveFormFields(): Forms\Components\Toggle
    {
        return Forms\Components\Toggle::make('is_active')
            ->label('Ativo')
            ->inline(false)
            ->default(true)
            ->required();
    }
}


//                 Forms\Components\Toggle::make('is_active')
//                     ->required(),
//                 Forms\Components\TextInput::make('status'),

