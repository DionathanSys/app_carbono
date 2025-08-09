<?php

namespace App\Filament\Resources;

use App\Enum\InstrumentTypeEnum;
use App\Enum\StatusDiversosEnum;
use App\Filament\Resources\InstrumentResource\Pages;
use App\Filament\Resources\InstrumentResource\RelationManagers;
use App\Models\Instrument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstrumentResource extends Resource
{
    protected static ?string $model = Instrument::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $pluralModelLabel = 'Ativos';

    protected static ?string $pluralLabel = 'Ativos';

    protected static ?string $label = 'Instrumento';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(8)
            ->schema([
                static::getDescriptionFormFields(),
                static::getPropertyIdFormFields(),
                static::getTypeInstrumentFormFields(),
                static::getAmountFormFields(),
                static::getUnitFormFields(),
                static::getValueFormFields(),
                static::getIsActiveFormFields(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->owner()
                    ->with('property');
            })
            ->columns([
                Tables\Columns\TextColumn::make('property.name')
                    ->label('Propriedade')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Quantidade')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit')
                    ->label('Unidade')
                    ->numeric('2', ',', '.')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
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
            'index' => Pages\ListInstruments::route('/'),
            'edit' => Pages\EditInstrument::route('/{record}/edit'),
        ];
    }

    public static function getPropertyIdFormFields(): Forms\Components\Select
    {
        return Forms\Components\Select::make('property_id')
            ->label('Propriedade')
            ->columnSpan(4)
            ->relationship('property', 'name', fn(Builder $query) => $query->owner())
            ->required()
            ->native(false);
    }

    public static function getTypeInstrumentFormFields(): Forms\Components\Select
    {
        return Forms\Components\Select::make('type')
            ->label('Tipo')
            ->columnSpan(2)
            ->options(InstrumentTypeEnum::toSelectArray())
            ->required()
            ->native(false);
    }

    public static function getAmountFormFields(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('amount')
            ->label('Quantidade')
            ->columnSpan(2)
            ->autocomplete(false)
            ->numeric()
            ->required();
    }

    public static function getUnitFormFields(): Forms\Components\Select
    {
        return Forms\Components\Select::make('unit')
            ->label('Unidade')
            ->columnSpan(2)
            ->options([
                'm²' => 'Metros Quadrados',
                'ha' => 'Hectares',
            ])
            ->required()
            ->native(false);
    }

    public static function getValueFormFields(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('value')
            ->label('Valor')
            ->prefix('R$')
            ->columnSpan(2)
            ->autocomplete(false)
            ->numeric()
            ->required();
    }

    public static function getDescriptionFormFields(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('description')
            ->label('Descrição')
            ->columnSpan(4)
            ->autocomplete(false)
            ->required()
            ->maxLength(255);
    }

    public static function getStatusFormFields(): Forms\Components\Select
    {
        return Forms\Components\Select::make('status')
            ->label('Status')
            ->columnSpan(2)
            ->options(StatusDiversosEnum::toSelectArray())
            ->required()
            ->native(false);
    }

    public static function getIsActiveFormFields(): Forms\Components\Toggle
    {
        return Forms\Components\Toggle::make('is_active')
            ->label('Ativo')
            ->inline(false)
            ->columnSpan(1)
            ->required()
            ->default(true);
    }


}

