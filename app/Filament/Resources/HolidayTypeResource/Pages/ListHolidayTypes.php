<?php

namespace App\Filament\Resources\HolidayTypeResource\Pages;

use App\Filament\Resources\HolidayTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHolidayTypes extends ListRecords
{
    protected static string $resource = HolidayTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
