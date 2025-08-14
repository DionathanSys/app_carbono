<?php

namespace App\Filament\Resources;

use App\Enum\StatusOfferEnum;
use App\Filament\Resources\OfferResource\Pages;
use App\Filament\Resources\OfferResource\RelationManagers;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Leandrocfe\FilamentPtbrFormFields\Money;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?int $navigationSort = 6;

    protected static ?string $pluralModelLabel = 'Ofertas';

    protected static ?string $pluralLabel = 'Ofertas';

    protected static ?string $label = 'Oferta';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(7)
            ->schema([
                Forms\Components\Select::make('instrument_id')
                    ->label('Ativo')
                    ->columnSpan(3)
                    ->required()
                    ->relationship('instrument', 'description')
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('amount')
                    ->label('Quantidade')
                    ->columnSpan(2)
                    ->required()
                    ->prefix(null),
                Money::make('value')
                    ->label('Valor')
                    ->columnSpan(2)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->with('user', 'instrument');

            })
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->visible(fn() => Auth::user()->is_admin)
                    ->sortable(),
                Tables\Columns\TextColumn::make('instrument.description')
                    ->label('Ativo')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Quantidade')
                    ->numeric(2, ',', '.')
                    ->formatStateUsing(function ($state, $record) {
                        return Auth::user()->is_admin || $record->user_id === Auth::id() || $record->status === StatusOfferEnum::VISUALIZADO
                            ? number_format((float) $state, 2, ',', '.')
                            : 'Aguardando visualização';
                    })
                    ->suffix(fn ($state, $record) => $record?->instrument->unit ? ' ' . $record->instrument->unit : ''),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->formatStateUsing(function ($state, $record) {
                        return Auth::user()->is_admin || $record->user_id === Auth::id() || $record->status !== StatusOfferEnum::PENDENTE
                            ? 'R$ ' . number_format((float) $state, 2, ',', '.')
                            : 'Aguardando visualização';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->visible(fn(Offer $record) => $record->status == StatusOfferEnum::PENDENTE && $record->user_id !== Auth::id())
                    ->mutateRecordDataUsing(function (array $data, Offer $record): array {
                        $record->update([
                            'status' => StatusOfferEnum::VISUALIZADO,
                        ]);
                        $data['amount'] = $record->amount . ' ' . $record?->instrument->unit;
                        return $data;
                    }),
                Tables\Actions\Action::make('recusar')
                    ->iconButton(),
                Tables\Actions\Action::make('aceitar')
                    ->iconButton(),
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
