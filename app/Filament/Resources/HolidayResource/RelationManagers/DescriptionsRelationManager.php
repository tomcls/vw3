<?php

namespace App\Filament\Resources\HolidayResource\RelationManagers;

use App\Models\HolidayDescription;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Str;

class DescriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'descriptions';

    public function form(Form $form): Form
    {
        return $form
            ->schema(HolidayDescription::getForm());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('description')->html()
                    ->formatStateUsing(fn(string $state): String => Str::limit(new HtmlString($state))),
                Tables\Columns\TextColumn::make('lang')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()->hiddenLabel(),
                Tables\Actions\DeleteAction::make(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
