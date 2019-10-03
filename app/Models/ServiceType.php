<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function publishers()
    {
        return $this->hasMany(PublisherServiceType::class);
    }
}
