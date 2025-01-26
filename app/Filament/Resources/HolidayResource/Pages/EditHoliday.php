<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Enums\LangEnum;
use App\Filament\Resources\HolidayResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\SelectAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;
    public $lang = null;

    protected $listeners = ['refresh' => 'refreshLang'];

    public function mount(int | string $record): void
    {
        logger('editHoliday mounted');
        $this->record = $this->resolveRecord($record);
        logger($record);

        $this->authorizeAccess();

        $this->fillForm();

        $this->previousUrl = url()->previous();

    }
    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return false;
    }
    public function refreshLang() {
        logger('refresh lang');
        logger($this->lang);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            SelectAction::make('lang')
                ->options(LangEnum::class),
            ActionGroup::make([
                Action::make('fr')->action(fn() => App::setLocale('fr')),
                Action::make('nl')->action(fn() => App::setLocale('nl')),
                Action::make('en')->action(fn() => App::setLocale('en')),
            ])->label('lang')->button()->dropdown(true)
        ];
    }
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        logger($data);
        logger($record);
        return $record;
    }
    public function updatedLang($lang)
    {
        // App::setLocale($lang);
        $this->dispatch('refresh');
        $this->lang = $lang;
        logger(App::getLocale());
    }
}
