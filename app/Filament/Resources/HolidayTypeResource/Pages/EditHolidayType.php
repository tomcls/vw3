<?php

namespace App\Filament\Resources\HolidayTypeResource\Pages;

use App\Filament\Resources\HolidayTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHolidayType extends EditRecord
{
    protected static string $resource = HolidayTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
