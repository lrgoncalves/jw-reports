<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublisherAddress extends Model
{
    protected $fillable = [
        'publisher_id',
        'address',
        'address_2',
        'number',
        'neighborhood',
        'city',
        'state',
        'zipcode',
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
