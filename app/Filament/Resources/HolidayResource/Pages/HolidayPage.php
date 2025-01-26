<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Filament\Resources\HolidayResource;
use Filament\Resources\Pages\Page;

class HolidayPage extends Page
{
    protected static string $resource = HolidayResource::class;

    protected static string $view = 'filament.resources.holiday-resource.pages.holiday-page';
}
