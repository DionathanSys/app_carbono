<?php

namespace App\Filament\Pages;

use App\Enum\BiomaEnum;
use App\Enum\InstrumentTypeEnum;
use App\Enum\StatusDiversosEnum;
use App\Models\Instrument;
use App\Services\Offer\OfferFacade;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Forms;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Leandrocfe\FilamentPtbrFormFields\Money;

class MarketInstruments extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationLabel = 'Ativos à venda';

    protected static ?int $navigationSort = 5;

    protected static ?string $title = '';

    protected static ?string $slug = 'market/ativos';

    protected static string $view = 'filament.pages.market-instruments';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Instrument::query()
                    ->where('is_active', true)
                    ->where('status', StatusDiversosEnum::VALIDO)
                    ->when(Auth::id(), fn ($q, $id) => $q->where('user_id', '!=', $id))
            )
            ->columns([
                Tables\Columns\TextColumn::make('property.bioma')
                    ->label('Bioma')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Quantidade')
                    ->numeric(2, ',', '.')
                    ->suffix(fn ($state, $record) => $record?->unit ? ' ' . $record->unit : ''),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),
                    // ->formatStateUsing(fn ($state) => is_null($state) ? '-' : 'R$ ' . number_format((float) $state, 2, ',', '.')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->groups([
                Tables\Grouping\Group::make('property.bioma')
                    ->label('Bioma')
                    ->collapsible(),
                Tables\Grouping\Group::make('type')
                    ->label('Tipo Ativo')
                    ->collapsible(),
            ])
            ->defaultGroup('property.bioma')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(InstrumentTypeEnum::toSelectArray())
                    ->label('Tipo de Ativo'),
                Tables\Filters\SelectFilter::make('property.bioma')
                    ->label('Tipo de Bioma')
                    ->options(BiomaEnum::toSelectArray())
                    ->query(function ($query, $state) {
                        if ($state['value']) {
                            return $query->whereHas('property', fn ($q) => $q->where('bioma', $state));
                        }
                        return $query;
                    })
            ])
            ->actions([
                Tables\Actions\Action::make('Proposta')
                    ->icon('heroicon-o-document-currency-dollar')
                    ->iconButton()
                    ->tooltip('Nova Proposta')
                    ->fillForm(fn(Instrument $record) => [
                        'amount' => $record->amount,
                        'value'  => $record->value,
                    ])
                    ->form(function (Forms\Form $form, Instrument $record) {
                        return $form
                            ->columns(4)
                            ->schema([
                                Forms\Components\TextInput::make('amount')
                                    ->label('Quantidade')
                                    ->columnSpan(2)
                                    ->prefix($record->unit)
                                    ->required()
                                    ->maxValue($record->amount)
                                    ->minValue(0.01),
                                Money::make('value')
                                    ->label('Valor')
                                    ->columnSpan(2)
                                    ->required()
                                    ->minValue(0.01),
                            ]);
                    })
                    ->modalWidth(MaxWidth::Small)
                    ->action(fn (Instrument $record, array $data) => OfferFacade::create($record, $data))
            ])
            ->bulkActions([])
            ->emptyStateHeading('Nenhum instrumento disponível')
            ->emptyStateDescription('Quando outros usuários anunciarem itens, eles aparecerão aqui.')
            ->defaultSort('created_at', 'desc');
    }
}
