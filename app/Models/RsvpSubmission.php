<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsvpSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'ceremony',
        'guest_name',
        'attendance_status',
        'guest_count',
        'message',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'ceremony' => 'boolean',
        'guest_count' => 'integer',
    ];
}
