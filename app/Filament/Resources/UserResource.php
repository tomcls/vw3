<?php

namespace App\Filament\Resources;

use App\Enums\LangEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Infolists\Components\Group;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ComponentsSection::make('Profile')
                    ->description('User ID: #')
                    ->collapsible()
                    ->schema(User::getForm())->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                ->circular()
                ->defaultImageUrl(function ($record) {
                    return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($record->firstname);
                }),
                Tables\Columns\TextInputColumn::make('firstname')
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('lastname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextInputColumn::make('phone')
                    ->searchable(),
                Tables\Columns\SelectColumn::make('lang')
                    ->options(LangEnum::class)
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('zip')
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('street')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('street_number')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('street_box')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('active'),
                //Tables\Columns\IconColumn::make('active')->boolean(),
                Tables\Columns\ToggleColumn::make('optin_newsletter'),
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
                Tables\Actions\EditAction::make()->hiddenLabel(),
                Tables\Actions\ViewAction::make()->hiddenLabel(),
            ],position: Tables\Enums\ActionsPosition::BeforeColumns)
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
                Section::make('Profile')
                    ->description('User ID: #' . $infoList->record->id)
                    ->schema([
                        Group::make()
                            ->columns($infoList->record->code ? 4 : 3)
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
                                    ->weight(FontWeight::Bold)
                                    ->formatStateUsing(function (string $state) {
                                        return __($state);
                                    }),
                                TextEntry::make('code')
                                    ->visible($infoList->record->code != null)
                            ]),
                    ]),
                Section::make('Personal Information')
                    ->columns(3)
                    ->schema([
                        ImageEntry::make('avatar')
                            ->hiddenLabel()
                            ->circular(),
                        Group::make()
                            ->columnSpan(2)
                            ->columns(2)
                            ->schema([
                                TextEntry::make('firstname')
                                    ->weight(FontWeight::Bold)
                                    ->columnSpan($infoList->record->company_id != null ? 1 : 2)
                                    ->label('Full name')
                                    ->formatStateUsing(fn(string $state): string => $infoList->record->firstname . ' ' . $infoList->record->lastname),
                                TextEntry::make('company.name')
                                    ->label('Company')
                                    ->visible($infoList->record->company_id != null),
                                    //->formatStateUsing(fn(string $state): string => $state ?  $state : 'No company'),
                                TextEntry::make('email')
                                    ->url(function ($record) {
                                        return 'mailto:' . $record->email;
                                    })
                                    ->icon('heroicon-o-envelope')
                                    ->color('info')
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1500),
                                TextEntry::make('phone')
                                    ->url(function ($record) {
                                        return 'tel:' . $record->phone;
                                    })
                                    ->copyable()
                                    ->copyMessage('Copied!')
                                    ->copyMessageDuration(1500)
                                    ->icon('heroicon-o-phone')
                                    ->color('info'),
                            ])

                    ]),
                Section::make('Location')
                    ->schema([
                        Group::make()
                            ->columns(3)
                            ->schema([
                                TextEntry::make('street')
                                    ->hiddenLabel()
                                    ->formatStateUsing(fn(string $state): string => $infoList->record->street . ' ' . $infoList->record->street_number . ' ' . $infoList->record->street_box . ', ' . $infoList->record->zip . ' ' . $infoList->record->city . ', ' . $infoList->record->country),
                            ]),
                    ]),
                Section::make('Other infos')
                    ->schema([
                        Group::make()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('created_at')->dateTime('d/m/Y H:i:s'),
                                TextEntry::make('updated_at')->dateTime('d/m/Y H:i:s'),
                            ]),
                    ]),
                Section::make('More infos')
                    ->schema([
                        Group::make()
                            ->schema([
                                TextEntry::make('more_info')->html()->hiddenLabel(),
                            ]),
                    ])
            ]);
    }
    public static function getRelations(): array
    {
        return [
            RelationManagers\RolesRelationManager::class,
           // RelationManagers\CompanyRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
             'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
