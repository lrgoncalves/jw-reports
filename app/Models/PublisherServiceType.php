<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublisherServiceType extends Model
{
    protected $fillable = [
        'publisher_id',
        'service_type_id',
        'start_at',
        'finish_at',
    ];

    protected $dates = [
        'start_at',
        'finish_at',
        'created_at',
        'updated_at',
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
}
