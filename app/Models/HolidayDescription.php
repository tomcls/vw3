<?php

namespace App\Models;

use App\Enums\LangEnum;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayDescription extends Model
{
    /** @use HasFactory<\Database\Factories\HolidayDescriptionFactory> */
    use HasFactory;

    public function holiday () {
        return $this->belongsTo(Holiday::class);
    }
    public static function getForm($holidayId = null)
    {
        return [
            //Group::make()->columns(8)->schema([])->columnSpanFull(),
            Select::make('lang')
                ->default(null)
                ->options(LangEnum::class),
            RichEditor::make('description')
                ->required()
                ->label('Description')
                ->columnSpanFull(),
        ];
    }
    
}
