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
            ->columns(6)
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
                return $query->owner();
            })
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Descrição')
                    ->searchable(),
                Tables\Columns\TextColumn::make('area')
                    ->label('Área (m²)')
                    ->numeric('2', ',', '.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Localização')
                    ->searchable(),
                Tables\Columns\TextColumn::make('property_type')
                    ->label('Tipo de Propriedade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('car_code')
                    ->label('Código CAR')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Excluído em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(false),
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
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }

    public static function getNameFormFields(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('name')
            ->label('Descrição')
            ->columnSpan(4)
            ->autocomplete(false)
            ->required()
            ->maxLength(255);
    }

    public static function getAreaFormFields(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('area')
            ->label('Área (m²)')
            ->columnSpan(2)
            ->autocomplete(false)
            ->numeric()
            ->inputMode('decimal')
            ->required();
    }

    public static function getLocationFormFields(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('location')
            ->label('Localização')
            ->columnSpan(4)
            ->autocomplete(false)
            ->required()
            ->maxLength(255);
    }

    public static function getPropertyTypeFormFields(): Forms\Components\Select
    {
        return Forms\Components\Select::make('property_type')
            ->label('Tipo de Propriedade')
            ->columnSpan(2)
            ->required()
            ->options(PropertyTypeEnum::toSelectArray());
    }

    // Cadastro Ambiental Rural
    public static function getCarCodeFormFields(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('car_code')
            ->label('Código CAR')
            ->columnSpan(4)
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

