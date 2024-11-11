<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Imoveis;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Moradores;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Fieldset;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;
use App\Filament\Resources\MoradoresResource\Pages;

class MoradoresResource extends Resource
{
    protected static ?string $model = Moradores::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Administração';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Morador';

    protected static ?string $pluralModelLabel = 'Moradores';

    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Dados do Morador')->schema([
                    Forms\Components\Select::make('user_id')
                        ->columnSpanFull()
                        ->native(false)
                        ->searchable()
                        ->label('Usuário')
                        ->live()
                        ->options(function () {
                            return User::where('type', 2)
                                ->pluck('name', 'id')->toArray();
                        })
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            $usuario = User::where('id', $get('user_id'))->first();
                            $set('nome', $usuario->name);
                            $set('email', $usuario->email);
                        }),

                    Forms\Components\Select::make('imovel_id')
                        ->columnSpanFull()
                        ->native(false)
                        ->searchable()
                        ->label('Endereço do Imóvel')
                        ->required()
                        ->options(function () {
                            return Imoveis::where('ativo', true)
                                ->where('ativo', true)
                                ->orderBy('full_imovel')
                                ->pluck('full_imovel', 'id')->toArray();
                        }),

                    Forms\Components\TextInput::make('nome')
                        ->label('Nome do Morador')
                        ->required()
                        ->maxLength(80),

                    Forms\Components\DatePicker::make('data_nascimento')
                        ->label('Data de Nascimento')
                        ->required(),

                    Document::make('cpf')
                        ->cpf()
                        ->label('CPF')
                        ->required()
                        ->maxLength(14),

                    Forms\Components\Select::make('sexo')
                        ->label('Sexo')
                        ->options([
                            'M' => 'Masculino',
                            'F' => 'Feminino',
                            'O' => 'Outro',
                            'N' => 'Prefiro não informar',
                        ])
                        ->required(),

                    PhoneNumber::make('fone')
                        ->label('Telefone')
                        ->mask('(99) 99999-9999')
                        ->required()
                        ->maxLength(20),

                    Forms\Components\TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->required()
                        ->maxLength(40),



                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome do Morador')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('imoveis.full_imovel')
                    ->label('Endereço do Imóvel')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('cpf')
                    ->label('CPF')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('fone')
                    ->label('Telefone')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data de Cadastro')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
            'index' => Pages\ListMoradores::route('/'),
            'create' => Pages\CreateMoradores::route('/create'),
            'edit' => Pages\EditMoradores::route('/{record}/edit'),
        ];
    }
}
