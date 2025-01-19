<?php

namespace App\Models;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsTo(HolidayType::class);
    }
    public function holidays(): HasMany
    {
        return $this->hasMany(Holiday::class);
    }
    static function getForm()
    {
        return [
            Select::make('user_id')
                // ->required()
                // ->preload()
                ->relationship(
                    name: 'user',
                    modifyQueryUsing: fn (Builder $query) => $query->orderBy('firstname')->orderBy('lastname'),
                )
                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id}# {$record->firstname} {$record->lastname} {$record->email}")
                ->searchable(['firstname', 'lastname','email'])

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
                modifyQueryUsing: fn (Builder $query) => $query->orderBy('order'),
            )
            ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->id}# {$record->code}")
            ->searchable(['code']),
            DatePicker::make('startdate')
                ->format('d-m-Y')
                ->timezone('Europe/Brussels')
                ->native(false)
                ->required(),
            DatePicker::make('enddate')
                ->format('d-m-Y')
                ->native(false)
                ->timezone('Europe/Brussels')
                ->required(),
        ];
    }
}
