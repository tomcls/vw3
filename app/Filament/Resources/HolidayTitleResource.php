<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HolidayTitleResource\Pages;
use App\Filament\Resources\HolidayTitleResource\RelationManagers;
use App\Models\HolidayTitle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HolidayTitleResource extends Resource
{
    protected static ?string $model = HolidayTitle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(HolidayTitle::getForm());
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
            'index' => Pages\ListHolidayTitles::route('/'),
            'create' => Pages\CreateHolidayTitle::route('/create'),
            'edit' => Pages\EditHolidayTitle::route('/{record}/edit'),
        ];
    }
}
