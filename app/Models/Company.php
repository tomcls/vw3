<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
        'is_agency' => 'boolean',
    ];
    public static function getForm  () 
    {
         return [
            TextInput::make('name')
                ->required()
                ->maxLength(150),
            TextInput::make('vat')
                ->maxLength(25)
                ->default(null),
            TextInput::make('phone')
                ->tel()
                ->maxLength(40)
                ->default(null),
            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(150),
            TextInput::make('country')
                ->maxLength(3)
                ->default(null),
            TextInput::make('city')
                ->maxLength(50)
                ->default(null),
            TextInput::make('zip')
                ->maxLength(10)
                ->default(null),
            TextInput::make('street')
                ->maxLength(200)
                ->default(null),
            TextInput::make('street_number')
                ->maxLength(7)
                ->default(null),
            TextInput::make('street_box')
                ->maxLength(7)
                ->default(null),
            Toggle::make('active')
                ->required(),
            Toggle::make('is_agency')
                ->required(),
            TextInput::make('partner')
                ->maxLength(50)
                ->default(null),
         ];
    }
}
