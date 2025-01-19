<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HolidayTypeResource\Pages;
use App\Models\HolidayType;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HolidayTypeResource extends Resource
{
    protected static ?string $model = HolidayType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(HolidayType::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHolidayTypes::route('/'),
            'create' => Pages\CreateHolidayType::route('/create'),
            'edit' => Pages\EditHolidayType::route('/{record}/edit'),
        ];
    }
}
