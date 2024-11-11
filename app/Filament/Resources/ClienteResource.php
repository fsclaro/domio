<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Enums\TypeEnum;
use App\Models\Cliente;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Filters\SelectFilter;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;
use App\Filament\Resources\ClienteResource\Pages;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon      = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup     = 'Administração';
    protected static ?int $navigationSort         = 4;
    protected static ?string $modelLabel          = 'Cliente/Gestor';
    protected static ?string $pluralModelLabel    = 'Clientes/Gestores';
    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        $estados = self::getEstados();
        // $cidades = self::getCidades('SP');

        return $form
            ->schema([
                Fieldset::make('Identificação do Cliente')->schema([
                    Document::make('cnpj')
                        ->label('CNPJ')
                        ->cnpj()
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('inscricao_estadual')
                        ->label('Inscrição Estadual')
                        ->required()
                        ->maxLength(12),

                    Forms\Components\TextInput::make('razao_social')
                        ->label('Razão Social')
                        ->required()
                        ->maxLength(50),

                    Forms\Components\TextInput::make('nome_fantasia')
                        ->label('Nome Fantasia')
                        ->required()
                        ->maxLength(50),

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

                    Forms\Components\Toggle::make('ativo')
                        ->label('Ativo')
                        ->required(),
                ])->columns(3),

                Fieldset::make('Dados do Responsável')->schema([
                    Forms\Components\Select::make('user.name')
                        ->label('Usuário')
                        ->native(false)
                        ->relationship(name: 'user', titleAttribute: 'name')
                        ->columnSpan(2)
                        ->options(
                            User::query()
                                ->where('type', TypeEnum::GESTOR)
                                ->get()
                                ->pluck('name', 'id')
                        )
                        ->required(),

                    Document::make('cpf_administrador')
                        ->label('CPF')
                        ->cpf()
                        ->mask('999.999.999-99')
                        ->required()
                        ->columnSpan(1),

                        PhoneNumber::make('fone_administrador')
                        ->label('Telefone')
                        ->mask('(99) 99999-9999')
                        ->required()
                        ->columnSpan(1)
                        ->maxLength(20),
                ])->columns(4),

                Fieldset::make('Endereço')->schema([
                    Cep::make('cep')
                        ->label('CEP')
                        ->mask('99999-999')
                        ->required()
                        ->maxLength(9)
                        ->columnSpan(1)
                        ->live(onBlur: true)
                        ->viaCep(
                            mode: 'suffix',
                            errorMessage: 'CEP inválido.',
                                setFields: [
                                    'logradouro' => 'logradouro',
                                    'nro' => 'numero',
                                    'complemento' => 'complemento',
                                    'bairro' => 'bairro',
                                    'cidade' => 'localidade',
                                    'uf' => 'uf'
                                ]

                            ),

                    Forms\Components\TextInput::make('logradouro')
                        ->label('Endereço')
                        ->required()
                        ->columnSpan(3)
                        ->maxLength(80),

                    Forms\Components\TextInput::make('nro')
                        ->label('Número')
                        ->required()
                        ->columnSpan(1)
                        ->maxLength(10),

                    Forms\Components\TextInput::make('complemento')
                        ->label('Complemento')
                        ->columnSpan(2)
                        ->maxLength(50),

                    Forms\Components\TextInput::make('bairro')
                        ->label('Bairro')
                        ->columnSpan(3)
                        ->required()
                        ->maxLength(40),

                    Forms\Components\Select::make('uf')
                        ->label('UF')
                        ->columnSpan(2)
                        ->required()
                        ->live()
                        ->options(function() {
                            $data = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome')->throw()->json();

                            $estados = collect($data)->mapWithKeys(function ($estado) {
                                return [$estado['sigla'] => $estado['nome']];
                            });

                            return $estados->toArray();
                        }),

                    Forms\Components\Select::make('cidade')
                        ->label('Cidade')
                        ->live()
                        ->native(false)
                        ->options(function (Get $get) {
                            $uf = $get('uf');
                            return self::getCidades($uf);
                        })
                        ->columnSpan(3)
                        ->required(),

                ])->columns(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('razao_social')
                    ->label('Razão Social')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('cnpj')
                    ->label('CNPJ')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('fone')
                    ->label('Telefone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),

                Tables\Columns\IconColumn::make('ativo')
                    ->label('Ativo')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('ativo')
                    ->label('Cliente Ativo?')
                    ->native(false)
                    ->options([
                        0 => 'Não',
                        1 => 'Sim',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('inativa')
                        ->label('Desativar Cliente')
                        ->icon('heroicon-o-x-circle')
                        ->visible(function (Cliente $cliente) {
                            return $cliente->ativo;
                        })
                        ->color('danger')
                        ->action(
                            function (Cliente $cliente) {
                                $cliente->ativo = false;
                                $cliente->save();
                            }
                        ),
                    Tables\Actions\Action::make('ativa')
                        ->label('Ativar Cliente')
                        ->icon('heroicon-o-check-circle')
                        ->visible(function (Cliente $cliente) {
                            return !$cliente->ativo;
                        })
                        ->color('success')
                        ->action(
                            function (Cliente $cliente) {
                                $cliente->ativo = true;
                                $cliente->save();
                            }
                        ),
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
            'index'  => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'edit'   => Pages\EditCliente::route('/{record}/edit'),
        ];
    }

    public static function getEstados(): array
    {
        $data = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome')->throw()->json();

        $estados = collect($data)->mapWithKeys(function ($estado) {
            return [$estado['sigla'] => $estado['nome']];
        });

        return $estados->toArray();
    }

    public static function getCidades(string $uf=null): array
    {
        if (!is_null($uf)) {
            $data = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios")->throw()->json();

            $cidades = collect($data)->mapWithKeys(function ($cidade) {
                return [$cidade['nome'] => $cidade['nome']];
            });

            return $cidades->toArray();
        }

        return [];
    }
}
