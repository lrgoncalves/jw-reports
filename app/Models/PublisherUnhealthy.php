<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublisherUnhealthy extends Model
{
    protected $fillable = [
        'publisher_id',
        'start_at',
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}
