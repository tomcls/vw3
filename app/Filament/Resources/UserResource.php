<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Infolists\Components\Group;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Group as ComponentsGroup;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(User::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar'),
                Tables\Columns\TextColumn::make('firstname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lastname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lang')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('street_number')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('street_box')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('optin_newsletter')
                    ->boolean(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('more_info')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infoList(Infolist $infoList): Infolist
    {
        return $infoList
            ->schema([
                Section::make('Personal Information')
                    ->description('User ID: #' . $infoList->record->id)
                    ->columns(2)
                    ->schema([
                        Group::make()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('active')
                                    ->getStateUsing(function ($record) {
                                        return $record->active
                                            > 0 ? 'Active' : 'Not active';
                                    })
                                    ->badge()
                                    ->color(function ($state) {
                                        if ($state == 'Active') {
                                            return 'success';
                                        }
                                        return 'danger';
                                    }),
                                TextEntry::make('optin_newsletter')
                                    ->getStateUsing(function ($record) {
                                        return $record->optin_newsletter
                                            > 0 ? 'Yes' : 'No';
                                    })
                                    ->badge()
                                    ->color(function ($state) {
                                        if ($state) {
                                            return 'success';
                                        }
                                        return 'danger';
                                    }),
                                TextEntry::make('lang')
                                    ->formatStateUsing(function (string $state) {
                                        logger(__($state));
                                        return __($state);
                                    }),
                            ]),
                    ]),
                Section::make('Personal Information')
                    ->columns(3)
                    ->schema([
                        ImageEntry::make('avatar')
                            ->circular(),
                        Group::make()
                            ->columnSpan(2)
                            ->columns(2)
                            ->schema([
                                TextEntry::make('firstname'),
                                TextEntry::make('lastname'),
                                TextEntry::make('email'),
                                TextEntry::make('phone'),
                            ])

                    ]),
                Section::make('Location')
                    ->schema([
                        Group::make()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('country'),
                                TextEntry::make('city')->label(' City'),
                                TextEntry::make('zip'),
                            ]),
                        Group::make()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('street')
                                    ->label('Address')
                                    ->formatStateUsing(fn(string $state): string => $infoList->record->street . ' ' . $infoList->record->street_number . ' ' . $infoList->record->street_box),
                            ]),
                    ]),
                Section::make('Other infos')
                    ->schema([
                        Group::make()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('lang'),
                                TextEntry::make('more_info'),
                                TextEntry::make('code'),
                                TextEntry::make('company_id'),
                                TextEntry::make('created_at'),
                                TextEntry::make('updated_at'),
                            ]),
                    ])
            ]);
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\RolesRelationManager::class,
            RelationManagers\CompanyRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
