<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Actions\DeleteAction;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Company::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextInputColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('vat')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('city')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('zip')
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('street')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('street_number')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextInputColumn::make('street_box')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('active'),
                Tables\Columns\ToggleColumn::make('is_agency'),
                Tables\Columns\TextColumn::make('partner')
                ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->hiddenLabel(),
                Tables\Actions\DeleteAction::make()->hiddenLabel(),
            ],position: Tables\Enums\ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
