<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'address',
        'email',
        'hotline',
        'social',
        'logo',
        'footer_logo',
        'favicon',
    ];

    protected $casts = [
        'social' => 'array',
    ];
}
