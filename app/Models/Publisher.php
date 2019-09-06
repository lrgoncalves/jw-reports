<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = [
        'name',
        'birthdate',
        'baptize_date',
        'pioneer_code',
        'householder_id',
    ];

    public function householder()
    {
        return $this->belongsTo('App\Models\Publisher', 'id', 'householder_id');
        // return $this->belongsTo(Publisher::class);
    }
}
