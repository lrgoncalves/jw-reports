<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'date',
        'attendance',
        'observations',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];
}
