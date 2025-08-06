<?php

namespace App\Filament\Resources;

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

    protected static ?string $pluralModelLabel = 'Instrumentos';

    protected static ?string $pluralLabel = 'Instrumentos';

    protected static ?string $label = 'Instrumento';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(6)
            ->schema([
                Forms\Components\Select::make('property_id')
                    ->label('Propriedade')
                    ->columnSpan(4)
                    ->relationship('property', 'name')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->columnSpan(2)
                    ->options([
                    ])
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Quantidade')
                    ->columnSpan(2)
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('unit')
                    ->label('Unidade')
                    ->columnSpan(2)
                    ->options([
                        'kg' => 'Quilograma',
                        'g' => 'Grama',
                        'l' => 'Litro',
                        'ml' => 'Mililitro',
                    ]),
                Forms\Components\TextInput::make('value')
                    ->label('Valor')
                    ->prefix('R$')
                    ->columnSpan(2)
                    ->numeric(),
                Forms\Components\TextInput::make('description')
                    ->label('Descrição')
                    ->columnSpan(3)
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->columnSpan(2)
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Ativo')
                    ->inline(false)
                    ->columnSpan(1)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('property_id')
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->numeric()
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
}
