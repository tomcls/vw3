<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\HasName;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements HasName
{
    use HasFactory;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'integer',
        'email_verified_at' => 'timestamp',
        'active' => 'boolean',
        'optin_newsletter' => 'boolean',
        'company_id' => 'integer',
    ];

    public function company(): BelongsTo
    {
        return $this->BelongsTo(Company::class);
    }
    public static function getForm()
    {
        return [
            Toggle::make('active')
                ->required(),
                Toggle::make('optin_newsletter')
                    ->required(),
            TextInput::make('firstname')
                ->label('First Name')
                ->helperText('Please enter your first name!!')
                ->prefixIcon('heroicon-s-user')
                ->hint('This is the first name of the user!!!!')
                ->required()
                ->maxLength(150),
            TextInput::make('lastname')
                ->label('Last Name')
                ->required()
                ->maxLength(150),
            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(150),
            DateTimePicker::make('email_verified_at'),
            TextInput::make('phone')
                ->tel()
                ->maxLength(40)
                ->default(null),
            TextInput::make('lang')
                ->required()
                ->maxLength(2)
                ->default('fr'),
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
            TextInput::make('avatar')
                ->maxLength(200)
                ->default(null),
            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                ->dehydrated(fn($state) => filled($state))
                ->required(fn(string $context): bool => $context === 'create')
                ->maxLength(150),
            TextInput::make('code')
                ->maxLength(25)
                ->default(null),
            Select::make('company_id')
                // // ->options(
                // //     Company::all()->pluck('name', 'id')->toArray()
                // // )
                // ->searchable()
                // //->preload()
                // ->createOptionForm(Company::getForm())
                // ->editOptionForm(Company::getForm())
                //  ->relationship('company', 'name', modifyQueryUsing: function (Builder $query, Forms\Get $get) {
                //     $q = $query->where('name', $get('company_id'));
                //     logger($q->toSql());
                //      return $q;
                //  })
                ->searchable()
                ->getSearchResultsUsing(fn(string $search): array => Company::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                ->getOptionLabelUsing(fn($value): ?string => Company::find($value)?->name),
            Select::make('role')
                ->enum(UserRoleEnum::class)
                ->options(UserRoleEnum::class),
            MarkdownEditor::make('more_info')
                    ->disableToolbarButtons(['heading', 'bold', 'italic', 'underline', 'strike', 'link', 'bulletedList', 'numberedList', 'alignment', 'blockQuote', 'codeBlock', 'horizontalLine', 'image', 'table', 'undo', 'redo', 'removeFormat'])
                    ->maxLength(255)
                    ->default(null)
        ];
    }
    public function getFilamentName(): string
    {
        return $this->getAttributeValue('firstname') . ' ' . $this->getAttributeValue('lastname');
    }
}
