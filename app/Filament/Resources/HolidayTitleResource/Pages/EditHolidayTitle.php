<?php

namespace App\Filament\Resources\HolidayTitleResource\Pages;

use App\Filament\Resources\HolidayTitleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;

class EditHolidayTitle extends EditRecord
{
    protected static string $resource = HolidayTitleResource::class;

    public function mount(int | string $record): void
    {
        logger('editHoliday mounted');
        $this->record = $this->resolveRecord($record);
        logger($record);

        $this->authorizeAccess();

        $this->fillForm();

        $this->previousUrl = url()->previous();

    }
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        logger('aaaaaaaaa');
        logger($data);
        logger($record);
        return $record;
    }
}
