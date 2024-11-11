<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Condominios;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Filters\SelectFilter;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;
use App\Filament\Resources\CondominiosResource\Pages;

class CondominiosResource extends Resource
{
    protected static ?string $model = Condominios::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Administração';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Condominio';

    protected static ?string $pluralModelLabel = 'Condominios';

    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Informações do Condomínio')->schema([
                    Forms\Components\TextInput::make('razao_social')
                        ->label('Razão Social')
                        ->required()
                        ->maxLength(50)
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('nome_fantasia')
                        ->label('Nome Fantasia')
                        ->maxLength(50)
                        ->columnSpan(1),

                    Document::make('cnpj')
                        ->label('CNPJ')
                        ->cnpj()
                        ->required()
                        ->columnSpan(1)
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('nome_sindico')
                        ->label('Nome do Síndico')
                        ->required()
                        ->maxLength(50),

                    Document::make('cpf_sindico')
                        ->label('CPF do Síndico')
                        ->cpf()
                        ->required(),

                    PhoneNumber::make('fone_sindico')
                        ->label('Telefone do Síndico')
                        ->mask('(99) 99999-9999')
                        ->required()
                        ->columnSpan(1)
                        ->maxLength(20),

                    Forms\Components\TextInput::make('email_sindico')
                        ->label('E-mail do Síndico')
                        ->email()
                        ->required()
                        ->maxLength(40),

                    Forms\Components\Toggle::make('ativo')
                        ->label('Condomínio Ativo?')
                        ->required(),
                ])->columns(4),


                Fieldset::make('Endereço do Condomínio')->schema([
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
                                'uf' => 'uf',
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
                        ->default('SP')
                        ->columnSpan(2)
                        ->required()
                        ->live()
                        ->options(function () {
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
                Tables\Columns\TextColumn::make('clientes.razao_social')
                    ->label('Gestor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('razao_social')
                    ->label('Razão Social')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cnpj')
                    ->label('CNPJ')
                    ->searchable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('ativo')
                    ->label('Ativo?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('nome_sindico')
                    ->label('Síndico')
                    ->searchable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('dd/MM/yyyy')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                SelectFilter::make('ativo')
                    ->label('Condominio Ativo?')
                    ->native(false)
                    ->options([
                        0 => 'Não',
                        1 => 'Sim',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('inativa')
                        ->label('Desativar Condominio')
                        ->icon('heroicon-o-x-circle')
                        ->visible(function (Condominios $condominio) {
                            return $condominio->ativo;
                        })
                        ->color('danger')
                        ->action(
                            function (Condominios $condominio) {
                                $condominio->ativo = false;
                                $condominio->save();
                            }
                        ),
                    Tables\Actions\Action::make('ativa')
                        ->label('Ativar Condominio')
                        ->icon('heroicon-o-check-circle')
                        ->visible(function (Condominios $ondominio) {
                            return !$ondominio->ativo;
                        })
                        ->color('success')
                        ->action(
                            function (Condominios $condominio) {
                                $condominio->ativo = true;
                                $condominio->save();
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
            'index' => Pages\ListCondominios::route('/'),
            'create' => Pages\CreateCondominios::route('/create'),
            'edit' => Pages\EditCondominios::route('/{record}/edit'),
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

    public static function getCidades(?string $uf = null): array
    {
        if (! is_null($uf)) {
            $data = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$uf}/municipios")->throw()->json();

            $cidades = collect($data)->mapWithKeys(function ($cidade) {
                return [$cidade['nome'] => $cidade['nome']];
            });

            return $cidades->toArray();
        }

        return [];
    }
}
