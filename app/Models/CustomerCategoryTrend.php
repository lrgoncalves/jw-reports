<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCategoryTrend extends Model
{
    protected $fillable = [
        'product_id',
        'category_id',
        'customer_id',
        'date',
        'total',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'id',
        'product_id',
        'category_id',
        'customer_id',
        'created_at',
        'updated_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
