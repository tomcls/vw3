<?php

namespace App\Models;

use App\Enums\LangEnum;
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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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
        return $this->BelongsTo(Company::class, 'company_id', 'id');
    }
    // public function company(): HasOne
    // {
    //     return $this->hasOne(Company::class, 'id','company_id');
    // }

    public function roles(): hasMany
    {
        return $this->hasMany(UserRole::class);
    }
    public static function getForm($userId = null)
    {
        return [

            Group::make()->schema([
                FileUpload::make('avatar')
                    ->alignCenter()
                    ->hiddenLabel()
                    ->maxSize(1024 * 1024 * 50)
                    ->avatar()
                    ->directory('avatars')
                    ->imageEditor()
                    ->default(null)
                    ->getUploadedFileNameForStorageUsing(
                        fn(TemporaryUploadedFile $file): string => (string) str(md5($file->getClientOriginalName()) . '.' . $file->extension()),
                    )->columnSpan('full'),
            ])->columns(1)->columnSpan('full'),
            Group::make()->columns([
                'default' => 2,
                'sm' => 2,
                'xl' => 2,
                '2xl' => 2,
            ])->schema([
                Toggle::make('active')
                    ->label('Active')
                    ->required(),
                Toggle::make('optin_newsletter')
                    ->label('newletter')
                    ->required(),
            ])->columnSpan('full'),
            Group::make()->columns([
                'default' => 1,
                'sm' => 2,
                'xl' => 2,
                '2xl' => 2,
            ])->schema([
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
                    ->maxLength(150)

            ])->columnSpan('full'),

            Group::make()->columns([
                'default' => 1,
                'sm' => 2,
                'xl' => 2,
                '2xl' => 2,
            ])->schema([
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(150),

                TextInput::make('phone')
                    ->tel()
                    ->maxLength(40)
                    ->default(null)
            ])->columnSpan('full'),

            Group::make()->columnSpanFull()->schema([
                Group::make()->columns(6)->schema([
                    TextInput::make('street')
                        ->maxLength(200)
                        ->default(null)
                        ->columnSpan([
                            'default' => 6,
                            'sm' => 4,
                            'xl' => 4,
                            '2xl' => 4,
                        ]),
                    TextInput::make('street_number')
                        ->label('N°')
                        ->maxLength(7)
                        ->default(null)
                        ->columnSpan([
                            'default' => 5,
                            'sm' => 1,
                            'xl' => 1,
                            '2xl' => 1,
                        ]),
                    TextInput::make('street_box')
                        ->label('Box')
                        ->maxLength(7)
                        ->default(null)
                        ->columnSpan([
                            'default' => 1,
                            'sm' => 1,
                            'xl' => 1,
                            '2xl' => 1,
                        ])
                ])->columnSpanFull(),
                Group::make()->columns(3)->schema([
                    TextInput::make('country')
                        ->maxLength(3)
                        ->default(null),
                    TextInput::make('city')
                        ->maxLength(50)
                        ->default(null),
                    TextInput::make('zip')
                        ->maxLength(10)
                        ->default(null)
                ])
            ]),

            Select::make('company_id')
                ->columnSpan('full')
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
                ->editOptionForm(Company::getForm())
                ->relationship('company', 'name', modifyQueryUsing: function (Builder $query, Forms\Get $get) {
                    return $query->where('id', $get('company_id'));
                })
                ->createOptionForm(Company::getForm())
                ->getSearchResultsUsing(fn(string $search): array => Company::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                ->getOptionLabelUsing(fn($value): ?string => Company::find($value)?->name),
            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn($state) => Hash::make($state))
                ->dehydrated(fn($state) => filled($state))
                ->required(fn(string $context): bool => $context === 'create')
                ->maxLength(150)
                ->columnSpan('full'),
            Group::make()->columns(2)->schema([
                Select::make('lang')
                    ->required()
                    //->maxWidth('w-32')
                    ->inlineLabel()
                    ->default('fr')
                    ->options(LangEnum::class),
                TextInput::make('code')
                    ->inlineLabel()
                    ->maxLength(25)
                    ->default(null),
            ])->columnSpan('full'),
            MarkdownEditor::make('more_info')
                ->disableToolbarButtons(['heading', 'bold', 'italic', 'underline', 'strike', 'link', 'bulletedList', 'numberedList', 'alignment', 'blockQuote', 'codeBlock', 'horizontalLine', 'image', 'table', 'undo', 'redo', 'removeFormat'])
                ->maxLength(255)
                ->default(null)
                ->columnSpan('full'),
            // Select::make('user_id')
            //     ->hidden(function() use($userId){
            //         return $userId ? true : false;
            //     }),
        ];
    }
    public function getFilamentName(): string
    {
        return $this->getAttributeValue('firstname') . ' ' . $this->getAttributeValue('lastname');
    }
}
