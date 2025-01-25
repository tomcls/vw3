<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HolidayResource\Pages;
use App\Filament\Resources\HolidayResource\RelationManagers;
use App\Filament\Resources\HolidayResource\RelationManagers\DescriptionsRelationManager;
use App\Filament\Resources\HolidayResource\RelationManagers\TitlesRelationManager;
use App\Models\Holiday;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make("Holiday ID: # {$form->getRecord()->id}")
                            ->schema(Holiday::getForm($form->getRecord()->id)),
                        Tabs\Tab::make('Tab 2')
                            ->schema([
                                // ...
                            ]),
                        Tabs\Tab::make('Tab 3')
                            ->schema([
                                // ...
                            ]),
                    ])->columnSpanFull()->persistTabInQueryString(),
                
            ]);
    }
    public function isReadOnly(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('title.name')
                    ->sortable(),
                TextColumn::make('type.code')
                    ->sortable(),
                TextColumn::make('longitude')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('latitude')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('stars'),
                TextColumn::make('reader_trip')
                    ->sortable(),
                TextColumn::make('flash_deal')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
            // RelationGroup::make('Contacts', [
                
            // ]),
            TitlesRelationManager::class,
            DescriptionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHolidays::route('/'),
            'create' => Pages\CreateHoliday::route('/create'),
            'edit' => Pages\EditHoliday::route('/{record}/edit'),
        ];
    }
}
