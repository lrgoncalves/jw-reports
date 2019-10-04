<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'overseer_id',
        'assistant_id',
        'name',
    ];

    public function overseer()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function assistant()
    {
        return $this->belongsTo(Publisher::class);
    }

}
