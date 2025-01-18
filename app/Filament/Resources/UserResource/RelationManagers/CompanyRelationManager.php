<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Company;
use Filament\Tables\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyRelationManager extends RelationManager
{
    protected static string $relationship = 'company';

    public function isReadOnly ():bool
    {
         return false;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema(Company::getForm());
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->using(function (array $data, string $model): Model {
                    return $model::create($data);
                })
                ->after(function (Company $company, RelationManager $livewire) {
                    $livewire->ownerRecord->company_id = $company->id;
                    $livewire->ownerRecord->save();
                }),
               Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
