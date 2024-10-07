<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinanceiroResource\Pages;
use App\Filament\Resources\FinanceiroResource\RelationManagers;
use App\Models\Financeiro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FinanceiroResource extends Resource
{
    protected static ?string $model = Financeiro::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup     = 'Administração';
    protected static ?int $navigationSort         = 4;
    protected static ?string $modelLabel          = 'Financeiro';
    protected static ?string $pluralModelLabel    = 'Financeiro';
    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('imovel_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('data_vencimento')
                    ->required(),
                Forms\Components\TextInput::make('valor')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('data_pagamento')
                    ->required(),
                Forms\Components\TextInput::make('valor_pago')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('imovel_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_vencimento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('data_pagamento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor_pago')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListFinanceiros::route('/'),
            'create' => Pages\CreateFinanceiro::route('/create'),
            'edit' => Pages\EditFinanceiro::route('/{record}/edit'),
        ];
    }
}
