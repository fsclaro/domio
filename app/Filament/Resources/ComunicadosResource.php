<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComunicadosResource\Pages;
use App\Filament\Resources\ComunicadosResource\RelationManagers;
use App\Models\Comunicados;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComunicadosResource extends Resource
{
    protected static ?string $model = Comunicados::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup     = 'Administração';
    protected static ?int $navigationSort         = 4;
    protected static ?string $modelLabel          = 'Comunicado';
    protected static ?string $pluralModelLabel    = 'Comunicados';
    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tipo_origem')
                    ->required(),
                Forms\Components\TextInput::make('tipo_comunicado')
                    ->required(),
                Forms\Components\TextInput::make('imovel_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_envio_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('dt_comunicado')
                    ->required(),
                Forms\Components\Textarea::make('mensagem')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('acao')
                    ->required(),
                Forms\Components\DatePicker::make('dt_visualizacao')
                    ->required(),
                Forms\Components\TextInput::make('user_visualizacao_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipo_origem'),
                Tables\Columns\TextColumn::make('tipo_comunicado'),
                Tables\Columns\TextColumn::make('imovel_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_envio_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dt_comunicado')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('acao'),
                Tables\Columns\TextColumn::make('dt_visualizacao')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_visualizacao_id')
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
            'index' => Pages\ListComunicados::route('/'),
            'create' => Pages\CreateComunicados::route('/create'),
            'edit' => Pages\EditComunicados::route('/{record}/edit'),
        ];
    }
}
