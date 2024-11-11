<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Enums\TypeEnum;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon      = 'heroicon-o-user-group';
    protected static ?string $navigationGroup     = 'Administração';
    protected static ?int $navigationSort         = 3;
    protected static ?string $modelLabel          = 'Usuário';
    protected static ?string $pluralModelLabel    = 'Usuários';
    protected static bool $hasTitleCaseModelLabel = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Dados do Usuário')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome do Usuário')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('password')
                        ->label('Senha')
                        ->password()
                        ->required(fn (Page $livewire) => ($livewire instanceof CreateUser))
                        ->maxLength(255)
                        ->hint(function (Page $livewire) {
                            if (! $livewire instanceof CreateUser) {
                                return 'Deixe em branco para manter a senha atual.';
                            }
                        })
                        ->hintColor('danger')
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state)),

                    Forms\Components\Select::make('type')
                        ->label('Tipo de Usuário')
                        ->required()
                        ->native(false)
                        ->options(function () {
                            $options = TypeEnum::all();
                            return collect($options)->mapWithKeys(fn ($option) => [$option['value'] => $option['description']]);
                        })
                        ->default(TypeEnum::PROPRIETARIO_MORADOR),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Usuário Ativo?')
                        ->required()
                        ->default(true),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome do Usuário')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo de Usuário')
                    ->state(function (User $user) {
                        return TypeEnum::from($user->type)->description();
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Usuário Ativo?')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                ->label('Criado em')
                ->dateTime('d/m/Y H:i:s')
                ->sortable(),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Usuário Ativo?')
                    ->native(false)
                    ->options([
                        0 => 'Não',
                        1 => 'Sim',
                    ]),
                SelectFilter::make('type')
                    ->label('Tipo de Usuário')
                    ->multiple()
                    ->options(function () {
                        $options = TypeEnum::all();
                        return collect($options)->mapWithKeys(fn ($option) => [$option['value'] => $option['description']]);
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('inativa')
                        ->label('Desativar Usuário')
                        ->icon('heroicon-o-x-circle')
                        ->visible(function (User $user) {
                            return $user->is_active && $user->id !== auth()->id();
                        })
                        ->color('danger')
                        ->action(
                            function (User $user) {
                                $user->is_active = false;
                                $user->save();
                            }
                        ),
                    Tables\Actions\Action::make('ativa')
                        ->label('Ativar Usuário')
                        ->icon('heroicon-o-check-circle')
                        ->visible(function (User $user) {
                            return !$user->is_active && $user->id !== auth()->id();
                        })
                        ->color('success')
                        ->action(
                            function (User $user) {
                                $user->is_active = true;
                                $user->save();
                            }
                        ),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->visible(function (User $user) {
                            return $user->id !== auth()->id();
                        }),
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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
