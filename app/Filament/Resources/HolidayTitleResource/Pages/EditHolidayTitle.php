<?php

namespace App\Filament\Resources\HolidayTitleResource\Pages;

use App\Filament\Resources\HolidayTitleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHolidayTitle extends EditRecord
{
    protected static string $resource = HolidayTitleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
