<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HolidayType extends Model
{
    /** @use HasFactory<\Database\Factories\HolidayTypeFactory> */
    use HasFactory;

    static function getForm () 
    {
         return [
            TextInput::make('code')
                ->required()
                ->maxLength(10),
         ];
    }
}
