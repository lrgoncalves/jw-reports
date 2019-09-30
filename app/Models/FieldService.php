<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldService extends Model
{
    protected $fillable = [
        'publisher_id',
        'year_service_id',
        'service_type_id',
        'date',
        'placements',
        'videos',
        'hours',
        'return_visits',
        'studies',
        'month',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function yearService()
    {
        return $this->belongsTo(YearService::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
}
