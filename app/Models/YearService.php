<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YearService extends Model
{
    protected $fillable = [
        'start_at',
        'finish_at',
    ];

    protected $dates = [
        'start_at',
        'finish_at',
        'created_at',
        'updated_at',
    ];
}
