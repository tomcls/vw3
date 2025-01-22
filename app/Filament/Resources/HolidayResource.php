<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HolidayResource\Pages;
use App\Filament\Resources\HolidayResource\RelationManagers;
use App\Filament\Resources\HolidayResource\RelationManagers\TitlesRelationManager;
use App\Models\Holiday;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
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
            Section::make('Holiday')
                ->description("Holiday ID: # {$form->getRecord()->id}")
                ->collapsible()
                ->schema(Holiday::getForm())
        ]);
    }
    public function isReadOnly ():bool
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
            TitlesRelationManager::class,
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
