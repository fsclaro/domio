<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CondominiosResource\Pages;
use App\Filament\Resources\CondominiosResource\RelationManagers;
use App\Models\Condominios;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CondominiosResource extends Resource
{
    protected static ?string $model = Condominios::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup     = 'Administração';
    protected static ?int $navigationSort         = 4;
    protected static ?string $modelLabel          = 'Condominio';
    protected static ?string $pluralModelLabel    = 'Condominios';
    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('clientes_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('razao_social')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('nome_fantasia')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('cnpj')
                    ->required()
                    ->maxLength(14),
                Forms\Components\TextInput::make('logradouro')
                    ->required()
                    ->maxLength(80),
                Forms\Components\TextInput::make('nro')
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('complemento')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('bairro')
                    ->required()
                    ->maxLength(40),
                Forms\Components\TextInput::make('cep')
                    ->required()
                    ->maxLength(9),
                Forms\Components\TextInput::make('cidade')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('uf')
                    ->required()
                    ->maxLength(2),
                Forms\Components\Toggle::make('ativo')
                    ->required(),
                Forms\Components\TextInput::make('nome_sindico')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('cpf_sindico')
                    ->required()
                    ->maxLength(11),
                Forms\Components\TextInput::make('fone_sindico')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('email_sindico')
                    ->email()
                    ->required()
                    ->maxLength(40),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('clientes_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('razao_social')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nome_fantasia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cnpj')
                    ->searchable(),
                Tables\Columns\TextColumn::make('logradouro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('complemento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bairro')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cep')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cidade')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uf')
                    ->searchable(),
                Tables\Columns\IconColumn::make('ativo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('nome_sindico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cpf_sindico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fone_sindico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_sindico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListCondominios::route('/'),
            'create' => Pages\CreateCondominios::route('/create'),
            'edit' => Pages\EditCondominios::route('/{record}/edit'),
        ];
    }
}
