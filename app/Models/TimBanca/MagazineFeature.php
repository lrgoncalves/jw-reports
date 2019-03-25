<?php

namespace App\Models\TimBanca;

use Illuminate\Database\Eloquent\Model;

class MagazineFeature extends Model
{
    protected $connection = 'timbanca';

    protected $fillable = [
        'id',
        'user_id',
        'magazine_id',
        'total',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
