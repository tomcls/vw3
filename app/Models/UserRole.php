<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use App\Rules\UniqueTogether;
use Closure;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\Rules\Unique;

use function PHPUnit\Framework\callback;

class UserRole extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public static function getForm($userId = null)
    {
        return [
            Hidden::make('user_id')
            ->hidden(function () use ($userId) {
                return $userId;
            }),
            Select::make('role')
            ->unique(modifyRuleUsing: function (Unique $rule, callable $get) use($userId){ // $ge
                return $rule
                    ->where('user_id', $userId);
                }, ignoreRecord: true)
                ->options(UserRoleEnum::class)
                ->required()
        ];
    }
}
