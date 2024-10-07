<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MoradoresResource\Pages;
use App\Filament\Resources\MoradoresResource\RelationManagers;
use App\Models\Moradores;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MoradoresResource extends Resource
{
    protected static ?string $model = Moradores::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup     = 'Administração';
    protected static ?int $navigationSort         = 4;
    protected static ?string $modelLabel          = 'Morador';
    protected static ?string $pluralModelLabel    = 'Moradores';
    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('imovel_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(80),
                Forms\Components\DatePicker::make('data_nascimento')
                    ->required(),
                Forms\Components\TextInput::make('cpf')
                    ->required()
                    ->maxLength(11),
                Forms\Components\TextInput::make('sexo')
                    ->required()
                    ->maxLength(1),
                Forms\Components\TextInput::make('fone')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(40),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('imovel_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_nascimento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cpf')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sexo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
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
            'index' => Pages\ListMoradores::route('/'),
            'create' => Pages\CreateMoradores::route('/create'),
            'edit' => Pages\EditMoradores::route('/{record}/edit'),
        ];
    }
}
