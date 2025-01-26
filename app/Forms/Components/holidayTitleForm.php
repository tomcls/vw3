<?php

namespace App\Forms\Components;

use App\Models\HolidayTitle;
use Filament\Forms\Components\Field;
use Illuminate\Database\Eloquent\Model;

class holidayTitleForm extends Field
{
    protected string $view = 'forms.components.holiday-title-form';
    /** @var string|callable|null */
    public $relationship = null;

    public function relationship(string | callable $relationship): static
    {
        logger("relationship");
        logger($relationship);
        $this->relationship = $relationship;

        return $this;
    }
    public function saveRelationships(): void
    {
        logger("saveRelationships");
        $state = $this->getState();
        $record = $this->getRecord();
        $relationship = $record?->{$this->getRelationship()}();
        unset($state['is_slug_changed_manually']);
        if ($relationship === null) {
            return;
        } elseif ($holidayTitle = $relationship->first()) {
            $holidayTitle->update($state);
        } else {
            
            $relationship->updateOrCreate($state);
        }

        $record?->touch();
    }

    public function getChildComponents(): array
    {
        logger("getChildComponents");
       return HolidayTitle::getForm();
    }

    protected function setUp(): void
    {

        logger('setup');
        parent::setUp();
        
        $this->afterStateHydrated(function (holidayTitleForm $component, ?Model $record) {
            $holidayTitle = $record?->getRelationValue($this->getRelationship());
logger('afterStateHydrated');
logger($holidayTitle);
            $component->state($holidayTitle ? $holidayTitle->toArray() : [
                'name' => null,
                'lang' => null,
                'holiday_id' => null,
                'privilege' => null,
            ]);
        });

        $this->dehydrated(true);
    }

    public function getRelationship(): string
    {
        logger('getRelationship');
        logger($this->relationship);
        logger($this->getName());
        return $this->evaluate($this->relationship) ?? $this->getName();
    }
}
