<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartment_code',
        'phone_last4',
        'project_name',
        'voucher_code',
        'ip_address',
        'user_agent',
    ];
}
