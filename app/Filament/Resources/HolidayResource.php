<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HolidayResource\Pages;
use App\Filament\Resources\HolidayResource\Pages\HolidayPage;
use App\Filament\Resources\HolidayResource\RelationManagers\TitlesRelationManager;
use App\Forms\Components\holidayTitleForm;
use App\Models\Holiday;
use App\Models\HolidayDescription;
use App\Models\HolidayTitle;
use Filament\Forms\Components\Livewire;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                    ->schema(Holiday::getForm()),
                    holidayTitleForm::make('holidayTitle')->columnSpanFull()
                    
                // Section::make("title")
                //     ->relationship('holidayTitle')
                //     ->collapsible()
                //     ->schema(HolidayTitle::getForm($form->getRecord()->id)),

                // Section::make('Titles')
                //     ->headerActions([
                //         Action::make('reset')
                //             ->modalHeading('Are you sure?')
                //             ->modalDescription('All existing items will be removed from the order.')
                //             ->requiresConfirmation()
                //             ->color('danger')
                //             ->action(fn(Forms\Set $set) => $set('items', [])),
                //     ])
                //     ->schema([
                //         static::getTitlesRepeater(),
                //     ])->collapsible(),
                // Section::make('Descriptions')
                //     ->headerActions([
                //         Action::make('reset')
                //             ->modalHeading('Are you sure?')
                //             ->modalDescription('All existing items will be removed from the order.')
                //             ->requiresConfirmation()
                //             ->color('danger')
                //             ->action(fn(Forms\Set $set) => $set('items', [])),
                //     ])
                //     ->schema([
                //         static::getDescriptionsRepeater(),
                //     ])->collapsible(),
                // Form::make('title')
                //     ->relationship()
                //     ->collapsible()
                //     ->schema(HolidayTitle::getForm($form->getRecord()->id, App::currentLocale())),
                // Section::make('Description')
                //         ->collapsible()
                //         ->schema(HolidayDescription::getForm($form->getRecord()->id,App::currentLocale())),

            ]);
    }
    public function isReadOnly(): bool
    {
        return false;
    }
    public static function getTitlesRepeater(): Repeater
    {
        return Repeater::make('holidayTitles')
            ->relationship()
            ->schema(HolidayTitle::getForm())
            // ->extraItemActions([
            //     Action::make('openProduct')
            //         ->tooltip('Open product')
            //         ->icon('heroicon-m-arrow-top-right-on-square')
            //         ->url(function (array $arguments, Repeater $component): ?string {
            //             return 'text';
            //         }, shouldOpenInNewTab: true)
            //         ->hidden(fn (array $arguments, Repeater $component): bool => blank($component->getRawItemState($arguments['item'])['shop_product_id'])),
            // ])
            //  ->orderColumn('sort')
            ->defaultItems(1)
            ->hiddenLabel()
            ->columns([
                'md' => 10,
            ])->addActionLabel('Add title')
            ->cloneable()
            ->required();
    }

    public static function getDescriptionsRepeater(): Repeater
    {
        return Repeater::make('holidayDescriptions')
            ->relationship()
            ->schema(HolidayDescription::getForm())
            // ->extraItemActions([
            //     Action::make('openProduct')
            //         ->tooltip('Open product')
            //         ->icon('heroicon-m-arrow-top-right-on-square')
            //         ->url(function (array $arguments, Repeater $component): ?string {
            //             return 'text';
            //         }, shouldOpenInNewTab: true)
            //         ->hidden(fn (array $arguments, Repeater $component): bool => blank($component->getRawItemState($arguments['item'])['shop_product_id'])),
            // ])
            //  ->orderColumn('sort')
            ->defaultItems(1)
            ->hiddenLabel()
            ->columns([
                'md' => 10,
            ])->addActionLabel('Add a description')
            ->cloneable()
            ->required();
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
            // DescriptionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHolidays::route('/'),
            'create' => Pages\CreateHoliday::route('/create'),
            'edit' => Pages\EditHoliday::route('/{record}/edit'),
            'manage' => HolidayPage::route('/{record}/manage'),
        ];
    }
}
