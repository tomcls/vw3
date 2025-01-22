<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\UserRole;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';
    public function isReadOnly(): bool
    {
        return false;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema(UserRole::getForm($this->getOwnerRecord()->id));
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->recordTitleAttribute('Title')
            ->columns([
                Tables\Columns\TextColumn::make('role'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
