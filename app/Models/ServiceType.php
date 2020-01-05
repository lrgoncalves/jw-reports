<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    const PUBLISHER = 1;
    const AUXILIAR_PIONNER_30 = 2;
    const AUXILIAR_PIONEER_50 = 3;
    const REGULAR_PIONEER = 4;
    
    protected $fillable = [
        'name',
    ];

    public function publishers()
    {
        return $this->hasMany(PublisherServiceType::class);
    }
}
