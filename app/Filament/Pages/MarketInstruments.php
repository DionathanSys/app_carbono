<?php

namespace App\Filament\Pages;

use App\Models\Instrument;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MarketInstruments extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Instrumentos à venda';
    protected static ?string $navigationGroup = 'Mercado';
    protected static ?int $navigationSort = 30;

    protected static ?string $title = 'Instrumentos disponíveis para venda';

    protected static ?string $slug = 'market/instruments';

    protected static string $view = 'filament.pages.market-instruments';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Instrument::query()
                    ->where('is_active', true)
                    ->where('status', 'disponivel')
                    ->when(Auth::id(), fn ($q, $id) => $q->where('user_id', '!=', $id))
            )
            ->columns([
                TextColumn::make('property.name')
                    ->label('Propriedade')
                    ->toggleable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Quantidade')
                    ->numeric(2, ',', '.')
                    ->suffix(fn ($state, $record) => $record?->unit ? ' ' . $record->unit : ''),
                TextColumn::make('value')
                    ->label('Valor')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => is_null($state) ? '-' : 'R$ ' . number_format((float) $state, 2, ',', '.')),
                TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Adicione filtros se necessário
            ])
            ->actions([
                // Sem ações de edição; é apenas uma vitrine
            ])
            ->bulkActions([])
            ->emptyStateHeading('Nenhum instrumento disponível')
            ->emptyStateDescription('Quando outros usuários anunciarem itens, eles aparecerão aqui.')
            ->defaultSort('created_at', 'desc');
    }
}
