<?php

namespace App\Models;

use App\Enums\LangEnum;
use Closure;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Marvinosswald\FilamentInputSelectAffix\TextInputSelectAffix;

class HolidayTitle extends Model
{
    /** @use HasFactory<\Database\Factories\HolidayTitleFactory> */
    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'holiday_titles';

    public $lang;

    protected $fillable = [
        'lang',
        'name',
        'slug',
        'privilege',
        'holiday_id'
    ];

    public function __construct($lang = null)
    {
        $this->lang = $lang;
    }
    public function holiday(): BelongsTo
    {
        return $this->belongsTo(Holiday::class);
    }
    public static function getForm($holidayId = null)
    {
        return [
            //Group::make()->columns(8)->schema([])->columnSpanFull(),
            TextInputSelectAffix::make('name')
                ->debounce(1000)
                ->reactive()
                ->required()
                ->label('Title')
                ->maxLength(255)
                ->live(true, 300, function (callable $get, callable $set, ?string $state) {
                    if (! $get('is_slug_changed_manually') && filled($state)) {
                        $set('slug', Str::slug($state));
                    }
                })
                ->select(
                    fn() => Select::make('lang')
                        ->extraAttributes([
                            'class' => 'w-12' // if you want to constrain the selects size, depending on your usecase
                        ])
                        ->default(App::currentLocale())
                        ->options(LangEnum::class)
                        ->selectablePlaceholder(false)

                )->columnSpanFull(),
            // TextInput::make('name')
            //     ->debounce(1000)
            //     ->reactive()
            //     ->live(true, 300,function (callable $get, callable $set, ?string $state) {
            //         logger($state);
            //         if (! $get('is_slug_changed_manually') && filled($state)) {
            //             $set('slug', Str::slug($state));
            //         }
            //     })
            //     // ->afterStateHydrated(function (callable $get, callable $set, ?string $state) {
            //     //     logger($state);
            //     //     if (! $get('is_slug_changed_manually') && filled($state)) {
            //     //         $set('slug', Str::slug($state));
            //     //     }
            //     // })
            //     ->required()
            //     ->label('Title')
            //     ->maxLength(255)
            //     ->columnSpanFull(),
            TextInput::make('slug')
                ->debounce(1000)
                ->afterStateUpdated(function ($set) {
                    $set('is_slug_changed_manually', true);
                })
                ->required()
                ->maxLength(255)->columnSpanFull(),
            Hidden::make('is_slug_changed_manually')
                ->default(false)
                ->dehydrated(true),
            Select::make('lang')
                ->options(LangEnum::class)
                ->unique()
                ->required(),
            TextInput::make('privilege')
                ->default(null)
                ->maxLength(255)
                ->columnSpanFull(),
        ];
    }
}
