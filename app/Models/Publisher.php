<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = [
        'name',
        'birth_date',
        'baptize_date',
        'pioneer_code',
    ];  
}
