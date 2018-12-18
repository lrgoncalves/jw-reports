<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $dates = [
        "created_at",
        "updated_at",
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

}
