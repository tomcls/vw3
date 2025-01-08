<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\HasName;

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

    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }
    
    public function getFilamentName(): string
    {
        return $this->getAttributeValue('firstname') . ' ' . $this->getAttributeValue('lastname');
    }
}
