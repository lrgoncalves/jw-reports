<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MagazineFeature extends Model
{
    protected $fillable = [
        'id',
        'product_id',
        'user_id',
        'magazine_id',
        'date',
        'total',
    ];

    protected $dates = [
        'date',
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
