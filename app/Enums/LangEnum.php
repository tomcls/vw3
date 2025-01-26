<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum LangEnum: string implements HasLabel
{
    case en = 'en';
    case fr = 'fr';
    case nl = 'nl';
    public function getLabel(): ?string
    {
       // return $this->name;
        
        // or
    
        return match ($this) {
            self::en => 'English',
            self::fr => 'Français',
            self::nl => 'Dutch',
        };
    }
}
