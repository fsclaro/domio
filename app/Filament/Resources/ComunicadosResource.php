<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Comunicados;
use App\Models\Condominios;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Fieldset;
use App\Filament\Resources\ComunicadosResource\Pages;

class ComunicadosResource extends Resource
{
    protected static ?string $model = Comunicados::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Administração';

    protected static ?int $navigationSort = 5;

    protected static ?string $modelLabel = 'Comunicado';

    protected static ?string $pluralModelLabel = 'Comunicados';

    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Dados do Comunicado')->schema([
                    Forms\Components\Select::make('tipo_origem')
                        ->options(function () {
                            if (auth()->user()->type == 1) {
                                return [
                                    1 => 'Para todos os Moradores',
                                ];
                            } else {
                                return [
                                    0 => 'Para Síndico',
                                ];
                            }
                        })
                        ->default(1)
                        ->live()
                        ->required(),

                    Forms\Components\Select::make('condominio_id')
                        ->label('Condomínio')
                        ->options(
                            Condominios::all()->pluck('full_condominio', 'id')->toArray()
                        )
                        ->required(),

                    Forms\Components\Textarea::make('mensagem')
                        ->label('Mensagem')
                        ->required()
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('condominios.razao_social')
                    ->label('Condomínio')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_envio.name')
                    ->label('Enviado por')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_destino.name')
                    ->label('Destinatário')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('dt_comunicado')
                    ->label('Data do Comunicado')
                    ->date('d/m/Y')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('mensagem')
                    ->label('Mensagem')
                    ->searchable()
                    ->wrap()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data de Criação')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('user_envio_id', auth()->user()->id)
                    ->orWhere('user_destino_id', auth()->user()->id);
            })
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
