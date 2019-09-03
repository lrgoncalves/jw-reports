<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldService extends Model
{
    protected $fillable = [
        'publisher_id',
        'date',
        'hours',
        'placements',
        'videos',
        'return_visits',
        'studies',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
