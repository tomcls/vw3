<?php

namespace App\Filament\Resources\HolidayResource\RelationManagers;

use App\Models\Holiday;
use App\Models\HolidayTitle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TitlesRelationManager extends RelationManager
{
    protected static string $relationship = 'titles';

    public function form(Form $form): Form
    {
        return $form
            ->schema(HolidayTitle::getForm($this->getOwnerRecord()->id));
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->description(function ($record){
                    return $record->slug;
                }),
                Tables\Columns\TextColumn::make('lang'),
                Tables\Columns\TextColumn::make('privilege')->wrap()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->hiddenLabel(),
                Tables\Actions\DeleteAction::make()->hiddenLabel(),
            ],position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
