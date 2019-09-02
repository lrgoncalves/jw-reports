<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $fillable = [
        'congregation_id',
        'name',
        'birth_date',
        'baptize_date',
        'pioneer_code',
    ];

    public function congregation()
    {
        return $this->belongsTo(Congregation::class);
    }
}
