<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
        'is_agency' => 'boolean',
    ];
}
