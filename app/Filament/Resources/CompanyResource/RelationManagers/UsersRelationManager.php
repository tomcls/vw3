<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DissociateAction;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public function form(Form $form): Form
    {
        return $form
            ->schema(User::getForm($this->getOwnerRecord()->id));
    }
    public function isReadOnly(): bool
    {
        return false;
    }
    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->recordTitleAttribute('firstname')
            ->columns([
                Tables\Columns\TextInputColumn::make('firstname'),
                Tables\Columns\TextInputColumn::make('lastname'),
                Tables\Columns\TextInputColumn::make('email'),
                Tables\Columns\TextInputColumn::make('phone'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->slideOver(),
                Tables\Actions\AssociateAction::make()
                    ->preloadRecordSelect()
                    ->modelLabel(' with email')
                    ->recordSelectSearchColumns(['firstname', 'lastname','email'])
                    ->multiple()
                   // ->recordSelectOptionsQuery(fn(Builder $query) => $query->whereBelongsTo(auth()->user()))
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
                Tables\Actions\DeleteAction::make(),
                DissociateAction::make(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
