<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Imoveis;
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
use App\Filament\Resources\ImoveisResource\Pages;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class ImoveisResource extends Resource
{
    protected static ?string $model = Imoveis::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Administração';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Imóvel';

    protected static ?string $pluralModelLabel = 'Imóveis';

    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Informações do Imóvel')->schema([
                    Forms\Components\Select::make('condominio_id')
                        ->label('Condomínio')
                        ->options(function () {
                            return Condominios::where('ativo', true)
                                ->where('clientes_id', auth()->user()->id)
                                ->pluck('full_condominio', 'id')->toArray();
                        })
                        ->columnSpan(3)
                        ->required(),

                    Forms\Components\Select::make('tipo')
                        ->label('Tipo de Imóvel')
                        ->options([
                            1 => 'Apartamento',
                            2 => 'Casa',
                        ])
                        ->columnSpan(1)
                        ->required(),

                    Forms\Components\Toggle::make('ativo')
                        ->label('Imóvel Ativo')
                        ->columnSpan(1)
                        ->required(),

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

                Fieldset::make('Informações do Proprietário')->schema([
                    Forms\Components\TextInput::make('nome_proprietario')
                        ->label('Nome do Proprietário')
                        ->required()
                        ->maxLength(50),

                    Document::make('cpf_proprietario')
                        ->label('CPF do Proprietário')
                        ->cpf()
                        ->required()
                        ->maxLength(14),

                    PhoneNumber::make('fone_proprietario')
                        ->label('Telefone do Proprietário')
                        ->required()
                        ->maxLength(20),

                    Forms\Components\TextInput::make('email_proprietario')
                        ->email()
                        ->required()
                        ->maxLength(40),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('condominios.razao_social')
                    ->label('Condomínio')
                    ->sortable(),

                Tables\Columns\TextColumn::make('logradouro')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nro')
                    ->label('Nº')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nome_proprietario')
                    ->label('Nome do Proprietário')
                    ->searchable(),

                Tables\Columns\TextColumn::make('fone_proprietario')
                    ->label('Telefone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email_proprietario')
                    ->label('E-mail')
                    ->searchable(),

                Tables\Columns\IconColumn::make('ativo')
                    ->label('Ativo?')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('ativo')
                    ->label('Imóvel Ativo?')
                    ->native(false)
                    ->options([
                        0 => 'Não',
                        1 => 'Sim',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('inativa')
                        ->label('Desativar Imóvel')
                        ->icon('heroicon-o-x-circle')
                        ->visible(function (Imoveis $imovel) {
                            return $imovel->ativo;
                        })
                        ->color('danger')
                        ->action(
                            function (Imoveis $imovel) {
                                $imovel->ativo = false;
                                $imovel->save();
                            }
                        ),
                    Tables\Actions\Action::make('ativa')
                        ->label('Ativar Imóvel')
                        ->icon('heroicon-o-check-circle')
                        ->visible(function (Imoveis $imovel) {
                            return ! $imovel->ativo;
                        })
                        ->color('success')
                        ->action(
                            function (Imoveis $imovel) {
                                $imovel->ativo = true;
                                $imovel->save();
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
            'index' => Pages\ListImoveis::route('/'),
            'create' => Pages\CreateImoveis::route('/create'),
            'edit' => Pages\EditImoveis::route('/{record}/edit'),
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
