<?php

namespace App\Models;


use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\App;

class Holiday extends Model
{
    /** @use HasFactory<\Database\Factories\HolidayFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function type(): BelongsTo
    {
        return $this->belongsTo(HolidayType::class, 'holiday_type_id', 'id');
    }

    public function title($lang = null): HasOne
    {
        return $this->hasOne(HolidayTitle::class)->where('lang', $lang ?? App::currentLocale());
    }
    public function titles(): HasMany
    {
        return $this->hasMany(HolidayTitle::class, 'holiday_id', 'id');
    }
    public function cover()
    {
        return $this->hasOne(HolidayImage::class)->orderBy('sort');
    }
    static function getForm($holidayId = null)
    {
        return [
            Group::make()->columns(3)->schema([
                    Toggle::make('reader_trip'),
                    Toggle::make('flash_deal'),
                    TextInput::make('stars')
                        ->numeric()
                        ->inlineLabel()
                        ->maxLength(1)
                        ->columnSpan([
                            'default' => 'full',
                            'sm' => 1,
                            'xl' => 1,
                            '2xl' => 1,
                        ]),
                
            ])->columnSpanFull(),
            Group::make()->columns(2)->schema([
                Select::make('user_id')
                    // ->required()
                    // ->preload()
                    ->relationship(
                        name: 'user',
                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('firstname')->orderBy('lastname'),
                    )
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->id}# {$record->firstname} {$record->lastname} {$record->email}")
                    ->searchable(['firstname', 'lastname', 'email'])

                // ->relationship(name: 'firstname', titleAttribute: 'lastname')
                // ->searchable(['firstname', 'lastname'])
                // ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->firstname} {$record->lastname}")
                // ->getSearchResultsUsing(fn (string $search): array => User::where(function ($q) use ($search) {
                //     $q->where('id', '=', $search)
                //         ->orWhere('firstname', 'like', '%' . $search . '%')
                //         ->orWhere('email', 'like', '%' . $search . '%')
                //         ->orWhere('lastname', 'like', '%' . $search . '%');
                // })->limit(50)->pluck('lastname', 'id')->toArray())
                //->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->lastname)
                //->options(User::all()->pluck('firstname', 'id'))
                // ->editOptionForm(User::getForm())
                // ->relationship('user', 'firstname', modifyQueryUsing: function (Builder $query, Get $get) {
                //     return $query->where('id', $get('user_id'));
                // })
                // ->createOptionForm(User::getForm())
                // ->getSearchResultsUsing(fn(string $search): array => User::where('firstname', 'like', "%{$search}%")->limit(50)->pluck('firstname', 'lastname')->toArray())
                // ->getOptionLabelUsing(fn($value): ?string => User::find($value)?->pluck('id', 'lastname')->toArray())
                ,
                Select::make('holiday_type_id')
                    ->relationship(
                        name: 'type',
                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('order'),
                    )->preload()
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->id}# {$record->code}"),
            ]),
            Group::make()->columns(2)->schema([
                DatePicker::make('startdate')
                    //->format('d-m-Y')
                    ->timezone('Europe/Brussels')
                    ->native(false)
                    ->required(),
                DatePicker::make('enddate')
                    // ->format('d-m-Y')
                    ->native(false)
                    ->timezone('Europe/Brussels')
                    ->required(),
            ]),
            Group::make()->columns(2)->schema([
                TextInput::make('longitude')
                    ->required()
                    ->numeric(),
                TextInput::make('latitude')
                    ->required()
                    ->numeric(),
            ]),
            Actions::make([
                Action::make('star')
                    ->label('Fill with Factory Data')
                    ->icon('heroicon-m-star')
                    ->visible(function (string $operation) {
                        if ($operation !== 'create') {
                            return false;
                        }
                        if (! app()->environment('local')) {
                            return false;
                        }
                        return true;
                    })
                    ->action(function ($livewire) {
                        $data = Holiday::factory()->make()->toArray();
                        $livewire->form->fill($data);
                    }),
            ]),
        ];
    }
}
