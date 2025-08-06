<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $pluralModelLabel = 'Documentos';

    protected static ?string $pluralLabel = 'Documentos';

    protected static ?string $label = 'Documento';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome do Documento')
                    ->required(),
                Forms\Components\TextInput::make('file_path')
                    ->label('Caminho do Arquivo')
                    ->required(),
                Forms\Components\TextInput::make('file_name')
                    ->label('Nome do Arquivo')
                    ->required(),
                Forms\Components\TextInput::make('mime_type')
                    ->label('Tipo MIME')
                    ->nullable(),
                Forms\Components\TextInput::make('file_size')
                    ->label('Tamanho do Arquivo (bytes)')
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->label('Descrição')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('documentable_type')
                    ->label('Tipo do Documento Associado')
                    ->required(),
                Forms\Components\TextInput::make('documentable_id')
                    ->label('ID do Documento Associado')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Ativo')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome do Documento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->label('Caminho do Arquivo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_name')
                    ->label('Nome do Arquivo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mime_type')
                    ->label('Tipo MIME')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_size')
                    ->label('Tamanho do Arquivo (bytes)')
                    ->numeric('2', ',', '.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('documentable_type')
                    ->label('Tipo do Documento Associado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('documentable_id')
                    ->label('ID do Documento Associado')
                    ->numeric('0', ',', '.')
                    ->sortable(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
