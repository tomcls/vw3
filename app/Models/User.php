<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
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
}
