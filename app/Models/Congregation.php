<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Congregation extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];    

    public function publishers()
    {
        return $this->hasMany(Publisher::class);
    }
}
