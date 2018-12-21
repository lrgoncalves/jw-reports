<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTrendingTopic extends Model
{
    protected $fillable = [
        'id',
        'product_id',
        'news_id',
        'total',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'id',
        'product_id',
        'created_at',
        'updated_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
